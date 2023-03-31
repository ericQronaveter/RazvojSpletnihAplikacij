SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `vaja1`
--
CREATE DATABASE IF NOT EXISTS `vaja1` DEFAULT CHARACTER SET utf8 COLLATE utf8_slovenian_ci;
USE `vaja1`;

-- --------------------------------------------------------

--
-- Struktura tabele `ads`
--

DROP TABLE IF EXISTS `ads`;
CREATE TABLE IF NOT EXISTS `ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_slovenian_ci NOT NULL,
  `description` text COLLATE utf8_slovenian_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` text COLLATE utf8_slovenian_ci NOT NULL,
  `views` int(11) NOT NULL,
  `date` DATE NOT NULL,
  `price` DOUBLE NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

INSERT INTO category (name) VALUES ('Računalništvo');
INSERT INTO category (name) VALUES ('Avto-moto');
INSERT INTO category (name) VALUES ('Šport');
INSERT INTO category (name) VALUES ('Dom');
INSERT INTO category (name) VALUES ('Telefonija');
INSERT INTO category (name) VALUES ('Gradnja');
INSERT INTO category (name) VALUES ('Oblačila-pobutev');
INSERT INTO category (name) VALUES ('Fotografija');
INSERT INTO category (name) VALUES ('Knjige');

-- --------------------------------------------------------

--
-- Struktura tabele `category_ads`
--

DROP TABLE IF EXISTS `categoryAd`;
CREATE TABLE IF NOT EXISTS `categoryAd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idAd` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

ALTER TABLE categoryAd
ADD CONSTRAINT FK_Ads
FOREIGN KEY (idAd) REFERENCES ads(id);

ALTER TABLE categoryAd
ADD CONSTRAINT FK_Category
FOREIGN KEY (idCategory) REFERENCES category(id);

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE utf8_slovenian_ci NOT NULL,
  `password` text COLLATE utf8_slovenian_ci NOT NULL,
  `email` text COLLATE utf8_slovenian_ci NOT NULL,
  `address` text COLLATE utf8_slovenian_ci,
  `postNumber` text COLLATE utf8_slovenian_ci,
  `phoneNumber` text COLLATE utf8_slovenian_ci,
  `isAdmin` BIT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
