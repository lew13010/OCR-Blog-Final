-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 10 Juillet 2016 à 11:46
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(63) NOT NULL DEFAULT '0',
  `mdp` varchar(127) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`id`, `pseudo`, `mdp`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(127) DEFAULT NULL,
  `contenu` text,
  `auteur` varchar(63) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id`, `titre`, `contenu`, `auteur`, `date`) VALUES
(2, 'Titre2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem deleniti ea eaque, fugiat fugit impedit incidunt ipsum mollitia porro quo repudiandae sequi sit suscipit tempora tempore unde ut voluptas voluptatibus.', 'Loic', '2016-06-29 13:38:52'),
(3, 'Titre3', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem deleniti ea eaque, fugiat fugit impedit incidunt ipsum mollitia porro quo repudiandae sequi sit suscipit tempora tempore unde ut voluptas voluptatibus.', 'Loic', '2016-06-29 13:40:52'),
(4, 'Titre4', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem deleniti ea eaque, fugiat fugit impedit incidunt ipsum mollitia porro quo repudiandae sequi sit suscipit tempora tempore unde ut voluptas voluptatibus.', 'Loic', '2016-06-29 14:42:27'),
(5, 'Titre5', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem deleniti ea eaque, fugiat fugit impedit incidunt ipsum mollitia porro quo repudiandae sequi sit suscipit tempora tempore unde ut voluptas voluptatibus.', 'Loic', '2016-06-29 14:42:27'),
(7, 'titre1', 'Lorem ipsum token', 'Moi', '2016-06-30 10:34:21');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(63) DEFAULT '0',
  `email` varchar(127) DEFAULT '0',
  `contenu` text NOT NULL,
  `id_articles` int(11) NOT NULL DEFAULT '0',
  `date_com` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `valide` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `pseudo`, `email`, `contenu`, `id_articles`, `date_com`, `valide`) VALUES
(2, 'test', 'a@b.com', 'sdlghfqsljdhfsqd', 1, '2016-06-29 14:50:00', '0'),
(5, 'Loic', 'a@a.com', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquam aut earum enim labore molestias natus neque quia repudiandae similique sint temporibus unde, voluptatem. Aspernatur consequuntur iusto necessitatibus voluptatem voluptates.', 1, '2016-06-29 15:14:32', '0'),
(6, '', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus ea earum esse modi nobis! Architecto atque, cumque debitis dolorem enim eos error expedita neque, placeat praesentium quis, quod ut voluptatem.', 2, '2016-06-29 15:16:14', '0'),
(7, 'test', 'dormeur12h@hotmail.com', 'test gravatar token', 2, '2016-06-29 15:48:54', '0');

-- --------------------------------------------------------

--
-- Structure de la table `mod_com`
--

CREATE TABLE IF NOT EXISTS `mod_com` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mod` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `mod_com`
--

INSERT INTO `mod_com` (`id`, `mod`) VALUES
(1, '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
