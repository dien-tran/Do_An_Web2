-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2024 at 10:29 AM
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
-- Database: `shop_db`
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

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CateId` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `CateName` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CateId`, `CateName`) VALUES
('ACT', 'Action'),
('ADV', 'Adventure'),
('CMD', 'Comedy'),
('DR', 'Drama'),
('HR', 'Horor'),
('HS', 'History'),
('NV', 'Novel'),
('RM', 'Romance'),
('SCH', 'School'),
('SF', 'Sci Fi');

-- --------------------------------------------------------

--
-- Table structure for table `detailsbill`
--

CREATE TABLE `detailsbill` (
  `IdBill` varchar(100) NOT NULL,
  `IdProduct` int(100) NOT NULL,
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
  `Id` int(100) NOT NULL,
  `CategoryId` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Price` int(100) NOT NULL,
  `Image` varchar(100) NOT NULL,
  `MainAuthor` varchar(50) NOT NULL,
  `Publisher` varchar(50) NOT NULL,
  `PublicationYear` varchar(50) NOT NULL,
  `Language` varchar(50) NOT NULL,
  `CoverType` varchar(50) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Id`, `CategoryId`, `Name`, `Price`, `Image`, `MainAuthor`, `Publisher`, `PublicationYear`, `Language`, `CoverType`, `Quantity`, `Description`) VALUES
(4, 'HR', 'Bạch Dạ Hành', 60, '1.jpeg', 'Higashino Keigo', 'NXB Hội Nhà Văn', '2021', 'VietNamese', 'Soft', 100, 'Osuke, chủ một tiệm cầm đồ bị sát hại tại một ngôi nhà chưa hoàn công, một triệu yên mang theo người cũng bị cướp mất.\r\n\r\nSau đó một tháng, nghi can Fumiyo được cho rằng có quan hệ tình ái với nạn nhân và đã sát hại ông để cướp một triệu yên, cũng chết tại nhà riêng vì ngộ độc khí ga. Vụ án mạng ông chủ tiệm cầm đồ rơi vào bế tắc và bị bỏ xó.\r\nNhưng với hai đứa trẻ mười một tuổi, con trai nạn nhân và con gái nghi can, vụ án mạng năm ấy chưa bao giờ kết thúc. \r\n\r\nSinh tồn và trưởng thành dưới bóng đen cái chết của bố mẹ, cho đến cuối đời, Ryoji vẫn luôn khao khát được một lần đi dưới ánh mặt trời, còn Yukiho cứ ra sức vẫy vùng rồi mãi mãi chìm vào đêm trắng.\r\n'),
(5, 'ADV', 'Núi Chuột Quét', 50, '2.jpeg', 'Hô Diên Vân', 'Hồng Đức', '2022', 'English', 'Hard', 100, 'Mười năm trước, cả Tây Giao rùng mình hãi hùng trước loạt án giết người đẫm máu nhằm vào những phụ nữ độc thân. Hung thủ đánh gục nạn nhân bằng búa, làm nhục rồi tiêu hủy chứng cứ theo những cách rất tàn bạo, thủ đoạn ra tay vô cùng quỷ quyệt và hiểm ác. Lần theo từng manh mối mơ hồ nhất, cảnh sát không ngờ đối tượng bắt được lại chỉ là một nam sinh chưa tròn mười tám tuổi!\r\n\r\nMười năm trôi qua trong bình yên, cho đến một ngày, ngọn lửa trên núi Chuột Quét nhuộm màu đỏ rực lên bầu trời đêm của thành phố. Lần này, trong những cái xác cháy đen có cả trẻ con. Hung thủ năm xưa lần nữa lộ diện, lầm lì đối đầu với tất cả, tự mình đưa ra phán quyết. Đến khi vén màn sự thật, tổ chuyên án phải đối diện câu hỏi nhức nhối: rốt cuộc ranh giới giữa sai và đúng là ở đâu?\r\n');

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
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CateId`);

--
-- Indexes for table `detailsbill`
--
ALTER TABLE `detailsbill`
  ADD PRIMARY KEY (`IdBill`),
  ADD KEY `IdBill` (`IdBill`),
  ADD KEY `IdProduct` (`IdProduct`);

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
  ADD PRIMARY KEY (`Id`),
  ADD KEY `CategoryId` (`CategoryId`),
  ADD KEY `CategoryId_2` (`CategoryId`),
  ADD KEY `CategoryId_3` (`CategoryId`);

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
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `detailsbill`
--
ALTER TABLE `detailsbill`
  MODIFY `IdProduct` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
