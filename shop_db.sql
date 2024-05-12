-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2024 at 06:39 PM
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
  `IdBill` int(11) NOT NULL,
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
  `IdBill` int(11) NOT NULL,
  `IdProduct` varchar(100) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `ProductAmount` varchar(1000) NOT NULL,
  `TotalMoneyEachProduct` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `placed_on` date NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Description` varchar(1000) NOT NULL,
  `SoldYet` varchar(5) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Id`, `CategoryId`, `Name`, `Price`, `Image`, `MainAuthor`, `Publisher`, `PublicationYear`, `Language`, `CoverType`, `Quantity`, `Description`, `SoldYet`, `Status`) VALUES
(1, 'ACT', 'The Hunger Games', 50, '10.jpeg', 'Suzanne Collins', 'Scholastic Corporation', '2008', 'English', 'Hardcover', 100, 'Set in a dark vision of the near future, a terrifying reality TV show is taking place. Twelve boys and twelve girls are forced to appear in a live event called the Hunger Games. There is only one rule: kill or be killed.', 'No', '1'),
(2, 'ADV', 'The Hobbit', 45, '11.jpeg', 'J.R.R. Tolkien', 'George Allen & Unwin', '1937', 'English', 'Paperback', 80, 'Bilbo Baggins, a hobbit, is swept into an epic quest to reclaim the lost Dwarf Kingdom of Erebor, which was long ago conquered by the dragon Smaug. Along the way, he is introduced to a colorful cast of characters, including Gandalf the wizard and a group of dwarves led by Thorin Oakenshield.', 'No', '1'),
(3, 'CMD', 'Pride and Prejudice', 35, '12.jpeg', 'Jane Austen', 'T. Egerton, Whitehall', '1813', 'English', 'Softcover', 100, 'Pride and Prejudice follows the turbulent relationship between Elizabeth Bennet, the headstrong daughter of a country gentleman, and Fitzwilliam Darcy, a wealthy aristocrat. Through a series of misunderstandings and miscommunications, they must overcome their initial prejudices and pride to find true love.', 'No', '1'),
(4, 'HR', 'Bạch Dạ Hành', 60, '1.jpeg', 'Higashino Keigo', 'NXB Hội Nhà Văn', '2021', 'VietNamese', 'Soft', 98, 'Osuke, chủ một tiệm cầm đồ bị sát hại tại một ngôi nhà chưa hoàn công, một triệu yên mang theo người cũng bị cướp mất.\r\n\r\nSau đó một tháng, nghi can Fumiyo được cho rằng có quan hệ tình ái với nạn nhân và đã sát hại ông để cướp một triệu yên, cũng chết tại nhà riêng vì ngộ độc khí ga. Vụ án mạng ông chủ tiệm cầm đồ rơi vào bế tắc và bị bỏ xó.\r\nNhưng với hai đứa trẻ mười một tuổi, con trai nạn nhân và con gái nghi can, vụ án mạng năm ấy chưa bao giờ kết thúc. \r\n\r\nSinh tồn và trưởng thành dưới bóng đen cái chết của bố mẹ, cho đến cuối đời, Ryoji vẫn luôn khao khát được một lần đi dưới ánh mặt trời, còn Yukiho cứ ra sức vẫy vùng rồi mãi mãi chìm vào đêm trắng.\r\n', 'Yes', '1'),
(5, 'ADV', 'Núi Chuột Quét', 50, '2.jpeg', 'Hô Diên Vân', 'Hồng Đức', '2022', 'English', 'Hard', 89, 'Mười năm trước, cả Tây Giao rùng mình hãi hùng trước loạt án giết người đẫm máu nhằm vào những phụ nữ độc thân. Hung thủ đánh gục nạn nhân bằng búa, làm nhục rồi tiêu hủy chứng cứ theo những cách rất tàn bạo, thủ đoạn ra tay vô cùng quỷ quyệt và hiểm ác. Lần theo từng manh mối mơ hồ nhất, cảnh sát không ngờ đối tượng bắt được lại chỉ là một nam sinh chưa tròn mười tám tuổi!\r\n\r\nMười năm trôi qua trong bình yên, cho đến một ngày, ngọn lửa trên núi Chuột Quét nhuộm màu đỏ rực lên bầu trời đêm của thành phố. Lần này, trong những cái xác cháy đen có cả trẻ con. Hung thủ năm xưa lần nữa lộ diện, lầm lì đối đầu với tất cả, tự mình đưa ra phán quyết. Đến khi vén màn sự thật, tổ chuyên án phải đối diện câu hỏi nhức nhối: rốt cuộc ranh giới giữa sai và đúng là ở đâu?\r\n', 'Yes', '1'),
(6, 'ADV', 'The Morningside', 26, '3.jpeg', 'Jenny Schwartz', 'Kindle Edition', '2017', 'English', 'Hard', 100, 'When starship shaman Jaya Romanov and her new mate partner, galactic bounty hunter and robot wolf shifter, Vulf Trent, saved the galaxy from the deadly actions of a determined geriatric terrorist, they forgot that old Earth truism: no good deed goes unpunished.', 'No', '1'),
(7, 'ACT', 'Cosmic Queries', 50, '4.jpeg', ' Neil deGrasse Tyson with James Trefil', 'National Geographic', '2021', 'English', 'Hard', 90, 'or science geeks, space and physics nerds, and all who want to understand their place in the universe, this enlightening new book from Neil deGrasse Tyson offers a unique take on the mysteries and curiosities of the cosmos, building on rich material from his beloved StarTalk podcast.In these illuminating pages, illustrated with dazzling photos and revealing graphics, Tyson and co-author James Trefil, a renowned physicist and science popularizer, take on the big questions that humanity has been posing for millennia--How did life begin? What is our place in the universe? Are we alone?--and provide answers based on the most current data, observations, and theories.', 'No', '1'),
(8, 'DR', 'The Tesla Secret', 100, '5.jpeg', 'Alex Lukeman', 'Kindle Edition', '2012', 'English', 'Transparent', 80, 'lans for a devastating weapon invented by Nikola Tesla fall into the hands of a centuries-old conspiracy bent on world domination. Powerful men will stop at nothing to use the weapon to achieve their goal, even at the risk of nuclear war. Nick Carter works for the Project, the shadow hand of the US President. Selena Connor is his teammate and lover. Their relationship will be tested to the breaking point as they are forced to question their commitment to the other and to the violent life they have chosen. From the streets of Prague to the jungles of Mexico, from the hills of Tuscany to the plains of Eastern Russia, the story moves with relentless pace toward a final, explosive confrontation.', 'No', '1'),
(9, 'SF', 'stephen king mercedes', 70, '6.jpeg', 'Stephen King', 'Midwest (United States)', '2014', 'English', 'Hard', 99, 'In the predawn hours, in a distressed American city, hundreds of unemployed men and women line up for the opening of a job fair. They are tired and cold and desperate. Emerging from the fog, invisible until it is too late, a lone driver plows through the crowd in a stolen Mercedes, running over the innocent, backing up, and charging again. Eight people are killed; fifteen are wounded. The killer escapes.Months later, an ex-cop named Bill Hodges, still haunted by the unsolved crime, contemplates suicide. When he gets a crazed letter from \"the perk,\" claiming credit for the murders, Hodges wakes up from his depressed and vacant retirement, fearing another even more diabolical attack and hell-bent on preventing it.', 'No', '1'),
(10, 'RM', 'the silence of the lambs', 80, '7.jpeg', 'Thomas Harris', 'Memphis, Tennessee', '1988', 'English', 'PaperBack', 100, 'A serial murderer known only by a grotesquely apt nickname—Buffalo Bill—is stalking women. He has a purpose, but no one can fathom it, for the bodies are discovered in different states. Clarice Starling, a young trainee at the FBI Academy, is surprised to be summoned by Jack Crawford, chief of the Bureaus Behavioral Science section. Her assignment: to interview Dr. Hannibal Lecter—Hannibal the Cannibal—who is kept under close watch in the Baltimore State Hospital for the Criminally Insane. Dr. Lecter is a former psychiatrist with a grisly history, unusual tastes, and an intense curiosity about the darker corners of the mind. His intimate understanding of the killer and of Clarice herself form the core of \"The Silence of the Lambs\"—an ingenious, masterfully written book and an unforgettable classic of suspense fiction.', 'No', '1'),
(11, 'SCH', 'The Lord of the Rings', 30, '8.jpeg', 'J.R.R. Tolkien', ' Houghton Mifflin Harcourt', '1954', 'English', 'Soft', 60, 'One Ring to rule them all, One Ring to find them, One Ring to bring them all and in the darkness bind them.In ancient times the Rings of Power were crafted by the Elven-smiths, and Sauron, the Dark Lord, forged the One Ring, filling it with his own power so that he could rule all others. But the One Ring was taken from him, and though he sought it throughout Middle-earth, it remained lost to him. After many ages it fell by chance into the hands of the hobbit Bilbo Baggins.From Saurons fastness in the Dark Tower of Mordor, his power spread far and wide. Sauron gathered all the Great Rings to him, but always he searched for the One Ring that would complete his dominion.When Bilbo reached his eleventy-first birthday he disappeared, bequeathing to his young cousin Frodo the Ruling Ring and a perilous quest: to journey across Middle-earth, deep into the shadow of the Dark Lord, and destroy the Ring by casting it into the Cracks of Doom.', 'No', '1'),
(12, 'CMD', 'Dracula', 40, '9.jpeg', 'Bram Stoker', ' Petrof Skinsky', '1897', 'English', 'Soft', 89, 'When Jonathan Harker visits Transylvania to help Count Dracula with the purchase of a London house, he makes a series of horrific discoveries about his client. Soon afterwards, various bizarre incidents unfold in England: an apparently unmanned ship is wrecked off the coast of Whitby; a young woman discovers strange puncture marks on her neck; and the inmate of a lunatic asylum raves about the master and his imminent arrival.In Dracula, Bram Stoker created one of the great masterpieces of the horror genre, brilliantly evoking a nightmare world of vampires and vampire hunters and also illuminating the dark corners of Victorian sexuality and desire.', 'No', '1'),
(13, 'HR', 'The Picture of Dorian Gray', 25, '13.jpeg', 'Oscar Wilde', 'Ward, Lock and Company', '1890', 'English', 'Softcover', 80, 'The Picture of Dorian Gray follows the story of a young man named Dorian Gray who is the subject of a portrait by artist Basil Hallward. Dorian of hedonistic lifestyle and desire for eternal youth lead to a Faustian bargain in which his portrait ages while he remains unchanged.', 'No', '1'),
(14, 'HS', 'Jane Eyre', 35, '14.jpeg', 'Charlotte Brontë', 'Smith, Elder & Co.', '1847', 'English', 'Paperback', 90, 'Jane Eyre is the story of a young orphaned girl who overcomes adversity to find love and independence. As she grows up, Jane faces challenges at every turn, from her abusive childhood to her difficult relationships with men, but she remains true to herself and her values.', 'No', '1'),
(15, 'NV', 'Gone with the Wind', 40, '15.jpeg', 'Margaret Mitchell', 'Macmillan Publishers', '1936', 'English', 'Hardcover', 95, 'Gone with the Wind is an epic novel set during the American Civil War and Reconstruction era. The story follows the life of Scarlett Hara, a headstrong Southern belle, as she navigates love, loss, and the collapse of the Old South.', 'No', '1'),
(16, 'RM', 'Anna Karenina', 30, '16.jpeg', 'Leo Tolstoy', 'The Russian Messenger', '1878', 'English', 'Paperback', 85, '', 'No', '1'),
(17, 'SCH', 'The Lord of the Flies', 35, '17.jpeg', 'William Golding', 'Faber and Faber', '1954', 'English', 'Softcover', 90, 'The Lord of the Flies follows a group of boys who are stranded on a deserted island and attempt to govern themselves without adult supervision. As their society descends into chaos and violence, the boys must confront their own inner darkness and the fragility of civilization.', 'No', '1'),
(18, 'SF', 'Foundation', 25, '18.jpeg', 'Isaac Asimov', 'Gnome Press', '1951', 'English', 'Paperback', 80, 'Foundation is the first book in Isaac Asimov of classic science fiction series. Set in a future where humanity has spread across the galaxy, the novel follows mathematician Hari Seldon as he predicts the fall of the Galactic Empire and establishes a plan to preserve human knowledge.', 'No', '1'),
(19, 'ACT', 'The Bourne Identity', 40, '19.jpeg', 'Robert Ludlum', 'Richard Marek Publishers', '1980', 'English', 'Hardcover', 85, 'The Bourne Identity follows the story of Jason Bourne, a man who wakes up with amnesia and discovers that he is being hunted by assassins. As he struggles to uncover his identity and evade his pursuers, Bourne discovers that he is a highly trained operative with deadly skills.', 'No', '1'),
(20, 'ADV', 'Around the World in Eighty Days', 35, '20.jpeg', 'Jules Verne', 'Pierre-Jules Hetzel', '1873', 'English', 'Softcover', 90, 'Around the World in Eighty Days follows the adventures of Phileas Fogg, a wealthy Englishman who makes a bet that he can circumnavigate the globe in eighty days. Accompanied by his loyal servant, Passepartout, Fogg embarks on a whirlwind journey full of obstacles and surprises.', 'No', '1'),
(21, 'CMD', 'Good Omens', 30, '21.jpeg', 'Neil Gaiman, Terry Pratchett', 'Gollancz', '1990', 'English', 'Paperback', 95, 'Good Omens is a comedic novel about the end of the world. The book follows an angel and a demon who team up to prevent the apocalypse, but their efforts are complicated by the Antichrist, a mix-up at the hospital, and a case of mistaken identity.', 'No', '1'),
(22, 'DR', 'A Streetcar Named Desire', 30, '22.jpeg', 'Tennessee Williams', 'New Directions', '1947', 'English', 'Softcover', 80, 'A Streetcar Named Desire tells the story of Blanche DuBois, a faded Southern belle who moves in with her sister Stella and her husband Stanley Kowalski in New Orleans. As Blanche of past catches up with her, she struggles to maintain her grip on reality and her sense of self.', 'No', '1'),
(23, 'HR', 'Little Women', 25, '23.jpeg', 'Louisa May Alcott', 'Robert Brothers', '1868', 'English', 'Paperback', 75, 'Little Women follows the lives of the four March sisters—Meg, Jo, Beth, and Amy—as they grow up in Civil War-era America. Through joys and sorrows, triumphs and setbacks, the sisters support each other and learn the true meaning of family and sisterhood.', 'No', '1'),
(24, 'HS', 'Great Expectations', 30, '24.jpeg', 'Charles Dickens', 'Chapman & Hall', '1861', 'English', 'Hardcover', 85, 'Great Expectations is the story of Pip, an orphan who is raised by his sister and her husband. As he grows up, Pip encounters a series of colorful characters and experiences that shape his life and his understanding of the world.', 'No', '1'),
(25, 'NV', 'Moby-Dick', 40, '25.jpeg', 'Herman Melville', 'Harper & Brothers', '1851', 'English', 'Softcover', 90, 'Moby-Dick is the story of Captain Ahab, a whaling captain who becomes obsessed with hunting down the white whale that maimed him. As Ahab pursues his nemesis across the seas, the novel explores themes of obsession, revenge, and the power of nature.', 'No', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `house_number` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `road` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ward` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `district` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `city` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `status` tinyint(1) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone_number`, `house_number`, `road`, `ward`, `district`, `city`, `user_type`, `status`, `date_time`) VALUES
(2, 'admin', 'admin@gmail.com', '4297f44b13955235245b2497399d7a93', '', '', '', '', '', '', 'admin', 0, '0000-00-00 00:00:00'),
(3, 'loc', 'loc@gmail.com', '4297f44b13955235245b2497399d7a93', '', '', '', '', '', '', 'user', 0, '0000-00-00 00:00:00'),
(4, 'điền', 'dientran@gmail.com', '4297f44b13955235245b2497399d7a93', '0987654321', '123', 'Ba Dinh', 'Ward 12', 'District 2', 'Hồ Chí Minh', 'user', 1, '2024-05-11 13:50:20');

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
  ADD KEY `IdProduct` (`IdProduct`);

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
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `IdBill` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `detailsbill`
--
ALTER TABLE `detailsbill`
  MODIFY `IdBill` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
