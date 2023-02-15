SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `bagong_ani`
--
CREATE DATABASE IF NOT EXISTS `bagong_ani` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bagong_ani`;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(222) NOT NULL AUTO_INCREMENT,
  `farm_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `UOM` varchar(255) NOT NULL,
  `image` LONGBLOB,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO products (farm_id, title, slogan, price, UOM)
VALUES 
(1, 'Pork Pigue', 'Fresh pork ham', 300.00, 'kilo'), 
(1, 'Pork Liempo', 'Fresh pork belly', 350.00, 'kilo'),
(1, 'Pork Loin', 'Fresh pork loin', 320.00, 'kilo'),
(1, 'Pork Pata', 'Fresh pork foot', 370.00, 'kilo'),
(1, 'Pork Ribs', 'Fresh pork ribs', 380.00, 'kilo'),
(1, 'Pork Shoulder', 'Fresh pork shoulder', 300.00, 'kilo'),
(1, 'Pork Tenderloin', 'Fresh pork tenderloin', 300.00, 'kilo'),
(1, 'Pork Longganisa', 'Fresh pork longganisa', 10.00, 'piece'),
(1, 'Pork Chorizo', 'Fresh pork chorizo', 10.00, 'piece')
;

INSERT INTO products (farm_id, title, slogan, price, UOM)
VALUES 
(2, 'Alugbati', 'Fresh from the farm', 30.00, 'bundle'), 
(2, 'Ampalaya', 'Fresh from the farm', 80.00, 'kilo'),
(2, 'Artichoke', 'Fresh from the farm', 60.00, 'kilo'),
(2, 'Atis', 'Fresh from the farm', 70.00, 'kilo'),
(2, 'Avocado', 'Fresh from the farm', 80.00, 'kilo'),
(2, 'Baguio Spinach', 'Fresh from the farm', 50.00, 'bundle'),
(2, 'Balatong', 'Fresh from the farm', 70.00, 'kilo'),
(2, 'Balimbing', 'Fresh from the farm', 50.00, 'kilo'),
(2, 'Bawang', 'Fresh from the farm', 200.00, 'kilo')
;


-- --------------------------------------------------------

--
-- Table structure for table `farms`
--

CREATE TABLE IF NOT EXISTS `farms` (
  `farm_id` int(222) NOT NULL AUTO_INCREMENT,
  `user_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `url` varchar(222) NOT NULL,
  `open_hour` varchar(222) NOT NULL,
  `close_hour` varchar(222) NOT NULL,
  `open_days` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `image` LONGBLOB,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`farm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



INSERT INTO `farms` (`user_id`, `title`, `email`, `phone`, `url`, `open_hour`, `close_hour`, `open_days`, `address`, `date`)
VALUES
    (1, 'Monton Piggery', 'brixmonton123@gmail.com', '09653545649', 'www.montonpiggery.com', '9:00 AM', '5:00 PM', 'Mon-Fri', 'Brgy. Sta. Fe, Abuyog, Leyte, 6510', NOW()),
    (1, 'Monton Integrated Farm', 'brixmonton123@gmail.com', '09653545649', 'www.montonfarm.com', '9:00 AM', '5:00 PM', 'Mon-Fri', 'Brgy. Sta. Fe, Abuyog, Leyte, 6510', NOW())
    ;



-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(222) NOT NULL AUTO_INCREMENT,
  `username` varchar(222) NOT NULL,
  `first_name` varchar(222) NOT NULL,
  `last_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `status` int(222) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `first_name`, `last_name`, `email`, `phone`, `password`, `address`, `status`, `date`) VALUES
(1, 'bsmonton', 'Brix Aaron', 'Monton', 'bsmonton@gmail.com', '09653545649', '81dc9bdb52d04dc20036dbd8313ed055', 'Brgy Sta. Fe, Abuyog, Leyte, 6510', 1, '2023-01-31 10:05:03');

-- --------------------------------------------------------

--
-- Table structure for table `users_orders`
--

CREATE TABLE IF NOT EXISTS `users_orders` (
  `order_id` int(222) NOT NULL AUTO_INCREMENT,  
  `buyers_user_id` int(222) NOT NULL,
  `product_id` int(222) NOT NULL,
  `farm_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,  
  `price` decimal(10,2) NOT NULL,
  `quantity` int(222) NOT NULL,
  `UOM` varchar(255) NOT NULL,
  `status` varchar(222) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


