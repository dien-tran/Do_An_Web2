-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2024 at 06:01 AM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `IdBill` varchar(100) NOT NULL,
  `IdUser` varchar(100) NOT NULL,
  `NameUser` varchar(100) NOT NULL,
  `ShipDate` varchar(100) NOT NULL,
  `TotalPay` double NOT NULL,
  `MethodPayment` varchar(50) NOT NULL,
  `BillStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(60, 3, 'Chú bé mang pijama sọc', 60000, 1, '17.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `detailsbill`
--

CREATE TABLE `detailsbill` (
  `IdBill` varchar(100) NOT NULL,
  `IdProduct` varchar(100) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `ProductAmount` int(50) NOT NULL,
  `TotalMoneyEachProduct` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(10, 3, 'Trần Hảo Điền', '0987654321', 'dien@gmail.com', 'momo', 'flat no. 290, An Dương Vương, HCM, VietNam - 123456', ', Chú bé mang pijama sọc (1) ', 60000, '13-Apr-2024', 'pending'),
(11, 3, 'Loc ', '1234567890', 'loc@gmail.com', 'credit card', 'flat no. 123, An Duong Vuong, TPHCM, VietNam - 123123', ', Chú bé mang pijama sọc (1) ', 60000, '14-Apr-2024', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `Id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Price` int(100) NOT NULL,
  `Image` varchar(100) NOT NULL,
  `MainAuthor` varchar(50) NOT NULL,
  `Publisher` varchar(50) NOT NULL,
  `PublicationYear` varchar(50) NOT NULL,
  `Language` varchar(50) NOT NULL,
  `CoverType` varchar(50) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Id`, `Name`, `Price`, `Image`, `MainAuthor`, `Publisher`, `PublicationYear`, `Language`, `CoverType`, `Quantity`, `Description`) VALUES
('1', 'Chú bé mang pijama sọc', 60000, '17.jpg', '', '', '', '', '', 0, ''),
('27', 'Đắc Nhân Tâm', 60000, '33.jpg', '', '', '', '', '', 0, ''),
('28', 'Xứ Tuyết', 60000, '3.jpg', '', '', '', '', '', 0, ''),
('53', 'Stephen King', 50000, '4.jpg', '', '', '', '', '', 0, ''),
('54', 'Bạch Dạ Hành', 60000, '1.jpg', '', '', '', '', '', 0, ''),
('55', 'Núi Chuột Quét', 50000, '2.jpg', '', '', '', '', '', 0, ''),
('56', 'Bóng Ma Ký Ức', 60000, '5.jpg', '', '', '', '', '', 0, ''),
('57', 'Cây Cam Ngọt Của Tôi', 60000, '18.jpg', '', '', '', '', '', 0, ''),
('58', 'A Game Of Thrones ', 120000, '19.jpg', '', '', '', '', '', 0, ''),
('59', 'Anne Tóc Đỏ Làng Auonlea', 110000, '20.jpg', '', '', '', '', '', 0, ''),
('60', 'Người Đua Diều', 70000, '21.jpg', '', '', '', '', '', 0, ''),
('61', 'Không Gia Đình', 100000, '22.jpg', '', '', '', '', '', 0, ''),
('62', 'Nhà Giả Kim', 80000, '23.jpg', '', '', '', '', '', 0, ''),
('63', 'Bố Con Cá Gai', 70000, '24.jpg', '', '', '', '', '', 0, ''),
('64', 'Lối Sống Tối Giản Của Người Nhật', 90000, '29.jpg', '', '', '', '', '', 0, ''),
('65', 'Ngủ Ít Vẫn Khỏe', 95000, '38.jpg', '', '', '', '', '', 0, ''),
('66', 'Bước Đường Cùng', 60000, '46.jpg', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `house_number` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `road` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ward` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `district` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `city` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `house_number`, `road`, `ward`, `district`, `city`, `user_type`) VALUES
(2, 'admin', 'admin@gmail.com', '4297f44b13955235245b2497399d7a93', '', '', '', '', '', '', 'admin'),
(3, 'loc', 'loc@gmail.com', '4297f44b13955235245b2497399d7a93', '', '', '', '', '', '', 'user'),
(4, 'điền', 'dientran@gmail.com', '4297f44b13955235245b2497399d7a93', '', '', '', '', '', '', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`IdBill`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detailsbill`
--
ALTER TABLE `detailsbill`
  ADD PRIMARY KEY (`IdBill`),
  ADD KEY `IdBill` (`IdBill`),
  ADD KEY `IdProduct` (`IdProduct`),
  ADD KEY `IdProduct_2` (`IdProduct`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailsbill`
--
ALTER TABLE `detailsbill`
  ADD CONSTRAINT `detailsbill_ibfk_1` FOREIGN KEY (`IdBill`) REFERENCES `bill` (`IdBill`),
  ADD CONSTRAINT `detailsbill_ibfk_2` FOREIGN KEY (`IdProduct`) REFERENCES `products` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
