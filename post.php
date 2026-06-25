<?php
require __DIR__ . '/cms/bootstrap.php';

$slug = trim($_GET['slug'] ?? '');
$post = $slug !== '' ? cms_post_by_slug($slug) : null;
if (!$post) {
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post ? e($post['title']) : 'Post Not Found'; ?> | Display Square</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <a href="index.php" class="brand-container">
            <img src="Images/logo.png" alt="Display Square Logo" class="custom-logo" onerror="this.style.display='none'">
            <div class="logo">DISPLAY SQUARE</div>
        </a>
        <div class="menu-toggle" id="mobile-menu"><span class="bar"></span><span class="bar"></span><span class="bar"></span></div>
        <nav class="nav-center">
            <ul class="nav-links">
                <li class="close-menu-li"><button class="close-menu" aria-label="Close menu">&times;</button></li>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="portfolio.php">Portfolio</a></li>
                <li><a href="blog.php" class="active-link">Insights</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <?php if ($post): ?>
        <section class="page-header" style="<?php echo cms_bg('blog_header', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); ?>">
            <div class="header-content reveal">
                <h1><?php echo e($post['title']); ?></h1>
                <p><?php echo e(strtoupper($post['category'] ?: 'INSIGHT')); ?> &bull; <?php echo e(cms_date($post['published_at'])); ?></p>
            </div>
        </section>
        <section class="blog-detail-section reveal">
            <article class="blog-detail">
                <?php if (!empty($post['file_path'])): ?>
                    <div class="blog-detail-media"><?php echo cms_media_tag($post, $post['file_path'], $post['title']); ?></div>
                <?php endif; ?>
                <p class="lead-desc" style="color: var(--text-muted); font-size: 1.2rem;"><?php echo e($post['excerpt']); ?></p>
                <div class="blog-body">
                    <?php echo nl2br(e($post['body'])); ?>
                </div>
                <a class="btn" href="blog.php" style="margin-top: 2rem;">Back to Insights</a>
            </article>
        </section>
    <?php else: ?>
        <section class="page-header" style="<?php echo cms_bg('blog_header', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); ?>">
            <div class="header-content reveal">
                <h1>Post Not Found</h1>
                <p>This insight may have been moved or unpublished.</p>
            </div>
        </section>
    <?php endif; ?>

    <footer>
        <div class="footer-container reveal">
            <div class="footer-col"><div class="brand-container" style="margin-bottom: 1rem;"><div class="logo">DISPLAY SQUARE</div></div><p>Locally engineered and built in Nigeria. Global standard commercial craftsmanship engineered for uncompromised structural impact across Africa.</p></div>
            <div class="footer-col"><h4>Commercial Matrix</h4><ul><li><a href="about.php">Manufacturing Plant</a></li><li><a href="services.php">Solution Architectures</a></li><li><a href="portfolio.php">Execution Case Studies</a></li><li><a href="blog.php">Technical Insights</a></li></ul></div>
            <div class="footer-col"><h4>Procurement Desk</h4><p style="color: #ffffff;">123 Design Avenue,<br>Industrial Zone, Creative District, Lagos.</p><p style="margin-top: 1rem;">Direct: +234 (0) 800 DISPLAY<br>Inquiries: studio@displaysquare.com</p></div>
        </div>
        <div class="footer-bottom"><p>&copy; 2026 Display Square Ltd. All rights reserved.</p></div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
