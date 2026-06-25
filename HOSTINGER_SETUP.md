# Display Square CMS Setup

This version turns the static site into a lightweight PHP/MySQL CMS that works on normal Hostinger shared hosting.

## Upload

1. Upload all files in this folder to Hostinger `public_html`.
2. In Hostinger, create a MySQL database and database user.
3. Copy `cms/config.example.php` to `cms/config.php`.
4. Edit `cms/config.php` with the Hostinger database name, username, and password.
5. Visit `https://yourdomain.com/cms/install.php`.
6. Create your first admin username and password.
7. Delete or rename `cms/install.php` after installation.
8. Sign in at `https://yourdomain.com/admin/login.php`.

## What You Can Manage

- Blog posts with title, category, excerpt, full text, status, publish date, featured flag, image, or video.
- Media library uploads for JPG, PNG, GIF, WebP, MP4, WebM, and OGG files.
- Page media slots for homepage hero slides, homepage service pillars, page headers, service images, and portfolio images.

## Important Hostinger Notes

- The upload size is still limited by Hostinger PHP settings. If a large video fails, increase `upload_max_filesize` and `post_max_size` in Hostinger PHP settings.
- Keep `cms/config.php` private. Do not share it because it contains database credentials.
- The original `.html` files are still included as a backup, but the live CMS pages are the `.php` files.
