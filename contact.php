<?php require __DIR__ . '/cms/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Procurement Desk | Request Technical Audit | Display Square</title>
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
                <li><a href="blog.php">Insights</a></li>
                <li><a href="contact.php" class="active-link">Contact</a></li>
            </ul>
        </nav>
        <div class="nav-right">
            <form action="portfolio.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search capabilities..." class="search-input">
                <button type="submit" class="search-btn"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
            </form>
        </div>
    </header>

    <section class="page-header" style="<?php echo cms_bg('contact_header', 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); ?>">
        <div class="header-content reveal">
            <h1>Commercial Procurement Desk</h1>
            <p>Initiate a Turnkey Design-Build Technical Audit.</p>
        </div>
    </section>

    <section class="contact-section reveal">
        <div class="contact-split">
            <div class="contact-info-panel">
                <span class="eyebrow" style="margin-bottom: 1rem;">SECURE TENDER DESK</span>
                <h2 style="color: var(--accent-blue);">Submit an RFP or Rollout Scope</h2>
                <p style="color: var(--text-muted);">Whether initiating a nationwide branch visual rebranding or requesting structural engineering calculations for exterior campus monuments, our estimating team delivers complete technical proposals within 48 hours.</p>
                
                <div class="contact-details" style="margin-top: 3rem;">
                    <div class="detail-item"><span class="detail-label">Manufacturing Plant</span><p style="color: var(--text-dark);">123 Design Avenue, Industrial Zone,<br>Creative District, Lagos, Nigeria 🇳🇬</p></div>
                    <div class="detail-item"><span class="detail-label">Direct Commercial Lines</span><p style="color: var(--text-dark);">+234 (0) 800 DISPLAY<br>+234 (0) 812 345 6789</p></div>
                    <div class="detail-item"><span class="detail-label">Secure Tender Inbox</span><p style="color: var(--text-dark);">tenders@displaysquare.com<br>procurement@displaysquare.com</p></div>
                </div>
            </div>
            <div class="contact-form-panel">
                <form action="#" method="POST" class="glass-form" style="background: var(--graphite);">
                    <h3 style="color: #ffffff; margin-bottom: 2rem; font-family: 'Playfair Display', serif; font-size: 1.8rem;">Project Registration Notice</h3>
                    <div class="form-row">
                        <div class="form-group"><label>First & Last Name</label><input type="text" placeholder="John Doe" required></div>
                        <div class="form-group"><label>Organization / Bank Holding</label><input type="text" placeholder="Zenith Bank Plc" required></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>Corporate Official Email</label><input type="email" placeholder="j.doe@zenithbank.com" required></div>
                        <div class="form-group"><label>Direct Mobile / WhatsApp</label><input type="tel" placeholder="+234 800 000 0000" required></div>
                    </div>
                    <div class="form-group">
                        <label>Execution Solution Required</label>
                        <select required>
                            <option value="">Select an execution pillar...</option>
                            <option value="retail">Retail Displays & VM Rollout</option>
                            <option value="architectural">Architectural Signage Systems</option>
                            <option value="wayfinding">Corporate Campus Wayfinding</option>
                            <option value="interiors">Commercial Branded Interiors</option>
                            <option value="exhibitions">Exhibition Pavilions</option>
                            <option value="fabrication">Heavy Metal/Acrylic Fabrication</option>
                        </select>
                    </div>
                    <div class="form-group"><label>Technical Scope & Estimated Locations</label><textarea rows="5" placeholder="Detail your approximate branch numbers, height requirements, or installation timelines..." required></textarea></div>
                    <button type="submit" class="btn" style="width: 100%; border-radius: 8px; padding: 1.2rem;">Initiate Secure Audit &rarr;</button>
                </form>
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
