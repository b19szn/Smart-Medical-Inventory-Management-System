-- Smart Medical Inventory System Database Schema
-- Created for Laravel Application

-- Create Database
CREATE DATABASE IF NOT EXISTS `medical` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `medical`;

-- Users Table
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','admin','staff','supplier') NOT NULL DEFAULT 'staff',
  `phone` varchar(20) DEFAULT NULL,
  `hospital_name` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inventory Items Table
CREATE TABLE `inventory_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `unit_of_measure` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `minimum_stock_level` int(11) NOT NULL DEFAULT 10,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `supplier_name` varchar(255) DEFAULT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  `manufacturing_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `storage_location` varchar(255) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `is_critical` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `inventory_items_item_code_unique` (`item_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Stock Transactions Table
CREATE TABLE `stock_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inventory_item_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` enum('add','consume','transfer_out','transfer_in','adjustment') NOT NULL,
  `quantity` int(11) NOT NULL,
  `balance_after` int(11) NOT NULL DEFAULT 0,
  `reference_number` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `transfer_from` varchar(255) DEFAULT NULL,
  `transfer_to` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','completed') NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_transactions_inventory_item_id_foreign` (`inventory_item_id`),
  KEY `stock_transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `stock_transactions_inventory_item_id_foreign` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Alerts Table
CREATE TABLE `alerts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inventory_item_id` bigint(20) UNSIGNED NOT NULL,
  `alert_type` enum('shortage','expiry','expired') NOT NULL,
  `message` varchar(255) NOT NULL,
  `severity` enum('low','medium','high','critical') NOT NULL DEFAULT 'medium',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alerts_inventory_item_id_foreign` (`inventory_item_id`),
  CONSTRAINT `alerts_inventory_item_id_foreign` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Alert Settings Table
CREATE TABLE `alert_settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `low_stock_threshold_days` int(11) NOT NULL DEFAULT 10,
  `expiry_warning_days` int(11) NOT NULL DEFAULT 30,
  `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `system_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Default Data
-- Default Alert Settings
INSERT INTO `alert_settings` (`low_stock_threshold_days`, `expiry_warning_days`, `email_notifications`, `system_notifications`, `created_at`, `updated_at`) VALUES
(10, 30, 1, 1, NOW(), NOW());

-- Default Users
INSERT INTO `users` (`name`, `email`, `password`, `role`, `phone`, `hospital_name`, `department`, `is_active`, `created_at`, `updated_at`) VALUES
('Super Admin', 'admin@smartmedical.com', '$2y$12$LQv3c1yycaGdCgzgGlXXXe7DO5GoOQ98h1cHXPhV4Ej/H1.aMqYe2', 'superadmin', '+880 1700-000000', 'System Administration', 'IT', 1, NOW(), NOW()),
('Hospital Admin', 'hospital@smartmedical.com', '$2y$12$LQv3c1yycaGdCgzgGlXXXe7DO5GoOQ98h1cHXPhV4Ej/H1.aMqYe2', 'admin', '+880 1700-000001', 'Dhaka Medical College Hospital', 'Administration', 1, NOW(), NOW()),
('Staff Member', 'staff@smartmedical.com', '$2y$12$LQv3c1yycaGdCgzgGlXXXe7DO5GoOQ98h1cHXPhV4Ej/H1.aMqYe2', 'staff', '+880 1700-000002', 'Dhaka Medical College Hospital', 'Pharmacy', 1, NOW(), NOW()),
('Medical Supplier', 'supplier@smartmedical.com', '$2y$12$LQv3c1yycaGdCgzgGlXXXe7DO5GoOQ98h1cHXPhV4Ej/H1.aMqYe2', 'supplier', '+880 1700-000003', 'MediSupply Bangladesh', 'Sales', 1, NOW(), NOW());

-- Note: All default passwords are 'password'
