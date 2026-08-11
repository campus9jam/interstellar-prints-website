-- ═══════════════════════════════════════════════════════════════════
-- INTERSTELLAR PRINTS GLOBAL LTD. — Database Schema (Updated)
-- ═══════════════════════════════════════════════════════════════════
--
-- Run this in your telehosting cPanel → phpMyAdmin → SQL tab
-- or via MySQL command line.
--
-- Make sure you update config.php with the correct database name,
-- username, and password you created in cPanel → MySQL® Databases.
-- ═══════════════════════════════════════════════════════════════════

-- ─── Stationery / Merchandise Quote Requests ────────────────────────
CREATE TABLE IF NOT EXISTS `quote_requests` (
    `id`                    INT AUTO_INCREMENT PRIMARY KEY,
    `order_ref`             VARCHAR(30)  NOT NULL UNIQUE,
    `item_type`             VARCHAR(100) NOT NULL,
    `quantity`              INT          NOT NULL,
    `branding_requirements` TEXT         DEFAULT NULL,
    `full_name`             VARCHAR(200) NOT NULL,
    `company_name`          VARCHAR(200) DEFAULT NULL,
    `email`                 VARCHAR(255) NOT NULL,
    `phone`                 VARCHAR(50)  NOT NULL,
    `additional_details`    TEXT         DEFAULT NULL,
    `submitted_at`          DATETIME     NOT NULL,
    `status`                ENUM('new','contacted','quoted','completed','cancelled') DEFAULT 'new',
    `ip_address`            VARCHAR(45)  DEFAULT NULL,
    `user_agent`            VARCHAR(255) DEFAULT NULL,
    `admin_notes`           TEXT         DEFAULT NULL,
    `updated_at`            DATETIME     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_status` (`status`),
    INDEX `idx_submitted_at` (`submitted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── Logistics / Delivery Bookings ────────────────────────────────
CREATE TABLE IF NOT EXISTS `logistics_bookings` (
    `id`                   INT AUTO_INCREMENT PRIMARY KEY,
    `order_ref`            VARCHAR(30)  NOT NULL UNIQUE,
    `pickup_location`      VARCHAR(500) NOT NULL,
    `dropoff_location`     VARCHAR(500) NOT NULL,
    `package_description`  TEXT         NOT NULL,
    `weight`               VARCHAR(20)  DEFAULT NULL,
    `dimensions`           VARCHAR(50)  DEFAULT NULL,
    `delivery_type`        VARCHAR(50)  DEFAULT 'standard',
    `full_name`            VARCHAR(200) NOT NULL,
    `company_name`         VARCHAR(200) DEFAULT NULL,
    `email`                VARCHAR(255) NOT NULL,
    `phone`                VARCHAR(50)  NOT NULL,
    `pickup_date`          DATE         DEFAULT NULL,
    `submitted_at`         DATETIME     NOT NULL,
    `status`               ENUM('new','contacted','scheduled','completed','cancelled') DEFAULT 'new',
    `ip_address`           VARCHAR(45)  DEFAULT NULL,
    `user_agent`           VARCHAR(255) DEFAULT NULL,
    `admin_notes`          TEXT         DEFAULT NULL,
    `updated_at`           DATETIME     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_status` (`status`),
    INDEX `idx_submitted_at` (`submitted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── Newsletter Subscriptions ─────────────────────────────────────
CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
    `id`           INT AUTO_INCREMENT PRIMARY KEY,
    `email`        VARCHAR(255) NOT NULL UNIQUE,
    `subscribed_at` DATETIME    NOT NULL,
    `ip_address`   VARCHAR(45)  DEFAULT NULL,
    INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
