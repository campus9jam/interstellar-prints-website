# Interstellar Prints Global Ltd. — Website

**End-to-End Corporate Supply, Custom Merchandise & General Logistics**

Production-ready website with PHP backend, MySQL database, email order forwarding, and product gallery. Designed for deployment on **telehosting** (or any cPanel-based shared hosting).

---

## 📦 What's Inside

```
interstellar-prints-website/
├── index.php               # Main website (PHP — generates CSRF tokens)
├── success.html            # Order confirmation page
├── submit-quote.php        # Handles stationery/merchandise quote requests
├── submit-logistics.php    # Handles logistics/delivery bookings
├── submit-newsletter.php   # Handles newsletter signups
├── config.php              # Database & email configuration ← EDIT THIS
├── database.sql            # MySQL schema — run once to create tables
├── .htaccess               # Apache config (security, caching, compression)
├── favicon.svg             # Favicon (IP logo)
├── includes/
│   ├── db.php              # PDO database connection & helpers
│   └── mail.php            # Email formatting & sending
├── gallery/
│   ├── README.md           # Instructions for adding gallery images
│   └── (upload your images here)
└── README.md               # This file
```

---

## ✅ What's New (Updated Version)

### Security Improvements
- **CSRF protection** on all forms (token-based, session-bound)
- **Honeypot spam trap** — invisible to humans, catches bots
- **Proper `<label for>` attributes** — all form labels linked to inputs (accessibility)
- **Security headers** in `.htaccess` (X-Content-Type-Options, X-Frame-Options, XSS-Protection)
- **Input validation** — server-side email/required field validation
- **IP & User-Agent logging** — every order records the submitter's IP and browser

### Database Improvements
- **ENUM status fields** — prevents invalid status values
  - `quote_requests`: new → contacted → quoted → completed → cancelled
  - `logistics_bookings`: new → contacted → scheduled → completed → cancelled
- **`updated_at` column** — tracks when records change
- **`admin_notes` column** — internal notes for your team
- **`ip_address` & `user_agent` columns** — fraud/spam auditing
- **`newsletter_subscribers` table** — stores newsletter signups

### Frontend Improvements
- **Favicon** added (SVG IP logo)
- **Updated contact info** — real address, phone, WhatsApp
- **X (Twitter) floating button** — bottom-right FAB linking to @interstellarp21
- **Twitter timeline embed** — dark-themed feed section
- **Product gallery** — filterable grid (Mockups / Designs / Completed Works) with lightbox
- **Gallery nav link** — added to both desktop and mobile navigation
- **Social links** — X, WhatsApp, and call buttons in footer
- **Newsletter form** — now posts to a real PHP handler (saves to database)

---

## 🚀 Deployment Guide (telehosting / cPanel)

### Step 1 — Upload Files

1. Log into your **telehosting cPanel**.
2. Open **File Manager**.
3. Navigate to your domain's `public_html/` directory (or the subdomain/addon domain folder).
4. Upload the entire contents of this zip to `public_html/`.
5. Make sure `index.php` is directly inside `public_html/` — not in a subfolder.

### Step 2 — Create the MySQL Database

1. In cPanel, go to **MySQL® Databases**.
2. Create a new database:
   - Database name: `interstellar_prints` (or any name you prefer)
3. Create a database user:
   - Set a strong username and password
   - **Write these down** — you'll need them for `config.php`
4. Add the user to the database:
   - Select the database and user
   - Grant **ALL PRIVILEGES**

### Step 3 — Import the Database Schema

1. Go to **phpMyAdmin** in cPanel.
2. Select your database from the left sidebar.
3. Click the **SQL** tab.
4. Open `database.sql` from this zip in a text editor.
5. Copy all the SQL and paste it into the SQL box.
6. Click **Go** to run it.
   - This creates three tables: `quote_requests`, `logistics_bookings`, and `newsletter_subscribers`.

### Step 4 — Edit config.php

Open `config.php` and update these values:

```php
define('DB_HOST', 'localhost');                    // Usually "localhost" on telehosting
define('DB_NAME', 'interstellar_prints');           // Your database name (may have a prefix)
define('DB_USER', 'your_db_user');                  // Your database username
define('DB_PASS', 'your_db_password');              // Your database password

define('COMPANY_EMAIL', 'orders@yourdomain.com');   // Where customer orders get sent
define('SENDER_EMAIL', 'noreply@yourdomain.com');    // "From" address (must be on your domain)
define('SITE_URL', 'https://yourdomain.com');       // Your website URL
```

> ⚠️ **Important:** Update `COMPANY_EMAIL` to the email address where you want
> all customer orders forwarded. This is the company email that receives every
> quote request and logistics booking.

> ℹ️ **CSRF tokens** are now generated automatically per-session (stored in
> PHP's `$_SESSION`) — no manual secret syncing needed. Just make sure PHP
> sessions work on your host (they do by default on cPanel).

### Step 5 — Enable Email Delivery

1. In cPanel, go to **Email Accounts**.
2. Create at least one email address on your domain (e.g., `noreply@yourdomain.com`).
   - This is used as the "From" address for outgoing order emails.
3. PHP's `mail()` function uses your hosting mail server automatically — no extra config needed.
4. (Optional) To improve deliverability, set up **SPF** and **DKIM** records in cPanel → **Email Deliverability**.

### Step 6 — Enable SSL (HTTPS)

1. In cPanel, go to **SSL/TLS Status** or **Let's Encrypt SSL**.
2. Issue a free SSL certificate for your domain.
3. Open `.htaccess` and **uncomment** the Force HTTPS lines:
   ```apache
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

### Step 7 — Upload Gallery Images

1. Upload your product photos, design mockups, and completed work photos to the `gallery/` folder.
2. Name them as described in `gallery/README.md` (e.g., `mockup-1.jpg`, `design-1.jpg`, `work-1.jpg`).
3. The gallery uses an `onerror` fallback — if an image isn't found, it shows a placeholder from Unsplash. Once you upload your own images, the placeholders are automatically replaced.

### Step 8 — Test the Website

1. Visit your domain in a browser.
2. Scroll through all sections — Stationery, Merchandise, Gallery, Logistics.
3. Fill out and submit the **Stationery / Merchandise Quote** form.
4. Fill out and submit the **Logistics / Delivery Booking** form.
5. You should be redirected to the success page with your order reference.
6. Check the company email inbox — you should receive two formatted order notifications.
7. In phpMyAdmin, check the database tables — records should be saved.
8. Click the X floating button — it should open your X profile.
9. Check the Twitter timeline section — it should show your latest posts.

---

## 📧 How Order Forwarding Works

1. Customer fills out a form on the website (quote request, delivery booking, or newsletter).
2. PHP validates the input (CSRF check, honeypot check, required fields).
3. PHP saves the order to the MySQL database.
4. PHP sends a formatted HTML email to `COMPANY_EMAIL` (defined in `config.php`).
5. Customer is redirected to `success.html` with their order reference number.

**Emails include:**
- Order/booking reference number (e.g., `SQ-20260806-A1B2C` or `LG-20260806-X3Y4Z`)
- All form fields the customer filled out
- Timestamp of submission
- Customer's IP address
- Branded HTML email template matching the website's design

---

## 🖼️ Gallery Section

The gallery shows your work in three categories: Mockups, Designs, and Completed Works.

**To add images:**
1. Upload to the `gallery/` folder
2. Edit `index.php` → find `<!-- Gallery Grid -->` → add or modify `<div class="gallery-item">` blocks
3. Set `data-category` to `mockups`, `designs`, or `works`
4. Update the `src` to `gallery/your-image.jpg`

Images fall back to Unsplash placeholders if your file isn't uploaded yet.

---

## 🔧 Configuration Reference

| Setting | File | Description |
|---------|------|-------------|
| Database credentials | `config.php` | MySQL host, name, user, password |
| Company email | `config.php` | `COMPANY_EMAIL` — where orders are forwarded |
| Sender email | `config.php` | `SENDER_EMAIL` — must be on your domain |
| Contact info | `config.php` | Used in email templates |
| Error display | `config.php` | Set `error_reporting(0)` for production |
| Force HTTPS | `.htaccess` | Uncomment the HTTPS redirect block |
| Gallery images | `gallery/` | Upload your photos, update paths in `index.php` |
| Twitter handle | `index.php` | Search for `interstellarp21` to update |
| WhatsApp number | `index.php` | Search for `2348111110243` to update |
| Phone number | `index.php` | Search for `2347045246353` to update |

---

## 🗄️ Database Tables

### `quote_requests`
Stationery and merchandise quote requests. Fields: order_ref, item_type, quantity, branding_requirements, full_name, company_name, email, phone, additional_details, submitted_at, status, ip_address, user_agent, admin_notes, updated_at.

**Status flow:** new → contacted → quoted → completed / cancelled

### `logistics_bookings`
Logistics and delivery bookings. Fields: order_ref, pickup_location, dropoff_location, package_description, weight, dimensions, delivery_type, full_name, company_name, email, phone, pickup_date, submitted_at, status, ip_address, user_agent, admin_notes, updated_at.

**Status flow:** new → contacted → scheduled → completed / cancelled

### `newsletter_subscribers`
Newsletter email subscriptions. Fields: email, subscribed_at, ip_address.

---

## 🛠️ Troubleshooting

| Issue | Solution |
|-------|----------|
| Forms show "Security token expired" | Fixed in this version — tokens are now session-based. Make sure cookies/sessions work on your host and that you did not cache `index.php` behind a static page cache (CSRF tokens must be generated fresh per visitor session). |
| Forms show "server error" | Check DB credentials in `config.php` — the database name may have a cPanel prefix (e.g., `user_interstellar_prints`) |
| Email not arriving | Ensure `SENDER_EMAIL` is a real mailbox on your domain. Check cPanel → **Email Deliverability** for SPF/DKIM. Look in **Track Delivery** or **Mail Delivery Reports**. |
| Blank page after submit | Temporarily set `error_reporting(E_ALL)` and `display_errors(1)` in `config.php` to see the error, then fix and revert. |
| Gallery shows placeholder images | Upload your own images to the `gallery/` folder with the correct filenames (see `gallery/README.md`) |
| Twitter timeline not loading | X sometimes blocks embedded timelines. Ensure the handle `interstellarp21` is correct and the account is public. |
| `.htaccess` causes 500 error | Your host may not allow some directives. Comment out blocks one at a time to isolate the issue. |
| index.php downloads instead of executing | Ensure PHP is enabled in cPanel → **MultiPHP Manager**. Set PHP version to 7.4+ (8.0+ recommended). |

---

## 🔒 Security Notes

- `config.php`, `includes/`, and `database.sql` are protected from direct browser access via `.htaccess`.
- All database queries use **PDO prepared statements** — no SQL injection risk.
- All user input is validated server-side before processing.
- **CSRF tokens** protect against cross-site request forgery.
- **Honeypot fields** catch automated spam bots.
- **IP and User-Agent** logged for every submission (fraud auditing).
- Error details are hidden from visitors in production mode.
- **Recommended:** Change your database password periodically and keep cPanel updated.
- **Recommended:** For production, compile Tailwind CSS to a static file instead of using the CDN. See https://tailwindcss.com/docs/installation for build instructions.

---

## 📞 Support

For website modifications or issues, contact your developer. For hosting/server issues, contact **telehosting** support.

---

© 2026 Interstellar Prints Global Ltd. — Your Brand, Everywhere.
