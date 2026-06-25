<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$errors = [];
$success = false;
$db = cms_db();

if (!$db) {
    $errors[] = 'Database connection failed. Copy cms/config.example.php to cms/config.php, then fill in your Hostinger database name, user, and password.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cms_verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = (string) ($_POST['password'] ?? '');

    if ($username === '') {
        $errors[] = 'Choose an admin username.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Use an admin password with at least 8 characters.';
    }

    if (!$errors) {
        $schema = file_get_contents(__DIR__ . '/schema.sql');
        foreach (array_filter(array_map('trim', explode(';', $schema))) as $statement) {
            $db->exec($statement);
        }

        $count = (int) $db->query('SELECT COUNT(*) FROM admins')->fetchColumn();
        if ($count === 0) {
            cms_query(
                'INSERT INTO admins (username, password_hash, created_at) VALUES (:username, :password_hash, NOW())',
                [
                    'username' => $username,
                    'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                ]
            );
        }

        $seedCount = (int) $db->query('SELECT COUNT(*) FROM posts')->fetchColumn();
        if ($seedCount === 0) {
            foreach (cms_blog_fallback_posts() as $post) {
                cms_query(
                    'INSERT INTO posts (title, slug, excerpt, body, category, status, featured, published_at, created_at, updated_at)
                     VALUES (:title, :slug, :excerpt, :body, :category, "published", :featured, :published_at, NOW(), NOW())',
                    [
                        'title' => $post['title'],
                        'slug' => cms_slug($post['title']),
                        'excerpt' => $post['excerpt'],
                        'body' => $post['body'],
                        'category' => $post['category'],
                        'featured' => $post['featured'],
                        'published_at' => $post['published_at'],
                    ]
                );
            }
        }

        $success = true;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display Square CMS Installer</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../admin/admin.css">
</head>
<body class="admin-body">
    <main class="admin-auth">
        <section class="admin-panel">
            <h1>Display Square CMS Installer</h1>
            <?php if ($success): ?>
                <div class="notice success">CMS installed. Delete or rename <strong>cms/install.php</strong>, then sign in.</div>
                <a class="admin-btn" href="../admin/login.php">Go to admin login</a>
            <?php else: ?>
                <?php foreach ($errors as $error): ?>
                    <div class="notice error"><?php echo e($error); ?></div>
                <?php endforeach; ?>
                <p>Create the database tables and your first admin account.</p>
                <form method="post" class="admin-form">
                    <input type="hidden" name="csrf" value="<?php echo e(cms_csrf_token()); ?>">
                    <label>Admin username<input name="username" required></label>
                    <label>Admin password<input name="password" type="password" minlength="8" required></label>
                    <button class="admin-btn" type="submit" <?php echo $db ? '' : 'disabled'; ?>>Install CMS</button>
                </form>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
