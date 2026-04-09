-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2025 at 11:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_medical_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `type` enum('low_stock','expiry_warning','expired','transfer_request') NOT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `type`, `hospital_id`, `item_id`, `batch_id`, `message`, `is_read`, `created_at`) VALUES
(1, 'transfer_request', 3, 2, NULL, 'New transfer request: 5000 units requested from Hospital ID 2 to Hospital ID 3', 0, '2025-09-02 14:33:25'),
(2, 'transfer_request', 3, 3, NULL, 'New transfer request: 1000 units requested from another hospital', 0, '2025-09-04 13:00:38'),
(3, 'transfer_request', 2, 2, NULL, 'Superadmin completed transfer: 25000 units transferred out', 0, '2025-09-04 13:04:56'),
(4, 'transfer_request', 3, 2, NULL, 'Superadmin completed transfer: 25000 units received', 0, '2025-09-04 13:04:56'),
(5, 'transfer_request', 2, 3, NULL, 'Superadmin completed transfer: 500 units transferred out', 0, '2025-09-08 12:18:39'),
(6, 'transfer_request', 3, 3, NULL, 'Superadmin completed transfer: 500 units received', 0, '2025-09-08 12:18:39'),
(7, 'transfer_request', 2, 3, NULL, 'Superadmin completed transfer: 110 units transferred out', 0, '2025-09-08 12:29:00'),
(8, 'transfer_request', 3, 3, NULL, 'Superadmin completed transfer: 110 units received', 0, '2025-09-08 12:29:00'),
(9, 'transfer_request', 2, 3, NULL, 'New transfer request: 100 units requested from another hospital', 0, '2025-09-08 15:03:40');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `is_active`) VALUES
(1, 'Medicines', 'Pharmaceutical products and drugs', 1),
(2, 'Medical Equipment', 'Medical devices and equipment', 1),
(3, 'Surgical Supplies', 'Surgical instruments and supplies', 1),
(4, 'Laboratory Supplies', 'Lab testing materials and reagents', 1),
(5, 'Personal Protective Equipment', 'PPE items like masks, gloves, gowns', 1),
(6, 'Emergency Supplies', 'Emergency medical supplies', 1),
(7, 'Consumables', 'Single-use medical items', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontend_content`
--

CREATE TABLE `frontend_content` (
  `id` int(11) NOT NULL,
  `section` varchar(50) NOT NULL,
  `content_key` varchar(100) NOT NULL,
  `content_value` text DEFAULT NULL,
  `content_type` enum('text','textarea','image','number') DEFAULT 'text',
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `frontend_content`
--

INSERT INTO `frontend_content` (`id`, `section`, `content_key`, `content_value`, `content_type`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'hero', 'title', 'Smart Medical Inventory Management', 'text', 1, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(2, 'hero', 'subtitle', 'Advanced inventory management solution designed specifically for healthcare facilities. Streamline operations, reduce waste, and ensure critical supplies are always available when you need them.', 'textarea', 2, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(3, 'hero', 'primary_button_text', 'Get Started Today', 'text', 3, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(4, 'hero', 'secondary_button_text', 'Watch Demo', 'text', 4, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(5, 'stats', 'hospitals_count', '500+', 'text', 1, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(6, 'stats', 'hospitals_label', 'Healthcare Facilities', 'text', 2, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(7, 'stats', 'items_count', '10,000+', 'text', 3, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(8, 'stats', 'items_label', 'Medical Items Tracked', 'text', 4, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(9, 'stats', 'transactions_count', '1M+', 'text', 5, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(10, 'stats', 'transactions_label', 'Transactions Processed', 'text', 6, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(11, 'stats', 'support_text', '24/7', 'text', 7, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(12, 'stats', 'support_label', 'Customer Support', 'text', 8, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(13, 'features', 'title', 'Comprehensive Healthcare Inventory Solutions', 'text', 1, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(14, 'features', 'subtitle', 'Everything you need to manage medical supplies efficiently and safely', 'textarea', 2, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(15, 'features', 'feature1_icon', 'fas fa-boxes', 'text', 3, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(16, 'features', 'feature1_title', 'Real-time Inventory Tracking', 'text', 4, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(17, 'features', 'feature1_description', 'Monitor stock levels, expiration dates, and usage patterns in real-time across all locations.', 'textarea', 5, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(18, 'features', 'feature2_icon', 'fas fa-bell', 'text', 6, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(19, 'features', 'feature2_title', 'Smart Alerts & Notifications', 'text', 7, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(20, 'features', 'feature2_description', 'Automated alerts for low stock, expiring items, and critical supply shortages.', 'textarea', 8, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(21, 'features', 'feature3_icon', 'fas fa-chart-line', 'text', 9, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(22, 'features', 'feature3_title', 'Advanced Analytics', 'text', 10, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(23, 'features', 'feature3_description', 'Detailed reports and insights to optimize purchasing decisions and reduce waste.', 'textarea', 11, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(24, 'features', 'feature4_icon', 'fas fa-shield-alt', 'text', 12, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(25, 'features', 'feature4_title', 'Compliance & Security', 'text', 13, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(26, 'features', 'feature4_description', 'HIPAA compliant with role-based access control and audit trails.', 'textarea', 14, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(27, 'features', 'feature5_icon', 'fas fa-mobile-alt', 'text', 15, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(28, 'features', 'feature5_title', 'Mobile Accessibility', 'text', 16, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(29, 'features', 'feature5_description', 'Access your inventory from anywhere with our responsive mobile-friendly interface.', 'textarea', 17, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(30, 'features', 'feature6_icon', 'fas fa-exchange-alt', 'text', 18, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(31, 'features', 'feature6_title', 'Inter-Hospital Transfers', 'text', 19, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(32, 'features', 'feature6_description', 'Seamlessly transfer supplies between facilities with automated approval workflows.', 'textarea', 20, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(33, 'footer', 'company_name', 'Smart Medical Inventory', 'text', 1, 1, '2025-09-02 13:31:21', '2025-09-08 12:26:08'),
(34, 'footer', 'company_description', 'Advanced inventory management solution designed specifically for healthcare facilities. Streamline your medical supply chain with intelligent automation.', 'textarea', 2, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(35, 'footer', 'contact_email', 'info@smartinventory.com', 'text', 3, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(36, 'footer', 'contact_phone', '+880-1XXXXXXXXX', 'text', 4, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(37, 'footer', 'contact_address', 'Dhaka, Bangladesh', 'text', 5, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(38, 'footer', 'copyright_text', '2024 Smart Medical Inventory. All rights reserved.', 'text', 6, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(39, 'about', 'title', 'Why Choose Smart Medical Inventory?', 'text', 1, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(40, 'about', 'subtitle', 'Trusted by healthcare professionals worldwide', 'text', 2, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21'),
(41, 'about', 'description', 'Our platform combines cutting-edge technology with healthcare expertise to deliver a comprehensive inventory management solution that grows with your organization.', 'textarea', 3, 1, '2025-09-02 13:31:21', '2025-09-02 13:31:21');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `type` enum('hospital','clinic','pharmacy') DEFAULT 'hospital',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`id`, `name`, `address`, `phone`, `email`, `license_number`, `type`, `is_active`, `created_at`) VALUES
(2, 'PG HOSPITAL', 'Shahbagh Rd, Dhaka 1000', '01959069942', 'shezanmahmud1147@gmail.com', '6008642636', 'hospital', 1, '2025-09-02 13:45:19'),
(3, 'Popular Diagnostic', 'House #16, Road # 2, Dhanmondi R/A, Dhaka-1205', '01959069942', 'la8656453@gmail.com', '6008642637', 'hospital', 1, '2025-09-02 13:48:10'),
(5, 'shahbag Hospital', 'PATKIABARI, AZAD PRINTING PRESS, PABNA SADAR\r\nPABNA', '01959069942', 'shezanmahmud1147@gmail.com', '0101010101010', 'hospital', 1, '2025-09-08 12:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_batches`
--

CREATE TABLE `inventory_batches` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `batch_number` varchar(100) NOT NULL,
  `manufacturing_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `initial_quantity` int(11) NOT NULL,
  `current_quantity` int(11) NOT NULL,
  `received_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_batches`
--

INSERT INTO `inventory_batches` (`id`, `item_id`, `hospital_id`, `supplier_id`, `batch_number`, `manufacturing_date`, `expiry_date`, `purchase_price`, `selling_price`, `initial_quantity`, `current_quantity`, `received_date`, `created_at`) VALUES
(2, 2, 2, 1, 'BATCH-20250902-290', NULL, '2026-09-24', NULL, NULL, 500, 6500, '2025-09-02', '2025-09-02 14:32:20'),
(3, 2, 3, 1, 'BATCH-20250902-290', NULL, '2026-09-24', NULL, NULL, 5000, 30000, '2025-09-02', '2025-09-02 14:34:27'),
(4, 3, 2, 1, 'BATCH-20250903-685', NULL, '2026-09-03', NULL, NULL, 1030, 420, '2025-09-03', '2025-09-03 08:50:04'),
(5, 4, 3, 1, 'BATCH-20250904-989', NULL, '2026-09-04', NULL, NULL, 700, 700, '2025-09-04', '2025-09-04 11:11:56'),
(6, 3, 3, 1, 'BATCH-20250903-685', NULL, '2026-09-03', NULL, NULL, 1000, 1610, '2025-09-04', '2025-09-04 13:04:32'),
(7, 5, 2, 1, 'BATCH-20250908-883', NULL, '2026-09-08', NULL, NULL, 12, 12, '2025-09-08', '2025-09-08 12:27:39');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `generic_name` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `unit` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `min_stock_level` int(11) DEFAULT 10,
  `max_stock_level` int(11) DEFAULT 1000,
  `qr_code` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `generic_name`, `category_id`, `unit`, `description`, `min_stock_level`, `max_stock_level`, `qr_code`, `is_active`, `created_at`) VALUES
(2, 'napa extra', NULL, 1, '10000', 'hello', 10, 1000, NULL, 1, '2025-09-02 14:32:20'),
(3, 'losectril', NULL, 1, '1000', '', 10, 1000, NULL, 1, '2025-09-03 08:50:04'),
(4, 'NAPA EXTREME PRO', NULL, 1, '1000', '', 10, 1000, NULL, 1, '2025-09-04 11:11:56'),
(5, 'Surgical Mask V2026', NULL, 3, '110', 'hello everyone. How are you ?', 10, 1000, NULL, 1, '2025-09-08 12:27:39');

-- --------------------------------------------------------

--
-- Table structure for table `report_generations`
--

CREATE TABLE `report_generations` (
  `id` int(11) NOT NULL,
  `report_id` varchar(50) NOT NULL,
  `report_type` varchar(100) NOT NULL,
  `report_format` varchar(20) NOT NULL,
  `report_title` varchar(255) NOT NULL,
  `generated_by` int(11) NOT NULL,
  `generation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parameters`)),
  `record_count` int(11) DEFAULT 0,
  `file_size` int(11) DEFAULT 0,
  `hospital_filter` int(11) DEFAULT NULL,
  `category_filter` int(11) DEFAULT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `status` enum('generated','downloaded','failed') DEFAULT 'generated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report_generations`
--

INSERT INTO `report_generations` (`id`, `report_id`, `report_type`, `report_format`, `report_title`, `generated_by`, `generation_date`, `parameters`, `record_count`, `file_size`, `hospital_filter`, `category_filter`, `date_from`, `date_to`, `status`) VALUES
(1, 'RPT-20250904-133152-9392', 'inventory_summary', 'csv', 'Inventory Summary Report', 8, '2025-09-04 11:31:52', '{\"type\":\"inventory_summary\",\"format\":\"csv\",\"date_from\":\"\",\"date_to\":\"\",\"hospital_id\":\"\",\"category_id\":\"\"}', 4, 0, NULL, NULL, NULL, NULL, 'generated'),
(2, 'RPT-20250904-133206-2997', 'inventory_summary', 'csv', 'Inventory Summary Report', 8, '2025-09-04 11:32:06', '{\"type\":\"inventory_summary\",\"format\":\"csv\",\"date_from\":\"\",\"date_to\":\"\",\"hospital_id\":\"\",\"category_id\":\"\"}', 4, 0, NULL, NULL, NULL, NULL, 'generated'),
(3, 'RPT-20250904-133825-9938', 'stock_transactions', 'csv', 'Stock Transactions Report', 16, '2025-09-04 11:38:25', '{\"type\":\"stock_transactions\",\"format\":\"csv\",\"date_from\":\"2025-09-01\",\"date_to\":\"2025-09-04\",\"hospital_id\":\"\",\"category_id\":\"\"}', 2, 0, NULL, NULL, '2025-09-01', '2025-09-04', 'generated'),
(4, 'RPT-20250908-141855-3030', 'inventory_summary', 'csv', 'Inventory Summary Report', 8, '2025-09-08 12:18:55', '{\"type\":\"inventory_summary\",\"format\":\"csv\",\"date_from\":\"\",\"date_to\":\"\",\"hospital_id\":\"\",\"category_id\":\"\"}', 5, 0, NULL, NULL, NULL, NULL, 'generated'),
(5, 'RPT-20250908-142038-9488', 'inventory_summary', 'csv', 'Inventory Summary Report', 8, '2025-09-08 12:20:38', '{\"type\":\"inventory_summary\",\"format\":\"csv\",\"date_from\":\"\",\"date_to\":\"\",\"hospital_id\":\"\",\"category_id\":\"\"}', 5, 0, NULL, NULL, NULL, NULL, 'generated');

-- --------------------------------------------------------

--
-- Table structure for table `security_logs`
--

CREATE TABLE `security_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_type` varchar(100) NOT NULL,
  `event_details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `security_logs`
--

INSERT INTO `security_logs` (`id`, `user_id`, `event_type`, `event_details`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 8, 'UPLOAD_SUCCESS', 'Document: Screenshot_39.png, Type: license', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-04 09:58:51'),
(2, 8, 'DOWNLOAD_PATH_VIOLATION', '../uploads/documents/user_8/doc_license_8_1756979931_a7162717e4545b212754e26bf7068972.png', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-04 09:58:58'),
(3, 8, 'UPLOAD_SUCCESS', 'Document: Screenshot_39.png, Type: license', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-04 09:59:55'),
(4, 8, 'DOWNLOAD_PATH_VIOLATION', '../uploads/documents/user_8/doc_license_8_1756979995_f32cffa97d9a482d2490e6e6164021e6.png', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-04 09:59:59'),
(5, 8, 'UPLOAD_SUCCESS', 'Document: COLOMBIA.png, Type: certificate', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-04 10:03:02'),
(6, 8, 'DOWNLOAD_PATH_VIOLATION', '../uploads/documents/user_8/doc_certificate_8_1756980182_e27b7d89a711cc46cc0e9c6ce8f0c601.png', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-04 10:03:06'),
(7, 8, 'DOWNLOAD_FILE_MISSING', '../uploads/documents/user_8/doc_certificate_8_1756980182_e27b7d89a711cc46cc0e9c6ce8f0c601.png', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', '2025-09-04 10:05:01'),
(8, 8, 'UPLOAD_SUCCESS', 'Document: Updated_Degree_Plan_CS.docx.pdf, Type: license', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-04 10:06:13'),
(9, 8, 'DOWNLOAD_SUCCESS', 'Document: Updated_Degree_Plan_CS.docx.pdf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-04 10:06:17'),
(10, 8, 'UPLOAD_SUCCESS', 'Document: Guatemala.png, Type: invoice', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-04 10:06:37'),
(11, 8, 'DOWNLOAD_SUCCESS', 'Document: Guatemala.png', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-04 10:06:43'),
(12, 16, 'UPLOAD_SUCCESS', 'Document: hungary.png, Type: contract', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-04 10:51:12'),
(13, 16, 'DOWNLOAD_SUCCESS', 'Document: hungary.png', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-04 10:51:20'),
(14, 5, 'UPLOAD_SUCCESS', 'Document: spain.png, Type: invoice', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-04 10:52:02'),
(15, 5, 'DOWNLOAD_SUCCESS', 'Document: spain.png', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-04 10:52:06'),
(16, 8, 'DOWNLOAD_SUCCESS', 'Document: Guatemala.png', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-08 15:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_by`, `updated_at`) VALUES
(1, 'low_stock_threshold_days', '7', 'Days before low stock alert', NULL, '2025-09-02 11:11:29'),
(2, 'expiry_warning_days', '30', 'Days before expiry warning', NULL, '2025-09-02 11:11:29'),
(3, 'system_name', 'Smart Medical Inventory', 'System name', NULL, '2025-09-02 11:11:29'),
(4, 'default_language', 'en', 'Default system language', NULL, '2025-09-02 11:11:29'),
(5, 'upload_max_file_size', '52428800', 'Maximum file size in bytes (50MB)', NULL, '2025-09-04 10:02:24'),
(6, 'upload_max_files_per_user', '1000', 'Maximum number of files per user', NULL, '2025-09-04 10:02:24'),
(7, 'upload_max_storage_per_user', '1073741824', 'Maximum storage per user in bytes (1GB)', NULL, '2025-09-04 10:02:24'),
(8, 'upload_allowed_extensions', 'pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,webp,txt,rtf', 'Allowed file extensions', NULL, '2025-09-04 10:02:24');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `transaction_type` enum('add','consume','transfer_out','transfer_in','adjustment') NOT NULL,
  `quantity` int(11) NOT NULL,
  `from_hospital_id` int(11) DEFAULT NULL,
  `to_hospital_id` int(11) DEFAULT NULL,
  `reference_number` varchar(100) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_transactions`
--

INSERT INTO `stock_transactions` (`id`, `batch_id`, `transaction_type`, `quantity`, `from_hospital_id`, `to_hospital_id`, `reference_number`, `reason`, `user_id`, `transaction_date`) VALUES
(1, 2, 'add', 500, NULL, NULL, NULL, 'Initial stock', 8, '2025-09-02 14:32:20'),
(2, 2, 'add', 10000, NULL, NULL, NULL, '', 8, '2025-09-02 14:32:39'),
(3, 2, 'transfer_out', 5000, 2, 3, 'TR-1', 'Transfer to destination hospital', 8, '2025-09-02 14:34:27'),
(4, 3, 'transfer_in', 5000, 2, 3, 'TR-1', 'Transfer from source hospital', 8, '2025-09-02 14:34:27'),
(5, 2, 'add', 1000, NULL, NULL, NULL, '', 5, '2025-09-02 14:39:19'),
(6, 2, 'add', 15000, NULL, NULL, NULL, '', 5, '2025-09-02 14:39:27'),
(7, 2, 'add', 10000, NULL, NULL, NULL, '', 8, '2025-09-03 07:30:37'),
(8, 4, 'add', 1030, NULL, NULL, NULL, 'Initial stock', 8, '2025-09-03 08:50:04'),
(9, 4, 'add', 1000, NULL, NULL, NULL, '', 8, '2025-09-03 18:54:17'),
(10, 5, 'add', 700, NULL, NULL, NULL, 'Initial stock', 5, '2025-09-04 11:11:56'),
(11, 4, 'transfer_out', 1000, 2, 3, 'TR-2', 'Transfer to destination hospital', 8, '2025-09-04 13:04:32'),
(12, 6, 'transfer_in', 1000, 2, 3, 'TR-2', 'Transfer from source hospital', 8, '2025-09-04 13:04:32'),
(13, 2, 'transfer_out', 25000, 2, 3, 'TR-3', 'Superadmin instant transfer', 8, '2025-09-04 13:04:56'),
(14, 3, 'transfer_in', 25000, 2, 3, 'TR-3', 'Superadmin instant transfer', 8, '2025-09-04 13:04:56'),
(15, 4, 'transfer_out', 500, 2, 3, 'TR-5', 'Superadmin instant transfer', 8, '2025-09-08 12:18:39'),
(16, 6, 'transfer_in', 500, 2, 3, 'TR-5', 'Superadmin instant transfer', 8, '2025-09-08 12:18:39'),
(17, 7, 'add', 12, NULL, NULL, NULL, 'Initial stock', 8, '2025-09-08 12:27:39'),
(18, 4, 'transfer_out', 110, 2, 3, 'TR-6', 'Superadmin instant transfer', 8, '2025-09-08 12:29:00'),
(19, 6, 'transfer_in', 110, 2, 3, 'TR-6', 'Superadmin instant transfer', 8, '2025-09-08 12:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `phone`, `email`, `address`, `license_number`, `is_active`, `created_at`) VALUES
(1, 'Medical Supply Co', 'John Supplier', '+1-555-SUPPLY', 'contact@supply.com', '456 Supply St', NULL, 1, '2025-09-02 13:34:30');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_requests`
--

CREATE TABLE `transfer_requests` (
  `request_type` enum('hospital_to_hospital','hospital_to_supplier') NOT NULL DEFAULT 'hospital_to_hospital',
  `id` int(11) NOT NULL,
  `from_hospital_id` int(11) NOT NULL,
  `to_hospital_id` int(11) DEFAULT NULL,
  `from_supplier_id` int(11) DEFAULT NULL,
  `to_supplier_id` int(11) DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `requested_quantity` int(11) NOT NULL,
  `approved_quantity` int(11) DEFAULT 0,
  `status` enum('pending','approved','rejected','completed','cancelled') DEFAULT 'pending',
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `requested_by` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_date` timestamp NULL DEFAULT NULL,
  `completed_date` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transfer_requests`
--

INSERT INTO `transfer_requests` (`request_type`, `id`, `from_hospital_id`, `to_hospital_id`, `from_supplier_id`, `to_supplier_id`, `item_id`, `requested_quantity`, `approved_quantity`, `status`, `priority`, `requested_by`, `approved_by`, `request_date`, `approved_date`, `completed_date`, `notes`, `admin_notes`) VALUES
('hospital_to_hospital', 1, 2, 3, NULL, NULL, 2, 5000, 5000, 'completed', 'medium', 17, 17, '2025-09-02 14:33:25', '2025-09-02 14:33:30', NULL, '', NULL),
('hospital_to_hospital', 2, 2, 3, NULL, NULL, 3, 1000, 1000, 'completed', 'medium', 8, 8, '2025-09-04 13:00:38', '2025-09-04 13:00:48', NULL, '', ''),
('hospital_to_hospital', 3, 2, 3, NULL, NULL, 2, 25000, 25000, 'completed', 'medium', 8, 8, '2025-09-04 13:04:56', '2025-09-04 13:04:56', '2025-09-04 13:04:56', '', 'Superadmin instant transfer - no approval required'),
('hospital_to_hospital', 5, 2, 3, NULL, NULL, 3, 500, 500, 'completed', 'medium', 8, 8, '2025-09-08 12:18:39', '2025-09-08 12:18:39', '2025-09-08 12:18:39', 'hello', 'Superadmin instant transfer - no approval required'),
('hospital_to_hospital', 6, 2, 3, NULL, NULL, 3, 110, 110, 'completed', 'medium', 8, 8, '2025-09-08 12:29:00', '2025-09-08 12:29:00', '2025-09-08 12:29:00', '', 'Superadmin instant transfer - no approval required'),
('hospital_to_hospital', 8, 3, 2, NULL, NULL, 3, 100, 100, 'approved', 'medium', 16, 8, '2025-09-08 15:03:40', '2025-09-09 09:30:42', NULL, '', ''),
('hospital_to_supplier', 10, 3, NULL, NULL, 1, 4, 150, 150, 'approved', 'medium', 16, 8, '2025-09-08 15:17:44', '2025-09-09 09:30:40', NULL, '', ''),
('hospital_to_supplier', 11, 5, NULL, NULL, 1, 3, 100, 100, 'approved', 'medium', 19, 8, '2025-09-08 15:37:58', '2025-09-09 09:30:36', NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_requests_backup`
--

CREATE TABLE `transfer_requests_backup` (
  `id` int(11) NOT NULL DEFAULT 0,
  `from_hospital_id` int(11) NOT NULL,
  `to_hospital_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `requested_quantity` int(11) NOT NULL,
  `approved_quantity` int(11) DEFAULT 0,
  `status` enum('pending','approved','rejected','completed') DEFAULT 'pending',
  `requested_by` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_date` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transfer_requests_backup`
--

INSERT INTO `transfer_requests_backup` (`id`, `from_hospital_id`, `to_hospital_id`, `item_id`, `requested_quantity`, `approved_quantity`, `status`, `requested_by`, `approved_by`, `request_date`, `approved_date`, `notes`) VALUES
(1, 2, 3, 2, 5000, 5000, 'completed', 17, 17, '2025-09-02 14:33:25', '2025-09-02 14:33:30', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','admin','staff','supplier') NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `language` enum('en','bn') DEFAULT 'en',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `full_name`, `phone`, `hospital_id`, `supplier_id`, `language`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 'staff', 'staff@test.com', '$2y$10$wZc/cqQRzAWITiFx6zfFZubuj/XIaInMkouDDqYwx/u8mJ9GEoP7i', 'staff', 'Hospital Staff', '+1-000-000-0003', 1, NULL, 'en', 1, '2025-09-02 13:30:42', '2025-09-03 08:52:32'),
(5, 'supplier', 'supplier@test.com', '$2y$10$wZc/cqQRzAWITiFx6zfFZubuj/XIaInMkouDDqYwx/u8mJ9GEoP7i', 'supplier', 'Medical Supplier', '+1-000-000-0004', NULL, 1, 'en', 1, '2025-09-02 13:30:42', '2025-09-04 13:07:01'),
(8, 'superadmin', 'superadmin@hospital.com', '$2y$10$UnDAD5E8tLv5yMkkfNhCCO/mLEeBtXycYUi.V39Cq5/OTMQPNSWie', 'superadmin', 'Super Administrator', '+1-555-0002', 1, NULL, 'en', 1, '2025-09-02 13:34:31', '2025-09-09 09:32:13'),
(16, 'popularhospital', 'popularlhospital2025@gmail.com', '$2y$10$W.x1QCv3kKet9MGLx.vsr.9UIc27/xFPVKExLtJIan0c/MoZc.44O', 'admin', 'Popular Hospital', '01959066945', 3, NULL, 'en', 1, '2025-09-02 14:02:05', '2025-09-08 15:09:59'),
(17, 'pghospital', 'pghospital@gmail.com', '$2y$10$4phwy2xWNTq/tyWJp5XKO.WTIwlDIxqKhMetjb4hHvd2gaZvmcVdO', 'admin', 'PG HOSPITAL', '01959069947', 2, NULL, 'en', 1, '2025-09-02 14:06:08', '2025-09-04 13:06:17'),
(19, 'shahbaghospital', 'shahbaghospital11@gmail.com', '$2y$10$NCg6FfcqpzBnebB.q8mVf.A8KSozhKgbAMu3OHrcMVsQ8HPYIoWdW', 'admin', 'shahbag Hospital', '01959066943', 5, NULL, 'en', 1, '2025-09-08 12:25:19', '2025-09-08 15:37:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `document_type` enum('invoice','contract','license','certificate','warranty','approval') NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `stored_filename` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_extension` varchar(10) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_documents`
--

INSERT INTO `user_documents` (`id`, `user_id`, `document_type`, `original_filename`, `stored_filename`, `file_path`, `file_size`, `file_extension`, `mime_type`, `description`, `upload_date`, `is_active`) VALUES
(1, 8, 'license', 'Screenshot_39.png', 'doc_license_8_1756979931_a7162717e4545b212754e26bf7068972.png', '../uploads/documents/user_8/doc_license_8_1756979931_a7162717e4545b212754e26bf7068972.png', 210641, 'png', 'image/png', '', '2025-09-04 09:58:51', 0),
(2, 8, 'license', 'Screenshot_39.png', 'doc_license_8_1756979995_f32cffa97d9a482d2490e6e6164021e6.png', '../uploads/documents/user_8/doc_license_8_1756979995_f32cffa97d9a482d2490e6e6164021e6.png', 210641, 'png', 'image/png', 'hello', '2025-09-04 09:59:55', 0),
(3, 8, 'certificate', 'COLOMBIA.png', 'doc_certificate_8_1756980182_e27b7d89a711cc46cc0e9c6ce8f0c601.png', '../uploads/documents/user_8/doc_certificate_8_1756980182_e27b7d89a711cc46cc0e9c6ce8f0c601.png', 767670, 'png', 'image/png', 'hello', '2025-09-04 10:03:02', 0),
(4, 8, 'license', 'Updated_Degree_Plan_CS.docx.pdf', 'doc_license_8_1756980373_ef54f86bf334d7f6f1bf9e3830e2a634.pdf', 'C:\\xampp\\htdocs\\presentation/uploads/documents/user_8/doc_license_8_1756980373_ef54f86bf334d7f6f1bf9e3830e2a634.pdf', 273110, 'pdf', 'application/pdf', '', '2025-09-04 10:06:13', 1),
(5, 8, 'invoice', 'Guatemala.png', 'doc_invoice_8_1756980397_7723150f38e26c92f399a645150c005d.png', 'C:\\xampp\\htdocs\\presentation/uploads/documents/user_8/doc_invoice_8_1756980397_7723150f38e26c92f399a645150c005d.png', 1161841, 'png', 'image/png', '', '2025-09-04 10:06:37', 1),
(6, 16, 'contract', 'hungary.png', 'doc_contract_16_1756983072_d6b6f74cebf1abf032d42d460d10f99b.png', 'C:\\xampp\\htdocs\\presentation/uploads/documents/user_16/doc_contract_16_1756983072_d6b6f74cebf1abf032d42d460d10f99b.png', 1051229, 'png', 'image/png', '', '2025-09-04 10:51:12', 1),
(7, 5, 'invoice', 'spain.png', 'doc_invoice_5_1756983122_2561796e99eb4c04328e0dc793fe56a7.png', 'C:\\xampp\\htdocs\\presentation/uploads/documents/user_5/doc_invoice_5_1756983122_2561796e99eb4c04328e0dc793fe56a7.png', 1261096, 'png', 'image/png', 'hello', '2025-09-04 10:52:02', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `idx_alerts_hospital` (`hospital_id`),
  ADD KEY `idx_alerts_unread` (`is_read`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `hospital_id` (`hospital_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `frontend_content`
--
ALTER TABLE `frontend_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_section_key` (`section`,`content_key`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_batches`
--
ALTER TABLE `inventory_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `idx_inventory_hospital` (`hospital_id`),
  ADD KEY `idx_inventory_item` (`item_id`),
  ADD KEY `idx_inventory_expiry` (`expiry_date`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qr_code` (`qr_code`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `report_generations`
--
ALTER TABLE `report_generations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_id` (`report_id`),
  ADD KEY `hospital_filter` (`hospital_filter`),
  ADD KEY `category_filter` (`category_filter`),
  ADD KEY `idx_report_generations_user` (`generated_by`),
  ADD KEY `idx_report_generations_type` (`report_type`),
  ADD KEY `idx_report_generations_date` (`generation_date`),
  ADD KEY `idx_report_generations_report_id` (`report_id`);

--
-- Indexes for table `security_logs`
--
ALTER TABLE `security_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_security_logs_user` (`user_id`),
  ADD KEY `idx_security_logs_event` (`event_type`),
  ADD KEY `idx_security_logs_date` (`created_at`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_hospital_id` (`from_hospital_id`),
  ADD KEY `to_hospital_id` (`to_hospital_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_transactions_batch` (`batch_id`),
  ADD KEY `idx_transactions_date` (`transaction_date`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_requests`
--
ALTER TABLE `transfer_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_hospital_id` (`from_hospital_id`),
  ADD KEY `to_hospital_id` (`to_hospital_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `requested_by` (`requested_by`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `fk_transfer_from_supplier` (`from_supplier_id`),
  ADD KEY `fk_transfer_to_supplier` (`to_supplier_id`),
  ADD KEY `idx_transfer_request_type` (`request_type`),
  ADD KEY `idx_transfer_status` (`status`),
  ADD KEY `idx_transfer_date` (`request_date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_documents_user` (`user_id`),
  ADD KEY `idx_user_documents_type` (`document_type`),
  ADD KEY `idx_user_documents_date` (`upload_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontend_content`
--
ALTER TABLE `frontend_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory_batches`
--
ALTER TABLE `inventory_batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `report_generations`
--
ALTER TABLE `report_generations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `security_logs`
--
ALTER TABLE `security_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transfer_requests`
--
ALTER TABLE `transfer_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`),
  ADD CONSTRAINT `alerts_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `alerts_ibfk_3` FOREIGN KEY (`batch_id`) REFERENCES `inventory_batches` (`id`);

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chat_messages_ibfk_3` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`),
  ADD CONSTRAINT `chat_messages_ibfk_4` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `inventory_batches`
--
ALTER TABLE `inventory_batches`
  ADD CONSTRAINT `inventory_batches_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `inventory_batches_ibfk_2` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`),
  ADD CONSTRAINT `inventory_batches_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `report_generations`
--
ALTER TABLE `report_generations`
  ADD CONSTRAINT `report_generations_ibfk_1` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_generations_ibfk_2` FOREIGN KEY (`hospital_filter`) REFERENCES `hospitals` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `report_generations_ibfk_3` FOREIGN KEY (`category_filter`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `security_logs`
--
ALTER TABLE `security_logs`
  ADD CONSTRAINT `security_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD CONSTRAINT `stock_transactions_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `inventory_batches` (`id`),
  ADD CONSTRAINT `stock_transactions_ibfk_2` FOREIGN KEY (`from_hospital_id`) REFERENCES `hospitals` (`id`),
  ADD CONSTRAINT `stock_transactions_ibfk_3` FOREIGN KEY (`to_hospital_id`) REFERENCES `hospitals` (`id`),
  ADD CONSTRAINT `stock_transactions_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transfer_requests`
--
ALTER TABLE `transfer_requests`
  ADD CONSTRAINT `fk_transfer_from_supplier` FOREIGN KEY (`from_supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `fk_transfer_to_supplier` FOREIGN KEY (`to_supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `transfer_requests_ibfk_1` FOREIGN KEY (`from_hospital_id`) REFERENCES `hospitals` (`id`),
  ADD CONSTRAINT `transfer_requests_ibfk_2` FOREIGN KEY (`to_hospital_id`) REFERENCES `hospitals` (`id`),
  ADD CONSTRAINT `transfer_requests_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `transfer_requests_ibfk_4` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transfer_requests_ibfk_5` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD CONSTRAINT `user_documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
