-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 08:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zenithzone`
--

-- --------------------------------------------------------

--
-- Table structure for table `artist_info`
--

CREATE TABLE `artist_info` (
  `artist_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `nid_number` varchar(17) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `artist_picture` varchar(255) NOT NULL,
  `nid_picture` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artist_info`
--

INSERT INTO `artist_info` (`artist_id`, `first_name`, `last_name`, `email`, `mobile_number`, `gender`, `nid_number`, `date_of_birth`, `address`, `postal_code`, `artist_picture`, `nid_picture`, `password_hash`) VALUES
(8, 'Raj', 'Kumar', 'rahatmi0001@gmail.com', '01794353669', 'male', '3736367628', '2024-11-06', 'Habiganj sadar', '3300', 'artistpic/01780492587.png', 'artistnid/01780492587.jpg', '$2y$10$TS34.VQ13X9OC3Vv9Yv.SuU3qGXLfnskzIOG6.b5Wc96Z3DFdE13a'),
(9, 'Nafisa', 'Jasim', 'rahatmidf0001@gmail.com', '01756459179', 'female', '3736367629', '2024-11-28', 'Habiganj sadar', '3300', 'artistpic/01756459179.png', 'artistnid/01756459179.jpg', '$2y$10$xG5HOWUc1pIEbcJ5SSl2t.zji/GjisOWXflXgouvi.59ME4xxiwlK');

-- --------------------------------------------------------

--
-- Table structure for table `artist_wallet`
--

CREATE TABLE `artist_wallet` (
  `wallet_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artist_wallet`
--

INSERT INTO `artist_wallet` (`wallet_id`, `artist_id`, `balance`, `created_at`) VALUES
(1, 8, 3000.00, '2024-12-04 06:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `art_bids`
--

CREATE TABLE `art_bids` (
  `bid_id` int(11) NOT NULL,
  `art_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `bid_amount` decimal(10,2) NOT NULL,
  `bid_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `art_gallery`
--

CREATE TABLE `art_gallery` (
  `art_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `art_name` varchar(255) NOT NULL,
  `art_description` text DEFAULT NULL,
  `art_img` varchar(255) DEFAULT NULL,
  `art_init_price` decimal(10,2) NOT NULL,
  `previous_bid_price` decimal(10,2) DEFAULT NULL,
  `final_bid_price` decimal(10,2) DEFAULT NULL,
  `bid_status` enum('active','pending','closed') DEFAULT 'active',
  `bid_end_date` datetime DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `num_bids` int(11) DEFAULT 0,
  `winner_customer_id` int(11) DEFAULT NULL,
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `art_gallery`
--

INSERT INTO `art_gallery` (`art_id`, `artist_id`, `art_name`, `art_description`, `art_img`, `art_init_price`, `previous_bid_price`, `final_bid_price`, `bid_status`, `bid_end_date`, `creation_date`, `num_bids`, `winner_customer_id`, `approval_status`) VALUES
(9, 8, 'Nature Beautiful', 'jfhgj fghjf gkj', '../art_gallery67509f8669aa7_5.jpg', 545.00, NULL, NULL, 'active', NULL, '2024-12-05 00:29:26', 0, NULL, 'pending'),
(10, 8, 'Nature Beautiful lmjk', 'fdggjhfghj', '../art_gallery6750a06a68904_your_bid.jpg', 453.00, NULL, NULL, 'active', '2024-12-19 00:43:00', '2024-12-05 00:33:14', 0, NULL, 'approved'),
(11, 8, 'Nature Beautiful lmjk', 'fghjgh fhgjfg', '../art_gallery6750a0bbc4ba7_we.jpg', 12354.00, NULL, NULL, 'active', NULL, '2024-12-05 00:34:35', 0, NULL, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `autocom`
--

CREATE TABLE `autocom` (
  `products` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `autocom`
--

INSERT INTO `autocom` (`products`) VALUES
('Laptop'),
('Smartphone'),
('Headphones'),
('Gaming Console'),
('Smartwatch'),
('Camera'),
('Tablet'),
('Wireless Mouse'),
('Bluetooth Speaker'),
('Fitness Tracker'),
('Monitor'),
('Keyboard'),
('External Hard Drive'),
('Printer'),
('Drone'),
('Desktop Computer'),
('TV'),
('Router'),
('Power Bank'),
('Charger'),
('USB Flash Drive'),
('Memory Card'),
('Graphics Card'),
('Motherboard'),
('Processor'),
('RAM'),
('Cooling Fan'),
('Webcam'),
('Projector'),
('Microphone'),
('VR Headset'),
('Smart Glasses'),
('Fitness Band'),
('Smart Ring'),
('Bluetooth Earbuds'),
('Smart Home Hub'),
('Smart Light Bulb'),
('Smart Plug'),
('Smart Thermostat'),
('Security Camera'),
('Video Doorbell'),
('Robot Vacuum'),
('Electric Scooter'),
('Hoverboard'),
('3D Printer'),
('Drone Camera'),
('Portable Speaker'),
('Wireless Charger'),
('Phone Case'),
('Screen Protector'),
('Laptop Sleeve'),
('Laptop Stand'),
('Keyboard Cover'),
('Mouse Pad'),
('Desk Lamp'),
('Gaming Chair'),
('Gaming Desk'),
('Portable Monitor'),
('External SSD'),
('Network Switch'),
('Modem'),
('Bluetooth Adapter'),
('Ethernet Cable'),
('USB Hub'),
('Docking Station'),
('Surge Protector'),
('UPS Battery Backup'),
('Laptop Charger'),
('Projector Screen'),
('Conference Speakerphone'),
('Document Scanner'),
('Label Printer'),
('Barcode Scanner'),
('Photo Printer'),
('E-Reader'),
('Portable Power Station'),
('Solar Charger'),
('Action Camera'),
('Camcorder'),
('Digital Photo Frame'),
('Graphic Tablet'),
('Drawing Monitor'),
('Laser Printer'),
('Inkjet Printer'),
('Thermal Printer'),
('POS System'),
('Cash Register'),
('Receipt Printer'),
('Portable Air Conditioner'),
('Smart Fan'),
('Electric Heater'),
('Air Purifier'),
('Dehumidifier'),
('Humidifier'),
('Smart Lock'),
('Fingerprint Door Lock'),
('Smart Doorbell'),
('Home Security System'),
('Fire Alarm'),
('Smoke Detector'),
('CO Detector'),
('Water Leak Detector'),
('Motion Sensor'),
('Window Sensor'),
('Door Sensor'),
('Security Alarm'),
('Smart Blinds'),
('Smart Curtains'),
('Solar Lights'),
('LED Strip Lights'),
('String Lights'),
('Smart Switch'),
('Dimmer Switch'),
('Motion-Activated Light'),
('Recessed Lighting'),
('Track Lighting'),
('Pendant Light'),
('Chandelier'),
('Ceiling Fan'),
('Table Lamp'),
('Floor Lamp'),
('Wall Sconce'),
('Under Cabinet Lighting'),
('Night Light'),
('Desk Organizer'),
('Cable Management'),
('Monitor Stand'),
('Laptop Desk'),
('Foot Rest'),
('Ergonomic Chair'),
('Standing Desk'),
('Monitor Arm'),
('Keyboard Tray'),
('Desk Shelf'),
('Desk Drawer'),
('Desk Pad'),
('Pen Holder'),
('Bookend'),
('Magazine Rack'),
('File Cabinet'),
('File Organizer'),
('Document Holder'),
('Paper Shredder'),
('Letter Tray'),
('Mail Organizer'),
('Trash Can'),
('Recycling Bin'),
('Whiteboard'),
('Bulletin Board'),
('Cork Board'),
('Desk Calendar'),
('Planner'),
('Notebook'),
('Journal'),
('Sticky Notes'),
('Highlighters'),
('Markers'),
('Pens'),
('Pencils'),
('Stapler'),
('Staples'),
('Paper Clips'),
('Binder Clips'),
('Rubber Bands'),
('Scissors'),
('Tape Dispenser'),
('Hole Punch'),
('Glue Stick'),
('Ruler'),
('Calculator'),
('Label Maker'),
('Envelope'),
('Mailing Labels'),
('Shipping Labels'),
('Packing Tape'),
('Bubble Wrap'),
('Packing Peanuts'),
('Shipping Box'),
('Packing List'),
('Invoice'),
('Receipt Book'),
('Bill of Lading'),
('Packing Slip'),
('Return Label'),
('Shipping Scale'),
('Address Label'),
('Thermal Label Printer'),
('Laser Label Printer'),
('Inkjet Label Printer'),
('Label Tape'),
('Label Holder'),
('Label Dispenser'),
('Label Rewinder'),
('Label Applicator'),
('Handheld Labeler'),
('Portable Label Printer'),
('Desktop Label Printer'),
('Industrial Label Printer'),
('Barcode Printer'),
('Wristband Printer'),
('Tag Printer'),
('Card Printer'),
('ID Card Printer'),
('Membership Card Printer'),
('Business Card Printer'),
('Photo ID Printer'),
('Plastic Card Printer'),
('RFID Card Printer'),
('Smart Card Printer'),
('Magnetic Stripe Card Printer'),
('Embossing Machine'),
('Encoding Machine'),
('Card Laminator'),
('Card Cutter'),
('Card Punch'),
('Card Holder'),
('Card Sleeve'),
('Card Case'),
('Badge Reel'),
('Badge Clip'),
('Lanyard'),
('Badge Holder'),
('Badge Slot Punch'),
('Badge Printer'),
('ID Badge'),
('Visitor Badge'),
('Event Badge'),
('Security Badge'),
('Employee Badge'),
('Student ID'),
('Access Control Card'),
('Key Fob'),
('Proximity Card'),
('Smart Key'),
('Electronic Lock'),
('Biometric Lock'),
('RFID Lock'),
('Access Control System'),
('Door Access Control'),
('Gate Access Control'),
('Turnstile'),
('Barrier Gate'),
('Parking System'),
('Intercom System'),
('Video Intercom'),
('Audio Intercom'),
('IP Intercom'),
('Wireless Intercom'),
('Two-Way Radio'),
('Walkie Talkie'),
('Paging System'),
('Public Address System'),
('Sound Masking System'),
('Conference System'),
('AV System'),
('Broadcast System'),
('CCTV System'),
('Surveillance System');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `customer_id`, `created_at`, `updated_at`) VALUES
(5, 6, '2024-11-25 04:56:04', '2024-11-25 04:56:04'),
(6, 7, '2024-11-29 12:21:07', '2024-11-29 12:21:07');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `product_id`, `added_at`) VALUES
(19, 5, 77, '2024-11-27 21:32:59'),
(26, 6, 246, '2024-11-30 11:36:25'),
(27, 5, 315, '2024-11-30 12:01:04'),
(28, 5, 66, '2024-12-02 13:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `coupon_id` int(11) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `coupon_name` varchar(100) NOT NULL,
  `coupon_description` text DEFAULT NULL,
  `discount_rate` int(3) DEFAULT NULL CHECK (`discount_rate` between 1 and 100),
  `minimum_price` decimal(10,2) DEFAULT 0.00,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`coupon_id`, `coupon_code`, `coupon_name`, `coupon_description`, `discount_rate`, `minimum_price`, `start_date`, `end_date`, `status`) VALUES
(22, 'Rajib', 'This is Rajib', 'This a coupon which provide you some discount ', 9, 499.00, '2024-12-03 01:44:00', '2024-12-11 01:44:00', 'Active'),
(23, 'Nafisa21', 'This is Nafisa\'s Coupon', 'Apply this code and get 15% discount over the project. ', 15, 700.00, '2024-12-03 11:40:00', '2024-12-27 11:40:00', 'Active'),
(24, 'Nadia24', 'This is Nadia\'s Coupon', 'eid', 9, 500.00, '2024-12-05 11:41:00', '2024-12-23 11:41:00', 'Active'),
(25, 'Nisha01', 'This is Nisha\'s Coupon', 'qurbani eid', 3, 99.00, '2024-12-01 14:44:00', '2024-12-10 03:44:00', 'Active'),
(26, 'Bijoy71', 'Bijoy Dibos', 'Tjsfd fjkvh', 7, 500.00, '2024-12-03 17:09:00', '2024-12-17 17:10:00', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `customer_info`
--

CREATE TABLE `customer_info` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `nid_number` varchar(17) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `address` text NOT NULL,
  `customer_picture` varchar(255) NOT NULL,
  `nid_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_info`
--

INSERT INTO `customer_info` (`customer_id`, `first_name`, `last_name`, `email`, `mobile_number`, `password`, `gender`, `nid_number`, `date_of_birth`, `address`, `customer_picture`, `nid_picture`) VALUES
(6, 'Rajib', 'Kumar Dhar', 'rrajibkd@gmail.com', '01660029173', '$2y$10$QwlIKNgOjGTZSLIaVEIdm.QxRcQiE9djne7kw8LGIbRuPGjzWSrxK', 'male', NULL, '2024-11-29', 'Rowshan villa, Housing pond 2, Housing state', '../uploads/customers/customer_674ca53befe204.09641165.png', ''),
(7, 'Nisha', 'Akthar', 'zenkepler@fearlessmails.com', '01537436170', '$2y$10$.VvWuDcESNB1Tc/9k3ci5u5y9aJjtzzKgoGsagAyHQB63E.zkamvy', 'female', NULL, '2024-11-30', 'Rowshan villa, Housing pond 2, Housing state', '', ''),
(8, 'Rahul', 'Kumar', 'rajibinf00@gmail.com', '01780492587', '$2y$10$TAidPjNeTsnCLAGO1WNpgePuTkn9ow72Cky3iJFjZsdBKxPIFYmZa', 'male', NULL, '0000-00-00', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer_wallet`
--

CREATE TABLE `customer_wallet` (
  `wallet_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_wallet`
--

INSERT INTO `customer_wallet` (`wallet_id`, `customer_id`, `balance`, `created_at`) VALUES
(1, 6, 187806.00, '2024-12-01 18:19:40'),
(2, 7, 54000.00, '2024-12-02 09:26:07'),
(5, 8, 1000.00, '2024-12-04 06:32:40');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`) VALUES
(2, 6),
(3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `Sh_product_id` int(11) DEFAULT NULL,
  `art_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Canceled','Shipping','Complete') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `Sh_product_id`, `art_id`, `quantity`, `order_amount`, `status`, `created_at`) VALUES
(101, 2, 107, NULL, NULL, 5, 22620.00, 'Canceled', '2024-11-30 08:53:24'),
(102, 2, 107, NULL, NULL, 5, 22620.00, 'Pending', '2024-11-30 08:53:34'),
(103, 2, 107, NULL, NULL, 5, 22620.00, 'Shipping', '2024-11-30 09:05:14'),
(104, 2, 335, NULL, NULL, 1, 102019.00, 'Complete', '2024-11-30 09:21:24'),
(105, 3, 137, NULL, NULL, 1, 3645.60, 'Complete', '2024-12-03 11:11:24'),
(106, 2, 309, NULL, NULL, 1, 1064.70, 'Pending', '2024-12-04 05:32:08'),
(107, 2, 353, NULL, NULL, 1, 4320.00, 'Complete', '2024-12-04 10:38:15'),
(110, 2, NULL, 26, NULL, 1, 245574.00, 'Pending', '2024-12-04 14:50:05'),
(111, 2, NULL, 26, NULL, 1, 245574.00, 'Pending', '2024-12-04 14:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `product_info`
--

CREATE TABLE `product_info` (
  `Product_id` int(11) NOT NULL,
  `Product_code` varchar(50) NOT NULL,
  `Product_name` varchar(255) NOT NULL,
  `Product_category` varchar(100) DEFAULT NULL,
  `Product_Description` text DEFAULT NULL,
  `Product_image_path` varchar(255) DEFAULT NULL,
  `Old_price` decimal(10,2) DEFAULT NULL,
  `New_price` decimal(10,2) DEFAULT NULL,
  `Stock_quantity` int(11) DEFAULT NULL,
  `Stock_status` varchar(50) DEFAULT NULL,
  `Rating` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_info`
--

INSERT INTO `product_info` (`Product_id`, `Product_code`, `Product_name`, `Product_category`, `Product_Description`, `Product_image_path`, `Old_price`, `New_price`, `Stock_quantity`, `Stock_status`, `Rating`) VALUES
(126, 'B001', 'Women Summer Large Capacity Handbags Tote Straw Bags Shoulder Bag', 'Bag', 'A large, open-top bag with parallel handles, ideal for carrying everyday essentials. It often has a spacious interior and can be made from various materials like canvas, leather, or fabric.', '../Products/Bag/B001.jpg', 2590.00, 2350.00, 50, 'Yes', 3.00),
(127, 'B002', 'Fashionable crossbody/Side hand bag for women/Girls', 'Bag', 'A structured bag with a flat bottom, often featuring a flap closure and a long strap. Satchels are medium to large in size and can be carried by hand or worn over the shoulder.', '../Products/Bag/B002.jpg', 2490.00, 2350.00, 599, 'Yes', 3.00),
(128, 'B003', 'Fashionable crossbody/Side hand bag for women/Girls', 'Bag', 'A versatile handbag with a single strap that is long enough to be worn over the shoulder. It comes in various sizes and styles, making it suitable for different occasions.', '../Products/Bag/B003.jpg', 2590.00, 2350.00, 599, 'Yes', 3.00),
(129, 'B004', 'Large Capacity Shoulder Fashionable Handbag For Women', 'Bag', 'A compact bag with a long strap worn across the body. It keeps your hands free and is ideal for carrying essentials like a phone, wallet, and keys', '../Products/Bag/B004.jpg', 2790.00, 2350.00, 599, 'Yes', 3.00),
(130, 'B005', 'Fashionable crossbody/Side bag hand bag for women/Girls', 'Bag', 'A small, handheld bag without handles or straps. Clutches are  used for evening events and can be embellished with beads, sequins, or other decorative elements.', '../Products/Bag/B005.jpg', 2590.00, 2350.00, 599, 'Yes', 3.00),
(131, 'B006', '2023 New Fashion Summer Large Capacity Casual Nylon Women Shoulder Bag Korean Style Hobos Bag Youth Crossbody Shoulder Bag', 'Bag', 'A crescent-shaped, slouchy bag with a single shoulder strap. Hobo bags are soft and unstructured, providing a relaxed, casual look', '../Products/Bag/B006.avif', 2590.00, 2350.00, 599, 'Yes', 3.00),
(132, 'B007', 'Y2K Style Shoulder Bag For Women Trendy Motorcycle Handbag Minimalist Shoulder Purse For Girls Street Wear', 'Bag', 'A small to medium-sized backpack designed for women. It combines the practicality of a backpack with the style of a purse and often features multiple compartments', '../Products/Bag/B007.avif', 4200.00, 2350.00, 599, 'Yes', 3.00),
(133, 'B008', 'Premium Quality leather PU Fashionable Shoulder Bag for Women for girls(9.5x6x3inc)', 'Bag', 'A bag with a round or oval base and a drawstring closure at the top. Bucket bags are often spacious and come with a long strap, making them easy to carry over the shoulder or crossbody.', '../Products/Bag/B008.jpg', 4300.00, 2350.00, 599, 'Yes', 3.00),
(134, 'B009', 'Niche Design Handbag Star Female Student Large Capacity Commuting Tote Corduroy Shoulder Crossbody Bag 2023 New', 'Bag', 'A small bag or clutch with a strap that wraps around the wrist. Wristlets are compact and perfect for carrying essentials like cards, cash, and a phone.', '../Products/Bag/B009.jpg', 4400.00, 2350.00, 56, 'Yes', 3.00),
(135, 'B010', 'Pearl Stylish Ladies Hand Bag Black color - bag for girls- Avant-garde Preferable', 'Bag', 'A slim, rectangular bag with a flap closure resembling an envelope. Envelope bags are sleek and often used as clutches for formal occasions.', '../Products/Bag/B010.jpg', 4200.00, 2350.00, 45, 'Yes', 3.00),
(136, 'B011', 'MYHOZEE Canvas Tote Bag - Large Aesthetic Hobo Shoulder Purse for Women', 'Bag', 'A large, flat bag with a long strap worn across the body. Originally used by couriers, messenger bags are practical and  used for carrying laptops and documents.', '../Products/Bag/B011.jpg', 4200.00, 2350.00, 45, 'Yes', 3.00),
(137, 'B012', 'Retro Canvas Mini Tote Bag with Zipper for Women | Crossbody Purse Handbag', 'Bag', '✅【HIGH QUALITY CANVAS】 The retro canvas tote bag is made of high-quality encrypted canvas, which is wear-resistant and good in texture, durable to use. ✅【MINI TOTE BAG】 Size: 12.60x11.42x5.51in. It not a normal size tote bag, but still roomy to fit your daily needs. You can easily take your iPad, cell phone, wallet, makeup, glasses, etc. with you. ✅【FINE WORKMANSHIP】 Reinforce the seams to strengthen the connection between the shoulder strap and the bag. The shoulder strap is length adjustable to meet your needs. ✅【SUITABLE OCCASIONS】 The canvas crossbody bag is suitable for office, shopping, appointments, weekends, schools, travel bags, etc. It is also a ideal gift for your friends, families, etc. ✅【CUSTOMER SATISFACTION SERVICE】 We provide professional customer service before and after purchase. If there is any quality issue with the canvas handbag, please feel free to contact us.', '../Products/Bag/B012.jpg', 4200.00, 3800.00, 45, 'Yes', 3.00),
(138, 'B013', 'David Jones Paris women tote bag pu leather shoulder bag female crossbody bag handbag', 'Bag', 'DAVIDJONES , a brand comes from Paris since 1987.We are committed to provide our customer trendy and stylish women bags.Over the years, we have been selling to more than 100 countries at prices that make keeping up with seasonal styles a luxury within reach.DAVID JONES is the lifestyle brand for people who are Positive, Authentic, and Bursting with personality.We thank you for your great support.\nBRAND:David Jones\nITEM NO:CM6827\nMATERIAL: Soft Canvas\nMETAL:Quality Golden hardware accents its chic\nLINING:Polyester&DAVIDJONES Logo Signature\nDIMENSION:10.2\"(L)x4.7\"(W)x7.5\"(H) 26x12x19cm\nWEIGHT:0.9kg\nPACKAGE WEIGHT:0.9kg\nCLOSURE:Zipper closure', '../Products/Bag/B013.jpg', 4200.00, 3800.00, 45, 'Yes', 3.00),
(139, 'B014', 'David Jones Paris tote bag women sling bag ladies handbag branded shopping bag leather shoulder bag 2022', 'Bag', 'DAVIDJONES , a brand comes from Paris since 1987.We are committed to provide our customer trendy and stylish women bags.Over the years, we have been selling to more than 100 countries at prices that make keeping up with seasonal styles a luxury within reach.DAVID JONES is the lifestyle brand for people who are Positive, Authentic, and Bursting with personality.We thank you for your great support.\nBRAND:David Jones\nITEM NO:6912-1\nMATERIAL: Soft Canvas\nMETAL:Quality silver hardware accents its chic\nLINING:Polyester&DAVIDJONES Logo Signature\nDIMENSION:10.6\"(L)x4.7\"(W)x10.2\"(H) 27x12x26cm\nWEIGHT:0.7kg\nPACKAGE WEIGHT:0.8kg\nCLOSURE:Zipper closure', '../Products/Bag/B014.jpg', 4200.00, 3800.00, 45, 'Yes', 3.00),
(140, 'B015', 'David Jones Paris women tote bag pu leather shoulder bag female crossbody bag handbag', 'Bag', 'DAVIDJONES , a brand comes from Paris since 1987.We are committed to provide our customer trendy and stylish women bags.Over the years, we have been selling to more than 100 countries at prices that make keeping up with seasonal styles a luxury within reach.DAVID JONES is the lifestyle brand for people who are Positive, Authentic, and Bursting with personality.We thank you for your great support.\nBRAND:David Jones\nITEM NO:CM6827\nMATERIAL: Soft Canvas\nMETAL:Quality Golden hardware accents its chic\nLINING:Polyester&DAVIDJONES Logo Signature\nDIMENSION:10.2\"(L)x4.7\"(W)x7.5\"(H) 26x12x19cm\nWEIGHT:0.9kg\nPACKAGE WEIGHT:0.9kg\nCLOSURE:Zipper closure', '../Products/Bag/B015.jpg', 4200.00, 3800.00, 45, 'Yes', 3.00),
(141, 'B016', 'David Jones Paris women tote bag crossbody bag pu leather female handbag lady shoulder bag', 'Bag', 'DAVIDJONES , a brand comes from Paris since 1987.We are committed to provide our customer trendy and stylish women bags.Over the years, we have been selling to more than 100 countries at prices that make keeping up with seasonal styles a luxury within reach.DAVID JONES is the lifestyle brand for people who are Positive, Authentic, and Bursting with personality.We thank you for your great support.\nBRAND:David Jones\nITEM NO:CM6909\nMATERIAL: Soft Pu Leather\nMETAL:Quality Golden hardware accents its chic\nLINING:Polyester&DAVIDJONES Logo Signature\nDIMENSION:13.8\"(L)x3.5\"(W)x11.8\"(H) 35x9x30cm\nWEIGHT:0.5kg\nPACKAGE WEIGHT:0.6kg\nCLOSURE:Zipper closure', '../Products/Bag/B016.jpg', 4200.00, 3800.00, 45, 'Yes', 3.00),
(142, 'B017', 'David Jones - Ladies Handbag Nylon - Tote Shopper Waterproof - Shoulder Bag Crossbody Bag - Carrying Bag Large Capacity - Elegant Fashion Travel Work Casual, Taupe brown, classic', 'Bag', 'DAVID JONES Brand: women, women, girls handbags. Designed in Paris, France. Made of high-quality faux leather. High-quality workmanship.\nDesign and use: women\'s bag with trapezoidal shape. Soft tote shopper handbag. Casual A4 size tote bag, ideal for everyday use: city, office, work, school, travel, shopping..\nLeather and features: waterproof nylon handle bag. Faux leather cover in black.\nClosure and size: zip. 33 x 27 x 13 cm (L x H x W). Shoulder bag with enough capacity for 13 inch laptop, A4 documents. Storage folder and folders do not fit in it.\nLong handles: easy to carry the bag over the shoulder or by hand. Compartments: inside: 1 large compartment with 2 inner pockets. Outside: 1 zip back pocket.', '../Products/Bag/B017.jpg', 4200.00, 3800.00, 45, 'Yes', 3.00),
(143, 'B018', 'David Jones Paris women tote bag canvas female handbag lady shoulder bag crossbody bag\n', 'Bag', 'DAVIDJONES , a brand comes from Paris since 1987.We are committed to provide our customer trendy and stylish women bags.Over the years, we have been selling to more than 100 countries at prices that make keeping up with seasonal styles a luxury within reach.DAVID JONES is the lifestyle brand for people who are Positive, Authentic, and Bursting with personality.We thank you for your great support.\nBRAND:David Jones\nITEM NO:CM7001 CM7026 CM7042\nMATERIAL: Canvas(CM7001) Pu leather(CM7026 CM7042)\nMETAL:Quality Golden hardware accents its chic\nLINING:Polyester&DAVIDJONES Logo Signature\nDIMENSION:7.5\"(L)x3.5\"(W)x8.2\"(H) 19x9x21cm\nWEIGHT:0.4kg\nPACKAGE WEIGHT:0.5kg\nCLOSURE:Zipper closure\nSTRAP:51.18\" (130cm)Adjustable long shoulder strap\nCONSTRUCTION:\nZipper closure for main compartment\n1 internal zip pocket\n1 internal slip pocket\n1 adjustable Long Strap and 2 fixed Short Strap\nOCCASIONS:A Simple and Classic Designer womens shoulder handbags.Perfect for work, shopping ,as a city bag and school bookbag purse for students.Goes well with casual jeans to business attire, work.Good choise for everyday daypack daily use.Availble for lipstick, keys,ballpen,notebook,wallet and cell phone Checkbook inside.A perfect gift for you or your important ones at Christmas, New Year, Birthday, Anniversary, Valentina,Mother\'s Day, Thanksgiving Day or any other holiday.\nProduct Maintain\n', '../Products/Bag/B018.jpeg', 5600.00, 3800.00, 45, 'Yes', 3.00),
(144, 'B019', 'David Jones Paris women crossbody bag pu leather female handbag small chain lady shoulder bag CM7014', 'Bag', 'DAVIDJONES , a brand comes from Paris since 1987.We are committed to provide our customer trendy and stylish women bags.Over the years, we have been selling to more than 100 countries at prices that make keeping up with seasonal styles a luxury within reach.DAVID JONES is the lifestyle brand for people who are Positive, Authentic, and Bursting with personality.We thank you for your great support.\nBRAND:David Jones\nITEM NO:CM7014\nMATERIAL: Soft Pu Leather\nMETAL:Quality Silver hardware accents its chic\nLINING:Polyester&DAVIDJONES Logo Signature\nDIMENSION:8.2\"(L)x2.7\"(W)x5.9\"(H) 21x7x15cm\nWEIGHT:0.5kg\nPACKAGE WEIGHT:0.6kg\nCLOSURE:Flap Hasp closure\nSTRAP:2 fixed top Straps.51.18\" (130cm)Adjustable long shoulder strap\nCONSTRUCTION:\nZipper closure for main compartment\n1 internal zip pocket\n1 internal slip pocket\nOCCASIONS:A Simple and Classic Designer womens shoulder handbags.Perfect for work, shopping ,as a city bag and school bookbag purse for students.Goes well with casual jeans to business attire, work.Good choise for everyday daypack daily use.Availble for lipstick, keys,ballpen,notebook,wallet and cell phone Checkbook inside.A perfect gift for you or your important ones at Christmas, New Year, Birthday, Anniversary, Valentina,Mother\'s Day, Thanksgiving Day or any other holiday.\nProduct Maintain\n', '../Products/Bag/B019.jpg', 5600.00, 3800.00, 45, 'Yes', 3.00),
(145, 'B020', 'STRIPE CANVAS TOTE', 'Bag', 'Composition: 100% Cotton\nStyle Number:\n26919268', '../Products/Bag/B020.jpg', 5600.00, 3800.00, 45, 'Yes', 3.00),
(161, 'E001', 'Walton Top Loading Washing Machine 8KG\n\nWWM-ATV80', 'Electronics', 'Basic Information\nBrand: Walton\nmodel :WWM-ATV80\nloading type:Top Loading\ncapacity (kg):8 Kg\noperation/control:Automatic\ncolor:Black', '../Products/Electronics/E001.jpeg', 3590.00, 31951.00, 10, 'Yes', 4.50),
(162, 'E002', 'Walton Direct Cool Refrigerator 176L\n\nWFD-1F3-GDEL-XX', 'Electronics', 'Brand:Walton\nmodel:WFD-1F3-GDEL-XX\nrefrigerator type:Frost\ngross volume:176 Ltr\nnet volume:163 Ltr\nrefrigerant:R600a\nNote:Color depends on stock availability', '../Products/Electronics/E002.jpeg', 33.00, 29.00, 10, 'Yes', 3.40),
(163, 'E003', 'Whirlpool Sanicare WFC105604RT-D (10.5 kg) Washing Machine', 'Electronics', 'Capacity 10.5 Kg\nColor Volcano Grey\nSpecial Eco Cotton Program\nHigh-Temperature Drum Clean\nAuto Restart\nRemoves Up To 10 Tough Stains\n10 Years Motor Warranty\n2 Years Service Warranty With Spare Parts', '../Products/Electronics/E003.webp', 75790.00, 71990.00, 10, 'Yes', 3.40),
(164, 'E004', 'Hisense WF3S9043BT (9 kg) Washing Machine', 'Electronics', 'Capacity 9 Kg\nMemory Backup\nJet Wash\nRaindrop Drum\nWIFI\nWash and dry linkage\nMotor 12 Years, Motherboard 2 Years, Spare part 2 Years', '../Products/Electronics/E004.jpg', 76000.00, 74300.00, 10, 'Yes', 3.40),
(165, 'E005', 'Walton AC', 'Electronics', '', '../Products/Electronics/E005.webp', 2100.00, 1580.00, 10, 'Yes', 3.40),
(166, 'E006', 'Walton Air Condition', 'Electronics', '', '../Products/Electronics/E006.webp', 2100.00, 1580.00, 10, 'Yes', 3.40),
(167, 'E007', 'General 1 Ton Non-Inverter AC (Split Type ASH12USCCW)', 'Electronics', '', '../Products/Electronics/E007.webp', 2100.00, 1580.00, 10, 'Yes', 3.40),
(168, 'E008', 'VISION RO Hot and Cold Water Purifier', 'Electronics', 'VISION RO Hot and Cold Water Purifier\nBrand: VISION\nItem code: 892672', '../Products/Electronics/E008.png', 3400.00, 2780.00, 10, 'Yes', 3.40),
(169, 'E009', 'VISION Rice Cooker 1.8 L REL-40-06 SS Red (Double Pot)', 'Electronics', ' Power: Cylinder shaped, 220V- 50Hz, 700W\n- 2 hole 6-6.5mm Plastic Handle Glass Lid.\n- Antibacterial action in warm mode.\n\n', '../Products/Electronics/E009.png', 3400.00, 2780.00, 10, 'Yes', 3.40),
(170, 'E010', 'VISION 750W Blender VIS-SBL-011 Crushers', 'Electronics', 'With heavy SS Jar\n- Fully Stainless Steel Blender\n- Motor overheat with low noise protection', '../Products/Electronics/E010.png', 3400.00, 2780.00, 10, 'Yes', 3.40),
(171, 'E011', 'SRIWEN Fridge Thermometer, Digital Refrigerator Thermometer Waterproof Fridge Freezer Thermometer Monitor for Home 2Pcs', 'Electronics', '[Perfect for fridge]The fridge thermometer accuracy is up to ± 1 ° C (± 1.8 °), wide measurement range from -50℃/-58℉ to 70°C/158°F. Provides you with timely and accurate reading to meet your need to use it in a refrigerator, a freezer or as an ordinary thermometer.\n[Easy to Use]Simple freezer thermometer with only 3 buttons. Just press the ON /OFF button to switch the thermometer on/off. Press °C/ °F button to select centigrade or fahrenheit. Press the \"CLR\" button, the max/min temperature will be reset\n\n\n', '../Products/Electronics/E011.jpg', 3400.00, 2780.00, 10, 'Yes', 3.40),
(172, 'E012', '2X Digital Thermometer with LCD for Fridges Freezers', 'Electronics', '2X Digital Thermometer with LCD for Fridges Freezers\nIt has a temperature range of -50Celsius to + 70Celsius and it has a clear and easy to read LCD display.', '../Products/Electronics/E012.jpg', 3400.00, 2780.00, 10, 'Yes', 3.40),
(173, 'E013', '', 'Electronics', 'Model:ETC-974\nTemperature measure range: NTC probe :-50~110Celsius(-58~230Fahrenheit)\nPTC probe:-55~140Celsius(-67~284Fahrenheit)\nDisplay resolution:1Celsius/0.1Celsius(with the swithch mode between integer and decimal)', '../Products/Electronics/E013.png', 3400.00, 2780.00, 10, 'Yes', 3.40),
(174, 'E014', 'ARELENE 2X LCD Refrigerator Freezer Fridge Digital Thermometer Temperature -50 - 110C', 'Electronics', 'Size:48*28*15 mm\nTemperature Range: -50c ~ 110c\nVoltage:1.5V,LR44 battery(included)', '../Products/Electronics/E014.png', 3400.00, 2780.00, 10, 'Yes', 3.40),
(175, 'E015', 'RS485 Temperature and Humidity Sensor Waterproof Digital (A)', 'Electronics', 'Power supply 10~30VDC\nAccuracy\nTemperature ±0.5℃\nHumidity ±3%RH', '../Products/Electronics/E015.png', 3400.00, 2780.00, 10, 'Yes', 3.40),
(176, 'E016', 'VISION Electric Kettle 1.8 Liter VIS-EK-006', 'Electronics', 'Size:48*28*15 mm\nTemperature Range: -50c ~ 110c\nVoltage:1.5V,LR44 battery(included)\n', '../Products/Electronics/E016.png', 3400.00, 2780.00, 10, 'Yes', 2.50),
(177, 'E017', 'VISION Electric Kettle 1.5 Liter VIS-EK-008', 'Electronics', 'Brand: VISION\nItem code: 823455\nModel: VIS-EK-008\nCapacity: 1.5L\nPower: 1500w, 220v, 50hz\n360° rotatable cordless electric kettle\nStainless steel body with concealed heating element\nAutomatically turn off when water boils\nBoil-dry and overheat protection\nTriple safety protection\nSafety lock lid\nIlluminated on-off switch\nCord storage convenience\nFull copper cord with two pin vde plug\nColor: As given picture.', '../Products/Electronics/E017.png', 1600.00, 1250.00, 10, 'Yes', 3.50),
(178, 'E018', 'Vision Portable Smart RO Water Purifier', 'Electronics', 'Vision Portable Smart RO Water Purifier\n\nItem Code: 988401\n\nRO & UV Technology\n\n4 stage water purification system\nInstant Hot & Warm water\nPure water is available at 4 different temperatures\nSafety child lock \nReal time monitoring\nPlug and play, easy Operation', '../Products/Electronics/E018.png', 1600.00, 1250.00, 10, 'Yes', 3.60),
(179, 'E019', 'Vision Table Top Water Dispenser', 'Electronics', 'Features and Functions:\n\n*Instant Hot and cold water\n\n*Stainless steel inner tank\n\n*Food grade ABS plastic material\n\n*Thickness plastic and metal panel', '../Products/Electronics/E019.png', 1600.00, 1250.00, 10, 'Yes', 3.70),
(180, 'E020', 'VISION Travel Electronic Iron with Aluminium Sole Plate VIS-TEI-006 Pink', 'Electronics', 'VISION Travel Electronic Iron with Aluminium Sole Plate VIS-TEI-006 Pink\nBrand: Vision\nItem code:823145\n\nSpecification:\nType: Electronic Iron\nTeflon coating with aluminum sole-plate\n100-240v 50/60hz, 80-220w\nThermostat temperature control\nAuto power off at target temperature\n100% heat proof cable\nOverheat protection\nFolding option\nEasy to carry for travel\nTwo pin power plug\nColor: Pink (As given picture).', '../Products/Electronics/E020.png', 1600.00, 1250.00, 10, 'Yes', 3.80),
(181, 'E021', 'Vision Electronic Iron 1000W Shock and Burn Proof  VIS-YPF 633 Blue', 'Electronics', 'Electronic Iron\nItem code: 94737\nModel: VIS-YPF 633\nCeramic Coating Sole-plate\n220V/1000W\nThermostat temperature control\nFlexible 360-degree swivel cord guard\nOverheat protection\nShock & BurnProof\nWeight: 0.7 Kg\nAuto Power off when Temperature reach Target\nTwo pin Power Plug\nColor: Blue (As given picture).', '../Products/Electronics/E021.png', 1600.00, 1250.00, 10, 'Yes', 3.90),
(182, 'E022', '2K Refrigerator Temperature Sensor Probe for Midea/ Meiling/ Rongsheng Parts Tetuo', 'Electronics', '2K refrigerator temperature sensor probe for Midea/ Meiling/ Rongsheng universal freezer fridge ice box parts (round head)The square head sensor can be used for refrigeration, freezing, micro-freezing, etc. Suitable for refrigerators.(The round head is especially suitable for domestic refrigerators such as for Rongsheng, for Meiling, for Xinfei, for Midea)To ensure that the temperature sensor is not invaded by moisture, please pay attention to:1.The lead wire of the sensor should not be cut too short and should be kept at least 10CM.2.The connector of the sensor should be connected with a heat shrink tube.3. Avoid large bends on the temperature-sensitive head.Warm reminder: The resistance of the detection sensor should not be less than 1K and greater than 5K in a normal room temperature environment, and should not be less than 20K and greater than 35K when the evaporator is full of frost.Package include ：1pcs * Sensor', '../Products/Electronics/E022.png', 1600.00, 1250.00, 10, 'Yes', 4.00),
(183, 'E023', 'VSN LPG Double Glass Gstv Fancy', 'Electronics', 'VSN LPG Double Glass Gstv Fancy\n\nCode: 892906\n\n1)Double  tempared glass gas with design\n2) BEEHIVE CI Burner 100MM\n3)Rated thermal flow (kw)-3.4/3.4\n4) Auto Ignition 50,000 times\n5) Bakelite knob with MS Cove 6)Size : 720mmx380mmx105mm', '../Products/Electronics/E023.png', 1600.00, 1250.00, 10, 'Yes', 4.00),
(184, 'E024', 'Vision Rechargeable Half Stand Fan 16\"', 'Electronics', 'Vision Rechargeable Half Stand Fan 16\"\nCode: 900646\nSize: 16\"/400mm\n\nFeatures:\nSolar Charging System (12V DC Input)\nDouble Battery (6V, 4.5Ah)\nMobile Charging (5V DC Output)\nAC/DC Operated\n90 Degree Oscillation\n30mints Timer Option', '../Products/Electronics/E024.png', 1600.00, 1250.00, 10, 'Yes', 4.00),
(185, 'E025', 'VSN NG Double Glass Gstv Fancy', 'Electronics', 'VSN NG Double Glass Gstv Fancy\n\nCode: 892907\n\n1)Double  tempared glass gas with design\n2) BEEHIVE CI Burner 100MM\n3)Rated thermal flow (kw)-3.4/3.4\n4) Auto Ignition 50,000 times\n5) Bakelite knob with MS Cove 6)Size : 720mmx380mmx105mm', '../Products/Electronics/E025.png', 1600.00, 1250.00, 10, 'Yes', 4.00),
(186, 'E026', 'VSN NG Double Glass Gstv Fancy', 'Electronics', 'VSN NG Double Glass Gstv Fancy\n\nCode: 892907\n\n1)Double  tempared glass gas with design\n2) BEEHIVE CI Burner 100MM\n3)Rated thermal flow (kw)-3.4/3.4\n4) Auto Ignition 50,000 times\n5) Bakelite knob with MS Cove 6)Size : 720mmx380mmx105mm', '../Products/Electronics/E026.png', 1600.00, 1250.00, 10, 'Yes', 4.00),
(187, 'E027', 'VISION 13W Oil Pressing Machine', 'Electronics', '', '../Products/Electronics/E027.png', 1600.00, 1250.00, 10, 'Yes', 4.00),
(188, 'E028', '', 'Electronics', '', '../Products/Electronics/E028.png', 1600.00, 1250.00, 10, 'Yes', 4.00),
(189, 'E029', 'Vision Light Weight Electric Iron 1000W with Overheat Protection VIS-DEI-009 Blue', 'Electronics', 'Vision Light Weight Electric Iron 1000W-VIS-DEI-009 Blue\nBrand: Vision\nItem code:873502\n\nSpecification:\nNon-stick coating sole-plate\n220V, 50Hz, 1000W,\nThermostat temperature control.\nOverheat protection.\nWeight: Around 550g.\nAuto Power off when Temperature reach Target. \nWarranty: 1 Year.', '../Products/Electronics/E029.png', 1600.00, 1250.00, 10, 'Yes', 4.00),
(190, 'E030', 'VISION Electric Iron-Model No. VIS-DEI-005', 'Electronics', 'VISION Electric Iron-Model No. VIS-DEI-005\nBrand: VISION\nCeramic Coating Sole-plate\n220 ~230V, 50Hz, 1000 ~ 1200W,\nThermostat temperature control.\nOverheat protection.\nShock & Burn Proof\nWeight: 1.5 to 1.8Kg.\nAuto Power off when Temperature reach Target.\n\nWarranty: 1 Year.', '../Products/Electronics/E030.png', 1800.00, 1250.00, 10, 'Yes', 4.00),
(191, 'E031', 'VSN RAC MWO 30L Rotisserie', 'Electronics', 'Vision Micro Oven VSM 30L Rotisserie\nItem code: 988412\nBrand: Vision                                                                                                                                                                                  Capacity: 30 L                                                                                                                                                                            Rated Voltage: 230~50Hz\nRated Input Power (Microwave): 1400W\nRated Output Power (Microwave): 900W\nRated Input Power(Grill): 1000W\nMicrowave+convention+gril function\nStainless steel interior cavity\nMirror finished glass door\nTouch & press control\n10 microwave power levels with 4 combinatons\n10 international auto cooking menus\n200 indian auto cooking menus\n95 minutes cooking timer\nCooking end signal\nMulti cooking stage\nDefrost by weight or time', '../Products/Electronics/E031.png', 1800.00, 1250.00, 57, 'Yes', 4.00),
(192, 'E032', 'Vision MA-20B  Microwave Oven', 'Electronics', 'Item Code:873572\nCavity (L): 20L\nCavity Interior:\ngrey painted Body exterior:\nBlack Glass door:\nBlack finished Microwave Output: 700W\nMicrowave Input: 1050W\nMechanical control 35’ cooking timer Cooking end signal Defrost by Weight or Time 5 Power levels Turntable\ndiameter：255mm', '../Products/Electronics/E032.png', 1800.00, 1250.00, 57, 'Yes', 4.00),
(193, 'E033', 'Vision Microwave Oven - 30 Ltr (Convection)', 'Electronics', 'Home/Home Appliance/Microwave Oven/Vision Microwave Oven - 30 Ltr (Convection)6of12\nVision Microwave Oven - 30 Ltr (Convection)\nShare\nSave\n10%\nCODE:\n823464\n৳16,020.00\n৳17,800.00\nYou save:\n৳1,780.00\nIn stock\n1\nAdd to wish list\nCompare\nRFL Electronics Ltd. (REL)\nVendor: RFL Electronics Ltd. (REL)\nAsk a question\nShipping time and rates: \nDhaka\n Shipping: about 1-7 Working Days, from ৳0.00\nDescription\nReviews\nItem Name:Vision Micro Oven VSM 30 Ltr Convection\nItem code: 823464\nBrand: Vision\nVSNMWO-30L Convection\nRated Voltage: 230 ~ 50Hz\nRated Input Power(Microwave): 1400-1450W\nRated Output Power(Microwave): 900W\nRated Input Power(Grill): 1000-1100W\nRated Input Power(Convection): 2300-2500W\nOven Capacity: 30Ltr\nTurntable Diameter: 315 mm\nExternal Dimensions: 520 497 326mm\nNet Weight: Approx. 18kg\n10 Automatic power Labels\nChild safety lock system\nHigh-Performance Class 220A Transformer which will give better insulation and protection\nHigh-performance Magnetron for producing efficient heat\n2 Layer inner cavity and 3 Layer glass door so that no radiation takes place\nDiamond Pattern inner Cavity for Smooth Heat Circulation\nMirror glass Door\nCavity Interior: Stainless Steel\nBody exterior: silver Color\n95-minute cooking timer\nCooking end signal\nMulti cooking stage\nDefrost by Weight or Time\n30-sec Plus\nColor: As given picture', '../Products/Electronics/E033.png', 1800.00, 1250.00, 57, 'Yes', 4.00),
(194, 'E034', 'Vision Rice Cooker 3.0 Liter REL-50-05 SS Coffee (Double Pot)', 'Electronics', 'Item code: 873567\nInner Pot: Double pot (One is SS pot and one is Aluminum)\nPower: Cylinder shaped, 3.0 Ltr. 220V- 50Hz, 1100W\n2 hole 6-6.5mm Plastic Handle Glass Lid\nMagnetic Switch and Thermostat\nFull SS Body and thickness  0.28mm\nAl/ Stainless steel Steamer With plastic Handle.\nBuilt-in thermostat maintains heat at a precise and uniform level\n1100 W power which is very much enough for cooking rice in 15-20 min\nHeating element with coating for easy cleaning and Anti-dirty\n1.2mm Actual Non-stick Coating Inner pot, Base Board- Silver\nAntibacterial action in warm mode\nColor: As given picture.\n\nWarranty:  1 year', '../Products/Electronics/E034.png', 1800.00, 1250.00, 57, 'Yes', 4.00),
(195, 'E035', 'VISION 750W Blender VIS-SBL-011 Crushers', 'Electronics', 'VISION 750W Blender VIS-SBL-011 Crushers\nBrand: VISION\nItem code: 873154\n\n\nSpecification:\n220 ~240V, 50Hz, 750W,\nDimension: L- 13.75 X W- 11 X H- 10.5 Inch\nFully Stainless Steel Blender\n100% ABS material Plastic body with Metallic Color\n1.4L Juicer, 1.0L Mincer & 0.5Kg Grinder Jar\n(Juicer, Grinder and Mincer) with heavy SS Jar\nHigh-quality Stainless steel blade with 6 heads\nMotor overheat with low noise protection\n20000 RPM & energy efficient pure copper coil motor\nColor: As given picture.', '../Products/Electronics/E035.png', 1800.00, 1250.00, 57, 'Yes', 4.00),
(196, 'E036', 'VISION Multimedia Speaker DJ-03', 'Electronics', 'VSN Multimedia Speaker-Dj-03\nItem code: 873240\nBrand: VISION\nR.M.S: 80W\nOutput power: 100W\nSpeaker size: 8\"*2+2\"*2\nSubwoofer: RMS 50W\nSatellites: RMS 2\"*2\nDimensions: H930*W330*D305mm\n\nEQ Adjustment\nAcoustic feedback control function\nBluetooth\nAUX IN(3.5mm)\nUSB playback\nFM Radio\nLED display\nFlashing light\nMicrophone jack\nIncluded wireless microphone 1pc\nMicrophone priority\nColor: As given picture\nWarranty 1year Warranty.', '../Products/Electronics/E036.png', 1800.00, 1250.00, 57, 'Yes', 3.80),
(197, 'E037', 'Vision 2:1 Multimedia Speaker Sonic- 404 Pro', 'Electronics', '• Input AC-220V/USB/SD/FM/AUX/\n• BLUETOOTH/REMOTE CONTROL\n• Output power(RMS): 20W+5W*2\n• Speaker unit: 4\"+3\"*2\n• Frequency Response: 80Hz-20KHz\n• S/N Ratio: 65dB\n• Impedance: Bass 6Ω+ sub 4Ω\n• Subwoofer: W155*D270*H235 MM\n• Satellite: W92*D100*H133 MM', '../Products/Electronics/E037.png', 1800.00, 1250.00, 57, 'Yes', 3.80),
(198, 'E038', 'Share', 'Electronics', '', '../Products/Electronics/E038.png', 1890.00, 1250.00, 57, 'Yes', 3.80),
(199, 'E039', 'Vision Bluetooth Mini Speaker-MBTS-02-Black', 'Electronics', 'Home/Multimedia Speaker/Bluetooth Speaker/Vision Bluetooth Mini Speaker-MBTS-02-Black28of33\nVision Bluetooth Mini Speaker-MBTS-02-Black\nShare\n\n\nVision Bluetooth Mini Speaker-MBTS-02-Black\nCODE:\n873389\n৳890.00\nOut of stock\nAdd to wish list\nCompare\nRFL Electronics Ltd. (REL)\nVendor: RFL Electronics Ltd. (REL)\nAsk a question\nShipping time and rates: \nDhaka\n Shipping: about 1-7 Working Days, from ৳0.00\nDescription\nVideo gallery\nReviews\nVision Bluetooth Mini Speaker-MBTS-02-Black\n\nItem code: 873389\n\nBrand: Vision\nUnit Size: L206*W56*H89mm\nSpecification:\nWireless Speaker\nWorking Distance- 10M\nSNR- >/ 95 db\nBattery- 3.7V 1200 MAH\nNormal Volume playing time: 2H\nSpeaker Driver: 52mm\nPower: 3W*2\nFrequency response: 120Hz- 20 KHz\nTF/USB- Can decode and play format Audio\nAUX\nRadio\nColor: As given picture.', '../Products/Electronics/E039.png', 1890.00, 1250.00, 50, 'Yes', 3.80),
(200, 'E040', 'Vision 2:1 Multimedia Speaker Beat Max-01', 'Electronics', 'Vision 2:1 Multimedia Speaker Beat-Max-01\nItem code: 873197\nBrand: Vision\nR.M.S: 20W\nSubwoofer: RMS 10W\nSatellites: RMS 5W*2\nFrequency response: 20Hz~20 kHz\nSubwoofer driver unit: 5.\" \nSatellite driver unit: 3\'\'*2\nS/N: > = 65dB\nDistortion: <= 0.5% (1K, 1W)\nIntegrated circuit: 3*UTC2030\nSubwoofer size: W160*H273*D245mm\nSatellites size: W105*H172*D110mm\nWith Bluetooth 4.0\nUSB/SD\nFM Radio, MP3 and MP4 supporte\nLED display for time & program\nColor LED light\nBlue LED display\nColor: Black (As given picture)', '../Products/Electronics/E040.png', 1890.00, 1250.00, 50, 'Yes', 3.80),
(201, 'E041', 'VISION Sound Bar-01', 'Electronics', 'VISION Sound Bar-01\nBrand: VISION \nItem code: 873367\nModel Name: VSN Sound bar-01\nFunction: Bluetooth, 2.0ch, LED display, \nUSB,FM radio, Aux. Optical, Remote control DC 15V 3A\nOutput power: 40W\nOutput unit: full range speaker:2\"/4Ω,10W x4, Diaphragm x 2 \nBluetooth Version: 5.0 \nSize: 800 x 60 x 60mm \nGift box: 895*120*92MM \ncarton box size: 910*252*300MM 4pcs/ctn\nAccessories: Remote control, Line in cable, User manual\nColor: (Black) As given picture..', '../Products/Electronics/E041.png', 1890.00, 1250.00, 50, 'Yes', 3.80),
(202, 'E042', 'VISION Glass Door Refrigerator RE-185L Digital Lily Flower Bottom Mount', 'Electronics', 'Model: Vis- 185 Liter Electrical Rating: Input Power: 70-75W,160-260V,50Hz Fabulous ultra-Modern Glass door Colour\nNet capacity : 185L Direct Cool Refrigerator Very fast cooling speed\nGross Volume: 203L Climate Type(SN,N,ST,T): N~T hygienic clean air\nProduct dimension: (w*D*H) 572x552x1397MM Cooling Effects: Freezer Cabinet Less than -18℃ Anti-Bacterial gasket\nPacking dimension:(w*D*H) 604x635x1575 MM Cooling Effects: Refrigerator Cabinet 0℃ to +6℃ Vast of storage capacity\nGross / Net weight:62.85/58.12Kgs', '../Products/Electronics/E042.png', 1890.00, 1250.00, 50, 'Yes', 3.80),
(203, 'E043', 'VISION Mini Refrigerator RE-50L SS', 'Electronics', 'Model: VIS-50 L\nRefrigerator type: Single door\nCooling technology: Frost\nDoor type: VCM Door\nNet capacity:  50 Ltr\nPower & pin type: 60W, 220V, 50Hz, 3 Pin\nCompressor type: Reciprocating\nRefrigerant: R-600a - HFC free\nFoaming density: 35-37 (kg/m3)\nFoaming: C-Pantene foaming-FCKW free\nThermostat: Adjustable thermostat\nLight type: Interior LED light\nCondenser: MS condenser \nBody Material: PCM finish\nCFC & ODP: CFC & ODP Free\nClimate type: (SN,N,ST,T): N~T\nGWP: GWP very low\nGross weight (KG): 20.63 \nNet weight (KG): 18.61\nProduct dimension (W*D*H): 470X496X445mm\nPacking dimension (W*D*H): 560X520X630mm', '../Products/Electronics/E043.png', 1890.00, 1250.00, 50, 'Yes', 3.80),
(204, 'E044', 'VISION Glass Door Chest Freezer RE-250 Liter Black', 'Electronics', 'Model: VIS-250 L\nNet Volume:250Ltr \nPower: 105W,220V,50Hz\nClimate Type: S~T\nReal Tempered glass\nRoyal modern color\nFaster cooling speed\nHuge inside space\nThick foaming/side wall preserves long time cooling\nQuick freezer indicator\nTransferrin glass salve Free.\nThree layers PCM anti corrosive body.\nFree wire basket\nLow noise compressor.\nR600a Refrigerant - HFC free\nC-Pantene foaming - FCKW free\nwith lock and key\nAdjustable thermostat\nInterior LED light\nFoaming density :35-37(kg/m3)\nEco-friendly (100% CFC & HCFC Free) Green Technology\nGDP very Low\nGross / Net weight:45/41.87 Kgs\nProduct dimension:(W*D*H): 995x613x873 mm\nPacking dimension: (W*D*H): 1043×647×860 MM', '../Products/Electronics/E044.png', 1890.00, 1250.00, 50, 'Yes', 3.80),
(205, 'E045', 'VISION Top Loading 8KG Washing Machine ATC80', 'Electronics', 'Brand: VISION\nItem code: 874785\nCapacity: 8kg\nAir Dry \nRust free intelligent diamond drum\nHigh efficient pulsate with advance 3D motion\nChild lock\nLED Display\nStrong PCM cabinet\nSoft Closing Glass Lid\nMagic filter\nError message indication and alarm system\n6 washing program\nRPM: 780\nWashing power: 400W\nSpin power: 340W\nNet dimensions(mm) 545×550×945\nNet weight(Kg): 32kg\nColor: (Silver) As given picture.', '../Products/Electronics/E045.png', 1890.00, 1250.00, 50, 'Yes', 4.50),
(206, 'E046', 'VISION Twin Tub Washing Machine SATWM-8KG', 'Electronics', 'VISION Twin Tub Washing Machine SATWM-8KG\nBrand: VISION \nItem code: 874786\nFull Plastic Cabinet, Rust Proof\nLuxury Appearance \nControlling 3 knobs\nGlass Lid\nRated Power: 220-240V/50Hz\nRated Power(Wash) : 450W\nRated Power(Spin): 350W\nWash Capacity: 8KG\nSpin Capacity: 5KG\nMaximum water Level: 60 Liter\nNet Dimensions(mm)=700*460*815 mm\nPackaged Dimensions(mm)=800*540*845 mm\nNet Weight(Kg): 20KG\nGross Weight(Kg):24KG\nColor: (Mixed) As given picture.', '../Products/Electronics/E046.png', 1890.00, 1250.00, 50, 'Yes', 4.50),
(207, 'E047', 'Vision Single Tub Washing Machine 3kg-L03', 'Electronics', 'Wash capacity: 3Kg\nSpin capacity: 1Kg\nPlastic and Transparent Body\nPower Supply- 220V/50Hz\nInput power (Watts): 200W\nTimer Control: 15 min\nOne hand carrying\nNet Dimension: 360*370*550mm\nGross Dimension: 390*375*595mm\nColor: Cyan/Green\nWarranty: 1 year', '../Products/Electronics/E047.png', 1890.00, 1250.00, 50, 'Yes', 4.50),
(208, 'E048', 'VISION Front Loading Washing Machine 6kg-SFL09', 'Electronics', 'Brand: Vision\nMax wash capacity: 6KG\nDrum volume: 40Ltr\nDigital LED display\nIntelligent washing system\nAuto balance\nVariable spin speed\nVariable temperature: 90℃\nHot & cold water option\nAuto restart\nUniversal motor\nChild lock\nRated heating Input power: 1000W\nMax. input power: 1000W\nRated washing input power: 400W\nSpinning input power: 400W\nWater consumption: 48 L/Cycle\nEnergy consumption: 078(KW/Cycle)\nNoise level wash (PWL): 60 dB\nNoise level  spin (PWL): 74 dB\nTime delay: 3-24 hour', '../Products/Electronics/E048.png', 1890.00, 1850.00, 50, 'Yes', 4.50),
(209, 'E049', 'Vision 1 Ton Split Type AC APCI Inverter 3D Pro', 'Electronics', 'Vision 1 Ton Split Type AC APCI Inverter 3D Pro\nItem code:892492\nBrand: VISION', '../Products/Electronics/E049.png', 1890.00, 1850.00, 50, 'Yes', 4.50),
(210, 'E050', 'VISION AC 3.0 Ton T36K Ceiling', 'Electronics', 'Model Name VISION AC 3.0 Ton - T36K (Ceiling)\nFunction Fixed speed cooling /Non-inverter cooling\nCapacity (Ton) 3 ton\nCapacity (Btu/h) 36000 BTU/Hr\nWI-FI (available/ not available) Not avilable\n3D (Yes/No) Yes\nType Ceiling\nVoltage range 380V-440V\nFrequency (Hz) 50Hz\nDisplay Type Hidden\nIndoor Noise 45/42/39 dB\nOutdoor Noise 58dB\nSleep Mode Timer (Yes/No) Yes\nCompressor Brand PANASONIC\nCompressor Type Scroll\nRefrigerant R22', '../Products/Electronics/E050.png', 1890.00, 1850.00, 50, 'Yes', 4.50),
(211, 'E051', 'VISION AC Cassette Type 3.0 TR (T36K)', 'Electronics', 'Model: VAC-3.0TON\nNet capacity : 36000BTU/H\nPower Supply:1P/220-240V/50Hz\nPower Input:3838W\nCurrent: 16.5 A\nEER:2.75 w/w\nCompressor Type: Scroll\nCompressor Brand: PANASONIC\nCompressor Model:C-SB303H8A\nIndoor:45/43/41dB(A)\nOutdoor:58dB(A)\nRefrigerant Type: R-22\nAuto Air Swing\nAir Direction 4 Way Deflection', '../Products/Electronics/E051.png', 1890.00, 1850.00, 50, 'Yes', 4.50),
(212, 'E052', 'VISION VRF AC', 'Electronics', 'Brand: VISION \nItem code: 00000\nIntelligent Inverter Technology\nPowerful and fast Cooling system\nCompact design and convenient transport\nHigh efficient energy-saving & environment friendly\nStable & reliable performance\nConvenient Installation and Maintenance\nIntelligent operation control\nYear long energy-saving mode\nSuper long piping design\nIntelligent multi-connection, easy to cope with the spatial layout\nAir-cooled & refrigerant-cooled technology for main control board\nR410A High-efficiency environmentally friendly refrigerant gas\ncolor: (White) As given picture.', '../Products/Electronics/E052.png', 1890.00, 1850.00, 50, 'Yes', 4.50),
(213, 'E053', 'VISION VIS-Frosty  Air Cooler 20 Litre', 'Electronics', 'Rated Voltage: V? 220-240\nRated Frequency Hz: 50\nPhases: 1\nPower (high speed)W: 145W\nAir Volume (high speed)m3/h: 750 -5%\nType: Personal\nBlower: Yes\nAir flow range: Max 800 m3/hr\nHumid controls: Yes\nHoney comb: Yes\nFan Speed: 4\nNumber of Motor Stack mm: 28\nMotor Speed (high speed) RPM: 1250±50', '../Products/Electronics/E053.png', 1890.00, 1850.00, 50, 'Yes', 4.50),
(214, 'E054', 'VISION Evaporative Air Cooler 50M (Ice Berg)', 'Electronics', '160 watt powerfull motor \nWater tank Capacity:50L\nAir volume:2000m3/h\nCavarage Area: 250sqft\nHeavy duty Turbo Motors with TOP \nEngineered Angles of Fan Blade\nSubmersible Pumps \nMosquito net available to prevent mosquito and dust\nEnvironment Friendly extra large Honey Combo Cooling Pads.\nSilent Operation with High Speed Blower\nAttractive Function Knob Control', '../Products/Electronics/E054.png', 1890.00, 1850.00, 50, 'Yes', 4.50),
(215, 'E055', 'VISION Evaporative Air Cooler 35V (SLIM)', 'Electronics', 'High Power Motor 140W\nPower 220-240V,50Hz\nCavarage Area:25-125sqft\nThree speeds wind selector, High Medium, Low  \nAnti-Static Dust filter\nfully remote control\nNet weight: 13kg\nWater tank Capacity: 35L\nwind speed:11m/s / Auto Swing Left-Right, Up-Down \nair volume:1000m3/h\nWarranty: 1 years warranty\n', '../Products/Electronics/E055.png', 1890.00, 1850.00, 50, 'Yes', 4.50),
(216, 'E056', 'VISION Rechargeable Table Fan 12\" White With USB Charger', 'Electronics', '* Rechargeable \n* Over Charge & Over Discharge Protection\n* AC/DC Operated \n* Full Charge Indication\n* Step less Speed Control\n* Easy to Carry & Repair ', '../Products/Electronics/E056.png', 1890.00, 1850.00, 50, 'Yes', 4.50),
(217, 'E057', 'VISION Super Ceiling Fan Ivory 56\"', 'Electronics', ' 99.9% pure copper wire\n* High quality electric silicon sheet\n* High precisions chrome steel ball bearings\n* Powder coating paint\n* Whisper quiet motor\n* Regulated/Dimmer control\n* Ideal for year round operation \n* Safety wire for preventing any unwanted accidents\n* Aerodynamic blades allow high velocity and maximum air delivery throughout the room\n', '../Products/Electronics/E057.png', 1890.00, 1850.00, 50, 'Yes', 4.50),
(218, 'E058', 'VISION Super Ceiling Fan 36\" White', 'Electronics', '* 99.9% pure copper wire\n* High quality electric silicon sheet\n* High precisions chrome steel ball bearings\n* Powder coating paint\n* Whisper quiet motor\n* Regulated/Dimmer control\n* Ideal for year round operation \n* Safety wire for preventing any unwanted accidents\n* Aerodynamic blades allow high velocity and maximum air delivery throughout the room', '../Products/Electronics/E058.pmg', 1890.00, 1850.00, 50, 'Yes', 4.50),
(219, 'E059', 'VISION Ceiling Net Fan 20\" Black', 'Electronics', '99.9% pure copper wire\n* Heavy P.P. Plastic Blade\n* Aesthetically Designed\n* Rust Free Wire Guard\n* Over Voltage Carrying Capacity', '../Products/Electronics/E059.png', 1890.00, 1780.00, 50, 'Yes', 4.50),
(220, 'E060', 'Vision Metal Exhaust Fan -10\"', 'Electronics', '* 99.9% pure copper wire\n* Low power consumption\n* Durable and well Designed\n* Over voltage carrying capacity\n* Less sound in motor', '../Products/Electronics/E060.png', 1890.00, 1780.00, 50, 'Yes', 4.60),
(221, 'E061', 'VISION Elite Ceiling  Fan 51\'\' 5 Blade Decorative', 'Electronics', 'Brand: Vision\nItem code:876894\nSize - 1290mm/51”\nVoltage - 220 V\nPower – 76 W\nFrequency - 50 Hz\nRated Speed - 200 R.P.M.\nPower Factor - 0.95\nSpecial Feature:\nRF system Remote Controlled.\nFan speed and light operation can perform individually\nAntique bronze color', '../Products/Electronics/E061.png', 1890.00, 1780.00, 50, 'Yes', 4.60),
(222, 'E062', 'Vision Hair Dryer HD-01', 'Electronics', 'Vision Hair Dryer HD-01\nModle: 873770\nBrand: Vision\nProduct Types: Hair Dryer\nRated Power:  1200W\nRated Voltage: 220V-240V\nFrequency: 50Hz\nDimension: 245 x 100 X 260 mm\nIonic Technology\nComfortable and light\nAdjustable hot and cool air\nOver heat protection\nIt has 2 mods and temperature control and 2 speed level\nRegulated Air forces', '../Products/Electronics/E062.png', 1890.00, 1780.00, 50, 'Yes', 4.60),
(223, 'E063', 'Travello 28 Inch Royal Zipper Black', 'Electronics', 'Travello 28 Inch Royal Zipper Black\nBrand: Travello\nItem Code: 988712\nProduct type: Trolley bag\nProduct type: Trolley bag\nMaterial: ABS (Acrylonitrile Butadiene Styrene)\nWeight: 4.470 kg\nOuter dimension: L-495 x W-285 x H-745 mm (With wheel)\nInner dimension: L-490 x W-280 x H-697 mm\nUltra-Light Weight\nUnbreakable Body\nMore Capacity\nWater-Resistant\nDouble Caster Wheel\nTSA Combination Lock\nSecure Double Zipper\nCompression Straps Clast\nTrolley cover available\nColor: Black (As given picture)', '../Products/Electronics/E063.png', 1890.00, 1780.00, 12, 'Yes', 4.60),
(224, 'E064', 'Vision Air Fryer 6 Liter (AF-001)', 'Electronics', 'Brand: Vision \nItem code: 874531\nCapacity: 6.0 Ltr\nBody: New High-Gloss Plastic Parts\nSpare part: With fryer plate\nPower cord: 1.2m copper power cord\nPlug: VDE Plug, Power (W): 1300W, 1500W & 1700W, 220V\n5Lay carton box, one pcs in one carton ,\nControl switch: External rotation temperature control, internal rotation timing\nInner Pot: High temperature non-sticky, double spray, double layer anti-scald with handle\nSafety devices: Take the barrel and power off\nHeat dissipation: 4-dimensional heat dissipation\nAir frying function: Chicken, chicken wings, French fries, cake, egg tart,\nSweet Potato, Steak, Pork Chop, Grilled Fish, Bread\nKeep in good health: No oil, No Smoke, No Fat\nColor: (Mixed) As given picture.', '../Products/Electronics/E064.png', 1890.00, 1780.00, 12, 'Yes', 4.60),
(225, 'E065', 'VSN NS Glamour Casserole with Lid (Red) - 24 cm', 'Electronics', 'Nonstick finish interior\nHealth Friendly Cooking\nMaximum Life\nHeat Resistance\nStrong Joint\n3 layer coating:\n1. Top- coat:  Provides outstanding surface integrity\n2. Reinforced Mid-coat: Enhances abrasion & scratch resistance\n3. Reinforced Primer: Fortifies abrasion resistance & enhances overall durability\nPFOA, NICKEL, LEAD, & CADMIUM free. (these toxic chemical are causes of cancer)\nUP to 60% oil saver\nMade from food grade aluminum\nColor: As given picture.', '../Products/Electronics/E065.png', 1890.00, 1780.00, 12, 'Yes', 4.60),
(226, 'E066', 'Vision Electric Fry Pan-001', 'Electronics', 'Two layers non-stick coating for easy release food and cleaning\nFast hot conduction: Just using less time to fry\nFood grade: Safe and healthy\nSimple work type: Just for on/ Off two way,  simple using\nOperation way: Manual\nVoltage: 220V-240V/ 50-60Hz, Power: 520W\nMaterial using: Outside: PP, Inside pan: SS304 non-stick plating\nFashion outline unique design,  Handle: Wooden handle\nDurable inner pot with non-stick coating pot\nFashion wooden handle, safe for use.\nSimple operation, convenient for use.\nWaterproof design, safe to use. \nDouble safety device: Anti-dry protection and over heating protection.\nWarranty:1 Year\n', '../Products/Electronics/E066.png', 1890.00, 1780.00, 12, 'Yes', 4.60),
(227, 'E067', 'VSN AVR 1500VA (VSN-AVR01-1500VA)', 'Electronics', '\nBrand: VISION\nProduct: Digital Voltage stabilizer\n\nItem code: 892071\nMicro-controller based design\nWide Input Voltage (120-270VAC)\nDigital RMS based Technology, Researched by BUET Engineer\nSelectable 6s / 300s delay operation\nColor: White (as per given picture)', '../Products/Electronics/E067.png', 1890.00, 1780.00, 12, 'Yes', 4.60),
(228, 'E068', 'VSN AVR 1000VA (VSN-AVR01-1000VA)', 'Electronics', 'Brand: VISION\nProduct: Digital Voltage stabilizer\n\nItem code: 892070\nMicro-controller based design\nWide Input Voltage (80-260VAC)\nDigital RMS based Technology, Researched by BUET Engineer\nSelectable 6s / 300s delay operation\nColor: White (as per given picture)', '../Products/Electronics/E068.png', 1890.00, 1780.00, 12, 'Yes', 4.60),
(229, 'E069', 'VISION Mosquito Killing Bat MKB-002', 'Electronics', 'Input Power: AC110-220V,50~60Hz,0.7W\nOutput Power: 2500V, DC\nBattery Capacity:600mah\nOne LED light\nUSB 2-Pin power cord\nCoverage Area: <20 square meters\nEco-Friendly, Long battery life, Strong and durable. \nColor : AS same as picture\nNote: Product delivery duration may vary due to product availability in stock.', '../Products/Electronics/E069.png', 1890.00, 1780.00, 12, 'Yes', 4.60),
(230, 'E070', 'Drinkit Water Purifier Microfiber Filter Big', 'Electronics', 'Drinkit Water Purifier Microfiber Filter Big\nBrand: Drinkit\nItem Code: 923233\nCapable to remove: Iron, mud, sand\nNeed to change after chocking\nColor: White (As given Picture)', '../Products/Electronics/E070.png', 1890.00, 1780.00, 12, 'Yes', 4.60),
(231, 'E071', 'Vision Rechargeable Battery Charger-Li-ion-2 Slot', 'Electronics', 'Model: ZL223E\n\nBrand:Vision\n\nColor: Black\n\nSuitable with various round shaped Li-ion, Ni-MH, Ni-Cd rechargeable batteries ranging 1.2V to 4.2V.\n\n3.7-4.2V : 26650, 21700, 18650, 18350, 16340, 14500 etc (most used in Flashlight, Toys)\n1.2-1.5V : AA/AAA (most used in Remote, Wireless Mouse/Keyboard, Camera)\nLED indication: Red (Charging ON); Green (Charging OFF)\n\nOvercharge protection\nReverse protection\n\nInput Supply: USB DC5V 2A\n\nOutput: Single slot: DC4.2V 1A (Max); Double slot: DC4.2V 1.5A (Max)\n\nAccessories:\n\n1*Micro USB charger cable', '../Products/Electronics/E071.png', 3500.00, 1780.00, 12, 'Yes', 4.60),
(232, 'E072', 'PROTON M-Earphone Neck Band-P5-Ash', 'Electronics', 'Metal body\n10 Meter Bluetooth connection supported earphone\nHeavy BASS with Excellent quality sound\nHD Calling Sound\nNoise cancellation\nUniversal, usable for all type of mobile phone\nEasy to Use\nCall receive and call end button\nVolume control button\n\n', '../Products/Electronics/E072.png', 3500.00, 1780.00, 12, 'Yes', 4.60),
(233, 'E073', 'PROTON M-Earphone Neck Band-P7-Red', 'Electronics', '10 Meter Bluetooth connection supported earphone\nHeavy BASS with Excellent quality sound\nHD Calling Sound\nNoise cancellation\nUniversal, usable for all type of mobile phone\nEasy to Use\nCall receive and call end button\nVolume control button', '../Products/Electronics/E073.png', 3500.00, 1780.00, 12, 'Yes', 5.00),
(234, 'E074', 'PROTON M-Earphone-P Buds-1', 'Electronics', 'Chipset: JL6973\n\nBluetooth Version: V5.0 + EDR\n\nFrequency range: 20HZ-20KHZ\n\nBands: 2.4GHz-2.4835GHz\n\nSensitivity: 103dB±3 at1KHZ\n\nRange: 10meters (no barrier)\n\nMedia playback time: 3-4hours\n\nCalling time: 3.5-4hours\n\nEarphone battery capacity: 25mAh\n\nCase battery capacity: 180mAh\n\nEarphone charging time: 30mins (3-4 times)\n\nCase Charging time: 1hour\n\nCharging jack type: Lightning\n\nPower Supply Rating: 5V/1A\n\nDust & waterproof: IPX5', '../Products/Electronics/E074.png', 3500.00, 1780.00, 12, 'Yes', 5.00),
(235, 'E075', 'PROTON Pendrive 64 GB', 'Electronics', 'Model 64GB\nOriginal memory\nHigh Speed data transfer\nMetal body\nFor long time use\nSmall and standard in size\nEasy to Use', '../Products/Electronics/E075.png', 3500.00, 1780.00, 12, 'Yes', 5.00),
(236, 'E076', 'PROTON-Mobile Charger-FEB-383-Dual Port-PD', 'Electronics', '20W  Dual Port PD Quick Charger\n\n Input 100-240V~50/60Hz, 0.5A Max\n Output: USB 5V=3A, 9V=2A, 12V=1.5A\n Output: Type-C 5V=3A, 9V=2.22A, 12V=1.67A\n USB+Type-C Total Output: 5A=3A Max', '../Products/Electronics/E076.png', 3500.00, 2580.00, 12, 'Yes', 5.00),
(237, 'E077', 'PROTON 3-in 1 USB Cable', 'Electronics', 'Item Name: 3-in 1 USB Cable\n\nItem Code: 873788\n\nMaterial: Nylon braided + Aluminum Alloy Shell\n\nLength: 1.5m\n\nOutput: 5V, 2.4A Max\n\nFeature: Quick Charging\n\nConnector: Micro USB/ Lightening/Type-C\n\nNo data transfer', '../Products/Electronics/E077.png', 3500.00, 2580.00, 12, 'Yes', 5.00),
(238, 'E078', 'PROTON M-Earphone Neck Band-P5-Red', 'Electronics', 'Metal body\n10 Meter Bluetooth connection supported\nearphone\nHeavy BASS with Excellent quality sound\nHD Calling Sound\nNoise cancellation\nUniversal, usable for all type of mobile phone\nEasy to Use\nCall receive and call end button\nVolume control button', '../Products/Electronics/E078.jpg', 3500.00, 2580.00, 12, 'Yes', 4.96);
INSERT INTO `product_info` (`Product_id`, `Product_code`, `Product_name`, `Product_category`, `Product_Description`, `Product_image_path`, `Old_price`, `New_price`, `Stock_quantity`, `Stock_status`, `Rating`) VALUES
(239, 'E079', 'VISION V1 Smart Phone', 'Electronics', 'Network : 4G /3G /2G OS :\nAndroid 11 Go\n\nDisplay : 5.7 Inch , 2.5D HD+ IPS Super Bright Display with 16.7M Color\n\nResolution : 720* 1440\nPlatform : MediaTek 1.3GHZ Quad core\n\nMemory : 2GB+32GB ( Up to 64GB Expandable )\n\nCamera : Back - BSI 13MP Auto Focus with Flash + 8MP Selfie\n\nBattery : Li-ion 3000mAh\nSensors : Fingerprint , G-sensor ,others\n\nSpecial Features :\nOTG Supported , Display Flash , Parental Control , Digital Wellbeing ,\nDark Theme , Fingerprint Gesture , Face Unlock , Screen Recorder ,\n\nDark Mode , Night Light , Camera Portrait Mode . VoLTE Supported.\nOTA Supported ( Customer will get SW update )\n\n Inside Box : Handset , Battery , Charger , Data cable , TPU Case ,\n\nWarranty card Color : Metal Green , Oil Black\n\nColor : Metal Green , Oil Black .', '../Products/Electronics/E079.png', 3500.00, 2580.00, 12, 'Yes', 4.96),
(240, 'E080', 'Vision Megaphone-MP-02-(Shadin)', 'Electronics', 'Vision Megaphone-MP-02-(Shadin)\nItem Code :874565\n\nFunctions: Talk/Record/Play/Siren/BT/USB/TF/AUX\nPower source:7.4V-9V\nPower output: 50 W\nRecording time: 350s\nAudible range: 500m\nWith a 7.4V lithium battery\nMaterial: PP material\nSpare parts: 1 pc rechargeable battery and 1 pc microphone', '../Products/Electronics/E080.png', 3500.00, 2580.00, 12, 'Yes', 4.96),
(241, 'E081', 'Vision Megaphone-MP-01-(Durjoy)', 'Electronics', 'Vision Megaphone-MP-01-(Durjoy)\nItem Code :874564\n\nFunctions: Talk/Record/Play/Siren/Music/U disk/TF card\nPower source:DC3V7\nPower output: 20W\nRecording time: 300s\nAudible range: 500m\nDimension: (L)210mm*(D)135mm\nMaterial: ABS material\nSpare parts: 1 pc charging cable', '../Products/Electronics/E081.png', 3500.00, 2580.00, 12, 'Yes', 4.96),
(242, 'E082', 'VISION Home IPS-Sine wave 850', 'Electronics', 'VISION Home IPS-Sine wave 850\nBrand: Vision \nItem code:874871\nColor: Black (As given picture)\n\nModel: 850\nCapacity: 700VA 12V (460W)\nLoad: Ceiling Fan-3pcs, LED Light-8pcs\nOutput: Pure Sine Wave\nDSP Microcontroller Technology\nDisplay: LED Indicator\nUPS functionality\nLA/SMF/Tubular Battery compatible\nAutomatic Bypass function\nBattery Low, Over Charge, Over load, Over heat protection\nShort circuit protection\nBattery Reverse protection\nAutomatic Cooling fan operation\n\nService and Support:\nService Warranty  2 years;\nFree Home Service  2 years;', '../Products/Electronics/E082.png', 7800.00, 5300.00, 12, 'Yes', 4.96),
(243, 'E083', 'Vision 55\" QLED TV Google Android 4K PQ1Galaxy Pro', 'Electronics', 'QLED 4K 60Hz Panel\nGoogle TV(Android 11.0)\nBezel less design\nADS panel technology\nColor gamut : DCI-P3 90% (Typ.)\nUltra viewing angle\nBrightness- 320 cd/m2(+- 20)\nEnhanced picture with Dolby vision and HLG\nHDR 10 and HDR 10+ enabled\nRAM-2 GB, ROM- 32 GB\nGoogle play store with eco system for TV\nAuthorized Netflix, YouTube and Prime video.\nEnhanced PFC and EMI circuits\n2*12-watt speakers with DTS studio and surround Sound.\nEnriched with Dolby ATMOS, Dolby Digital and Dolby Digital plus decoders.\nChromecast to cast your mobile and laptop\nFastest browser to explore the world (Toffee, Bongo, Chorki, Hoichoi, Facebook, Instagram)\n2 USB, 3 HDMI and 1 digital audio out.\nRefresh Rate: 60Hz\nColor: (Mixed) As given picture', '../Products/Electronics/E083.png', 7800.00, 5300.00, 12, 'Yes', 4.96),
(244, 'E084', 'Anker 10000mAh 22.5W Power Bank - Black - A1388H11', 'Electronics', 'Brand: Anker\nColour Black\nBattery Capacity 10000mAh\nNumber Of Port 2\nDimensions 4.5 × 2.8 × 1.2 inch\nModel A1388H11\nInput USB-C : 5V 3A / 9V 2.22A (20W max)\nInterface USB-C & USB-A\nMaterial ABS Plastic', '../Products/Electronics/E084.png', 7800.00, 5300.00, 12, 'Yes', 3.84),
(245, 'E085', 'Wiwu Wi-P020 Ultra-Thin Magsafe Powerbank 15W 10000mAh Explore Series Wireless - Gold', 'Electronics', 'Wiwu Wi-P020 Ultra-Thin Magsafe Powerbank 15W 10000mAh\n\nExperience seamless wireless charging with the ultra-thin Wiwu Wi-P020 MagSafe Powerbank. Enjoy 15W fast charging and a 10000mAh Explore Series Power bank for all-day power.\n\nThe MagSafe wireless backup charger for iPhone is an indispensable item when traveling or traveling. With an ultra-thin, compact, and lightweight design, it meets the criteria for daily carry.\n\nFeatures:\nWiwu Wi-P020 Explore, with its 10000mAh charging capacity, you can charge all your devices. It offers flexibility that will make your daily life easier with either wired or wireless charging options. Especially it’s made of aluminum alloy material.\n', '../Products/Electronics/E085.png', 7800.00, 5300.00, 12, 'Yes', 3.84),
(246, 'E086', 'Fantech GC-192 Black Gaming Chair', 'Electronics', 'This Fantech GC192 Gaming Chair is the ultimate gaming throne. The Fantech GC192 Gaming Chair with Memory Foam Lumbar Pillow is made with premium materials and designed with your comfort in mind. This chair ensures you can game for hours on end without any discomfort. The memory foam lumbar pillow supports your lower back, while the 3D armrests can be adjusted to suit your preferred gaming position. Whether you\'re a seasoned pro or a casual gamer, the GC192 caters to your needs with its plush velvet cushioning and multi-tilt function, ensuring long-term comfort during intense gaming sessions. ', '../Products/Electronics/E086.jpg', 7800.00, 5300.00, 12, 'Yes', 3.84),
(247, 'E087', 'Gaming Desk Z Shaped Large PC | Computer Gaming Desks Tables', 'Electronics', 'The gaming table built with RGB LED lights.7 attractive colors，3 models are available in this RGB LED lights. Adjust it to your loving lighting, that you can enjoy your game in a cool and blue or colored gaming arena.dazzling RGB lighting effects for enhancing your extreme gaming experiences.\nThe table comes with a cup holder, a headphone hook and 2 cable management holes. These added features help you have a better gaming experience.\nYour satisfaction is our top priority. We provide professional customer service both before and after your purchase by responding in 24 hours ASAP. Please feel free to contact us if you have any questions. ', '../Products/Electronics/E087.jpg', 7800.00, 5300.00, 12, 'Yes', 3.84),
(248, 'E088', 'HTC AT-1210 Rechargeable 4 Clipper Hair Trimmer For Men', 'Electronics', 'With the Perfect HTC Cordless Trimmer, you can get a neat look in your home within minutes. This personal grooming appliance comes with a Cable for an easy charge, and a Stainless Steel Blade for your safety. Also, the removable head makes it an easy-to-clean appliance.\nBlade Material: Stainless Steel\nTrimming Range: 0.5 - 7 mm\n4 length settings\nFor Beard and Moustache', '../Products/Electronics/E088.jpg', 7800.00, 5300.00, 12, 'Yes', 3.84),
(249, 'E089', 'Adjustable and Flexible Eye-Caring Study Desk Table Lamp for Bedroom and Office - Without Light (Any Color)', 'Electronics', 'Product details of Adjustable and Flexible Eye-Caring Study Desk Table Lamp for Bedroom and Office - Multi-color\nCLASSIC DESIGN: Simple and easy to operate with the integral on/off switch, this classic design flexi lamp looks stylish and will fit in with any room décor.\nCOMPACT: The AKA 40W \'Classic\' Flexi Table Lamp stand at approx. 34cm tall and has a flexible arm to adjust the angle of light exactly where you need it.\nADJUSTABLE FLEXI NECK: The attached lampshade is designed to help radiate the light in the desired direction, making it ideal for both arm length and close up work such as hobbies, working or studying. Simply adjust the flexible neck into various positions to change the height, direction and angle of the light.\nEXTRA SAFE: The stable base holds the lamp securely and allows you to safely adjust the neck to position the light in the direction you need. The AKA 40W \'Classic\' Flexi Desk Lamp is ideal for working, studying and hobbies including reading, drawing, writing, model construction and more, or simply use as stylish ambient lighting on a shelf or table top around your home or office.', '../Products/Electronics/E089.jpg', 7800.00, 5300.00, 12, 'Yes', 3.84),
(250, 'E090', 'A4 Tech Wired Optical Mouse 2X Click, USB, Black (OP-620D)', 'Electronics', 'Contoured shape is for maximum comfort and support. The sturdy scroll wheel with rubber makes sure that your hand will not slip when scrolling.\n* 5 M Clicks Durable Button Life: Extreme quality offer over 5 million clicks guaranteed.\n* 2X-button: Just one click on “2X Button” straightly open files and programs easily. Without any driver, Save times and improve efficiency.\n* 4-way Wheel: Smart horizontal and vertical scrolling.\n* Dust-resistant Wheel: Dust-resistant design prolong wheel life-span.\n* Plug and Play: 8 gestures to perform selectable hotkey commands.\n* Screen Capture', '../Products/Electronics/E090.jpg', 7800.00, 5300.00, 12, 'Yes', 3.84),
(361, 'Ea001', 'Ladies gold earring', 'Earring', 'Gold Color:Yellow gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:1.20 gm\nGross Weight:1.20 gm', '../Products/Earring/Ea001.webp', 8840.00, 8500.00, 78, 'Yes', 3.50),
(362, 'Ea002', 'Ladies gold earring', 'Earring', 'Gold Color:Yellow gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:3.94 gm\nGross Weight:3.94 gm', '../Products/Earring/Ea002.webp', 8840.00, 8500.00, 4, 'Yes', 3.50),
(363, 'Ea003', 'Ladies gold earring', 'Earring', 'Gold Color:Yellow gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:3.70 gm\nGross Weight:3.70 gm', '../Products/Earring/Ea003.webp', 8840.00, 8700.00, 5, 'Yes', 3.50),
(364, 'Ea004', 'Ladies gold earring', 'Earring', 'Gold Color:Yellow gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:1.37 gm\nGross Weight:1.37 gm   ', '../Products/Earring/Ea004.webp', 8840.00, 8700.00, 6, 'Yes', 3.50),
(365, 'Ea005', 'Ladies gold earring', 'Earring', 'Gold Color:Yellow gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:5.18 gm\nGross Weight:5.18 gm', '../Products/Earring/Ea005.webp', 8840.00, 8700.00, 8, 'Yes', 3.50),
(366, 'Ea006', 'Ladies gold earring\nDesign no: GPENT2728\n\n', 'Earring', 'Gold Color:Yellow goGold Karat:22 Karat\nMetal Purity:916\nNet Weight:6.01 gm\nGross Weight:6.01 gm', '../Products/Earring/Ea006.webp', 8840.00, 8700.00, 9, 'Yes', 3.50),
(367, 'Ea007', 'Ladies gold earring\nDesign no: GPENT2742', 'Earring', 'Gold Color:Yellow gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:2.28 gm\nGross Weight:2.28 gm', '../Products/Earring/Ea007.webp', 8840.00, 8700.00, 10, 'Yes', 3.50),
(368, 'Ea008', 'Ladies gold earring\nDesign no: EARR15064', 'Earring', 'Gold Color:Yellow gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:7.27 gm\nGross Weight:7.27 gm', '../Products/Earring/Ea008.webp', 8840.00, 8700.00, 47, 'Yes', 3.50),
(369, 'Ea009', 'Ladies gold earring\nDesign no: EARR15260', 'Earring', 'Gold Color:Yellow gold\nGold Karat:22 KaraMetal Purity:916\nNet Weight:2.59 gm\nGross Weight:2.59 gm', '../Products/Earring/Ea009.webp', 8840.00, 8700.00, 14, 'Yes', 3.50),
(370, 'Ea010', 'Ladies gold earring\nDesign no: GPENT2758', 'Earring', 'Gold Color:Yellow gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:3.78 gm\nGross Weight:3.78 gm', '../Products/Earring/Ea010.webp', 8840.00, 8700.00, 15, 'Yes', 3.50),
(371, 'Ea011', 'Ladies gold earring\nDesign no: EARR21156', 'Earring', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:5.72 gm\nGross Weight:5.72 gm', '../Products/Earring/Ea011.webp', 8840.00, 8700.00, 16, 'Yes', 3.50),
(372, 'Ea012', 'Ladies gold earring\nDesign no: EARR21168', 'Earring', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:1.84 gm\nGross Weight:1.84 gm', '../Products/Earring/Ea012.webp', 8840.00, 8700.00, 17, 'Yes', 3.50),
(373, 'Ea013', 'Ladies gold earring\nDesign no: EARR21107', 'Earring', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:1.43 gm\nGross Weight:1.43 gm', '../Products/Earring/Ea013.webp', 8840.00, 8700.00, 18, 'Yes', 3.50),
(374, 'Ea014', 'Ladies gold earring\nDesign no: EARR21074', 'Earring', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nGross Weight:1.87 gm', '../Products/Earring/Ea014.webp', 8840.00, 8700.00, 19, 'Yes', 3.50),
(375, 'Ea015', 'Ladies gold earring\nDesign no: NECK15077', 'Earring', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:9.36 gm\nGross Weight:9.36 gm', '../Products/Earring/Ea015.webp', 8840.00, 8500.00, 20, 'Yes', 3.50),
(818, 'ele001', 'Lenovo V15 Core i3 10th Gen Laptop', 'Electronics', 'Brand	Lenovo\r\nCondition	Intact\r\nLaptop Type	Standard\r\nProcessor Type	Intel Core i3-10110U 10th Gen\r\nProcessor Speed	4M Cache, 1.20 GHz up to 3.40 GHz\r\nChipset	Intel\r\nScreen Size	15.6\" HD LED Anti-Glare Display\r\nRAM	4GB DDR4 2666Mhz\r\nHard Disk	1TB SATA', '../Products/Electronics/ele001.jpg', 95000.00, 85000.00, 50, 'Yes', 0.00),
(829, 'ele002', 'Dell Latitude 7280 Core i7 7th Gen 128GB SSD Laptop', 'Electronics', 'Brand	Dell\r\nCondition	Used\r\nLaptop Type	Mini\r\nProcessor Type	Core i7 7th generation\r\nProcessor Speed	Base Frequency 2.8 GHz, up to 3.90 GHz, 4M Cache\r\nChipset	Intel\r\nScreen Size	12.5 Inch Diagonal FHD UWVA Anti-Glare Ultra Slim LED-Backlit\r\nRAM	8GB DDR4 2133MHz\r\nHard Disk	128GB M.2\r\nDisk Type	SSD', '../Products/Electronics/ele002.jpg', 35000.00, 26999.99, 25, 'Yes', 0.00),
(276, 'G001', '5 Spring Chest Pull', 'Gym Instruments', 'Strong and cozy streamlining design, great tightness, made by high-quality rubber plastic / stainless carbon spring steel wire, easy to carry anywhere.', '../Products/Gym Instrument/G001.jpg', 700.00, 550.00, 20, 'Yes', 4.50),
(277, 'G002', 'Double Suction Sit Up Bar', 'Gym Instruments', 'This is a double suction sit up bar suitable for doing roll belly movements, push-ups, side kicks, sit-ups, back stretching, elbow planks, abdominal exercises. It is made of slitted super-elastic wear-resistant eco-friendly foam material that is comfortable and safe. It is small in size and easy installation on smooth wooden floor, terrazzo floor, marble floor, tiles floor.', '../Products/Gym Instrument/G002.png', 6500.00, 2550.00, 20, 'Yes', 4.50),
(278, 'G003', 'Yoga Mat', 'Gym Instruments', 'Everyday essentials superior all-purpose exercise yoga mat has high slide resistance to help prevent injuries. You will be able to maintain your balance in any training type because to your exceptional resilience. The mat can be readily washed with soap and water. This mat has easy strapping and is low in weight, making it easy to travel and store.', '../Products/Gym Instrument/G003.jpg', 7500.00, 5600.00, 20, 'Yes', 4.50),
(279, 'G004', 'Foot Chest Body Tunntry', 'Gym Instruments', 'Portable and easily fit into your arm / chest and abdomen, foam handle and non slip pedal, NBR foam material, TPR high quality latex, suitable for travel and storage, men and women can use it, 52 x 28 cm dimension.', '../Products/Gym Instrument/G004.jpg', 8500.00, 6500.00, 20, 'Yes', 4.50),
(280, 'G005', 'Miss Hot Shaper Body Belt', 'Gym Instruments', 'Reduce belly fat very easily by this miss hot shaper body belt, 100% guarantee that this belt will make you slim by reducing your extra fat thus looking very attractive, you can use at / home / walking / work / shopping / jogging, polyester / spandex / nylon / rubber material, free size belt.', '../Products/Gym Instrument/G005.jpg', 3500.00, 2500.00, 20, 'Yes', 4.50),
(281, 'G006', 'Vibro Shape High Performance Comfortable Slimming belt', 'Gym Instruments', ' Elliptic oscillation slimming belt mechanism, effectiveness, good digestion, relaxation and exercise, powerful and comfortable massage system, heat system, auto or manual massage and controller. It allows you to massage the body effortlessly, it will reduce your fat and bring a beautiful shape and weight to the body, spend only 5 to 5 minutes a day with Vibro Shape while sitting in your home or office and get slim figure, it is easy to use, free size.', '../Products/Gym Instrument/G006.jpg', 3500.00, 1500.00, 20, 'Yes', 4.50),
(282, 'G007', 'Tummy Trimmer Single Spring Exerciser', 'Gym Instruments', 'There is no substitute for exercise to maintain fit fitness for both men and women. For those who can\'t go to the gym, this may be the worst. The spring system is, therefore, more durable than any other body trimmer. 12 types of exercises can be done with stainless steel springs. It has made of rust-free stainless steel spring material', '../Products/Gym Instrument/G007.jpg', 8000.00, 6500.00, 89, 'Yes', 4.50),
(283, 'G008', 'Adjustable Hand Grip Strengthener', 'Gym Instruments', 'This adjustable hand grip exerciser is made with stainless steel spring and polypropylene. It has a resistance range of 10 - 40Kg. The inner core is also made of stainless steel to provide strengthens the muscles and tendons in your hands.', '../Products/Gym Instrument/G008.jpg', 8500.00, 6500.00, 78, 'Yes', 4.50),
(284, 'G009', 'Revoflex Xtreme Roller', 'Gym Instruments', 'Revoflex xtreme roller complete body workout machine.', '../Products/Gym Instrument/G009.jpg', 8500.00, 6500.00, 78, 'Yes', 4.50),
(285, 'G010', 'Double Spring Tummy Trimmer', 'Gym Instruments', 'With tommy trimmer allows you to reduce fat and change your body shape, Can be extended from 50 cm in length to 165 cm, abdominal muscles become stronger when you sit on the ground and exercise by pressing and holding with your feet.', '../Products/Gym Instrument/G010.jpg', 8500.00, 6500.00, 56, 'Yes', 4.50),
(286, 'G011', 'Combo Pack of 2 Pieces Push Up Bar', 'Gym Instruments', 'Combo pack of 2 pieces push up bar is specially made for daily home exercise. This push up bar comes with crome plated steel. It built with soft cushioning. This is very strong but lightweight. It helps to widen the chest and triceps muscles. It features boosts strength, increases range of motion, This bar helps reduce pressure on the wrists and hands during push ups. For efficient storage, the bar remains in a flat folding position. Its handles have a great grip so it can be easily caught.', '../Products/Gym Instrument/G011.jpg', 8500.00, 6500.00, 34, 'Yes', 4.50),
(287, 'G012', 'Sweat Slim Belt Plus Slimming Belt Hot Body Shaper', 'Gym Instruments', 'Sweat slim belt plus is a perfect slimming belt for everyday use while doing regular work or exercise and it\'s internal texture help to reduce the sweating and sucks the moisturizer from your body, compatible for both man and women.', '../Products/Gym Instrument/G012.jpg', 8500.00, 6500.00, 12, 'Yes', 4.50),
(288, 'G013', 'Adjustable Self-Suction Sit Up Bar', 'Gym Instruments', 'The structure is made of steel, tough and durable, you can use it to hold all kinds of smooth surfaces, build muscle, lose weight very well and see the soft and comfortable real result without hitting the legs. Protective self-sucking is easy to move. The sturdy steel frame is built for extreme durability, and great assistance for the waist, abdomen, leg, body shaping, butt lift, and muscle. Its natural rubber sucker firmly grips the floor to ensure a safe and stable stand for training. Its max bear capacity is 330lbs. The soft and thick foam handles are comfortable against feet and prevent chafing. It features adjustable height to fit different needs and strong suction.', '../Products/Gym Instrument/G013.png', 8500.00, 6500.00, 90, 'Yes', 4.50),
(289, 'G014', 'Instant Waist Adjustable Hourglass Body Shape Miss Belt', 'Gym Instruments', 'Miss belt is a perfect body shaper that is comfortable, lightweight, and stretchy fabric. This belt stays in place while performing any activity. This belt gives two sizes and shapes smaller in seconds and it’s completely invisible. It stays under clothes and provides instant abdominal compression and back support. This belt uses double-compression waist training technology.', '../Products/Gym Instrument/G014.jpg', 8500.00, 6500.00, 90, 'Yes', 4.50),
(290, 'G015', 'Livivo Shape Slimming Belt', 'Gym Instruments', 'Elliptic oscillation slimming belt mechanism, powerful and comfortable massage system, auto or manual massage controller, use only 15 minute every day to reduce your fat and bring a beautiful shape to the body, easy to use.', '../Products/Gym Instrument/G015.jpg', 1500.00, 1200.00, 89, 'Yes', 4.50),
(291, 'G016', 'Royal Posture Back Support Brace', 'Gym Instruments', 'Amazing back support to align your spine, relieve pain by supporting your neck / spine and your lower back, extremely comfortable and the neoprene, nylon and cotton blend is so breathable, it\'s virtually undetectable, giving you perfect support anywhere and anytime.', '../Products/Gym Instrument/G016.jpg', 8500.00, 6500.00, 778, 'Yes', 4.50),
(292, 'G017', 'AB Rocket Abs Workout Machine', 'Gym Instruments', 'Ab Rocket Abs Workout Machine offers a revolutionary way to build lower/upper/middle abs by doing regular exercises. This ab rocket machine works like a real piece of gym equipment, with a back and head machine that comfortably supports your head and neck, along with a rotating cushion that gives the user a gentle massage and a relaxing exercise experience. Also, it comes with a two-sided sitting handle for holding during the workout and it gives the user a lot of strength.', '../Products/Gym Instrument/G017.jpg', 8500.00, 6500.00, 778, 'Yes', 4.50),
(293, 'G018', 'American Fitness Premium 35 Motorized Treadmill', 'Gym Instruments', 'The American Fitness Premium 35 is a high-quality motorized treadmill designed for use in gyms, sports clubs and at home. It has body massager, with sit up function. It has LCD display which shows heartbeat, pulse, speed, calories, time, distance all on the display. It is foldable so it can save any space in the room at home. Also, this treadmill has lock system wheels that you can easily transport.', '../Products/Gym Instrument/G018.png', 8500.00, 6500.00, 54, 'Yes', 4.50),
(294, 'G019', 'Norflex XR800VR Multifunctional Motorized Treadmill', 'Gym Instruments', 'This Norflex XR800VR is a multifunctional motorized treadmill that has a heavy-duty 3.5HP powerful motor. It offers speeds ranging from 1 to 22 km per hour. It has an LED monitor that can monitor speed, time, incline, calories, distance and heart rate. It also has an MP3 / USB port and Hi-Fi speakers that let you tune into a playlist. Also easily access your apps from a compatible device.', '../Products/Gym Instrument/G019.png', 8500.00, 6500.00, 45, 'Yes', 4.50),
(295, 'G020', 'Ninja NH718 Knee Support', 'Gym Instruments', 'This Ninja NH718 is a knee support that is used to reduce knee stiffness, improve blood circulation and increase blood oxygen levels. It can also be used as a sports brace for those who have knee surgery or athletes. It is made of high-quality neoprene and nylon material.', '../Products/Gym Instrument/G020.png', 8500.00, 6500.00, 45, 'Yes', 4.50),
(296, 'G021', 'Vigbody Hl-X3B Indoor Stationary Bike', 'Gym Instruments', 'The Vigbody Hl-X3B is a high-quality indoor stationary bike designed for exercise at home or at the gym. It is heavier and more stable than outdoor bikes so can offer different resistance levels and workout programs. This bike is designed with upgraded multi-grip handlebars, thick triangular steel frame and whisper quiet belt driven system so you get stability in both sitting and standing positions while riding. It has an adjustable seat that can be adjusted to a height of 31.8-38.5 inches. Also its comfortable seat cushion that allows you to ride for a long time.', '../Products/Gym Instrument/G021.png', 8500.00, 6500.00, 67, 'Yes', 4.50),
(297, 'G022', 'American Fitness Premium A8 Ultra Motorized Treadmill\n    ', 'Gym Instruments', 'The American Fitness Premium A8 ultra is a high-quality motorized treadmill designed for use in sports clubs, gyms, and at home. It has a powerful 5 horsepower motor that runs smoothly. It can run at a speed of 1-18KM per hour. Also, this treadmill is capable of carrying up to 180 kg. It is easy to use and offers long life if maintained. This treadmill has a digital display monitor so you can see everything.', '../Products/Gym Instrument/G022.png', 8500.00, 6500.00, 9, 'Yes', 4.50),
(298, 'G023', 'Premium Adjustable Back Posture Corrector Belt', 'Gym Instruments', 'This Premium Adjustable Corrector Belt can be adjusted to support the upper back and lower and makes it easy to wear. The soft material provide comfortable for your back. It has some amazing features like kyphosis, poor posture, kyphosis, spine curvature, thoracic surgery kyphosis, thoracic disc herniation, clavicle fracture, spinal dislocation, round shoulders.', '../Products/Gym Instrument/G023.png', 8500.00, 6500.00, 68, 'Yes', 4.50),
(299, 'G024', 'Fitness Exercise Bicycle', 'Gym Instruments', 'This fitness exercise bicycle is manufactured in China. It is high-standard gym equipment for daily exercise to burn calories, support heart health, strengthen and tone muscles, reduce stress & engage lower body muscles. This excellent bicycle features a seat that can be adjusted back and forth to satisfy your different postures. Besides, an electronic meter on the handle can keep track of your cycling speed, time, distance, and time while doing fitness training.', '../Products/Gym Instrument/G024.jpg', 8500.00, 6500.00, 78, 'Yes', 4.50),
(300, 'G025', 'Six Pack Care X-Bike Exercise Bench', 'Gym Instruments', 'This six-pack Care X-Bike exercise bench has 6 different workout options that are useful for daily exercise. This machine can be used for push-ups, and sit-ups / to relieve back and neck pain / to increase leg, shoulder, and muscle strength. However, the X-Bile machine has a maximum weight loading capacity of 150 kg and comes with dimensions of 70 x 60 x 100 cm, and a weight of 10 kg.', '../Products/Gym Instrument/G025.jpg', 8800.00, 6500.00, 98, 'Yes', 4.50),
(251, 'K001', 'T-Shirt and Polo for kids', 'Kids Collection', ' Comfortable and versatile, available in various colors and patterns.', '../Products/Kids/K001.jpeg', 2800.00, 2500.00, 12, 'Yes', 3.84),
(252, 'K002', 'Jeans and Pant for kids', 'Kids Collection', 'Durable and suitable for everyday play. Options include denim, cotton, and leggings.', '../Products/Kids/K002.webp', 2800.00, 2500.00, 12, 'Yes', 3.90),
(253, 'K003', ' Kids Premium Superman Peach Short Pant', 'Kids Collection', 'Ideal for warmer weather, available in casual and sporty styles.', '../Products/Kids/K003.jpeg', 2800.00, 2500.00, 12, 'Yes', 3.90),
(254, 'K004', ' Premium Quality Stylish Cotton Hoodie For Women', 'Kids Collection', 'For layering and warmth,  made from soft, cozy materials.', '../Products/Kids/K004.jpeg', 2800.00, 2500.00, 12, 'Yes', 3.90),
(255, 'K005', 'Uniform for kids', 'Kids Collection', 'Often required by schools, including items like button-down shirts, blouses, skirts, and trousers.', '../Products/Kids/K005.jpeg', 2800.00, 2500.00, 12, 'Yes', 3.90),
(256, 'K006', 'Premium Ladies Girls Fashion long Blazer Cardigen and Sweater.', 'Kids Collection', 'For a more polished look,  part of school uniforms or dressier occasions.Available in every shade and colour.', '../Products/Kids/K006.webp', 2800.00, 2500.00, 12, 'Yes', 3.90),
(257, 'K007', 'Export Quality Girl Baby Frock/Tops/Soft Fabric Baby Girls Dress', 'Kids Collection', ' Suitable for school events or formal occasions.', '../Products/Kids/K007.webp', 2800.00, 2500.00, 12, 'Yes', 3.90),
(258, 'K008', '30cm Duck Clothes Hoodie Cute Pajamas Jumpers Rompers LaLafanfan Plush Toy Stuffed Soft Duck Doll Toys Girl`s Gift for Kids DIY', 'Kids Collection', 'Sets or one-piece sleepers made from soft fabrics like cotton and flannel.', '../Products/Kids/K008.jpeg', 2800.00, 2500.00, 12, 'Yes', 3.90),
(259, 'K009', 'aHome Slippers - Fashionable Regular Amenities indoor Strip Coral Fleece luxury Sanda', 'Kids Collection', 'Cozy options for lounging or bedtime routines.', '../Products/Kids/K009.jpeg', 2800.00, 2500.00, 12, 'Yes', 3.90),
(260, 'K010', 'Top Design New Style Jacket For Women - Winter new Collection For Women - Jacket For kids', 'Kids Collection', 'Includes options like raincoats, winter coats, and lightweight jackets for various weather conditions.', '../Products/Kids/K010.webp', 2800.00, 2500.00, 12, 'Yes', 3.90),
(261, 'K011', 'Ensure Safety in the Water with the Intex Pool School-Dillax Swim Vest Life Jacket-Yellow (3-6 Years), Easy to Use and Clean, A Unique Choice for Kids', 'Kids Collection', 'Useful for layering in cooler weather without restricting arm movement.', '../Products/Kids/K011.jpeg', 2800.00, 2500.00, 12, 'Yes', 3.90),
(262, 'K012', 'Dragon Ball Super Anime TCG Card Game English Version Goku Gohan Vegeta Trunk Broly Rare Collectibles Kids Gift Toy Holo Lamination', 'Kids Collection', 'Moisture-wicking fabrics for sports and physical activities.', '../Products/Kids/K012.webp', 800.00, 500.00, 12, 'Yes', 3.90),
(263, 'K013', 'Summer Kid Baby Girls Floral Long Tutu skart Wedding Party Dresses and birthday Dresses 0-7', 'Kids Collection', 'Comfortable for exercise or casual wear.', '../Products/Kids/K013.webp', 500.00, 400.00, 12, 'Yes', 3.90),
(264, 'K014', '2024 autumn new girl baby round neck dress children flowers cotton skirt 0-4 Years', 'Kids Collection', 'Includes swimsuits, rash guards, and swim trunks for pool or beach days.', '../Products/Kids/K014.webp', 700.00, 500.00, 12, 'Yes', 3.90),
(265, 'K015', '6 pc multicolor baby ties pant for winter\n9 Ratings', 'Kids Collection', 'For weddings, parties, or other special events.', '../Products/Kids/K015.webp', 400.00, 300.00, 12, 'Yes', 3.90),
(266, 'K016', '1Pcs Funny Plush Clockwork Chick Jumping Wind Up Animal Kids Toys Cute Plush Chicken Toy Easter Gift for Little Boy and Girls Random Color', 'Kids Collection', 'Often used for birthdays or dress-up . For a complete formal look', '../Products/Kids/K016.webp', 700.00, 500.00, 12, 'Yes', 3.90),
(267, 'K017', 'Dinosaur Toy Set Radium\n', 'Kids Collection', 'Often used for birthdays or dress-up . For a complete formal look', '../Products/Kids/K017.webp', 700.00, 400.00, 12, 'Yes', 4.50),
(268, 'K018', 'Baby Cap Towel Baby hooded towels, Newborn Baby, Washable, Kids Cap Towel , Bath towels,Velvet Cap Towel Size 29\'\'*27\'\'', 'Kids Collection', 'Includes sundresses, tank tops, and shorts.', '../Products/Kids/K018.webp', 700.00, 400.00, 12, 'Yes', 4.50),
(269, 'K019', '14 Pcs Kids Hair Clips Set Cartoon Icecream Cute & Trendy Baby Girls Toddlers Hair Pins Barrettes, Combo of 14 Pcs (Coffee Brown)', 'Kids Collection', 'Includes thermal underwear, mittens, and scarves.', '../Products/Kids/K019.webp', 700.00, 400.00, 12, 'Yes', 4.50),
(270, 'K020', 'Bolttle Lovely Animals Creative Gift Outdoor Portable Sports Cycling Camping Hiking Bicycle School Kids Water Bottle', 'Kids Collection', 'Includes lightweight jackets, cardigans, and rain boots.', '../Products/Kids/K020.webp', 700.00, 400.00, 12, 'Yes', 4.50),
(271, 'K021', 'Dress For Kids 3 Months - 3 Years old Birthday Korean Style Long Sleeve Cute Floral Princess Formal Dresses Ootd For Baby Girl', 'Kids Collection', 'Durable and easy to put on and take off.', '../Products/Kids/K021.webp', 700.00, 400.00, 12, 'Yes', 4.50),
(272, 'K022', '1-12 Years Premium Quality 1 Piece Baby Girls Tops fashionable sweater Dress winter Collection beautiful full sleeve kids clothing', 'Kids Collection', 'Playful designs and bright colors for casual wear.', '../Products/Kids/K022.webp', 3100.00, 0.00, 12, 'Yes', 4.50),
(273, 'K023', 'Fashion Fastball CAP Beach Coconut Tree Club Party Hip Hop Hat Snapback Hats Unisex Adult Outdoor Casual Sun Baseball Cap', 'Kids Collection', 'Includes sun hats, beanies, and baseball caps', '../Products/Kids/K023.webp', 300.00, 250.00, 12, 'Yes', 4.50),
(274, 'K024', 'Scarves ', 'Kids Collection', 'For colder weather or as fashion accessories.\nPractical items for school and outings.', '../Products/Kids/K024.jpeg', 300.00, 250.00, 12, 'Yes', 4.50),
(275, 'K025', 'Backpacks ', 'Kids Collection', 'For colder weather or as fashion accessories.Practical items for school and outings.', '../Products/Kids/K025.webp', 650.00, 550.00, 12, 'Yes', 4.50),
(346, 'M001', 'MISS ROSE M 58 Color Professional Makeup pallet, Makeup Kit for Women Full Kit, All In One Makeup Kit Set, Makeup Gift Set for women girls (331N)', 'Makeup', '【All-in-One Makeup Kit】 Includes 39 colored eyeshadows, 6 Color Blush, 4 Color Comapct Powder, 3 Color Lipstick, 2 Color Pencil, 2 Color Glitter,, 2 lip liners, 2 eyeliners, 4 eye shadow brushes , 1 mirror.\n【Long Lasting and Skin-friendly】 The makeup palette has all outstanding matte, metallic, satin, shimmers and gel glitter - serious staying power and blend-ability. Healthy and safe ingredients, would not irritate your skin. High quality ingredients with silky shine color, can last for all day long.\n【High pigment and waterproof】 Super soft shadows easily blendable. long-lasting, natural, waterproof. For both personal and professional use.\n【Special Perfect Makeup Gift Set】 its versatile design and array of color options makes it an ideal gift for both makeup professionals and beauty. It can always offer you different creative eye look in different occasions, such as party, music party and casual everyday makeup.\n【Best Service】For our customers have a more enjoyable experience in our shop, we provide more comprehensive after-sales service, If you ever have questions or run into an issue, please give us a chance to address your concerns. Just send email or contact us. We have local store in the US as well.', '../Products/Makeup/M001.jpeg', 6500.00, 4300.00, 45, 'Yes', 5.00),
(347, 'M002', 'All in One Makeup Kit for Makeup storage bag 2X14 Colors Eyeshadow Palette Liquid Foundation Eyeliner Pencils Contouring Stick Lip Gloss Eyebrow Pencils 20Pcs Makeup Brushes etc For Women Girls Teens (Black)', 'Makeup', '【All In One Makeup Set】 1 x Makeup storage bag, 2x14 Color Eyeshadow Palette，5 x Lip Gloss，3 x Foundation （Different styles），1 x Mascara，1 x Eyebrow Pencil，1 x Eyeliner，1 x Contour Stick，1 x Eyebrow powder, 2 x Powder Puff, 20 x Makeup Brushes\n【Quality】Professional matte eyeshadow palette super soft and highly pigmented,waterproof,excellent ductility,strong adhesion.It can long last for all day long.\n【LONG LASTING】 Our cosmetics lasting color effect can be used for a long time. Long-lasting color effect, soft and comfortable texture,equipped with high-quality brush, easy to create perfect makeup. With high-quality ingredients and silky luster, they can last all day.\n【Wonderful World】 eyeshadow palette will take you through every season,providing you with every color of eyeshadow you need. Great for exploring colors and makeup artistry. Suit for different occasions, like casual, salon, party, wedding, etc\n【No Reason for Return&No Reason to Return】 For this price you can\'t find the reason for the return. If you want to return. you don\'t need to provide any reason. Easy return. Important thing,the product is safe. Made from the best pigments and purest mineral oil. No harm and great for all levels of skin', '../Products/Makeup/M002.jpg', 4500.00, 4200.00, 45, 'Yes', 4.50),
(348, 'M003', 'UNIFULL 132 Color All- In- One Makeup For Women Full Kit,Professional Makeup Kit,Makeup Gift Set for Women,Girls&Teens,Include eyeshadow/lipstick/concealer/Lip Gloss/Eyeliner/Mascara（006N2-Silver）', 'Makeup', '\nColor Set 1\nBrand UNIFULL\nFinish Type Semi-Matte\nCoverage Full\nItem Form Box', '../Products/Makeup/M003.jpg', 7800.00, 5800.00, 65, 'Yes', 2.80),
(349, 'M004', 'Makeup Kit for Women Full Kit - Eyeshadow Palette, Lipsticks, Lipgloss, Blushes, Contour, Highlighters, Makeup Pencil, False Eyelashes, Re-usable Train Case Gift Set for Teen Girls Starters Pros', 'Makeup', 'Color SET 01\nBrand CHARMCODE\nFinish Type Natural\nItem Form Pencil, Powder\nProduct Benefits A versatile makeup kit suitable for all skill levels', '../Products/Makeup/M004.jpg', 450.00, 420.00, 66, 'Yes', 2.80),
(350, 'M005', 'All In One Professional Makeup Kit Include Eyeshadow Palette Blushes Compact Bronzing Highlighter Powder Glitter Lipliner Eyeliner Pencil Brushes with Mirror Make Up Set Christmas Gifts For Women Girl', 'Makeup', '\nColor 06\nBrand UCANBE\nFinish Type Shimmery,Glitter,Shimmer,Matte,Natural\nCoverage Full\nItem Form Cream, Pencil, Powder', '../Products/Makeup/M005.jpg', 4588.00, 4200.00, 67, 'Yes', 3.50),
(351, 'M006', 'All In One Professional Makeup Kit Include Eyeshadow Palette Blushes Compact Bronzing Highlighter Powder Glitter Lipliner Eyeliner Pencil Brushes with Mirror Make Up Set Christmas Gifts For Women Girl', 'Makeup', 'Color 06\nBrand UCANBE\nFinish Type Shimmery,Glitter,Shimmer,Matte,Natural\nCoverage Full\nItem Form Cream, Pencil, Powder', '../Products/Makeup/M006.jpg', 5477.00, 5400.00, 68, 'Yes', 3.50),
(352, 'M007', 'Women Makeup Sets Full Kits - 190 Colors Cosmetic Make Up Gifts Combination with Eyeshadow Facial Blusher Eyebrow Powder Face Concealer Powder Eyeliner Pencil with Full Size Mirror Makeup Palette Kit', 'Makeup', 'Color 190 Colors Makeup Sets - Multicolors\nBrand MORNECA\nFinish Type Matte\nCoverage Full\nItem Form Powder', '../Products/Makeup/M007.jpg', 6584.00, 6500.00, 5, 'Yes', 3.50),
(353, 'M008', 'Makeup Kit for Teen Girls & Women Full Kit, Beauty Train Case with Starter Cosmetic Set, Make Up Valentine\'s Day Gift Box with Eyeshadow,Lipgloss,Highlighter,Blush,Lip&Eye Pencils,Brush & More(Purple)', 'Makeup', '\nColor Purple Train Case with Makeup Kit\nBrand CHARMCODE\nFinish Type Matte\nProduct Benefits Basic starter kit with rich pigmented colors for various makeup styles and brilliant finish\nSkin Tone All', '../Products/Makeup/M008.jpg', 4588.00, 4200.00, 89, 'Yes', 3.50),
(354, 'M009', 'Makeup Set for Girls, Rainbow Makeup Kit, Beauty Boxes with Brushes and Cosmetics, Fashionable Makeup Case Organizer, Pink', 'Makeup', '\nColor Multicolor\nBrand MTDXILTAI\nFinish Type Natural\nCoverage buildable\nItem Form Rectangular', '../Products/Makeup/M009.jpg', 4564.00, 4200.00, 55, 'Yes', 3.50),
(355, 'M010', '132 Color All In One Makeup Gift Set Kit- Includes 94 Eyeshadow, 12 Lip Gloss, 12 Concealer, 5 Eyebrow powder, 3 Face Powder, 3 Blush, 3 Contour Shade, 2 Lip Liners, 2 Eye Liners, 4 Eyeshadow Brush', 'Makeup', 'Color Silver\nBrand CHARMCODE\nFinish Type Matte\nItem Form Liners,Powder\nProduct Benefits Refreshing', '../Products/Makeup/M010.jpg', 455.00, 420.00, 52, 'Yes', 3.50),
(356, 'M011', 'All In One Makeup Gift Kit - Ultimate Color Combination - 36 Eyeshadow, 28 Lip Gloss, 3 Blusher, 4 Concealer, 3 Contour Powder, 3 Brushes, 1 Mirror, 74 Colors Palette Set', 'Makeup', 'Color Multicolor, Black\nBrand UDUOLER\nFinish Type Glossy, Glitter, Smooth, Shimmer, Matte\nCoverage full\nItem Form Powder', '../Products/Makeup/M011.jpg', 4558.00, 4480.00, 78, 'Yes', 3.50),
(357, 'M012', 'Hot Sugar Makeup Kit for Women Full Kit Teen Girls Starter Cosmetic Gift Set with Beautiful Rainbow Train Case Includes Pigmented Eyeshadow Palette Blush Lipstick Lip Pencil Eye Pencil (Rainbow)', 'Makeup', '\nColor Rainbow\nBrand Hot Sugar\nFinish Type Shimmer\nCoverage Full\nItem Form Powder', '../Products/Makeup/M012.jpg', 4550.00, 4220.00, 89, 'Yes', 3.50),
(358, 'M013', 'OCHEAL Makeup Bag, Portable Cosmetic Bag, Large Capacity Travel Makeup Case Organizer, Black For Women Toiletry Bag for Girls Traveling With Handle and Divider', 'Makeup', 'Separate Brushes Compartment - Travel makeup bag comes with a separate space to hold your brushes and protect them from dust. Good travel makeup bags for women\nFlexible Velcro Dividers - 2 small sections, 6 elastic cord section and one more small pocket attached to the back will help store your cosmetics well\nHigh Quality Material - The makeup organizer bag made of quality waterproof vegan leather fabric, lining-nylon.This cosmetic bag giving you a high-quality using experience which will last for a long time\nSize: 9.4 x 6.5 x 4.7 (inch) . Portable and lightweight design makeup bag for women which makes the makeup travel bag fit for suitcases and easy to carry. Do your makeup anywhere. The smooth two-way zippers allow easy access\n100% Satisfied After-Sales Service--If you have any questions or dissatisfaction with our large makeup bag, please contact our after-sales service', '../Products/Makeup/M013.jpg', 4550.00, 4220.00, 45, 'Yes', 3.50),
(359, 'M014', 'Queboom Travel Makeup Bag Cosmetic Bag Makeup Bag Toiletry bag for women and men (Green)\nBrand: Queboom', 'Makeup', '【Large Capacity 】Cosmetic Bag main size:9.5*2.5*7in,weight:4.39oz.Nylon Fabric:Made from nylon surface and the inner material is cotton.The small bag inside size:7.5*5.2in.3 separate compartments,double zipper design,easy storage and orderly\n【Makeup bag】Make up bag is made of soft fabrics,not a rigid type,also waterproof inside and outside.Can be hand wash.The makeup bag interior is covered with thick sponge to protect the cosmetics at all times\n【Multi-funtional and all in one place】Travel makeup bag organizer has a large makeup bag and a small cosmetic bag. It contains 3 compartments, a main large compartment, a brushes Compartment and a detachable cosmetic bag.Have enough space to storage your cosmetics, skin care products, cosmetic accessories\n【Portable】Travel makeup bag is portable and lightweight,very suitable for storage of cosmetics in suitcase and easy to carry when traveling or on bussiness\n【Cosmetic bag】Good for women,men or families on holidays and festivals', '../Products/Makeup/M014.webp', 4558.00, 4250.00, 52, 'Yes', 3.50),
(360, 'M015', 'Color Nymph All In One Makeup Kit Comestics Gifts for Girls Teens, Travel Makeup Set 4 Trays Train Case for Beginner Includes Eyeshadow Highlighter Lipgloss Blush Concealer Brush Eyeliner Lipbalm', 'Makeup', 'Color Green\nBrand Color Nymph\nItem Form compact, box, case\nProduct Benefits An all-in-one, fun, travel-friendly, high-quality, and versatile makeup kit suitable for various skin tones, occasions, and gifting options.An all-in-one, fun, travel-friendly, high-quality, and versatile makeup kit suitable for various skin tones, occasions, and gifting options.\nSkin Tone All', '../Products/Makeup/M015.jpg', 8770.00, 4500.00, 52, 'Yes', 3.50),
(331, 'N001', 'Ladies gold necklace', 'Necklace', 'Product Information:drop_up\nProduct name:Ladies gold necklace\n\nDesign no:WRIST10352-WRIST10351\n\nProduct code:24110050087-24110050086', '../Products/Necklace/N001.webp', 1.00, 101899.00, 11, 'Yes', 4.21),
(332, 'N002', 'Ladies diamond necklace', 'Necklace', 'Product name:Ladies diamond necklace\n\nDesign no:NECK17977-NECK17968\n\nProduct code:24100100176-24100100167', '../Products/Necklace/N002.webp', 1.00, 101899.00, 15, 'Yes', 4.21),
(333, 'N003', 'Ladies gold necklace', 'Necklace', 'Product name:Ladies gold necklace\n\nDesign no:NECK17975-EARR21065\n\nProduct code:24100100114-24100100174', '../Products/Necklace/N003.webp', 1.00, 101899.00, 18, 'Yes', 4.21),
(334, 'N004', 'Ladies gold ne', 'Necklace', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:118.42 gm\nGross Weight:131.61 gm', '../Products/Necklace/N004.webp', 1.00, 101899.00, 20, 'Yes', 4.21),
(335, 'N005', 'Gold necklace', 'Necklace', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:60.73 Gross Weight:60.73 gm', '../Products/Necklace/N005.jpeg', 1.00, 101899.00, 45, 'Yes', 4.21),
(336, 'N006', 'Ladies gold necklace', 'Necklace', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:7.85 gm\nGross Weight:7.85 gm', '../Products/Necklace/N006.webp', 1.00, 101899.00, 44, 'Yes', 4.21),
(337, 'N007', 'Ladies gold necklace', 'Necklace', 'Gold Color:Rose Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:46.34 gm\nGross Weight:46.34 gm', '../Products/Necklace/N007.webp', 1.00, 101899.00, 46, 'Yes', 4.21),
(338, 'N008', 'Ladies gold necklace', 'Necklace', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:48.28 gm\nGross Weight:48.28 gm', '../Products/Necklace/N008.webp', 1.00, 101899.00, 78, 'Yes', 4.21),
(339, 'N009', 'Ladies gold necklace', 'Necklace', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:40.70 gm\nGross Weight:40.70 gm', '../Products/Necklace/N009.webp', 1.00, 101899.00, 79, 'Yes', 4.21),
(340, 'N010', 'Ladies gold necklace', 'Necklace', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:43.81 gm\nGross Weight:43.81 gm', '../Products/Necklace/N010.webp', 1.00, 101899.00, 75, 'Yes', 4.21),
(341, 'N011', 'Baby gold necklace', 'Necklace', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nGold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:36.15 gm\nGross Weight:36.15 gm', '../Products/Necklace/N011.webp', 1.00, 101899.00, 75, 'Yes', 4.21),
(342, 'N012', 'Gold necklace', 'Necklace', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:95.69 gm\nGross Weight:114.35 gm', '../Products/Necklace/N012.webp', 1.00, 101899.00, 45, 'Yes', 4.21),
(343, 'N013', 'Ladies gold neck', 'Necklace', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:26.39 gm\nGross Weight:26.39 gm', '../Products/Necklace/N013.webp', 1.00, 101899.00, 89, 'Yes', 4.21),
(344, 'N014', 'Gold necklace', 'Necklace', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:51.32\nGross Weight:51.32', '../Products/Necklace/N014.jpeg', 1.00, 101899.00, 85, 'Yes', 4.21),
(345, 'N015', 'Gold necklace', 'Necklace', 'Gold Color:Yellow Gold\nGold Karat:22 Karat\nMetal Purity:916\nNet Weight:50.45\nGross Weight:50.45', '../Products/Necklace/N015.jpeg', 1.00, 101899.00, 78, 'Yes', 4.21),
(33, 'P002', 'Semi Slim Fit Washed Jeans With Five Pockets', 'Pant', 'Semi Slim Fit washed jeans with five pockets. Comes with Front zip and metal button closure. These garments were produced using technologies that reduce water consumption in the dyeing process. Depending on your computer or mobile screen resolution, product color may vary slightly.', '../Products/Pant/P002.jpg', 780.00, 450.00, 67, 'Yes', 4.80),
(34, 'P003', 'Semi Slim Fit Washed Jeans With Five Pockets', 'Pant', 'Semi Slim Fit washed jeans with five pockets. Comes with Front zip and metal button closure. These garments were produced using technologies that reduce water consumption in the dyeing process. Depending on your computer or mobile screen resolution, product color may vary slightly.', '../Products/Pant/P003.jpg', 890.00, 700.00, 89, 'Yes', 4.80),
(35, 'P004', 'Casual Pants', 'Pant', 'It is available in denim fabric, available in slim, regular, and relaxed fits, multiple washes and colors.Its so suitable for everyday wear, casual outings, and relaxed settings.', '../Products/Pant/P004.jpg', 780.00, 700.00, 7655, 'Yes', 5.00),
(36, 'P005', 'Casual Pants', 'Pant', ' Its loose fit, drawstring waist, made from materials like cotton or linen has made this iteam super comfortable.', '../Products/Pant/P005.jpg', 780.00, 700.00, 456, 'Yes', 5.00),
(37, 'P006', 'Casual Pants', 'Pant', 'Ideal for lounging, beachwear, and casual settings.', '../Products/Pant/P006.jpg', 567.00, 450.00, 3456, 'Yes', 2.70),
(38, 'P007', 'Semi Slim Fit Washed Jeans With Five Pockets', 'Pant', 'Semi Slim Fit washed jeans with five pockets. Comes with Front zip and metal button closure. These garments were produced using technologies that reduce water consumption in the dyeing process. Depending on your computer or mobile screen resolution, product color may vary slightly', '../Products/Pant/P007.jpg', 450.00, 420.00, 45, 'Yes', 2.80),
(39, 'P008', 'Semi Slim Fit Washed Jeans With Five Pockets', 'Pant', 'Semi Slim Fit washed jeans with five pockets. Comes with Front zip and metal button closure. These garments were produced using technologies that reduce water consumption in the dyeing process. Depending on your computer or mobile screen resolution, product color may vary slightly.', '../Products/Pant/P008.jpg', 1200.00, 950.00, 909, 'Yes', 2.80),
(40, 'P009', 'Casual Pants', 'Pant', 'It is featured with tailored fit,  with pleats or a flat front, creased legs.', '../Products/Pant/P009.jpg', 1250.00, 890.00, 788, 'Yes', 4.50),
(41, 'P010', 'Casual Pants', 'Pant', 'It is  made from a sturdier cotton twill.Its  Straight leg, neutral colors like beige and khaki make it more stylish and comfortable.', '../Products/Pant/P010.jpg', 1280.00, 890.00, 67, 'Yes', 4.50),
(42, 'P011', 'Casual Pants', 'Pant', 'Loose fit, made from flowing fabrics.', '../Products/Pant/P011.jpg', 1450.00, 1270.00, 66, 'Yes', 4.50),
(43, 'P012', 'Semi Slim Fit Washed Jeans With Five Pockets', 'Pant', 'Semi Slim Fit washed jeans with five pockets. Comes with Front zip and metal button closure. These garments were produced using technologies that reduce water consumption in the dyeing process. Depending on your computer or mobile screen resolution, product color may vary slightly.', '../Products/Pant/P012.jpg', 1580.00, 1350.00, 456, 'Yes', 4.50),
(44, 'P013', 'Semi Slim Fit Washed Jeans With Five Pockets', 'Pant', ' Durable workwear pants with extra pockets and loops.\nFeatures: Loose fit, hammer loop, reinforced stitching.', '../Products/Pant/P013.jpg', 1500.00, 1300.00, 4566, 'Yes', 4.50),
(45, 'P014', 'Semi Slim Fit Washed Jeans With Five Pockets', 'Pant', ' This pant is  made from corduroy fabric, which has a distinctive ribbed texture.\nFeatures: Durable, available in various fits, warm fabric.', '../Products/Pant/P014.jpg', 670.00, 450.00, 4567, 'Yes', 4.50),
(46, 'P015', '', 'Pant', 'Sporty pants designed for athletic activities and casual wear.Its features are elastic waistband, tapered leg, often with side stripes.', '../Products/Pant/P015.jpg', 900.00, 480.00, 8990, 'Yes', 4.50),
(47, 'P016', '', 'Pant', 'Pants that narrow down from the hip to the ankle.It is a causal and semi-formal setting.Available in every size.', '../Products/Pant/P016.jpg', 900.00, 780.00, 78, 'Yes', 4.50);
INSERT INTO `product_info` (`Product_id`, `Product_code`, `Product_name`, `Product_category`, `Product_Description`, `Product_image_path`, `Old_price`, `New_price`, `Stock_quantity`, `Stock_status`, `Rating`) VALUES
(48, 'P017', '', 'Pant', '  This Pant is designed with extra room in the thighs and a tapered leg.\nFeatures: Comfortable fit for muscular builds, often with stretch fabric.\nIt can be worn as Casual wear, light athletic activities.', '../Products/Pant/P017.jpg', 980.00, 900.00, 88, 'Yes', 4.50),
(49, 'P018', '', 'Pant', ' It is a one-piece pants with a bib front and straps over the shoulders.Features: Durable fabric, multiple pockets, adjustable straps.', '../Products/Pant/P018.jpg', 950.00, 900.00, 89, 'Yes', 4.50),
(50, 'P019', '', 'Pant', ' Pants are fitted through the thigh and flare out slightly at the bottom.\nFeatures: Flared leg opening, designed to be worn with boots.\nOccasions: Casual and semi-formal settings, Western-inspired fashion.', '../Products/Pant/P019.jpg', 4500.00, 3200.00, 78, 'Yes', 4.50),
(83, 'Pe001', 'Jimmy Choo Man Blue EDT (100mL)', 'Perfume', '100mL Bottle\nCollected from Authentic USA Store\nGenuine – Brand New – Intact\nHome Delivery available within Dhaka City. Courier Delivery to other Disctricts in Bangladesh', '../Products/Perfume/Pe001.jpg', 900.00, 790.00, 100, 'Yes', 4.60),
(84, 'Pe002', 'Haramain Noir French Collection 100ml', 'Perfume', 'Haramain Noir French Collection Spray 100ml is a luxurious and alluring perfume that will leave a lasting impression. Its one-of-a-kind blend of notes makes it ideal for those who want to stand out. The top notes of bergamot and lavender create a fresh and invigorating scent, while the heart notes of jasmine and violet add a touch of femininity. The base notes of amber and musk give this perfume a warm and sensual aroma. Haramain Noir is the best choice for those who want a fragrance that will stay with them all day thanks to its long-lasting formula.\n\n', '../Products/Perfume/Pe002.jpg', 1200.00, 1050.00, 332, 'Yes', 4.70),
(85, 'Pe003', 'Haramain Azure French Collection 100ml', 'Perfume', 'The Haramain Azure French Collection Spray is a luxurious perfume with a long-lasting scent. It is perfect for those who appreciate a unique and captivating fragrance. The 100ml bottle ensures that you will have enough perfume to last you for a long time. The enchanting aroma of the Haramain Azure French Collection Spray will linger throughout the day, leaving a trail of elegance and sophistication. Indulge in the best perfume experience with this amazing fragrance that is sure to turn heads.', '../Products/Perfume/Pe003.jpg', 1500.00, 1200.00, 42, 'Yes', 4.80),
(86, 'Pe004', 'Haramain Blanche French Collection 100 ML', 'Perfume', 'The Haramain Blanche French Collection Spray is a luxurious perfume that comes in a 100ml bottle. This fragrance is a perfect blend of floral and woody notes, creating a captivating aroma that lingers throughout the day. The top notes of bergamot and lemon add a refreshing touch, while the heart notes of jasmine and rose provide a delicate and feminine scent. The base notes of sandalwood and musk give this perfume a warm and sensual finish. With its long-lasting fragrance and exquisite blend of ingredients, the Haramain Blanche French Collection Spray is truly the best perfume for those who appreciate a captivating scent.\n\n', '../Products/Perfume/Pe004.jpg', 1800.00, 1690.00, 432, 'Yes', 4.90),
(87, 'Pe005', 'Haramain Deo Vintage Classic 200ML', 'Perfume', 'Product Name :VINTAGE CLASSIC DEODORANT 200ML\n\nSKU:AHP1700\n\nTYPE:Deodorant Spray\n\nLiquid Volume: 200 ml\n\nItem Weight :555G\n\nItem Dimension(DxH): 5.3X 7.6 (CM)\n\nGender :Masculine', '../Products/Perfume/Pe005.jpg', 1300.00, 400.00, 43, 'Yes', 3.70),
(88, 'Pe006', 'Haramain Ruhani. Attar 15 ML', 'Perfume', 'Haramain Ruhani is a sugary and nutty gourmand perfume oil. The fragrance is a perfect blend of sweetness and nuttiness, creating a warm and inviting aroma that is perfect for any occasion. The nutty notes of almonds and hazelnuts are complemented by the sugary sweetness of caramel and vanilla, which creates a beautiful and unique aroma. Ruhani is long-lasting and stays on the skin for several hours, so you don\'t have to reapply it throughout the day.', '../Products/Perfume/Pe006.jpg', 2100.00, 1200.00, 43, 'Yes', 3.70),
(89, 'Pe007', 'Goddess Eau De Toilette 100ml', 'Perfume', 'Get ready to find your new favourite fragrance, introducing the newest Fragrances by Revolution Beauty! Lose yourself in luxurious scents, with instant glamour in a bottle.\n\nThe Goddess Eau De Toilette by Revolution Beauty features a fresh burst of floral fragrance with scent notes of Wild Berries, White Violet, Jasmine & Sandalwood.\n\nGift to others or treat yourself with this romantic and radiant fresh scent', '../Products/Perfume/Pe007.jpg', 2680.00, 2300.00, 43, 'Yes', 3.70),
(90, 'Pe008', 'Revolution Man Eau De Toilette 100ml (Resurrection)', 'Perfume', 'Introducing the new fragrance collection by Revolution Man.\n\n \n\nImmerse yourself in four new powerful scents. Timeless scents at an affordable price.​\n\nResurrection by Revolution Man is a powerful and sophisticated scent. This fragrance opens with notes of bergamot and pineapple, followed by a subtle floral touch of patchouli and Moroccan jasmine, following you to the end of your day.​', '../Products/Perfume/Pe008.jpg', 2590.00, 2300.00, 43, 'Yes', 3.70),
(91, 'Pe009', 'Enchanteur Perfumed Deo Roll-on Romantic', 'Perfume', 'Enchanteur Romantic Perfumed Deo Roll-On caresses your body with its long lasting sensual floral fragrance to give you confidence and freshness all day long.\n\n48-hr malodor protection\nAnti-perspirant\nKills 99.9% bacteria\nQuick-drying\nNo residue on clothes\nNon-sticky', '../Products/Perfume/Pe009.webp', 2300.00, 1250.00, 45, 'Yes', 3.70),
(92, 'Pe010', 'Al Rehab Choco Musk – Eau De Spray Perfume (50 ml)', 'Perfume', 'Buy Original Al Rehab Choco Musk for Men & Women Online at Lowest Price in Bangladesh.\n\nA very popular fragrance with gourmet tones is now also in the perfume water spray.\n\n \n\nThe perfume is full of luring tones, dominated by a delicious vanilla with a sinfully irritating chocolate praline.\n\n \n\nThe creamy chords come with a caress of sandalwood, surrounded by the tenderness of a soft musk with a few glimpses of pink petals.\n\nIn the gourmet game, we sink deeper and deeper with the help of a honey-sensual, velvety ambergris complemented by tones of oriental spices that show off the aromatic myrrh with warm-spilling cinnamon', '../Products/Perfume/Pe010.webp', 5400.00, 4300.00, 54, 'Yes', 3.70),
(93, 'Pe011', 'Amami Alfredo EDT 100ml by Gianluca Bulega Couture', 'Perfume', 'Amami Alfredo by Gianluca Bulega Couture is a Amber Floral fragrance for women. Amami Alfredo was launched in 2008.\n\nTop notes are Bay Leaf, Dyer’s Greenweed, Amalfi Lemon, Neroli and Bergamot; middle notes are Rose, Ylang-Ylang, Orchid, Jasmine and African Orange flower; base notes are Patchouli, Amber, Sandalwood and Vanille.', '../Products/Perfume/Pe011.webp', 3400.00, 2305.00, 54, 'Yes', 3.70),
(94, 'Pe012', 'Blu for Men Perfume – 10 ML (0.3 oz) By Ajmal Miniature/Splash', 'Perfume', 'Blu for Men Perfume – 10 ML (0.3 oz) By Ajmal Miniature/Splash', '../Products/Perfume/Pe012.webp', 4300.00, 3490.00, 544, 'Yes', 3.60),
(95, 'Pe013', 'French Coffee EDP by Al-Rehab : It’s so yummy!', 'Perfume', 'Buy Original French Coffee EDP by Al-Rehab for Men and Women Online at the Lowest Price in Bangladesh. French Coffee EDP by Al-Rehab is a fragrance for women and men. French Coffee, hiding its seductively gourmet content in a metallic brown bottle, as the name suggests, will seduce and enchant you with coffee. Magical French Coffee does not present us black and bitter coffee, but gourmet coffee—such a “delicious” cappuccino, with a large layer of milk foam, decorated with cocoa and a pinch of cinnamon. On a plate with added almonds in dark chocolate for that sinful feeling and delicious enjoyment. Notes: cocoa, sugar, caramel, coffee, milk & cream, cinnamon, vanilla', '../Products/Perfume/Pe013.webp', 4334.00, 3490.00, 544, 'Yes', 4.50),
(96, 'Pe014', 'Lattafa Najdia for Men EDP\n', 'Perfume', 'Lattafa Najdia is a refreshing, pure perfume with aqua and citrus notes. The top note opens fresh and dynamic with bergamot, lemongrass, lemon, apple and cinnamon. Orange blossoms in the heart note set flowery accents and are accompanied by aqua notes, cardamom, rosemary and lavender.\n\nThe base is warm yet slightly fresh with cedar, sandalwood, tobacco, amber and musk. An energetic, youthful fragrance with a pleasant freshness, suitable for any occasion.\n\nGreat cheapy clone of Rasasi Hawas and Invictus Aqua 2016 combined. This is one of the scents that are very friendly and at the same time distinctive. It is very strong, versatile, just perfect.\n\n', '../Products/Perfume/Pe014.webp', 444.00, 200.00, 567, 'Yes', 4.50),
(97, 'Pe015', 'Ard Al Zaafaran Pure Musk – Eau De Parfum – 50ml', 'Perfume', ' Sourced from a brand-authorized retailer.\n– Genuine, intact, brand-new product.\n– Online purchases in Bangladesh can be delivered to your home.\n– Pay with a debit card, credit card, or bkash, nagad.\n– Available for installment payments (EMI) and offering reward points with each purchase.\n– Free delivery with purchases Over 10,000 Tk.\n– Delivery in no more than five days.\n\nArd Al Zaafaran Pure Musk', '../Products/Perfume/Pe015.webp', 344.00, 200.00, 76, 'Yes', 4.56),
(98, 'Pe016', 'Ard Al Zaafaran Oud Mood – Eau De Parfum – 50ml Spray', 'Perfume', 'Sourced from a brand-authorized retailer.\n– Genuine, intact, brand-new product.\n– Online purchases in Bangladesh can be delivered to your home.\n– Pay with a debit card, credit card, or bkash, nagad.\n– Available for installment payments (EMI) and offering reward points with each purchase.\n– Free delivery with purchases Over 10,000 Tk.\n– Delivery in no more than five days.\n\nArd Al Zaafaran Oud Mood', '../Products/Perfume/Pe016.webp', 666.00, 450.00, 76, 'Yes', 3.65),
(99, 'Pe017', 'Armaf Club De Nuit Intense Man Body Spray 200ml', 'Perfume', 'Armaf Club De Nuit Intense Man Body Spray is the expression of luxury that is original and innovative collection of signature fragrances for men with quality, competitive pricing and unique packaging.\n\nA sophisticated woody-spicy masculine fragrance with touches of fruity accords of Grapefruit and Mandarin, unified with Mint, laced on a Peppery heart notes of Clove, Cinnamon, Pepper, and Ginger. The base consists of the prehistoric scent of Leather, Amber, and Woody notes.', '../Products/Perfume/Pe017.webp', 1600.00, 1500.00, 78, 'Yes', 3.50),
(1, 'S001', 'Half sleeve waffle polo shirt', 'Shirt', ' a stiff collar, button front, and long sleeves with buttoned or cufflink-style cuffs. Ideal for formal occasions and business settings.', '../Products/Shirt/S001.jpg', 1500.00, 1080.00, 520, 'Yes', 4.70),
(2, 'S002', 'Men\'s Stylish & Fashionable Trendy Good Looking  Formal T Shirt', 'Shirt', 'It has made from high-quality cotton or a cotton blend for comfort and breathability. It features with vertical pleats running down the shirt\'s front, adding a classic and textured look.Its available in various fits, including classic, slim, and modern, to suit different body types and preferences.', '../Products/Shirt/S002.jpg', 2500.00, 1350.00, 100, 'Yes', 4.80),
(3, 'S003', 'Premium Cotton Full Sleeve Casual Shirt For Men', 'Shirt', 'This product is predominantly white,broader spread between the collar points, suitable for various bow tie stylesAvailable in various fits, including classic, slim, and modern, to suit different body types and preferences..', '../Products/Shirt/S003.jpg', 2580.00, 1400.00, 52, 'Yes', 4.50),
(4, 'S004', 'Open collared short sleeve knit shirt', 'Shirt', '\nDesigned for black-tie events. An elegant shirt with a front bib woven in plissé, resulting in a timeless pleated front. Renowned for its subtle but striking appearance and for elevating the evening look to an unmatched standard. Equipped with french cuffs and black removable studs', '../Products/Shirt/S004.jpg', 650.00, 480.00, 45, 'Yes', 4.90),
(5, 'S005', 'Open collared short sleeve knit shirt', 'Shirt', 'The available product is a unique combination of casual comfort and refined style makes it suitable for various occasions.It is made from Oxford cloth, a type of cotton fabric known for its basketweave texture, durability, and comfort.The defining feature of this shirt is its button-down collar, which has small buttons securing the collar points to the shirt.It is available in a wide range of solid colors, including classic white, blue, and pink.', '../Products/Shirt/S005.jpg', 4560.00, 3000.00, 312, 'Yes', 4.30),
(6, 'S006', 'Cotton, Smart Casual printed shirt for men.\n\n', 'Shirt', 'It is a versatile and stylish garment that combines the rugged appeal of denim with the lightweight comfort ,made from chambray fabric, which is a plain-weave fabric made with a colored warp and a white weft.It has  a full-length button placket.Colour in every shade is available.', '../Products/Shirt/S006.jpg', 645.00, 445.00, 5132, 'Yes', 3.60),
(7, 'S007', 'Cotton, Smart Casual shirt for men.', 'Shirt', 'Check out our entire stock of flannel shirt which fabric is  soft, medium-weight cotton fabric that has a napped, fuzzy, finish on one or both sides.Both short and full length sleeve is available in our stock.Black,green.gray colour is available in this design.', '../Products/Shirt/S007.jpg', 9875.00, 4545.00, 12, 'Yes', 3.70),
(8, 'S008', 'Cotton, Open collared short sleeve shirt for men.', 'Shirt', ' Flannel shirt is a timeless, versatile piece of clothing known for its comfort, warmth, and classic style.soft, medium-weight fabric, available fabrics are  cotton, wool, or a cotton blend. ', '../Products/Shirt/S008.jpg', 780.00, 380.00, 12, 'Yes', 4.90),
(9, 'S009', 'Cotton, Open collared short sleeve shirt for men.', 'Shirt', 'Its fabric is wool flannel,which  offers extra warmth, making it ideal for colder climates.In this product every size is available.', '../Products/Shirt/S009.jpg', 784.00, 450.00, 165, 'Yes', 4.10),
(10, 'S010', ' Fit. Cotton, Single pocket formal shirt for men.', 'Shirt', 'Its fabric is  cotton.In this product every size is available.', '../Products/Shirt/S010.jpg', 1000.00, 850.00, 5461, 'Yes', 4.50),
(11, 'S011', 'New full Sleeve Magnet Shirt', 'Shirt', '\nThis shirt is a casual, long-sleeve, button-down  designed for a stylish and relaxed look.It has made from a lightweight and breathable linen fabric   for warm weather.It also features a band collar (also known as a mandarin collar), giving it a modern and minimalist appearance.The shirt has a full-length button-down placket with white buttons that contrast nicely against the black fabric.', '../Products/Shirt/S011.jpg', 730.00, 500.00, 26, 'Yes', 4.90),
(12, 'S012', 'New Stylish & Smart Looking Trendy Cotton Oxford Long Sleeve Casual Shirt For Men By TopFinity', 'Shirt', 'Men\'s Linen Cotton Henley Shirt.It is a  Long Sleeve Basic Summer Shirt and  Band Collar.Its size is S-XXL', '../Products/Shirt/S012.jpg', 1250.00, 850.00, 251, 'Yes', 3.80),
(13, 'S013', 'Denim Casual shirt for men - Shirt', 'Shirt', 'It is a lightweight long sleeve button down Linen Shirt for men size for XL.The sleeves are buttoned at the cuffs, allowing for an adjustable fit and the option to roll up the sleeves for a more relaxed look.', '../Products/Shirt/S013.jpg', 2500.00, 2300.00, 212, 'Yes', 3.50),
(14, 'S014', 'New Stylish & Smart Looking Trendy Cotton Oxford Long Sleeve Casual Shirt For Men By TopFinity', 'Shirt', 'Features a ribbed or flat knit collar, which can be worn up or down.It is short sleeved,ribbed cuffs,co;our and size for all shapes is available.', '../Products/Shirt/S014.jpg', 2800.00, 2300.00, 256, 'Yes', 2.80),
(15, 'S015', 'New full Sleeve Magnet Shirt', 'Shirt', 'All shades   from solid colors like navy, black, and white to vibrant hues and patterns is available.A short button placket at the neck, typically with two to three buttons, allowing for adjustable ventilation.', '../Products/Shirt/S015.jpg', 4800.00, 3800.00, 56, 'Yes', 2.70),
(16, 'S016', 'New Stylish & Smart Looking Trendy Cotton Oxford Long Sleeve Casual Shirt For Men By TopFinity', 'Shirt', 'All shades   from solid colors like navy, black, and white to vibrant hues and patterns is available.A short button placket at the neck at the bottom available.', '../Products/Shirt/S016.jpg', 500.00, 400.00, 56, 'Yes', 2.39),
(17, 'S017', 'Men\'s Stylish & Fashionable Trendy Good Looking Long Sleeve Formal Shirt', 'Shirt', 'Long sleeves that extend to the wrists, offering added coverage and warmth.\nSleeves often end with ribbed cuffs, adding a touch of structure and style while ensuring a snug fit. Available in a wide range of colors, from solid hues like navy, black, and white to vibrant tones and patterns also sizes.', '../Products/Shirt/S017..jpg', 3100.00, 1565.00, 586, 'Yes', 4.50),
(18, 'S018', 'Men\'s Stylish & Fashionable Trendy Good Looking Long Sleeve Formal Shirt', 'Shirt', 'It is available in a wide range of colors and patterns. Popular options include solid colors, stripes, and graphic prints.The fabric of this T-Shirt is cotton mostly.The defining feature is the round, circular neckline that sits snugly around the base of the neck.Available in various fits, including slim fit, regular fit, and relaxed fit, catering to different body types and style preferences.', '../Products/Shirt/S018.jpg', 1250.00, 1000.00, 55, 'Yes', 4.50),
(19, 'S019', 'Premium Quality Long Sleeve Design Shirt For men\'s', 'Shirt', 'Long sleeve variations are available.Hemmed sleeves that add a clean finish', '../Products/Shirt/S019.jpg', 1120.00, 870.00, 56, 'Yes', 4.50),
(20, 'S020', 'Export Quality New Stylish Long Sleeve Casual Shirts For Men By SHAZMI FASHION', 'Shirt', ' V-neck T-shirt is a stylish and versatile wardrobe staple known for its distinctive neckline.Its material is cotton mostly. Available in a wide range of colors and patterns. Popular options include solid colors, stripes, and graphic prints.', '../Products/Shirt/S020.jpg', 4645.00, 3500.00, 89, 'Yes', 4.80),
(21, 'S021', 'Export Quality New Stylish Long Sleeve Casual Shirts For Men By SHAZMI FASHION', 'Shirt', 'The product is made from 100% cotton. Available in a vast range of base colors, from classic black and white to vibrant hues and pastels.Artistic illustrations, abstract designs, patterns, or photographic images are available as a graphic.', '../Products/Shirt/S021.jpg', 2326.00, 2200.00, 89, 'Yes', 4.50),
(22, 'S022', 'Comfort Meets Style: China Stretch Shirts for the Modern Wardrobe', 'Shirt', 'The product comes with a crew neck with 100 % soft cotton materials.Its High-quality materials and construction ensure longevity, even with regular wear and washing.', '../Products/Shirt/S022.jpg', 1200.00, 750.00, 58, 'Yes', 4.50),
(23, 'S023', 'Cotton Full Sleeve Casual Shirt for Men', 'Shirt', 'Its texture is  soft yet sturdy, designed to withstand outdoor activities and frequent wear.Materials are flannel and linen is available here and size are X,XXL are available.Its embroidery Intricate embroidered designs, often depicting western themes like horses, cacti, and other southwestern motifs makes it looked so classy.', '../Products/Shirt/S023.jpg', 2125.00, 1500.00, 255, 'Yes', 4.50),
(24, 'S024', 'Premium Cotton Full Sleeve Casual Shirt For Men', 'Shirt', ' Typically features a pointed collar,Available in both long sleeves and short sleeves.', '../Products/Shirt/S024.jpg', 1200.00, 1011.00, 478, 'Yes', 4.50),
(25, 'S025', 'Premium Cotton Full Sleeve Casual Shirt For Men', 'Shirt', ' Soft yet sturdy, designed to withstand outdoor activities and frequent wear.It is aqvailable in a range of colors, often featuring earthy tones like browns, blues, and greens, as well as classic black and white.', '../Products/Shirt/S025.jpg', 800.00, 500.00, 487, 'Yes', 4.74),
(26, 'S026', 'Printed Round Neck Olive T-Shirt by Richman', 'Shirt', ' Available in both long sleeves and short sleeves,Its combines cotton with synthetic fibers for enhanced durability and ease of care makes this product mire comfortable.', '../Products/Shirt/S026.jpg', 4411.00, 3500.00, 88, 'Yes', 4.50),
(27, 'S027', 'Premium Quality Long Sleeve Design Shirt For men\'s', 'Shirt', 'Its wool fabric  Known for its excellent insulation and softness, perfect for colder climates.Its horizontal or vertical stripes add a playful or sophisticated touch.Common styles include crew neck, V-neck, turtleneck, and mock neck.\n Available in various fits, including slim fit, regular fit, and oversized for a more relaxed look.Ribbed cuffs provide a snug fit and help retain warmth.', '../Products/Shirt/S027.jpg', 4500.00, 2500.00, 899, 'Yes', 3.00),
(28, 'S028', 'Premium Quality Long Sleeve Design Shirt For men\'s', 'Shirt', 'Its  traditional, intricate patterns often seen in holiday and winter sweaters.Available in various fits, including slim fit, regular fit, and oversized for a more relaxed look.', '../Products/Shirt/S028.jpg', 4511.00, 3500.00, 5845, 'Yes', 3.00),
(29, 'S029', 'GoodMan Premium Quality Ash Color Full Sleeve Sweater for Men', 'Shirt', 'Its  traditional, intricate patterns often seen in holiday and winter sweaters.Available in various fits, including slim fit, regular fit, and oversized for a more relaxed look.Its  ribbed cuffs provide a snug fit and help retain warmth.', '../Products/Shirt/S029.jpg', 800.00, 600.00, 56, 'Yes', 2.58),
(30, 'S030', 'GoodMan Premium Quality Maroon Color High Neck Full Sleeve Zipper Sweater for Men.', 'Shirt', 'The product is  durable and moisture-wicking, great for active wear.Featuring logos, text, or artistic designs for a trendy look.', '../Products/Shirt/S030.jpg', 400.00, 300.00, 5, 'Yes', 4.90),
(31, 'S031', 'Men\'s Fashionable Hign Neck Zipper Jumper.', 'Shirt', 'This product is made from poplin, a tightly woven, plain-weave fabric.It is available in various sizes to accommodate different body types. It’s also available in both long and short sleeve options to suit different preferences and seasons.\n', '../Products/Shirt/S031.jpg', 6544.00, 4500.00, 55, 'Yes', 4.50),
(100, 'Sa001', 'New Design Half Silk Blockprint Saree for Women', 'Saree', 'Its  brocades made of gold and silver threads. Banarasi saree features  motifs of  flowers  inspired designs.', '../Products/Saree/Sa001.webp', 4600.00, 4500.00, 78, 'Yes', 3.50),
(101, 'Sa002', 'Colorful Fabric Patterned Background. Colorful Indian Saree Fabric Floral Patterned Background', 'Saree', 'Its  brocades made of gold and silver threads. Banarasi saree features  motifs of  flowers  inspired designs.', '../Products/Saree/Sa002.webp', 600.00, 500.00, 78, 'Yes', 3.00),
(102, 'Sa003', 'Hand Embroidered Half Silk Saree', 'Saree', 'Its  brocades made of gold and silver threa.Ready to put on occations like wedding festivles.', '../Products/Saree/Sa003.webp', 1600.00, 1200.00, 78, 'Yes', 3.00),
(103, 'Sa004', 'Hand Embroidered Half Silk Saree', 'Saree', 'Its  brocades made of gold and silver threads. Ready to put on occations like wedding festivles.', '../Products/Saree/Sa004.webp', 1600.00, 1200.00, 78, 'Yes', 3.00),
(104, 'Sa005', 'Hand Embroidered Half Silk Saree', 'Saree', 'Known for their rich, intricate brocades made of gold and silver threads. ', '../Products/Saree/Sa005.webp', 1600.00, 1200.00, 78, 'Yes', 3.00),
(105, 'Sa006', 'Red And Orange Color Saree', 'Saree', 'Known for their rich, intricate brocades made of gold and silver threads. ', '../Products/Saree/Sa006.webp', 1600.00, 1200.00, 78, 'Yes', 3.00),
(106, 'Sa007', 'Screen Printed Half Silk Saree', 'Saree', 'SCREEN PRINTED Grameen check HALF SILK SAREE', '../Products/Saree/Sa007.webp', 1600.00, 1500.00, 78, 'Yes', 3.00),
(107, 'Sa008', 'Block Printed Half Silk Saree', 'Saree', 'Block Printed Half Silk Saree', '../Products/Saree/Sa008.webp', 5600.00, 4500.00, 78, 'Yes', 3.00),
(108, 'Sa009', 'Block Printed Half Silk Saree', 'Saree', 'This saree can be put on weddings, religious ceremonies, and formal events.made from pure mulberry silk.', '../Products/Saree/Sa009.webp', 5600.00, 4500.00, 50, 'Yes', 3.00),
(109, 'Sa010', 'Block Printed Half Silk Saree', 'Saree', ' Lightweight and sheer, chiffon sarees drape beautifully and are embellished with sequins, embroidery. They are easy to manage and have a modern, elegant appeal.', '../Products/Saree/Sa010.webp', 5600.00, 4500.00, 50, 'Yes', 3.00),
(110, 'Sa011', 'Block Printed Half Silk Red Saree', 'Saree', 'This saree can be put on parties, casual gatherings, and formal events.The product is embellished with embriodery.', '../Products/Saree/Sa011.webp', 5600.00, 2700.00, 50, 'Yes', 3.00),
(111, 'Sa012', 'Screen Printed Half Silk Saree', 'Saree', 'This saree has a elegent appeal with a beautiful colour.Can be put on festivles or causual.', '../Products/Saree/Sa012.webp', 1080.00, 850.00, 50, 'Yes', 3.00),
(112, 'Sa013', 'Embroidered Muslin Saree', 'Saree', 'Made from muslin fabric, these sarees are flowy, lightweight, and comfortable.Available in every pastel shades.', '../Products/Saree/Sa013.webp', 1080.00, 850.00, 50, 'Yes', 3.00),
(113, 'Sa014', 'Eid Exclusive Half Silk Saree', 'Saree', 'This  features  bold prints, embroidery, or sequins.Lightweight,flowy,and comfortable thers saree can be put on every occasions. ', '../Products/Saree/Sa014.webp', 1080.00, 850.00, 50, 'Yes', 3.00),
(114, 'Sa015', 'Embroidered Half Silk Saree', 'Saree', 'This  features  bold prints, embroidery, or sequins.Lightweight,flowy,and comfortable thers saree can be put on every occasions. ', '../Products/Saree/Sa015.webp', 1080.00, 850.00, 50, 'Yes', 3.00),
(115, 'Sa016', 'Embroidered Half Silk Saree', 'Saree', 'Its occasions are  casual wear, parties, and office wear.Made from georgette fabric.', '../Products/Saree/Sa016.jpeg', 1080.00, 850.00, 50, 'Yes', 3.00),
(116, 'Sa017', 'Screen Printed With Embroidered Half Silk Saree', 'Saree', 'A blend of silk and cotton, Chanderi sarees are known for their glossy transparency and rich texture. They often feature motifs inspired by nature, such as flowers, birds, and geometric patterns.', '../Products/Saree/Sa017.webp', 1080.00, 850.00, 50, 'Yes', 3.00),
(117, 'Sa018', 'Screen Printed Hand Embroidered Half Silk Saree', 'Saree', 'Screen Printed Hand Embroidered Half Silk Saree', '../Products/Saree/Sa018.webp', 1080.00, 850.00, 50, 'Yes', 3.00),
(118, 'Sa019', 'Screen Printed Hand Embroidered Half Silk Saree', 'Saree', 'This saree is made from pure silk and are known for their smooth texture and rich luster. Its feature simple yet elegant designs with gold borders and pallu.', '../Products/Saree/Sa019.webp', 1080.00, 850.00, 50, 'Yes', 3.00),
(119, 'Sa020', 'Hand Embroidered Silk Saree', 'Saree', 'This saree is made from pure silk and are known for their smooth texture and rich luster. Its feature simple yet elegant designs with gold borders and pallu.', '../Products/Saree/Sa020.webp', 1080.00, 850.00, 50, 'Yes', 3.00),
(120, 'Sa021', 'Hand Embroidered Block Printed Half Silk Saree', 'Saree', 'These sarees are created using the tie-dye technique, resulting in colorful patterns and designs. They are vibrant and often adorned with mirror work or embroidery.', '../Products/Saree/Sa021.webp', 1080.00, 850.00, 50, 'Yes', 3.00),
(121, 'Sa022', 'Screen Printed Tie Dye Half Silk Saree', 'Saree', 'Known for their unique tie-dye patterns, Sambalpuri sarees are handwoven with motifs inspired by nature and tribal art.', '../Products/Saree/Sa022.webp', 1080.00, 850.00, 50, 'Yes', 3.00),
(122, 'Sa023', 'Black & Ash Block Half Silk Saree', 'Saree', 'Known for their unique tie-dye patterns, Sambalpuri sarees are handwoven with motifs inspired by nature and tribal art.', '../Products/Saree/Sa023.webp', 2590.00, 2350.00, 50, 'Yes', 3.00),
(123, 'Sa024', 'Hand Embroidered Half Silk Saree', 'Saree', 'Made from pure silk. They are similar to Kanjeevaram sarees but are generally lighter and more delicate.', '../Products/Saree/Sa024.webp', 2590.00, 2350.00, 50, 'Yes', 3.00),
(124, 'Sa025', 'Screen Printed Half Silk Saree', 'Saree', 'Tussar silk sarees have a natural, earthy texture and are known for their lightweight and breathable fabric. They often feature simple, elegant designs with tribal or floral motifs', '../Products/Saree/Sa025.webp', 2590.00, 2350.00, 50, 'Yes', 3.00),
(125, 'Sa026', 'Hand Embroidered Half Silk Saree', 'Saree', 'Made from net fabric, these sarees are sheer and often embellished with embroidery, sequins, and stones. They are stylish and trendy, popular among younger women.', '../Products/Saree/Sa026.webp', 2590.00, 2350.00, 50, 'Yes', 3.00),
(146, 'SC001', 'Bio Care Retinol+C Serum', 'Skincare product', 'Our Glycolic Acid Aloe Vera Retinol+C Serum is a magic potion for anti-aging! The power duo of Retinol and Vitamin C confidently leaves your skin irresistibly soft and rejuvenated while reducing the visible signs of aging, wrinkles, and melanin. Enhance your skincare routine with this potent solution for confidently youthful, radiant skin.', '../Products/Skin Care/SC001.webp', 560.00, 350.00, 45, 'Yes', 3.00),
(147, 'SC002', 'Simple Kind to Skin Refreshing Facial Wash Gel (150ml)', 'Skincare product', 'Your skin will feel smooth and fresh all day long with Simple Kind to Skin Refreshing Facial Gel cleanser, a mild face cleanser that efficiently gets rid of deep grime and pollutants. Its Pro Amino Acid technology boosts the skin\'s natural amount of amino acids, giving it a more youthful, healthy appearance. It is further enhanced with vitamins B5 and E. It removes debris and makeup residue while repairing the skin barrier without drying out the skin. This face cleanser is also approved as being gentle on sensitive skin because it is 100% soap-free and has undergone dermatological testing. Additionally, this product is non-alcoholic, fragrance-free, and non-comedogenic.\n\nIt has a large 150ml size for a face wash. This facewash is worth the money because of its effectiveness and pricing. Its affordable price makes it an excellent choice for students to purchase. As only a small amount is required each time, it lasts a very long period. ', '../Products/Skin Care/SC002.jpg', 5660.00, 3800.00, 10, 'Yes', 3.00),
(148, 'SC003', 'Simple Kind To Skin Purifying Cleansing Lotion (200ml)', 'Skincare product', 'Love the feeling of smooth, softened skin? The Simple Kind to Skin Purifying Cleansing Lotion is ideal for gently cleansing drier skin; with its creamy no-rinse formula, this cleansing lotion makes the first step in your skincare routine quick and easy.Our Purifying Cleansing Lotion is also ideal for taking with you on-the-go as there\'s no need to rinse it away, which is why you\'ll find it in both our bathroom cabinet and travel beauty bag', '../Products/Skin Care/SC003.jpg', 5660.00, 3800.00, 10, 'Yes', 3.00),
(149, 'SC004', 'Simple Kind to Skin Hydrating Cleansing Oil (125ml)', 'Skincare product', 'Simple Hydrating Cleansing Oil is a gentle, soothing and effective way to remove make-up and to deeply cleanse without irritating the skin.\n\nThe best cleansing oils for dry skin are deeply hydrating while leaving no greasy finish. Made with 100% natural grapeseed oil, this cleansing oil is light in texture and easy to rinse off, enriched with skin-loving vitamins to leave skin cleansed, hydrated and soft.\n\nOur Hydrating Cleansing Oil contains no artificial perfume or colour and no harsh chemicals that can upset your skin, making it perfect for even sensitive skin.This cleansing oil is hypoallergenic, dermatologically tested and approved.', '../Products/Skin Care/SC004.jpg', 5660.00, 3800.00, 10, 'Yes', 3.00),
(150, 'SC005', 'PanOxyl Acne Treatment Bar 10% Benzoyl Peroxide (113gm)', 'Skincare product', 'PanOxyl Acne Cleansing Bar will help you get rid of acne on your face, back, and chest. Dermatologists recommend this strong soap-free cleansing bar for clearing existing acne and preventing future breakouts by cleaning and unclogging pores. The bar contains 10% Benzoyl Peroxide at maximum potency to treat stubborn breakouts, but the pH-balanced formula leaves skin soft and clean. The bar is suited for acne-prone skin and provides an effective treatment for acne on the face and body when used as part of a daily routine. PanOxyl products contain high-quality, scientifically proven substances that help to eliminate breakouts without the need for a prescription. The washing bar will make your skin look its best, allowing you to be the clearest, most confident version of yourself.', '../Products/Skin Care/SC005.jpg', 1260.00, 800.00, 10, 'Yes', 3.00),
(151, 'SC006', 'Cerave Hydrating Cleanser Bar (128gm)', 'Skincare product', 'Bar soap is easy and convenient to use—and it can also be a source of hydration and other beneficial ingredients for the skin. You just need to know what to look for. With a formula that’s non-comedogenic, your cleanser bar won’t clog your pores—and with one, that contains ceramides and hyaluronic acid, like CeraVe Hydrating Cleanser Bar, it can also hydrate and restore the skin’s barrier. Suitable for normal to dry skin, the CeraVe Hydrating Cleanser Bar was developed with dermatologists to effectively remove dirt, oil, and makeup without disrupting the natural skin barrier. In addition to three essential ceramides and hyaluronic acid, this soap-free cleanser bar also features 5% CeraVe Moisturizing Cream and patented MVE Delivery Technology to release a steady stream of hydration for 24 hours', '../Products/Skin Care/SC006.jpg', 1260.00, 500.00, 10, 'Yes', 3.00),
(152, 'SC007', 'Some By Mi Miracle Toner + Miracle Serum + Miracle Cream + Miracle', 'Skincare product', 'Works as exfoliator to leave skin cleaner and more radiant than before!\n\nContain of Tea Tree 10,000ppm, AHA/BHA/PHA/Niacinamide 2%, 20 kinds nature plants extract.\n\nPore care, brightening, moisturizing!\n\nAHA: Removes impurities and dry flakes from skin surface.\nBHA: Exfoliates pores, removing clogged impurities and sebum.\nPHA: Stops losing moisture from skin, dissolving dead skin cell.\n\nWorks as effective exfoliator to leave skin cleaner and more radiant than before! Perfect exfoliator toner to use everyday!\n\nThis set consists of:\n\nAHA.BHA.PHA 30 Days Miracle Cleansing Bar 106g\nAHA.BHA.PHA 30 Days Miracle Toner 150ml\nAHA.BHA.PHA 30 Days Miracle Cream 50g\nAHA.BHA.PHA 30 Days Miracle Serum 50ml\nHow to Use\n\nAHA.BHA.PHA 30 Days Miracle Cleansing Bar 106g:\n\nRoll massage your cheeks.Massage your nose up and down.Roll massage your forehead below the hairline.Carefully massage near your eyes and mouth.\n\nAHA.BHA.PHA 30 Days Miracle Toner 150ml:\n\nAfter cleansing in the morning and evening, take an appropriate amount on a cotton swab, wipe it off along with the texture of the skin, and let it absorb lightly.\n\nAHA.BHA.PHA 30 Days Miracle Cream 50g:\n\nApply a bean-size amount on skin. Spread until the application melts and penetrates into skin, and then wrap the face with both palms to promote absorption into skin.\n\nMiracle Serum 50ml:\n\nApply at the serum or essence routine, take 3-4 drops and gently massage to spread over face.\n\nKey Ingredients\n\nAHA.BHA.PHA 30 Days Miracle Cleansing Bar 106g:\n\nLauric acid, sodium stearate, soapy palm oil, sodium laureth, sodium myristate, stearic acid, glycerin, sorbitol, lauramisopropyl betaine, chlorella powder, wheat sprout powder, tea tree extract, Houttuynia extract, licorice extract, edelweiss extract, olive oil, Argan oil, green tea seeds oil, baobab tree extract, willow tree extract, Asiatic pennywort, apple extract, lemon extract, orange extract, birch bark extract, hydrolyzed potato protein, hydrolyzed wheat protein, hydrolyzed rice protein, hydrolyzed oatprotein, lactobionic acid, teatree leaves oil, tetrasodium EDTA\n\nAHA.BHA.PHA 30 Days Miracle Toner 150ml:\n\nWater, Butylene Glycol,Dipropylene Glycol, Glycerin, Niacinamide, Melaleuca Alternifolia Tea Tree) Leaf Extract, Polyglyceryl-4 caprate Carica Papaya (Papaya) Fruit Extract Lens Esculenta (Lenti) Seed Extract, Hamamelis Virginiana Witch Hazel), Extract Nelumbo Nucifera Flower Extract, swiftlet Nest Extract, sodium Hyaluronate Fructan, Allantoin Adenosine, Hydroyethyl Urea, Xylitol Salicylic Acid, Lactobionic Acid, Citric Acid , Sodium Citrate, 1.2-Hexanediol, Benzyl Glycol, Ethylheeylglycerin,Raspberry Ketone, Mentha Piperita (Peppermint) Oil, No 20 Hazardous ingredients Tested \n\nMiracle Cream 50g:\n\nThis miracle cream contain 10,000ppm Tea tree extract and 70% centella leaf extract for main ingredients.\n\nMiracle Serum 50ml:\n\ncaprylic capric triglyceride, cetyl ethyl hexanoate, Centella asiatica extract (14.51%), purified water, olive oil, glycerin, propanediol butyleneglycol, ethanol, 1,2-hexanediol (7500ppb), sodium laurate (7500ppb), sodium laurate (10,000ppm), niacinamide, green tea extract, golden extract, horsetail root extract, Spanish licorice root extract, PCA (7500ppb)\n\n\n', '../Products/Skin Care/SC007.jpeg', 5660.00, 500.00, 10, 'Yes', 3.50),
(153, 'SC008', 'Neogen Real Cica Pad (150ml)', 'Skincare product', 'Neogen Real Cica Pad \n\nSkin Barrier Recovery + Calming Hydration + Skin Protecting + Dead Skin Peeling.\n\nA skin-calming recovery cica pad soothes the irritated and sensitized skin while reinforcing the skin barrier. Cica repair essence & PHA moisture peeling ingredient supplies skin-calming hydration while removing dead skin cells and excess sebum.\n\nNO skin irritating, harmful ingredients\n\nNO Artifical Fragrances,Pigments, and Preservatives\n\nWITHOUT Unnecessary Ingredients, WITH Only Real Beneficial Ingredients\n\nHuman Skin Irritation Completed/Approved\n\nSkin Barrier Repair Solution for Irritated and Inflamed Skin\n\nSkin repairing Madecassoside, Madecassic acid, Asiaticoside, Asiatic acid derived from the Centella asiatica plant delivers healthy recovery to the skin in a daily cica calming pad.\n\nConcentrated SOS  Solution that reinforces the skin’s natural strength\n\nAllantoin, Panthenol, Ceramide, NMF, Hyaluronic Acid ingredients deliver deep moisture to form a seamless moisture barrier that helps maintain moisture.\n\n \n\n Ingredients\nMadeca Cream Ingredient\n\nis known to generate new skin! Formulated to deliver a completely transformed skin with just one pad.\n\n \n\nBenefits\nHydrating\n\nCalming\n\nPeeling', '../Products/Skin Care/SC008.jpg', 5660.00, 3800.00, 10, 'Yes', 3.50),
(154, 'SC009', 'MA:NYO Bifida Biome Ampoule Pad-70 Pads (150ml)', 'Skincare product', ' \n\nMA:NYO Bifida Biome Ampoule Pad is a double-sided cotton pad, one side features an embossed texture for gentle exfoliation, while the other side is smooth for moisturizing. These toner pads contain hypoallergenic exfoliating ingredients like PHA and LHA, effectively removing dead skin cells. They also incorporate \'bifida ferment filtrate x micro biome\' to strengthen the skin barrier against external factors, along with 10 layers of hyaluronic acid for added hydration. The textured surface of these pads, with its unique pattern, ensures a delicate exfoliating experience while promoting a more balanced skin barrier.', '../Products/Skin Care/SC009.jpg', 5660.00, 3800.00, 10, 'Yes', 3.50),
(155, 'SC010', 'Manyo Herb Green Cleansing Oil (200ml)', 'Skincare product', '\nThe Herb Green Cleansing Oil is gentle yet powerful, cleaning the skin\'s surface without stripping it of essential moisture, leaving you feeling replenished, and refreshed. The herb extracts help to soothe and calm your skin while cleansing.\n\n \n\nIt transforms into a luscious milk that dissolves makeup and impurities while soothes the skin. It is suitable for oily, sensitive, and acne-prone skin.', '../Products/Skin Care/SC010.jpg', 5660.00, 3800.00, 10, 'Yes', 3.50),
(156, 'SC011', 'Cosrx Advanced Snail 96 Mucin Power Essence (100ml)', 'Skincare product', 'The South Korean skincare company COSRX offers a face essence called COSRX Advanced Snail 96 Mucin Power Essence. Snail mucin, which is known for its capacity to hydrate, heal, and shield the skin, makes up 96% of the composition in this essence. It also has additional healthy nutrients including allantoin, which calms and hydrates the skin, and niacinamide, which helps to brighten the skin and enhance its general tone and texture. This essence is intended to assist enhance the skin\'s overall texture and look while giving the skin great hydration and nourishment. Because it is packaged in a 100ml bottle—a bigger capacity than other essences—it is a more affordable choice for extended use. ', '../Products/Skin Care/SC011.jpg', 1660.00, 1580.00, 10, 'Yes', 3.50),
(157, 'SC012', 'Some By Mi Aha, Bha, Pha 30 Days Miracle Cream (60gm)', 'Skincare product', '\nThe Some By Mi 30-Day Miracle Cream, packed with tea trees, does miracles for your skin in just 30 days! All at once, it purifies, removes sebum and dead skin cells from pores, and stops more moisture loss.\nFor calming benefits, this miracle cream has water from tea tree leaves and components from Centella Asiatica. Tea tree leaf water helps to improve the skin barrier while AHA, BHA, and PHA ingredients gently exfoliate the skin. Madecassoside and Centella Asiatica provide further skin protection and well-being benefits.', '../Products/Skin Care/SC012.webp', 2100.00, 1580.00, 10, 'Yes', 3.50),
(158, 'SC013', 'Simple Hydrating Light Moisturizer (125ml)', 'Skincare product', '\nSimple Kind to Skin Hydrating Light Moisturizer is a unique formula-based moisturizer that is non-greasy and lightweight. It absorbs quickly in the skin and gives a matte look. It is a clinically tested product and dermatology recommended moisturizer which keeps skin hydrated and moisturized for 12 long hours. Moreover, it has no added color and is fragrance-free, perfect for sensitive skin. This product does not clog pores and helps on fading acne spots and pimples. \n\nSimple moisturizer prices in Bangladesh are extremely reasonable while giving the result of high-end moisturizers. ', '../Products/Skin Care/SC013.jpg', 2100.00, 1580.00, 10, 'Yes', 3.50),
(159, 'SC014', 'Streax Vitariche Gloss Hair Serum(100ml)', 'Skincare product', 'The goal of Streax Professional Vitariche Gloss Hair Serum is to turn your hair into a glossy, luscious masterpiece. This serum, which is enriched with rich nutrients and essential vitamins, is designed to give your hair an extra dose of hydration and gloss.\nThe serum\'s non-greasy composition allows it to easily coat every strand, controlling frizz and flyaways and giving a radiant shine that catches the light. With the Vitariche Gloss Hair Serum, your hair—whether straight, curly, or wavy—smoothes out the cuticles for a polished look. Your hair will stay bouncy and full of life without feeling heavy thanks to the lightweight texture.\nIt is an enormous 100ml hair serum that, given the price, goes a long way. You may anticipate both the long-term advantages of better hair health and an instant improvement in manageability and shine when you use this serum in your hair care regimen', '../Products/Skin Care/SC014.jpg', 2100.00, 1580.00, 10, 'Yes', 3.50),
(160, 'SC015', 'Ryo Damage Care & Nourishing Shampoo (480ml)', 'Skincare product', 'RYO Damage Care & Nourishing Shampoo (For Dry, Damaged & Chemically Treated Hair) 480ml\n\nClinically Proven To Improve Damaged Hair From The 1St Use!This Hydrating And Nourishing Shampoo Gently Cleanses & Fortifies Dry, Damaged & Chemically Treated Hair.Formulated With Proprietary Triple Collagen Technology™**, Ginseng, Caffeine, Pomegrante & Camellia Oil, This Mild Scalp CareShampoo Repairs Damaged Hair And Alleviates Hair Loss By Strengthening Scalp & Hair Roots For Healthier-Looking Hair', '../Products/Skin Care/SC015.webp', 2100.00, 1580.00, 10, 'Yes', 3.50),
(301, 'Sh001', 'All Match Leather Dexun Casual Shoe – Black', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Leather\nSole Material: Rubber\nColor: Black', '../Products/Shoe/Sh001.jpg', 3500.00, 3200.00, 50, 'Yes', 3.50),
(302, 'Sh002', 'All Match Leather Dexun Casual Shoe – Brown', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Leather\nSole Material: Rubber\nColor: Brown', '../Products/Shoe/Sh002.jpg', 4500.00, 3800.00, 51, 'Yes', 3.50),
(303, 'Sh003', 'All Match Low-cut Suede Leather Casual Shoe – Brown', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Leather\nSole Material: Rubber\nColor: Brown\n', '../Products/Shoe/Sh003.jpg', 991.00, 70.00, 52, 'Yes', 3.50),
(304, 'Sh004', 'All Season Premium Dexun Casual Shoe – Brown', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Artificial PU Leather\nSole Material: Rubber\nColor: Brown', '../Products/Shoe/Sh004.jpg', 980.00, 750.00, 48, 'Yes', 3.50),
(305, 'Sh005', 'All Season Retro Breathable Casual Shoe – Khaki', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Leather & Mesh\nSole Material: Rubber\nColor: Khaki', '../Products/Shoe/Sh005.jpg', 3000.00, 2850.00, 45, 'Yes', 3.50),
(306, 'Sh006', 'All Season Retro Leather Casual Shoe – Coffee', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Leather\nSole Material: Rubber\nColor: Coffee', '../Products/Shoe/Sh006.jpg', 4800.00, 3580.00, 44, 'Yes', 3.50),
(307, 'Sh007', 'All Season Retro Leather Casual Shoe – Khaki', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Leather\nSole Material: Rubber\nColor: Khaki', '../Products/Shoe/Sh007.jpg', 780.00, 550.00, 6, 'Yes', 3.50),
(308, 'Sh008', 'Autumn Trend Sports Hiking Casual Shoe – Gray', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Suede Leather\nSole Material: Rubber\nColor: Gray\n\n', '../Products/Shoe/Sh008.jpg', 1000.00, 850.00, 78, 'Yes', 3.50),
(309, 'Sh009', 'Autumn Trend Sports Hiking Casual Shoe – Sand', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Suede Leather\nSole Material: Rubber\nColor: Sand', '../Products/Shoe/Sh009.jpg', 1200.00, 1050.00, 45, 'Yes', 3.50),
(310, 'Sh010', 'Breathable High Quality Lazy Casual Shoe – Brown', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Leather & Mesh\nSole Material: Rubber\nColor: Brown\n\nOpens in a new window', '../Products/Shoe/Sh010.jpg', 1500.00, 1250.00, 100, 'Yes', 3.50),
(311, 'Sh011', 'Breathable High Quality Lazy Casual Shoe – Dark Khaki', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Leather & Mesh\nSole Material: Rubber\nColor: Dark Khaki', '../Products/Shoe/Sh011.jpg', 3500.00, 2580.00, 12, 'Yes', 3.50),
(312, 'Sh012', 'Breathable Light Weight Leather Casual Shoe – Brown', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material:  Genuine Leather\nSole Material: Rubber\nColor: Brown', '../Products/Shoe/Sh012.jpg', 1200.00, 950.00, 74, 'Yes', 3.50),
(313, 'Sh013', 'Genuine Leather Pedal Peas Casual Shoe – Sky Gray', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Leather\nSole Material: Rubber\nColor: Sky Gray', '../Products/Shoe/Sh013.jpg', 4800.00, 4500.00, 45, 'Yes', 3.50),
(314, 'Sh014', 'Wild Trend Korean Style Leather Casual Shoe – Khaki', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Leather\nSole Material: Rubber\nColor: Khaki', '../Products/Shoe/Sh014.jpg', 4900.00, 4500.00, 78, 'Yes', 3.50),
(315, 'Sh015', 'All Season Retro Leather Casual Shoe – Khaki', 'Shoe', 'Product Type: Casual Shoes\nStyle: Casual\nUpper Material: Genuine Leather\nSole Material: Rubber\nColor: Khaki\n\nOpens in a new window', '../Products/Shoe/Sh015.jpg', 850.00, 700.00, 89, 'Yes', 3.50),
(51, 'W001', 'Fossil Coachmen Chronograph White Dial Men\'s Watch', 'Watch', ' The dress watch is sleek and elegant, with a simple design.\nIts thin case, leather and metal strap, minimalistic dial makes it super comfy.', '../Products/Watch/W001.webp', 4500.00, 3200.00, 45, 'Yes', 4.50),
(52, 'W002', 'Fossil Coachman Chronograph Brown Dial Men\'s Watch', 'Watch', ' This Robust watch is designed for underwater activities.It is water-resistant (typically up to 200 meters or more), rotating bezel, luminescent hands and markers.', '../Products/Watch/W002.webp', 4500.00, 3200.00, 65, 'Yes', 4.50),
(53, 'W003', 'Emporio Armani Chronograph Two Tone Black Dial Men\'s Watch', 'Watch', 'Its mainly for underwater .Its occationally can be put on water sports, casual wear.', '../Products/Watch/W003.avif', 4500.00, 3200.00, 76, 'Yes', 4.50),
(54, 'W004', 'Emporio Armani Chronograph Grey Dial Men\'s Watch', '', ' This Robust watch is designed for underwater activities.It is water-resistant (typically up to 200 meters or more), rotating bezel, luminescent hands and markers.', '../Products/Watch/W004.file', 4500.00, 3200.00, 86, 'Yes', 4.50),
(55, 'W005', 'Emporio Armani Chronograph Black Dial Men\'s Watch', 'Watch', 'It is water -resistance suitable for water spots.Every shade of this stylish watch is available.', '../Products/Watch/W005.webp', 4500.00, 3200.00, 754, 'Yes', 4.50),
(56, 'W006', 'Fossil Grant Chronograph White Dial Men\'s Watch', '', 'It is a built-in stopwatch function watch.Ready to put on almost every fuctions like casual wear or everyday use.\n', '../Products/Watch/W006.webp', 4500.00, 3200.00, 7865, 'Yes', 4.50),
(57, 'W007', 'Fossil Grant Chronograph Black Dial Men\'s Watch', 'Watch', ' Its features are  multiple sub-dials, pushers to start/stop/reset the chronograph.Ready to put on almost every fuctions like casual wear or everyday use.\n', '../Products/Watch/W007.avif', 4500.00, 3200.00, 7656, 'Yes', 3.60),
(58, 'W008', 'Fossil Grant Analog Cream Dial Men’s Watch', '', 'It is a built-in stopwatch function watch.Ready to put on almost every fuctions like casual wear or everyday use.\n', '../Products/Watch/W008.webp', 6700.00, 4500.00, 65, 'Yes', 3.50);
INSERT INTO `product_info` (`Product_id`, `Product_code`, `Product_name`, `Product_category`, `Product_Description`, `Product_image_path`, `Old_price`, `New_price`, `Stock_quantity`, `Stock_status`, `Rating`) VALUES
(59, 'W009', 'Fossil Grant Sport Multifunction Blue Dial Men’s Watch', 'Watch', ' Its features are  multiple sub-dials, pushers to start/stop/reset the chronograph.Ready to put on almost every fuctions like casual wear or everyday use.\n', '../Products/Watch/W009.avif', 6000.00, 4500.00, 756, 'Yes', 5.00),
(60, 'W010', 'Fossil Minimalist Cream Dial Men\'s Men\'s Watch', 'Watch', ' This watch is  inspired by aviation, known for their legibility and functionality. Large dial, easy-to-read numerals with additional complications like GMT or chronograph.', '../Products/Watch/W010.avif', 8000.00, 7800.00, 7655, 'Yes', 5.00),
(61, 'W011', 'Fossil Townsman Multifunction White Dial Men\'s Watch ', 'Watch', 'It is a inspired  by avaition .Ready to put on casual and outdoor activities.', '../Products/Watch/W011.avif', 8900.00, 7500.00, 765, 'Yes', 3.80),
(62, 'W012', 'Fossil Grant Automatic Beige Dial Men\'s Watch', 'Watch', 'It is a  watch of simple design, durable materials, clear numerals  with a leather strap.', '../Products/Watch/W012.avif', 3400.00, 3000.00, 76, 'Yes', 4.60),
(63, 'W013', 'Fossil Grant Automatic Black Skeleton Dial Men\'s Watch', 'Watch', 'This watch is designed with fabric strap,designed for military use.', '../Products/Watch/W013.webp', 3700.00, 3500.00, 76, 'Yes', 4.70),
(64, 'W014', 'Fossil The Commuter Black Dial Men\'s Watch', 'Watch', 'This watch is designed with fabric strap,designed for military use.It is suitable for outdoor activities, casual wear.', '../Products/Watch/W014.avif', 4300.00, 3600.00, 76, 'Yes', 4.80),
(65, 'W015', 'Fossil Pilot Chronograph Sky Blue Dial Men\'s Watch', 'Watch', 'High-tech watch with touchscreen displays and various smart features.Its features are notifications, fitness tracking, apps, also integrated with mobile payment systems.', '../Products/Watch/W015.webp', 3200.00, 2200.00, 765, 'Yes', 4.20),
(66, 'W016', 'Fossil Goodwin Chronograph Black Dial Men\'s Watch', 'Watch', 'It is visible movement, artistic design, with  mechanical body.', '../Products/Watch/W016.avif', 3280.00, 4332.00, 54, 'Yes', 5.00),
(67, 'W017', 'Fossil Townsman Automatic Black Dial Men\'s Watch', 'Watch', 'It is  high-end watches crafted from premium materials with intricate details.Its features are  precious metals, gemstones, Swiss movement, brand prestige.Can be worn for status symbol.', '../Products/Watch/W017.avif', 5600.00, 4332.00, 654, 'Yes', 5.00),
(68, 'W018', 'Michael Kors Maritime Sky Blue Dial Silicone Band Men\'s Watch', 'Watch', 'Its features are precious metals, gemstones, Swiss movement, brand prestige.', '../Products/Watch/W018.avif', 8955.00, 4322.00, 765, 'Yes', 4.00),
(69, 'W019', 'Michael Kors Brecken Chronograph Black Dial Men\'s Watch', 'Watch', 'It  display time in multiple time zones.Its features are additional hour hand, rotating 24-hour bezel, often used by travelers.', '../Products/Watch/W019.webp', 4493.00, 2223.00, 655, 'Yes', 5.00),
(70, 'W020', 'Fossil Garrett Chronograph Blue Dial Men\'s Watch', 'Watch', 'Water-resistant, shock-resistant,  features like compass. This wtch is used for outdoor adventures, military use, rugged environments etc.', '../Products/Watch/W020.avif', 5555.00, 2340.00, 65, 'Yes', 4.01),
(71, 'W021', 'Fossil Forrester Chronograph Blue Dial Men\'s Watch', 'Watch', 'Water-resistant, shock-resistant,  features like compass. This wtch is used for outdoor adventures, military use, rugged environments etc.', '../Products/Watch/W021.avif', 5443.00, 3400.00, 66, 'Yes', 3.90),
(72, 'W022', 'Japanese Binbond waterproof Smart watch', 'Watch', 'It is featured with altimeter , durable watches designed for extreme conditions and outdoor activities.', '../Products/Watch/W022.webp', 4533.00, 3900.00, 66, 'Yes', 3.80),
(73, 'W023', 'Fashionable Watch Silicone Band Quartz Analog Wrist Watch For Men - Watch For Men - Easy To maintain - Iconic Style', 'Watch', 'It is featured with altimeter , durable watches designed for extreme conditions and outdoor activities.', '../Products/Watch/W023.webp', 4432.00, 3580.00, 65, 'Yes', 3.70),
(74, 'W024', 'Poedagar 924 Stainless Steel Fashion Quartz Men’s Watch', 'Watch', 'Plain dial, thin case,  monochrome dice makes it super stylish for everyday wear.', '../Products/Watch/W024.webp', 4330.00, 4000.00, 653, 'Yes', 2.60),
(75, 'W025', 'TRSOYE Brand New luxury Fashion Leather Belt Watch Wrist Watch for Men', 'Watch', 'Watch with a simple and clean design, focusing on minimal elements', '../Products/Watch/W025.webp', 4320.00, 4000.00, 54, 'Yes', 3.50),
(76, 'W026', 'New Stainless steel Men\'s Starry sky Creativity Fashion Calendar Watches Casual Sport Watch For Men Quartz WristWatch Relogio Masculino - Watch For Men', 'Watch', 'Watch with a simple and clean design, focusing on minimal elements', '../Products/Watch/W026.webp', 4320.00, 4000.00, 55, 'Yes', 3.50),
(77, 'W027', 'Poedagar 924 Stainless Steel Fashion Quartz Men’s Watch', 'Watch', 'It  combines with  the traditional analog watch design with smart features.Pastelcolours are available here for causal settings or random.', '../Products/Watch/W027.webp', 1230.00, 1150.00, 55, 'Yes', 3.50),
(78, 'W028', 'MVMT Analog Wrist Watch For Men - Watch For Men - Watch - Watch For Men - Watch - ঘড়ি - Watch For Men', 'Watch', ' Analog dial with hidden smart features like notifications, fitness tracking.\nOccasions: Everyday wear, tech-savvy environments.', '../Products/Watch/W028.webp', 3000.00, 2500.00, 66, 'Yes', 3.50),
(79, 'W029', 'TRSOYE Brand New luxury Fashion Leather Belt Watch Wrist Watch for Men', 'Watch', 'Analog dial with hidden smart features of  notifications.It combines the traditional analog watch with smart features.', '../Products/Watch/W029.jpeg', 900.00, 500.00, 77, 'Yes', 3.50),
(80, 'W030', 'Men\'s Fashion Faux Leather Strap Round Dial Analog Casual Wrist Watch Xmas Gift', 'Watch', 'Analog dial with hidden smart features of  notifications.It combines the traditional analog watch with smart features.', '../Products/Watch/W030.jpeg', 590.00, 400.00, 88, 'Yes', 3.50),
(81, 'W031', 'Olevs 9931 Luxury Fashion Stainless Steel Imported Wuartz Movement Ladies Wristwatch For Women', 'Watch', 'Description: Classic watches carried in a pocket, often with a chain.\nFeatures: Hinged cover, mechanical movement, often used as collector\'s items.', '../Products/Watch/W031.webp', 2099.00, 1500.00, 99, 'Yes', 3.50),
(82, 'W032', 'SANDA Brand Men\'s Trend Simple Fashion Casual Creative Electronic Watch Sports Waterproof Men-Watch', 'Watch', 'It is normally put on  historical or vintage fashion, formal events for its hinged cover and mechanical movement.', '../Products/Watch/W032.webp', 900.00, 750.00, 100, 'Yes', 3.50),
(316, 'Wa001', 'ORAS Large Capacity Genuine Leather Wallet for Men', 'Wallet', 'The ORAS Large Capacity Genuine Leather Wallet for Men is the perfect combination of style and functionality. Crafted from high-quality genuine leather, this wallet offers durability and elegance. With its spacious design, measuring 7.8 inches in height and 4.4 inches in width, it provides ample room for cash, cards, coins, and even documents. Despite its large capacity, it maintains a slim profile, fitting comfortably in your pocket. it is lightweight and portable. Upgrade your style and organization with the ORAS Large Capacity Genuine Leather Wallet for Men.', '../Products/Wallet/Wa001.webp', 850.00, 700.00, 78, 'Yes', 3.50),
(317, 'Wa002', 'R1001 ORAS Genuine Leather Long Hand Wallet', 'Wallet', '100% Genuine Leather Wallet\nSize: (7.5″)* (3.8″)\nSuitable for Carrying Mobile and Card\n1 Year Leather Warranty', '../Products/Wallet/Wa002.webp', 850.00, 450.00, 75, 'Yes', 3.50),
(318, 'Wa003', 'R1002 ORAS Genuine Leather Long Wallet for Men', 'Wallet', 'Brand Name: ORAS\nMain Material: Genuine Leather\nGenuine Leather Type: Cow Leather\nLining Material: Polyester\nHeight:19cm\nItem Length:9cm\nWallet Length: Long\nItem Width:2 cm', '../Products/Wallet/Wa003.webp', 650.00, 450.00, 45, 'Yes', 4.21),
(319, 'Wa004', 'R1004 ORAS Genuine Leather Wallet for Men\n', 'Wallet', 'Made from premium full-grain Genuine Leather\nSize  : Height: 3.6 inch ; Width: 4.3 inch\nFeatures: stylish, simple, soft rigid a tough wind.\nGreat to match any fashion style.\nSafe and Comfortable, provide you the most charming look.', '../Products/Wallet/Wa004.webp', 700.00, 450.00, 4, 'Yes', 4.21),
(320, 'Wa005', 'R1005 ORAS Genuine Leather Wallet for Men\n', 'Wallet', 'Made from premium full-grain Genuine Leather\nSize  : Height: 3.4 inch ; Width: 4.2 inch\nFeatures: stylish, simple, soft rigid a tough wind.\nGreat to match any fashion style.\nSafe and Comfortable, provide you the most charming look.', '../Products/Wallet/Wa005.webp', 820.00, 700.00, 5, 'Yes', 4.21),
(321, 'Wa006', 'R1008 ORAS Genuine Leather Wallet for Men\n', 'Wallet', 'Made from premium full-grain Genuine Leather\nSize  : Height: 3.6 inch ; Width: 4.3 inch\nFeatures: stylish, simple, soft rigid a tough wind.\nGreat to match any fashion style.\nSafe and Comfortable, provide you the most charming look.', '../Products/Wallet/Wa006.webp', 850.00, 750.00, 6, 'Yes', 4.21),
(322, 'Wa007', 'R1010 ORAS Genuine Leather Bifold Wallet', 'Wallet', 'This leather wallet is designed to be both practical and fashionable. Its slim design makes it easy to carry in any pocket, making it ideal for busy individuals. Made from high-quality top grain cowhide leather and handcrafted with care, this wallet also features RFID blocking technology to protect against identity theft. It can hold up to 5 credit or debit cards and has a microfiber-lined cash compartment for storing bank notes, tickets, and receipts.\n\nMade from premium top grain cowhide leather\nSuper slim design\nCan hold up to 5 credit/debit cards\nMicrofiber-lined cash compartment for bank notes, tickets, and receipts\nHandcrafted', '../Products/Wallet/Wa007.webp', 850.00, 750.00, 1, 'Yes', 4.21),
(323, 'Wa008', 'R1019 ORAS Genuine Leather Wallet', 'Wallet', 'Premium quality front pocket wallet designed for Bangladeshi banknotes\nMade of Full-Grain Vegetable-Tanned leather\nFolds to a size of 3×4.25 inches\nFeatures a magnetic flap for secure closure with a satisfying thud sound\nOne full-size cash chamber can hold up to 15 banknotes\nThree card slots for everyday essentials\nBecomes more functional with use and can accommodate more cards and cash\nAvailable in Ink Black, Yale Blue, and Wine Red\nUnfolded dimension: 21.5×10 cm, folded dimension: 7.5 inches', '../Products/Wallet/Wa008.webp', 850.00, 700.00, 2, 'Yes', 4.21),
(324, 'Wa009', 'Brown Textured Genuine Leather Wallet', 'Wallet', 'Brown textured genuine leather wallet. Features with multiple chambers for cash and card.', '../Products/Wallet/Wa009.webp', 850.00, 780.00, 3, 'Yes', 4.21),
(325, 'Wa010', 'Brown Genuine Leather Wallet', 'Wallet', 'Brown genuine leather wallet. Features with two chamber and card slots.', '../Products/Wallet/Wa010.webp', 850.00, 720.00, 78, 'Yes', 4.21),
(326, 'Wa011', 'Antique Green/Black Genuine Leather Wallet', 'Wallet', 'Antique green leather wallet with black border and applique details. Multiple chambers for cash and cards.', '../Products/Wallet/Wa011.webp', 850.00, 790.00, 78, 'Yes', 4.21),
(327, 'Wa012', 'Black Textured Genuine Leather Wallet', 'Wallet', 'Black textured genuine leather wallet. Features with two chambers and multiple card slot.', '../Products/Wallet/Wa012.webp', 850.00, 788.00, 78, 'Yes', 4.21),
(328, 'Wa013', 'Black Textured Genuine Leather Wallet', 'Wallet', 'Black textured genuine leather wallet. Features with two chambers and multiple card slot.', '../Products/Wallet/Wa013.webp', 850.00, 780.00, 45, 'Yes', 4.21),
(32, 'Wa014', 'Chocolate Textured Genuine Leather Wallet', 'Wallet', 'Chocolate textured genuine leather wallet with multiple chambers for cash and cards.', '../Products/Wallet/Wa014.webp', 850.00, 650.00, 10, 'Yes', 4.21),
(330, 'Wa015', 'Red Printed Genuine Leather Taaga Man Wallet', 'Wallet', 'Red and black printed Taaga Man genuine leather wallet with multiple chambers for cash and cards.', '../Products/Wallet/Wa015.webp', 850.00, 450.00, 12, 'Yes', 4.21);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `review_description` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `customer_id`, `product_id`, `review_description`, `rating`) VALUES
(3, 6, 353, 'dfbdfb sfdgsvb', 4);

-- --------------------------------------------------------

--
-- Table structure for table `second_hand_product`
--

CREATE TABLE `second_hand_product` (
  `Sh_product_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `Sh_product_name` varchar(255) NOT NULL,
  `Sh_category` varchar(100) NOT NULL,
  `Sh_Product_description` text DEFAULT NULL,
  `Sh_Product_present_condition` varchar(100) DEFAULT NULL,
  `Sh_price` decimal(10,2) NOT NULL,
  `Sh_image_path` varchar(255) DEFAULT NULL,
  `Sh_product_status` enum('Available','Sold','Reserved') DEFAULT 'Available',
  `Sh_date_posted` date NOT NULL,
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `second_hand_product`
--

INSERT INTO `second_hand_product` (`Sh_product_id`, `seller_id`, `Sh_product_name`, `Sh_category`, `Sh_Product_description`, `Sh_Product_present_condition`, `Sh_price`, `Sh_image_path`, `Sh_product_status`, `Sh_date_posted`, `approval_status`) VALUES
(26, 3, 'Lenovo V15 Core i3 10th Gen Laptop', 'Electronics', 'sdftthdgh', 'sdfgh', 245454.00, '../Second_hand/S_products/67506627304ec_giant_315453.jpg', 'Available', '2024-12-04', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `sellersinfo`
--

CREATE TABLE `sellersinfo` (
  `seller_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `nid_number` varchar(17) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `seller_picture` varchar(255) NOT NULL,
  `nid_picture` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellersinfo`
--

INSERT INTO `sellersinfo` (`seller_id`, `first_name`, `last_name`, `email`, `mobile_number`, `gender`, `nid_number`, `date_of_birth`, `address`, `postal_code`, `seller_picture`, `nid_picture`, `password_hash`) VALUES
(3, 'Rajib', 'Kumar', 'rahatmi0001@gmail.com', '01780492588', 'male', '3736367628', '2024-11-05', 'Habiganj sadar', '3300', 'sellerpic/01780492587.png', 'sellernid/01780492587.jpg', '$2y$10$eFPnvOWxBdSZRGkFZ1B3quYR.dDof8AHFoZ07P7.i1sQsd4XoN3uy');

-- --------------------------------------------------------

--
-- Table structure for table `seller_wallet`
--

CREATE TABLE `seller_wallet` (
  `wallet_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_wallet`
--

INSERT INTO `seller_wallet` (`wallet_id`, `seller_id`, `balance`, `created_at`) VALUES
(1, 3, 29000.00, '2024-12-04 17:35:42');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `customer_id`) VALUES
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `wishlist_item_id` int(11) NOT NULL,
  `wishlist_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist_items`
--

INSERT INTO `wishlist_items` (`wishlist_item_id`, `wishlist_id`, `product_id`, `added_at`) VALUES
(4, 1, 315, '2024-11-30 06:07:35'),
(5, 1, 358, '2024-12-03 06:03:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artist_info`
--
ALTER TABLE `artist_info`
  ADD PRIMARY KEY (`artist_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile_number` (`mobile_number`);

--
-- Indexes for table `artist_wallet`
--
ALTER TABLE `artist_wallet`
  ADD PRIMARY KEY (`wallet_id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- Indexes for table `art_bids`
--
ALTER TABLE `art_bids`
  ADD PRIMARY KEY (`bid_id`),
  ADD KEY `fk_art_id` (`art_id`),
  ADD KEY `fk_customer_id` (`customer_id`);

--
-- Indexes for table `art_gallery`
--
ALTER TABLE `art_gallery`
  ADD PRIMARY KEY (`art_id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `fk_winner_customer` (`winner_customer_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `customer_info`
--
ALTER TABLE `customer_info`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `idx_email` (`email`),
  ADD UNIQUE KEY `idx_mobile_number` (`mobile_number`),
  ADD KEY `idx_nid_number` (`nid_number`);

--
-- Indexes for table `customer_wallet`
--
ALTER TABLE `customer_wallet`
  ADD PRIMARY KEY (`wallet_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `art_id` (`art_id`),
  ADD KEY `FK_Sh_product_id` (`Sh_product_id`);

--
-- Indexes for table `product_info`
--
ALTER TABLE `product_info`
  ADD PRIMARY KEY (`Product_code`),
  ADD UNIQUE KEY `idx_product_id` (`Product_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `second_hand_product`
--
ALTER TABLE `second_hand_product`
  ADD PRIMARY KEY (`Sh_product_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `sellersinfo`
--
ALTER TABLE `sellersinfo`
  ADD PRIMARY KEY (`seller_id`);

--
-- Indexes for table `seller_wallet`
--
ALTER TABLE `seller_wallet`
  ADD PRIMARY KEY (`wallet_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`wishlist_item_id`),
  ADD KEY `wishlist_id` (`wishlist_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artist_info`
--
ALTER TABLE `artist_info`
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `artist_wallet`
--
ALTER TABLE `artist_wallet`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `art_bids`
--
ALTER TABLE `art_bids`
  MODIFY `bid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `art_gallery`
--
ALTER TABLE `art_gallery`
  MODIFY `art_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `customer_info`
--
ALTER TABLE `customer_info`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer_wallet`
--
ALTER TABLE `customer_wallet`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `product_info`
--
ALTER TABLE `product_info`
  MODIFY `Product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=830;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `second_hand_product`
--
ALTER TABLE `second_hand_product`
  MODIFY `Sh_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sellersinfo`
--
ALTER TABLE `sellersinfo`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seller_wallet`
--
ALTER TABLE `seller_wallet`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `wishlist_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artist_wallet`
--
ALTER TABLE `artist_wallet`
  ADD CONSTRAINT `artist_wallet_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artist_info` (`artist_id`) ON DELETE CASCADE;

--
-- Constraints for table `art_bids`
--
ALTER TABLE `art_bids`
  ADD CONSTRAINT `art_bids_ibfk_1` FOREIGN KEY (`art_id`) REFERENCES `art_gallery` (`art_id`),
  ADD CONSTRAINT `art_bids_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer_info` (`customer_id`),
  ADD CONSTRAINT `fk_art_id` FOREIGN KEY (`art_id`) REFERENCES `art_gallery` (`art_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer_info` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `art_gallery`
--
ALTER TABLE `art_gallery`
  ADD CONSTRAINT `art_gallery_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artist_info` (`artist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_winner_customer` FOREIGN KEY (`winner_customer_id`) REFERENCES `customer_info` (`customer_id`) ON DELETE SET NULL;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_info` (`customer_id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`Product_id`);

--
-- Constraints for table `customer_wallet`
--
ALTER TABLE `customer_wallet`
  ADD CONSTRAINT `customer_wallet_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_info` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_info` (`customer_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `FK_Sh_product_id` FOREIGN KEY (`Sh_product_id`) REFERENCES `second_hand_product` (`Sh_product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`Product_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_info` (`customer_id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`Product_id`);

--
-- Constraints for table `second_hand_product`
--
ALTER TABLE `second_hand_product`
  ADD CONSTRAINT `second_hand_product_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellersinfo` (`seller_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seller_wallet`
--
ALTER TABLE `seller_wallet`
  ADD CONSTRAINT `seller_wallet_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellersinfo` (`seller_id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_info` (`customer_id`);

--
-- Constraints for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `wishlist_items_ibfk_1` FOREIGN KEY (`wishlist_id`) REFERENCES `wishlist` (`wishlist_id`),
  ADD CONSTRAINT `wishlist_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_info` (`Product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
