-- --------------------------------------------------------
-- Strežnik:                     127.0.0.1
-- Verzija strežnika:            8.0.30 - MySQL Community Server - GPL
-- Operacijski sistem strežnika: Win64
-- HeidiSQL Različica:           12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for vaja1
CREATE DATABASE IF NOT EXISTS `vaja1` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `vaja1`;

-- Dumping structure for tabela vaja1.ads
CREATE TABLE IF NOT EXISTS `ads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `user_id` int NOT NULL,
  `image` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `views` int NOT NULL,
  `date` date NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Dumping data for table vaja1.ads: 0 rows
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;
INSERT INTO `ads` (`id`, `title`, `description`, `user_id`, `image`, `views`, `date`, `price`) VALUES
	(3, 'Prvi oglas', 'Neki opis, nekaj, nekaj.', 1, 'a:3:{i:0;s:26:"photos/20150418_100851.jpg";i:1;s:26:"photos/20150418_110013.jpg";i:2;s:26:"photos/20150418_111206.jpg";}', 0, '2023-03-20', 100);
/*!40000 ALTER TABLE `ads` ENABLE KEYS */;

-- Dumping structure for tabela vaja1.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Dumping data for table vaja1.category: 9 rows
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'Računalništvo'),
	(2, 'Avto-moto'),
	(3, 'Šport'),
	(4, 'Dom'),
	(5, 'Telefonija'),
	(6, 'Gradnja'),
	(7, 'Oblačila-obutev'),
	(8, 'Fotografija'),
	(9, 'Knjige');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Dumping structure for tabela vaja1.categoryad
CREATE TABLE IF NOT EXISTS `categoryad` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idAd` int NOT NULL,
  `idCategory` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Ads` (`idAd`),
  KEY `FK_Category` (`idCategory`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Dumping data for table vaja1.categoryad: 0 rows
/*!40000 ALTER TABLE `categoryad` DISABLE KEYS */;
INSERT INTO `categoryad` (`id`, `idAd`, `idCategory`) VALUES
	(1, 1, 1),
	(2, 2, 3),
	(3, 3, 3);
/*!40000 ALTER TABLE `categoryad` ENABLE KEYS */;

-- Dumping structure for tabela vaja1.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `password` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `email` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `address` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci,
  `postNumber` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci,
  `phoneNumber` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Dumping data for table vaja1.users: 1 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `email`, `address`, `postNumber`, `phoneNumber`) VALUES
	(1, 'leonsovic', '688afd0813758466b7bc26bfae0e64da1ee596d7', 'leonsovic@leonsovic.com', 'Ulica 1', '2000', '111222333');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
