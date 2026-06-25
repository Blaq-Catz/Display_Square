<?php require __DIR__ . '/cms/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Infrastructure & Operational Depth | Display Square</title>
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
                <li><a href="about.php" class="active-link">About</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="portfolio.php">Portfolio</a></li>
                <li><a href="blog.php">Insights</a></li>
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

    <section class="page-header" style="<?php echo cms_bg('about_header', 'https://images.unsplash.com/photo-1580481077494-e3299acae517?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); ?>">
        <div class="header-content reveal">
            <h1>Operational Depth & Capability</h1>
            <p>We do not outsource execution. We build it.</p>
        </div>
    </section>

    <section class="company-story reveal">
        <div class="section-heading left-align">
            <span class="eyebrow" style="margin-bottom: 1rem;">THE DISPLAY SQUARE STORY</span>
            <h2>Bridging Engineering Precision With Environmental Art</h2>
        </div>
        <div class="solution-row">
            <div class="solution-specs">
                <p class="lead-desc" style="color: var(--text-dark); font-size: 1.2rem;">Founded to eliminate the commercial gap between superficial design studios and uncoordinated local welders, Display Square operates as a true Design-Build execution partner.</p>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Headquartered in Lagos, Nigeria, our organizational model integrates strict structural engineering calculations, advanced automated metal/acrylic manufacturing, and certified nationwide site installation. We ensure that when a multinational corporation or financial institution approves a brand environment layout, it is deployed with absolute material fidelity and structural safety.</p>
            </div>
            <div class="solution-img-box" style="height: 450px;"><img src="<?php echo e(cms_media_url('about_story', 'https://images.unsplash.com/photo-1600607686527-6fb886090705?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80')); ?>" alt="Plant Operations"></div>
        </div>
    </section>

    <section class="infrastructure dark-section reveal">
        <div class="section-heading">
            <span class="eyebrow" style="margin-bottom: 1rem;">MANUFACTURING SCALE</span>
            <h2>Our In-House Production Capacity</h2>
            <p>Commercial statistics demonstrating execution confidence for large-scale procurement rollouts.</p>
        </div>
        <div class="infrastructure-grid">
            <div class="stat-card">
                <span class="stat-num">3,500</span>
                <span class="stat-label">SQM Production Facility</span>
                <span class="stat-desc">Advanced metal bending, CNC milling, and acrylic oven plant in Lagos.</span>
            </div>
            <div class="stat-card">
                <span class="stat-num">100%</span>
                <span class="stat-label">In-House Manufacturing</span>
                <span class="stat-desc">Zero reliance on third-party structural fabricators or outside print houses.</span>
            </div>
            <div class="stat-card">
                <span class="stat-num">14+</span>
                <span class="stat-label">ECOWAS Deployment Fleet</span>
                <span class="stat-desc">Dedicated heavy transport logistics servicing Nigeria, Ghana, and West Africa.</span>
            </div>
            <div class="stat-card">
                <span class="stat-num">99.4%</span>
                <span class="stat-label">On-Time SLA Delivery</span>
                <span class="stat-desc">Strict adherence to corporate completion timelines and night-work permitting.</span>
            </div>
        </div>
    </section>

    <section class="departments reveal">
        <div class="section-heading">
            <span class="eyebrow" style="margin-bottom: 1rem;">TECHNICAL DEPARTMENTS</span>
            <h2>End-to-End Infrastructure</h2>
        </div>
        <div class="services-matrix-grid" style="grid-template-columns: repeat(2, 1fr);">
            <div class="why-card" style="background: #ffffff; border-color: #e2e7ec;">
                <h4 style="color: var(--accent-blue);">01. Structural Engineering & CAD Desk</h4>
                <p style="color: var(--text-muted);">Before raw steel is cut, our structural engineers model exact wind load stress, weight distribution, and municipal electrical compliance using advanced CAD software.</p>
            </div>
            <div class="why-card" style="background: #ffffff; border-color: #e2e7ec;">
                <h4 style="color: var(--accent-blue);">02. Automated Fabrication Plant</h4>
                <p style="color: var(--text-muted);">Equipped with high-precision fiber laser metal cutters CNC automated routers, cast acrylic vacuum forming ovens, and architectural powder-coating spray booths.</p>
            </div>
            <div class="why-card" style="background: #ffffff; border-color: #e2e7ec;">
                <h4 style="color: var(--accent-blue);">03. Certified Site Installation Fleet</h4>
                <p style="color: var(--text-muted);">Our deployment technicians hold rigorous high-altitude rigging, scaffolding, and electrical safety certifications, ensuring zero workplace accidents on corporate sites.</p>
            </div>
            <div class="why-card" style="background: #ffffff; border-color: #e2e7ec;">
                <h4 style="color: var(--accent-blue);">04. Preventive Aftercare SLA Division</h4>
                <p style="color: var(--text-muted);">Offering ongoing quarterly cleaning, LED driver load balancing, and rapid storm-damage restoration contracts to maintain brand visibility indefinitely.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-container reveal">
            <div class="footer-col"><div class="brand-container" style="margin-bottom: 1rem;"><div class="logo">DISPLAY SQUARE</div></div><p>Locally engineered and built in Nigeria 🇳🇬. Global standard commercial craftsmanship engineered for uncompromised structural impact across Africa.</p></div>
            <div class="footer-col"><h4>Commercial Matrix</h4><ul><li><a href="about.php">Manufacturing Plant</a></li><li><a href="services.php">Solution Architectures</a></li><li><a href="portfolio.php">Execution Case Studies</a></li><li><a href="blog.php">Technical Insights</a></li></ul></div>
            <div class="footer-col"><h4>Procurement Desk</h4><p style="color: #ffffff;">123 Design Avenue,<br>Industrial Zone, Creative District, Lagos.</p><p style="margin-top: 1rem;">Direct: +234 (0) 800 DISPLAY<br>Inquiries: studio@displaysquare.com</p></div>
        </div>
        <div class="footer-bottom"><p>&copy; 2026 Display Square Ltd. All rights reserved.</p></div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
