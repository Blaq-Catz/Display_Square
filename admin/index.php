<?php
declare(strict_types=1);

require __DIR__ . '/../cms/bootstrap.php';
$admin = cms_require_admin();
$postCount = (int) (cms_query('SELECT COUNT(*) FROM posts')?->fetchColumn() ?? 0);
$mediaCount = (int) (cms_query('SELECT COUNT(*) FROM media')?->fetchColumn() ?? 0);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display Square CMS</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">
    <main class="admin-shell">
        <div class="admin-topbar">
            <div>
                <h1>Display Square CMS</h1>
                <p class="admin-muted">Signed in as <?php echo e($admin['username']); ?></p>
            </div>
            <nav class="admin-nav">
                <a href="posts.php">Blog Posts</a>
                <a href="media.php">Media Library</a>
                <a class="secondary" href="../index.php" target="_blank">View Site</a>
                <a class="secondary" href="logout.php">Logout</a>
            </nav>
        </div>
        <?php if ($flash = cms_flash()): ?><div class="notice <?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div><?php endif; ?>
        <section class="admin-grid">
            <article class="admin-card">
                <h2><?php echo $postCount; ?> Blog Posts</h2>
                <p class="admin-muted">Publish text, photos, and videos to the Insights page.</p>
                <a class="admin-btn" href="posts.php?action=new">Create post</a>
            </article>
            <article class="admin-card">
                <h2><?php echo $mediaCount; ?> Media Files</h2>
                <p class="admin-muted">Replace homepage, page header, service, portfolio, and blog media.</p>
                <a class="admin-btn" href="media.php">Upload media</a>
            </article>
        </section>
    </main>
</body>
</html>
