<?php
declare(strict_types=1);

require __DIR__ . '/../cms/bootstrap.php';
cms_require_admin();

$errors = [];
$action = $_GET['action'] ?? 'list';
$id = (int) ($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cms_verify_csrf();
    $postAction = $_POST['action'] ?? 'save';

    try {
        if ($postAction === 'delete') {
            cms_query('DELETE FROM posts WHERE id = :id', ['id' => (int) $_POST['id']]);
            cms_flash('Post deleted.');
            header('Location: posts.php');
            exit;
        }

        $postId = (int) ($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        if ($title === '') {
            throw new RuntimeException('Post title is required.');
        }

        $mediaId = $_POST['media_id'] !== '' ? (int) $_POST['media_id'] : null;
        if (!empty($_FILES['media_file']['name'])) {
            $upload = cms_upload_file(
                $_FILES['media_file'],
                'blog',
                '',
                $title,
                trim($_POST['media_alt_text'] ?? $title)
            );
            $mediaId = $upload['id'];
        }

        $publishedAt = trim($_POST['published_at'] ?? '');
        $params = [
            'title' => $title,
            'slug' => cms_unique_slug($title, $postId ?: null),
            'excerpt' => trim($_POST['excerpt'] ?? ''),
            'body' => trim($_POST['body'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'status' => $_POST['status'] === 'published' ? 'published' : 'draft',
            'featured' => !empty($_POST['featured']) ? 1 : 0,
            'media_id' => $mediaId,
            'published_at' => $publishedAt !== '' ? str_replace('T', ' ', $publishedAt) . ':00' : date('Y-m-d H:i:s'),
        ];

        if ($postId > 0) {
            $params['id'] = $postId;
            cms_query(
                'UPDATE posts SET title = :title, slug = :slug, excerpt = :excerpt, body = :body, category = :category, status = :status, featured = :featured, media_id = :media_id, published_at = :published_at, updated_at = NOW() WHERE id = :id',
                $params
            );
            cms_flash('Post updated.');
        } else {
            cms_query(
                'INSERT INTO posts (title, slug, excerpt, body, category, status, featured, media_id, published_at, created_at, updated_at)
                 VALUES (:title, :slug, :excerpt, :body, :category, :status, :featured, :media_id, :published_at, NOW(), NOW())',
                $params
            );
            cms_flash('Post created.');
        }

        header('Location: posts.php');
        exit;
    } catch (Throwable $e) {
        $errors[] = $e->getMessage();
        $action = $postAction === 'delete' ? 'list' : 'edit';
        $id = (int) ($_POST['id'] ?? 0);
    }
}

$editing = null;
if (($action === 'edit' || $action === 'new') && $id > 0) {
    $editing = cms_query('SELECT * FROM posts WHERE id = :id', ['id' => $id])?->fetch();
}

$posts = cms_query(
    'SELECT p.*, m.file_path, m.file_type FROM posts p LEFT JOIN media m ON m.id = p.media_id ORDER BY p.published_at DESC, p.id DESC'
)?->fetchAll() ?? [];
$mediaItems = cms_query('SELECT id, title, original_name, file_path FROM media ORDER BY created_at DESC')?->fetchAll() ?? [];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog Posts | Display Square CMS</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">
    <main class="admin-shell">
        <div class="admin-topbar">
            <div>
                <h1>Blog Posts</h1>
                <p class="admin-muted">Write posts with text, pictures, or videos for the Insights page.</p>
            </div>
            <nav class="admin-nav">
                <a href="posts.php?action=new">New Post</a>
                <a href="media.php">Media Library</a>
                <a class="secondary" href="index.php">Dashboard</a>
                <a class="secondary" href="logout.php">Logout</a>
            </nav>
        </div>

        <?php if ($flash = cms_flash()): ?><div class="notice <?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div><?php endif; ?>
        <?php foreach ($errors as $error): ?><div class="notice error"><?php echo e($error); ?></div><?php endforeach; ?>

        <?php if ($action === 'new' || $action === 'edit'): ?>
            <?php
                $post = $editing ?: [
                    'id' => 0,
                    'title' => '',
                    'excerpt' => '',
                    'body' => '',
                    'category' => '',
                    'status' => 'draft',
                    'featured' => 0,
                    'media_id' => '',
                    'published_at' => date('Y-m-d H:i:s'),
                ];
                $dateValue = date('Y-m-d\TH:i', strtotime($post['published_at'] ?: 'now'));
            ?>
            <section class="admin-card">
                <h2><?php echo $post['id'] ? 'Edit Post' : 'New Post'; ?></h2>
                <form method="post" enctype="multipart/form-data" class="admin-form">
                    <input type="hidden" name="csrf" value="<?php echo e(cms_csrf_token()); ?>">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" value="<?php echo (int) $post['id']; ?>">
                    <label>Title<input name="title" value="<?php echo e($post['title']); ?>" required></label>
                    <label>Category<input name="category" value="<?php echo e($post['category']); ?>" placeholder="Engineering, Materials, News"></label>
                    <label>Excerpt<textarea name="excerpt" rows="4"><?php echo e($post['excerpt']); ?></textarea></label>
                    <label>Body<textarea name="body" rows="12"><?php echo e($post['body']); ?></textarea></label>
                    <label>Existing media
                        <select name="media_id">
                            <option value="">No featured media</option>
                            <?php foreach ($mediaItems as $item): ?>
                                <option value="<?php echo (int) $item['id']; ?>" <?php echo (int) $post['media_id'] === (int) $item['id'] ? 'selected' : ''; ?>>
                                    <?php echo e($item['title'] ?: $item['original_name'] ?: $item['file_path']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label>Or upload new featured image/video<input type="file" name="media_file" accept="image/*,video/mp4,video/webm,video/ogg"></label>
                    <label>Media alt text<input name="media_alt_text" value="<?php echo e($post['title']); ?>"></label>
                    <label>Publish date<input type="datetime-local" name="published_at" value="<?php echo e($dateValue); ?>"></label>
                    <label>Status
                        <select name="status">
                            <option value="draft" <?php echo $post['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                            <option value="published" <?php echo $post['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                        </select>
                    </label>
                    <label style="display:flex; gap:10px; align-items:center;"><input style="width:auto;" type="checkbox" name="featured" value="1" <?php echo $post['featured'] ? 'checked' : ''; ?>> Featured post</label>
                    <div class="admin-actions">
                        <button class="admin-btn" type="submit">Save post</button>
                        <a class="admin-link-btn" href="posts.php">Cancel</a>
                    </div>
                </form>
            </section>
        <?php else: ?>
            <section class="admin-card">
                <h2>All Posts</h2>
                <table class="admin-table">
                    <thead><tr><th>Post</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($post['title']); ?></strong><br>
                                    <span class="admin-muted"><?php echo e($post['category']); ?> <?php echo $post['featured'] ? '| Featured' : ''; ?></span>
                                </td>
                                <td><?php echo e($post['status']); ?></td>
                                <td><?php echo e(cms_date($post['published_at'])); ?></td>
                                <td>
                                    <div class="admin-actions">
                                        <a class="admin-link-btn" href="posts.php?action=edit&id=<?php echo (int) $post['id']; ?>">Edit</a>
                                        <?php if ($post['status'] === 'published'): ?><a class="admin-link-btn" href="../post.php?slug=<?php echo e($post['slug']); ?>" target="_blank">View</a><?php endif; ?>
                                        <form method="post" onsubmit="return confirm('Delete this post?');">
                                            <input type="hidden" name="csrf" value="<?php echo e(cms_csrf_token()); ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo (int) $post['id']; ?>">
                                            <button class="admin-link-btn" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (!$posts): ?>
                            <tr><td colspan="4" class="admin-muted">No posts yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
