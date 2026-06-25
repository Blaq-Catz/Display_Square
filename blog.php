<?php
require __DIR__ . '/cms/bootstrap.php';

$featuredPosts = cms_posts(1, true);
$featured = $featuredPosts[0] ?? (cms_posts(1)[0] ?? null);
$recentPosts = cms_posts(12, false);
$defaultBlogImage = 'https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
if (!$recentPosts && $featured) {
    $recentPosts = array_values(array_filter(cms_posts(12), fn ($post) => ($post['slug'] ?? '') !== ($featured['slug'] ?? '')));
}

function blog_link(array $post): string
{
    return ($post['slug'] ?? '#') === '#' ? '#' : 'post.php?slug=' . rawurlencode($post['slug']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technical Insights & Whitepapers | Display Square</title>
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
                <li class="mobile-search">
                    <form action="portfolio.php" method="GET" class="search-form">
                        <input type="text" name="query" placeholder="Search capabilities..." class="search-input">
                        <button type="submit" class="search-btn"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
                    </form>
                </li>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="portfolio.php">Portfolio</a></li>
                <li><a href="blog.php" class="active-link">Insights</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <div class="nav-right">
            <form action="portfolio.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search capabilities..." class="search-input">
                <button type="submit" class="search-btn"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
            </form>
        </div>
    </header>

    <section class="page-header" style="<?php echo cms_bg('blog_header', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); ?>">
        <div class="header-content reveal">
            <h1>Technical Insights & Journal</h1>
            <p>Engineering whitepapers for commercial facility planners.</p>
        </div>
    </section>

    <?php if ($featured): ?>
    <section class="dark-section reveal">
        <div class="section-heading left-align"><h2>Featured Technical Publication</h2></div>
        <div class="featured-blog-split">
            <div class="featured-img">
                <?php echo cms_media_tag($featured, $featured['file_path'] ?? $defaultBlogImage, $featured['title']); ?>
            </div>
            <div class="featured-content">
                <span class="blog-meta"><?php echo e(strtoupper($featured['category'] ?: 'INSIGHT')); ?> &bull; <?php echo e(cms_date($featured['published_at'])); ?></span>
                <h3><?php echo e($featured['title']); ?></h3>
                <p><?php echo e($featured['excerpt']); ?></p>
                <a href="<?php echo e(blog_link($featured)); ?>" class="btn" style="margin-top: 2rem;">Read Full Insight</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="blog-grid-section reveal">
        <div class="section-heading"><span class="eyebrow" style="margin-bottom: 1rem;">KNOWLEDGE BASE</span><h2 style="color: var(--accent-blue);">Recent Engineering Bulletins</h2></div>
        <div class="blog-grid">
            <?php foreach ($recentPosts as $post): ?>
                <div class="blog-card">
                    <div class="blog-img-wrapper">
                        <?php echo cms_media_tag($post, $post['file_path'] ?? $defaultBlogImage, $post['title']); ?>
                    </div>
                    <div class="blog-text">
                        <span class="blog-meta" style="color: var(--accent-blue);"><?php echo e(strtoupper($post['category'] ?: 'INSIGHT')); ?> &bull; <?php echo e(cms_date($post['published_at'])); ?></span>
                        <h4><?php echo e($post['title']); ?></h4>
                        <p><?php echo e($post['excerpt']); ?></p>
                        <a href="<?php echo e(blog_link($post)); ?>" class="btn">Read Technical Brief</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

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
