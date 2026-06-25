<?php
declare(strict_types=1);

require __DIR__ . '/../cms/bootstrap.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cms_verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = (string) ($_POST['password'] ?? '');

    try {
        $stmt = cms_query('SELECT * FROM admins WHERE username = :username LIMIT 1', ['username' => $username]);
        $admin = $stmt?->fetch();
        if ($admin && password_verify($password, $admin['password_hash'])) {
            cms_start_session();
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int) $admin['id'];
            header('Location: index.php');
            exit;
        }
        $error = 'Invalid username or password.';
    } catch (Throwable $e) {
        $error = 'Admin tables are not ready. Run cms/install.php first.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display Square Admin Login</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">
    <main class="admin-auth">
        <section class="admin-panel">
            <h1>Admin Login</h1>
            <?php if ($error): ?><div class="notice error"><?php echo e($error); ?></div><?php endif; ?>
            <form method="post" class="admin-form">
                <input type="hidden" name="csrf" value="<?php echo e(cms_csrf_token()); ?>">
                <label>Username<input name="username" autocomplete="username" required></label>
                <label>Password<input type="password" name="password" autocomplete="current-password" required></label>
                <button class="admin-btn" type="submit">Sign in</button>
            </form>
            <p class="admin-muted" style="margin-top: 18px;">First time? Configure <code>cms/config.php</code>, then run <a href="../cms/install.php">cms/install.php</a>.</p>
        </section>
    </main>
</body>
</html>
