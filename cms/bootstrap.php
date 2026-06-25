<?php
declare(strict_types=1);

define('CMS_ROOT', __DIR__);
define('PUBLIC_ROOT', dirname(__DIR__));
define('UPLOAD_ROOT', PUBLIC_ROOT . DIRECTORY_SEPARATOR . 'uploads');
define('UPLOAD_URL_BASE', 'uploads');

function cms_config(): array
{
    static $config = null;
    if ($config !== null) {
        return $config;
    }

    $path = CMS_ROOT . DIRECTORY_SEPARATOR . 'config.php';
    if (!is_file($path)) {
        return $config = [];
    }

    $loaded = require $path;
    return $config = is_array($loaded) ? $loaded : [];
}

function cms_db(): ?PDO
{
    static $pdo = null;
    static $failed = false;

    if ($pdo instanceof PDO) {
        return $pdo;
    }
    if ($failed) {
        return null;
    }

    $config = cms_config();
    if (empty($config['db_host']) || empty($config['db_name']) || empty($config['db_user'])) {
        $failed = true;
        return null;
    }

    try {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=utf8mb4',
            $config['db_host'],
            $config['db_name']
        );
        $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'] ?? '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (Throwable $e) {
        $failed = true;
        return null;
    }
}

function cms_query(string $sql, array $params = []): ?PDOStatement
{
    $db = cms_db();
    if (!$db) {
        return null;
    }
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function cms_slug(string $value): string
{
    $slug = strtolower(trim($value));
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug) ?: 'post';
    $slug = trim($slug, '-');
    return $slug !== '' ? $slug : 'post';
}

function cms_unique_slug(string $title, ?int $ignoreId = null): string
{
    $base = cms_slug($title);
    $slug = $base;
    $counter = 2;

    while (true) {
        $params = ['slug' => $slug];
        $sql = 'SELECT id FROM posts WHERE slug = :slug';
        if ($ignoreId) {
            $sql .= ' AND id <> :id';
            $params['id'] = $ignoreId;
        }
        $row = cms_query($sql, $params)?->fetch();
        if (!$row) {
            return $slug;
        }
        $slug = $base . '-' . $counter++;
    }
}

function cms_media(string $slotKey): ?array
{
    try {
        $stmt = cms_query(
            'SELECT * FROM media WHERE slot_key = :slot_key ORDER BY id DESC LIMIT 1',
            ['slot_key' => $slotKey]
        );
        $media = $stmt?->fetch();
        return $media ?: null;
    } catch (Throwable $e) {
        return null;
    }
}

function cms_media_url(string $slotKey, string $fallback = ''): string
{
    $media = cms_media($slotKey);
    return $media['file_path'] ?? $fallback;
}

function cms_bg(string $slotKey, string $fallback): string
{
    return "background-image: url('" . e(cms_media_url($slotKey, $fallback)) . "');";
}

function cms_media_tag(?array $media, string $fallback, string $alt, string $class = ''): string
{
    if ($media && ($media['file_type'] ?? '') === 'video') {
        return '<video class="' . e($class) . '" controls playsinline preload="metadata"><source src="' . e($media['file_path']) . '" type="' . e($media['mime_type']) . '"></video>';
    }

    $src = $media['file_path'] ?? $fallback;
    $altText = $media['alt_text'] ?? $alt;
    return '<img src="' . e($src) . '" alt="' . e($altText) . '" class="' . e($class) . '">';
}

function cms_available_slots(): array
{
    return [
        'home_hero_1' => 'Home hero slide 1',
        'home_hero_2' => 'Home hero slide 2',
        'home_hero_3' => 'Home hero slide 3',
        'home_pillar_1' => 'Home service pillar 1',
        'home_pillar_2' => 'Home service pillar 2',
        'home_pillar_3' => 'Home service pillar 3',
        'home_pillar_4' => 'Home service pillar 4',
        'home_pillar_5' => 'Home service pillar 5',
        'home_pillar_6' => 'Home service pillar 6',
        'about_header' => 'About page header',
        'about_story' => 'About story image',
        'services_header' => 'Services page header',
        'services_retail' => 'Services retail image',
        'services_signage' => 'Services signage image',
        'services_wayfinding' => 'Services wayfinding image',
        'services_interiors' => 'Services interiors image',
        'portfolio_header' => 'Portfolio page header',
        'portfolio_case_aura' => 'Portfolio Aura image',
        'portfolio_case_studiov' => 'Portfolio Studio V image',
        'portfolio_case_nexus' => 'Portfolio Nexus image',
        'portfolio_case_elevate' => 'Portfolio Elevate image',
        'blog_header' => 'Blog page header',
        'contact_header' => 'Contact page header',
    ];
}

function cms_blog_fallback_posts(): array
{
    return [
        [
            'title' => 'The Future of Flagship Retail: Blurring Digital and Physical Environments at Scale',
            'slug' => '#',
            'excerpt' => 'How corporate real estate directors are utilizing integrated structural signages, digital outdoor LED displays, and modular visual merchandising.',
            'body' => '',
            'category' => 'Engineering',
            'featured' => 1,
            'published_at' => '2026-03-12 09:00:00',
            'file_path' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'file_type' => 'image',
            'mime_type' => 'image/jpeg',
        ],
        [
            'title' => 'Mastering Architectural Faux-Neon Layouts',
            'slug' => '#',
            'excerpt' => 'Preventing thermal heat sink buildup in interior joinery installations.',
            'body' => '',
            'category' => 'Compliance',
            'featured' => 0,
            'published_at' => '2026-02-28 09:00:00',
            'file_path' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'file_type' => 'image',
            'mime_type' => 'image/jpeg',
        ],
        [
            'title' => 'Calculating Wind Shear for Exterior Pylons',
            'slug' => '#',
            'excerpt' => 'Geotechnical soil considerations for 10m+ campus monument markers.',
            'body' => '',
            'category' => 'Wayfinding',
            'featured' => 0,
            'published_at' => '2026-02-15 09:00:00',
            'file_path' => 'https://images.unsplash.com/photo-1541888079213-718e2beab88e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'file_type' => 'image',
            'mime_type' => 'image/jpeg',
        ],
        [
            'title' => 'Cast Acrylics vs. Extruded in Tropical Sun',
            'slug' => '#',
            'excerpt' => 'An empirical audit of UV yellowing degradation in coastal West Africa.',
            'body' => '',
            'category' => 'Materials',
            'featured' => 0,
            'published_at' => '2026-01-30 09:00:00',
            'file_path' => 'https://images.unsplash.com/photo-1511289081-d06dda19034d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'file_type' => 'image',
            'mime_type' => 'image/jpeg',
        ],
    ];
}

function cms_posts(int $limit = 12, ?bool $featured = null): array
{
    try {
        $where = "p.status = 'published'";
        $params = [];
        if ($featured !== null) {
            $where .= ' AND p.featured = :featured';
            $params['featured'] = $featured ? 1 : 0;
        }
        $sql = "SELECT p.*, m.file_path, m.file_type, m.mime_type, m.alt_text
                FROM posts p
                LEFT JOIN media m ON m.id = p.media_id
                WHERE {$where}
                ORDER BY p.published_at DESC, p.id DESC";
        if ($limit > 0) {
            $sql .= ' LIMIT ' . $limit;
        }
        $stmt = cms_query($sql, $params);
        $posts = $stmt?->fetchAll();
        if ($posts) {
            return $posts;
        }
    } catch (Throwable $e) {
        $posts = [];
    }

    $fallback = cms_blog_fallback_posts();
    if ($featured === true) {
        return array_values(array_filter($fallback, fn ($post) => (int) $post['featured'] === 1));
    }
    if ($featured === false) {
        return array_values(array_filter($fallback, fn ($post) => (int) $post['featured'] === 0));
    }
    return $fallback;
}

function cms_post_by_slug(string $slug): ?array
{
    try {
        $stmt = cms_query(
            "SELECT p.*, m.file_path, m.file_type, m.mime_type, m.alt_text
             FROM posts p
             LEFT JOIN media m ON m.id = p.media_id
             WHERE p.slug = :slug AND p.status = 'published'
             LIMIT 1",
            ['slug' => $slug]
        );
        $post = $stmt?->fetch();
        return $post ?: null;
    } catch (Throwable $e) {
        return null;
    }
}

function cms_date(?string $date): string
{
    if (!$date) {
        return '';
    }
    $timestamp = strtotime($date);
    return $timestamp ? strtoupper(date('M j, Y', $timestamp)) : e($date);
}

function cms_start_session(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function cms_csrf_token(): string
{
    cms_start_session();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function cms_verify_csrf(): void
{
    cms_start_session();
    $token = $_POST['csrf'] ?? '';
    if (!$token || !hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(403);
        exit('Invalid form token.');
    }
}

function cms_current_admin(): ?array
{
    cms_start_session();
    if (empty($_SESSION['admin_id'])) {
        return null;
    }
    $stmt = cms_query('SELECT id, username FROM admins WHERE id = :id LIMIT 1', ['id' => $_SESSION['admin_id']]);
    $admin = $stmt?->fetch();
    return $admin ?: null;
}

function cms_require_admin(): array
{
    $admin = cms_current_admin();
    if (!$admin) {
        header('Location: login.php');
        exit;
    }
    return $admin;
}

function cms_flash(?string $message = null, string $type = 'success'): ?array
{
    cms_start_session();
    if ($message !== null) {
        $_SESSION['flash'] = ['message' => $message, 'type' => $type];
        return null;
    }
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function cms_upload_file(array $file, string $pageKey = '', string $slotKey = '', string $title = '', string $altText = ''): array
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Please choose a valid file to upload.');
    }

    $config = cms_config();
    $maxBytes = (int) ($config['upload_max_bytes'] ?? (150 * 1024 * 1024));
    if (($file['size'] ?? 0) > $maxBytes) {
        throw new RuntimeException('That file is larger than the configured upload limit.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed = [
        'image/jpeg' => ['jpg', 'image'],
        'image/png' => ['png', 'image'],
        'image/gif' => ['gif', 'image'],
        'image/webp' => ['webp', 'image'],
        'video/mp4' => ['mp4', 'video'],
        'video/webm' => ['webm', 'video'],
        'video/ogg' => ['ogv', 'video'],
    ];
    if (!isset($allowed[$mime])) {
        throw new RuntimeException('Only JPG, PNG, GIF, WebP, MP4, WebM, and OGG files are allowed.');
    }

    [$extension, $type] = $allowed[$mime];
    $folder = date('Y/m');
    $targetDir = UPLOAD_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $folder);
    if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
        throw new RuntimeException('Could not create the uploads folder.');
    }

    $base = cms_slug(pathinfo($file['name'], PATHINFO_FILENAME));
    $filename = $base . '-' . bin2hex(random_bytes(5)) . '.' . $extension;
    $target = $targetDir . DIRECTORY_SEPARATOR . $filename;
    if (!move_uploaded_file($file['tmp_name'], $target)) {
        throw new RuntimeException('Upload failed while moving the file.');
    }

    $path = UPLOAD_URL_BASE . '/' . $folder . '/' . $filename;
    $db = cms_db();
    if (!$db) {
        throw new RuntimeException('The database is not connected.');
    }

    if ($slotKey !== '') {
        $existing = cms_media($slotKey);
        if ($existing) {
            cms_query(
                'UPDATE media SET page_key = :page_key, title = :title, alt_text = :alt_text, file_path = :file_path, file_type = :file_type, mime_type = :mime_type, original_name = :original_name, updated_at = NOW() WHERE id = :id',
                [
                    'page_key' => $pageKey,
                    'title' => $title,
                    'alt_text' => $altText,
                    'file_path' => $path,
                    'file_type' => $type,
                    'mime_type' => $mime,
                    'original_name' => $file['name'],
                    'id' => $existing['id'],
                ]
            );
            return ['id' => (int) $existing['id'], 'file_path' => $path, 'file_type' => $type, 'mime_type' => $mime];
        }
    }

    cms_query(
        'INSERT INTO media (slot_key, page_key, title, alt_text, file_path, file_type, mime_type, original_name, created_at, updated_at)
         VALUES (:slot_key, :page_key, :title, :alt_text, :file_path, :file_type, :mime_type, :original_name, NOW(), NOW())',
        [
            'slot_key' => $slotKey !== '' ? $slotKey : null,
            'page_key' => $pageKey,
            'title' => $title,
            'alt_text' => $altText,
            'file_path' => $path,
            'file_type' => $type,
            'mime_type' => $mime,
            'original_name' => $file['name'],
        ]
    );

    return ['id' => (int) $db->lastInsertId(), 'file_path' => $path, 'file_type' => $type, 'mime_type' => $mime];
}
