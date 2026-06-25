document.addEventListener('DOMContentLoaded', () => {
    
    /* =========================================
       1. COMMERCIAL NAVBAR SCROLL
       ========================================= */
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(0, 18, 36, 0.96)';
            navbar.style.boxShadow = '0 10px 30px 0 rgba(0,0,0,0.5)';
            navbar.style.borderBottom = '1px solid rgba(212, 175, 55, 0.4)';
        } else {
            navbar.style.background = 'rgba(0, 18, 36, 0.85)';
            navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
            navbar.style.borderBottom = '1px solid rgba(212, 175, 55, 0.2)';
        }
    });

    /* =========================================
       2. BULLETPROOF MOBILE MENU
       ========================================= */
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileNav = document.querySelector('.nav-links');
    // Close button lives inside the nav panel
    const closeBtn = mobileNav ? mobileNav.querySelector('.close-menu') : document.querySelector('.close-menu');
    const body = document.querySelector('body');

    const openMenu = () => {
        if (mobileNav && body) {
            mobileNav.classList.add('active');
            body.classList.add('menu-open');
        }
    };

    const closeMenu = () => {
        if (mobileNav && body) {
            mobileNav.classList.remove('active');
            body.classList.remove('menu-open');
        }
    };

    if (menuToggle) menuToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        if (body && body.classList.contains('menu-open')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    if (closeBtn) closeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        closeMenu();
    });

    // Click backdrop (outside the panel) to close
    if (body) {
        body.addEventListener('click', (e) => {
            if (body.classList.contains('menu-open') && 
                mobileNav && !mobileNav.contains(e.target) && 
                menuToggle && !menuToggle.contains(e.target)) {
                closeMenu();
            }
        });
    }

    // Close menu on any nav link click
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });

    /* =========================================
       3. CINEMATIC HERO PILLAR CAROUSEL
       ========================================= */
    const carouselContainer = document.querySelector('.hero-carousel');
    if (carouselContainer) {
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');
        let currentIndex = 0;
        let autoPlayInterval;

        const goToSlide = (index) => {
            slides[currentIndex].classList.remove('active');
            if (dots[currentIndex]) dots[currentIndex].classList.remove('active');
            currentIndex = index;
            slides[currentIndex].classList.add('active');
            if (dots[currentIndex]) dots[currentIndex].classList.add('active');
        };

        const nextSlide = () => goToSlide((currentIndex + 1) % slides.length);
        const prevSlide = () => goToSlide((currentIndex - 1 + slides.length) % slides.length);

        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => goToSlide(index));
        });

        autoPlayInterval = setInterval(nextSlide, 7500);
    }

    /* =========================================
       4. SCROLL REVEALS (Execution Confidence)
       ========================================= */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    /* =========================================
       5. CASE STUDY MODAL ENGINE (v2.0)
       ========================================= */
    // Detailed Case Study Database for Procurement Audit
    const caseStudyDatabase = {
        'aura': {
            client: 'Aura Luxury Group',
            title: 'Flagship Storefront Facade & Illumination Rollout',
            brief: 'Redesign, fabricate, and deploy an illuminated architectural storefront facade across 14 ECOWAS flagship retail boutiques with zero operational store downtime.',
            challenge: 'The client required seamless, edge-to-edge illuminated brand marks engineered to withstand severe coastal humidity and solar UV radiation in Lagos and Accra without acrylic yellowing.',
            solution: 'We utilized structural marine-grade aluminum frames paired with UV-stabilized cast acrylic. Backlighting was powered by IP68-rated modular OSRAM LED chips delivering 50,000 hours of continuous lumen maintenance.',
            materials: 'Architectural Marine Aluminum, Cast UV-Acrylic, OSRAM IP68 LED Modules, Stainless Steel Rigging.',
            scope: 'Turnkey Structural Engineering, In-House Acrylic Molding, Permitting, Nighttime Deployment, 5-Year Maintenance SLA.',
            timeline: '45 Days (Concept Visualization to Final Sign-off)',
            results: '+42% Increase in Nighttime Foot Traffic; Zero LED chip failures across 24 months of continuous operation.'
        },
        'studiov': {
            client: 'Studio V Architectural Interiors',
            title: 'Custom Environmental Neon & Interior Signage Matrix',
            brief: 'Engineer an interior brand environment and structural directional signage system for a 4,500sqm commercial design hub.',
            challenge: 'Integrating high-voltage visual lighting elements directly into acoustic timber paneling without violating municipal fire codes or creating acoustic resonance.',
            solution: 'We designed low-voltage LED faux-neon silicone extrusions recessed into precision CNC-milled aluminum heat sinks, ensuring zero thermal transfer to surrounding woodwork.',
            materials: 'Food-grade Silicone Faux-Neon, Aircraft Aluminum Extrusions, Satin Brass Plaques.',
            scope: 'Interior Wayfinding Audit, CNC Fixture Manufacturing, Electrical Integration.',
            timeline: '28 Days Delivery',
            results: 'Flawless municipal safety audit passed on first inspection; 100% brand consistency achieved.'
        },
        'nexus': {
            client: 'Nexus Multinational Headquarters',
            title: 'Structural Campus Monument & Wayfinding Directory',
            brief: 'Design and erect a 7-meter exterior structural monument pylon and intuitive vehicular/pedestrian wayfinding for a 12-building corporate campus.',
            challenge: 'The primary monument required deep soil anchoring due to high wind shear in the open industrial park, alongside dynamic digital visitor directories.',
            solution: 'We deployed a structural steel I-beam substructure anchored to a 3-meter reinforced concrete footing. The exterior cladding featured brushed aluminum composite panels integrated with outdoor P4 digital LED screens.',
            materials: 'Structural Steel I-Beams, 4mm ACP Cladding, Outdoor P4 High-Brightness LED Displays, Concrete Foundations.',
            scope: 'Geotechnical Soil Audit, Heavy Steel Welding, Crane Deployment, Software CMS Integration.',
            timeline: '60 Days Turnkey Execution',
            results: 'Eliminated campus visitor navigation bottlenecks; provided client marketing team with real-time digital announcement capabilities.'
        },
        'elevate': {
            client: 'Elevate Retail Chains',
            title: 'National Point of Sale (POS) Fixture Rollout',
            brief: 'Mass-produce and distribute 250 standardized visual merchandising modular floor displays across retail branches nationwide.',
            challenge: 'Ensuring absolute structural durability during nationwide transit over rough terrain while allowing easy, toolless assembly by branch staff.',
            solution: 'We engineered a flat-pack modular shelving system utilizing powder-coated mild steel tubing paired with interchangeable magnetic backlit graphic panels.',
            materials: 'Powder-Coated Mild Steel tubing, Magnetic Lightboxes, High-Impact Polystyrene (HIPS).',
            scope: 'Industrial Prototyping, Mass CNC Metal Bending, Flat-Pack Logistics Logistics Deployment.',
            timeline: '90 Days Nationwide Rollout',
            results: '100% on-time deployment across 36 states; reported 0% transit damage due to custom foam packaging.'
        }
    };

    const modalOverlay = document.getElementById('case-study-modal');
    if (modalOverlay) {
        const modalClose = modalOverlay.querySelector('.modal-close');
        
        // Open Modal Logic
        document.querySelectorAll('.open-case-modal').forEach(button => {
            button.addEventListener('click', (e) => {
                const caseId = button.getAttribute('data-case');
                const data = caseStudyDatabase[caseId];
                
                if (data) {
                    modalOverlay.querySelector('.client-tag').textContent = data.client;
                    modalOverlay.querySelector('.case-title').textContent = data.title;
                    modalOverlay.querySelector('.case-brief').textContent = data.brief;
                    modalOverlay.querySelector('.case-challenge').textContent = data.challenge;
                    modalOverlay.querySelector('.case-solution').textContent = data.solution;
                    modalOverlay.querySelector('.case-materials').textContent = data.materials;
                    modalOverlay.querySelector('.case-scope').textContent = data.scope;
                    modalOverlay.querySelector('.case-timeline').textContent = data.timeline;
                    modalOverlay.querySelector('.case-results').textContent = data.results;
                    
                    modalOverlay.classList.add('active');
                    document.body.style.overflow = 'hidden'; // Lock background scrolling
                }
            });
        });

        // Close Modal Logic
        const closeBox = () => {
            modalOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        };

        if (modalClose) modalClose.addEventListener('click', closeBox);
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) closeBox();
        });
    }

    /* =========================================
       6. PORTFOLIO FILTER & SEARCH LOGIC
       ========================================= */
    const portfolioGrid = document.querySelector('#portfolio-grid');
    if (portfolioGrid) {
        const filterPills = document.querySelectorAll('.filter-pill');
        const cards = document.querySelectorAll('.case-study-card');

        // Pill Filtering
        filterPills.forEach(pill => {
            pill.addEventListener('click', () => {
                filterPills.forEach(p => p.classList.remove('active'));
                pill.classList.add('active');
                const filter = pill.getAttribute('data-filter');

                cards.forEach(card => {
                    if (filter === 'all' || card.getAttribute('data-category') === filter) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Search Bar Parameter Grabber
        const urlParams = new URLSearchParams(window.location.search);
        const query = urlParams.get('query');
        
        if (query) {
            let found = false;
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(query.toLowerCase())) {
                    card.style.display = 'flex';
                    found = true;
                } else {
                    card.style.display = 'none';
                }
            });

            const headerContent = document.querySelector('#portfolio-header');
            if (headerContent) {
                headerContent.innerHTML = `
                    <h1 style="font-size: 3.5rem;">Audit Results</h1>
                    <p style="color: var(--steel-grey);">Filtering execution portfolio for: <span style="color: var(--accent-gold); font-weight: 700;">"${query}"</span></p>
                    <a href="portfolio.php" class="btn" style="margin-top: 2rem;">&larr; Reset Full Portfolio</a>
                `;
            }
            
            if (!found) {
                portfolioGrid.style.display = 'none';
                const noResults = document.querySelector('#no-results');
                if (noResults) noResults.style.display = 'block';
            }
        }
    }
});