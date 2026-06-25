<?php
declare(strict_types=1);

require __DIR__ . '/../cms/bootstrap.php';
cms_require_admin();

$errors = [];
$slots = cms_available_slots();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cms_verify_csrf();
    $action = $_POST['action'] ?? 'upload';

    try {
        if ($action === 'delete') {
            $id = (int) ($_POST['id'] ?? 0);
            $media = cms_query('SELECT * FROM media WHERE id = :id', ['id' => $id])?->fetch();
            if ($media) {
                cms_query('DELETE FROM media WHERE id = :id', ['id' => $id]);
                $path = PUBLIC_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $media['file_path']);
                $uploadRoot = realpath(UPLOAD_ROOT) ?: '';
                $pathDir = realpath(dirname($path)) ?: '';
                if ($uploadRoot !== '' && $pathDir !== '' && strpos($pathDir, $uploadRoot) === 0 && is_file($path)) {
                    @unlink($path);
                }
                cms_flash('Media deleted.');
            }
            header('Location: media.php');
            exit;
        }

        $slotKey = trim($_POST['slot_key'] ?? '');
        $customSlot = trim($_POST['custom_slot_key'] ?? '');
        if ($customSlot !== '') {
            $slotKey = cms_slug($customSlot);
        }

        cms_upload_file(
            $_FILES['media_file'] ?? [],
            trim($_POST['page_key'] ?? ''),
            $slotKey,
            trim($_POST['title'] ?? ''),
            trim($_POST['alt_text'] ?? '')
        );
        cms_flash($slotKey ? 'Media uploaded and assigned to the selected page slot.' : 'Media uploaded to the library.');
        header('Location: media.php');
        exit;
    } catch (Throwable $e) {
        $errors[] = $e->getMessage();
    }
}

$mediaItems = cms_query('SELECT * FROM media ORDER BY updated_at DESC, created_at DESC, id DESC')?->fetchAll() ?? [];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Media Library | Display Square CMS</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">
    <main class="admin-shell">
        <div class="admin-topbar">
            <div>
                <h1>Media Library</h1>
                <p class="admin-muted">Upload images and videos, then assign them to page slots.</p>
            </div>
            <nav class="admin-nav">
                <a href="index.php">Dashboard</a>
                <a href="posts.php">Blog Posts</a>
                <a class="secondary" href="logout.php">Logout</a>
            </nav>
        </div>

        <?php if ($flash = cms_flash()): ?><div class="notice <?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div><?php endif; ?>
        <?php foreach ($errors as $error): ?><div class="notice error"><?php echo e($error); ?></div><?php endforeach; ?>

        <section class="admin-card" style="margin-bottom: 24px;">
            <h2>Upload Media</h2>
            <form method="post" enctype="multipart/form-data" class="admin-form">
                <input type="hidden" name="csrf" value="<?php echo e(cms_csrf_token()); ?>">
                <input type="hidden" name="action" value="upload">
                <label>Image or video file<input type="file" name="media_file" accept="image/*,video/mp4,video/webm,video/ogg" required></label>
                <label>Page slot
                    <select name="slot_key">
                        <option value="">No slot, library only</option>
                        <?php foreach ($slots as $key => $label): ?>
                            <option value="<?php echo e($key); ?>"><?php echo e($label); ?> (<?php echo e($key); ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Custom slot key<input name="custom_slot_key" placeholder="optional-custom-slot"></label>
                <label>Page key<input name="page_key" placeholder="home, about, services, portfolio, blog, contact"></label>
                <label>Title<input name="title" placeholder="Short internal title"></label>
                <label>Alt text / description<input name="alt_text" placeholder="Describe the media for accessibility"></label>
                <button class="admin-btn" type="submit">Upload media</button>
            </form>
        </section>

        <section class="admin-card">
            <h2>Uploaded Files</h2>
            <table class="admin-table">
                <thead><tr><th>Preview</th><th>Details</th><th>Slot</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($mediaItems as $item): ?>
                        <tr>
                            <td>
                                <?php if ($item['file_type'] === 'video'): ?>
                                    <video class="admin-media-thumb" controls preload="metadata"><source src="../<?php echo e($item['file_path']); ?>" type="<?php echo e($item['mime_type']); ?>"></video>
                                <?php else: ?>
                                    <img class="admin-media-thumb" src="../<?php echo e($item['file_path']); ?>" alt="<?php echo e($item['alt_text']); ?>">
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo e($item['title'] ?: $item['original_name']); ?></strong><br>
                                <span class="admin-muted"><?php echo e($item['file_type']); ?> | <?php echo e($item['mime_type']); ?></span><br>
                                <code><?php echo e($item['file_path']); ?></code>
                            </td>
                            <td>
                                <?php echo e($item['slot_key'] ?: 'Library only'); ?><br>
                                <span class="admin-muted"><?php echo e($item['page_key']); ?></span>
                            </td>
                            <td>
                                <form method="post" onsubmit="return confirm('Delete this media file?');">
                                    <input type="hidden" name="csrf" value="<?php echo e(cms_csrf_token()); ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo (int) $item['id']; ?>">
                                    <button class="admin-link-btn" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$mediaItems): ?>
                        <tr><td colspan="4" class="admin-muted">No media uploaded yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
