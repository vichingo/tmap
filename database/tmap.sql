-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 14 Jun 2010 om 00:44
-- Serverversie: 5.1.36
-- PHP-Versie: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tmap`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestanddeel`
--

CREATE TABLE IF NOT EXISTS `bestanddeel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) DEFAULT NULL,
  `code` int(3) unsigned DEFAULT NULL COMMENT 'ndb code',
  `prijs` decimal(4,2) DEFAULT NULL,
  `voedsel_categorie_id` int(3) NOT NULL,
  PRIMARY KEY (`id`,`voedsel_categorie_id`),
  KEY `fk_bestanddeel_voedsel_categorie1` (`voedsel_categorie_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestanddeel`
--

INSERT INTO `bestanddeel` (`id`, `naam`, `code`, `prijs`, `voedsel_categorie_id`) VALUES
(44, 'Broccoli', 77, '0.75', 1),
(50, 'Artisjok', 100, '0.75', 1),
(49, 'Alfalfa(Luzerne scheuten)', 611, '0.75', 1),
(51, 'Champignons', 100, '0.75', 1),
(52, 'Ui', 100, '0.75', 1),
(53, 'Olijven', 100, '0.75', 1),
(54, 'Doperwten', 100, '0.75', 1),
(55, 'Ui (rood)', 100, '0.75', 1),
(56, 'Tomatensaus', 100, '0.25', 1),
(57, 'Kaas (basis)', 100, '0.50', 5),
(58, 'Ham', 163, '2.50', 3),
(59, 'Salami', 162, '2.50', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestellijn_gerecht_opties`
--

CREATE TABLE IF NOT EXISTS `bestellijn_gerecht_opties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gerecht_opties_id` int(3) NOT NULL,
  `bestellijn_id` int(3) NOT NULL,
  PRIMARY KEY (`id`,`gerecht_opties_id`,`bestellijn_id`),
  KEY `fk_bestellijn_gerecht_opties_bestelling_lijn1` (`bestellijn_id`),
  KEY `fk_bestellijn_gerecht_opties_gerecht_opties1` (`gerecht_opties_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestellijn_gerecht_opties`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling`
--

CREATE TABLE IF NOT EXISTS `bestelling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `besteltijd` int(11) DEFAULT NULL COMMENT 'unix timestamp',
  `levertijd` int(11) DEFAULT NULL,
  `bestelling_nummer` int(11) NOT NULL,
  `leverwijze_id` datetime NOT NULL,
  PRIMARY KEY (`id`,`leverwijze_id`),
  KEY `fk_bestelling_klant_bestelling1` (`id`),
  KEY `fk_bestelling_leverwijze1` (`leverwijze_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestelling`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling_gerecht`
--

CREATE TABLE IF NOT EXISTS `bestelling_gerecht` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gerecht_id` int(11) NOT NULL,
  `bestelling_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`bestelling_id`,`gerecht_id`),
  KEY `fk_bestelling_gerecht_bestelling1` (`bestelling_id`),
  KEY `fk_bestelling_gerecht_gerecht1` (`gerecht_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestelling_gerecht`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling_lijn`
--

CREATE TABLE IF NOT EXISTS `bestelling_lijn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bestelling_id` int(3) NOT NULL,
  `gerecht_id` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`,`bestelling_id`),
  KEY `fk_bestelling_lijn_bestelling1` (`bestelling_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestelling_lijn`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE IF NOT EXISTS `gebruikers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) DEFAULT NULL,
  `login_naam` varchar(45) DEFAULT NULL,
  `login_wachtwoord` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `gebruikers`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht`
--

CREATE TABLE IF NOT EXISTS `gerecht` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `naam` tinytext NOT NULL,
  `code` varchar(4) NOT NULL,
  `basisprijs` decimal(3,2) NOT NULL,
  `omschrijving` mediumtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`menu_id`),
  KEY `fk_gerecht_menu1` (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `gerecht`
--

INSERT INTO `gerecht` (`id`, `menu_id`, `naam`, `code`, `basisprijs`, `omschrijving`, `image`) VALUES
(1, 4, 'Pizza Prosciutto', '1001', '8.00', 'simpele ham pizza', 'Pizza_Prosciutto.jpg'),
(2, 4, 'Pizza Salami', '1002', '8.00', 'simpele salami pizza', 'Pizza_Salami.jpg'),
(4, 4, 'Pizza Quattro Formaggio', '1004', '9.00', 'Pizza met 4 verschillende kazen', 'Pizza_Quattro_Stagioni.jpg'),
(5, 0, '', '', '0.00', '', ''),
(6, 0, '', '', '0.00', '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht_bestanddeel`
--

CREATE TABLE IF NOT EXISTS `gerecht_bestanddeel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gerecht_id` int(11) NOT NULL,
  `bestanddeel_id` int(11) NOT NULL,
  `op_basis` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`,`gerecht_id`,`bestanddeel_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Gegevens worden uitgevoerd voor tabel `gerecht_bestanddeel`
--

INSERT INTO `gerecht_bestanddeel` (`id`, `gerecht_id`, `bestanddeel_id`, `op_basis`) VALUES
(1, 1, 56, 1),
(2, 1, 57, 1),
(3, 1, 58, 1),
(4, 2, 56, 1),
(5, 2, 57, 1),
(6, 2, 59, 1),
(7, 4, 0, 0),
(8, 4, 0, 0),
(9, 4, 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht_gerecht_opties`
--

CREATE TABLE IF NOT EXISTS `gerecht_gerecht_opties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gerecht_id` int(3) NOT NULL,
  `gerecht_optie_id` int(3) NOT NULL,
  PRIMARY KEY (`id`,`gerecht_id`,`gerecht_optie_id`),
  KEY `fk_gerecht_gerecht_opties_gerecht_opties1` (`gerecht_optie_id`),
  KEY `fk_gerecht_gerecht_opties_gerecht_bestanddeel1` (`gerecht_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `gerecht_gerecht_opties`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht_opties`
--

CREATE TABLE IF NOT EXISTS `gerecht_opties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `gerecht_opties`
--

INSERT INTO `gerecht_opties` (`id`, `naam`) VALUES
(1, 'Grootte'),
(2, 'Vorm');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `in_seizoen`
--

CREATE TABLE IF NOT EXISTS `in_seizoen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bestanddeel_id` int(3) NOT NULL,
  `maand` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`,`bestanddeel_id`),
  KEY `fk_in_seizoen_bestanddeel1` (`bestanddeel_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `in_seizoen`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

CREATE TABLE IF NOT EXISTS `klant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wachtwoord` varchar(45) DEFAULT NULL,
  `achternaam` varchar(200) NOT NULL,
  `voornaam` varchar(45) NOT NULL,
  `straat` varchar(45) NOT NULL,
  `straat_nummer` varchar(45) NOT NULL,
  `nummer_bus` varchar(45) DEFAULT NULL,
  `lokatie_id` int(15) NOT NULL,
  `tel_vast` varchar(45) DEFAULT NULL,
  `tel_gsm` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `aanmaakdatum` int(11) DEFAULT NULL,
  `geblokkeerd` tinyint(1) DEFAULT NULL COMMENT 'Heeft klant alle openstaande rekeningen betaald?\n',
  `promotie` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`,`lokatie_id`),
  KEY `fk_klant_klant_bestelling1` (`id`),
  KEY `fk_klant_lokatie1` (`lokatie_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Deze tabel bevat de gegevens over de klanten' AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `klant`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant_bestelling`
--

CREATE TABLE IF NOT EXISTS `klant_bestelling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klant_id` int(11) unsigned NOT NULL,
  `bestelling_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`,`klant_id`,`bestelling_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `klant_bestelling`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leveren_in`
--

CREATE TABLE IF NOT EXISTS `leveren_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lokatie_id` int(11) NOT NULL,
  `resto_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`lokatie_id`,`resto_id`),
  KEY `fk_leveren_in_lokatie1` (`lokatie_id`),
  KEY `fk_leveren_in_resto1` (`resto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `leveren_in`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leverwijze`
--

CREATE TABLE IF NOT EXISTS `leverwijze` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `leverwijze`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lijn_bestanddeel`
--

CREATE TABLE IF NOT EXISTS `lijn_bestanddeel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bestelling_lijn_id` int(3) NOT NULL,
  `gerecht_bestanddeel_id` int(3) NOT NULL,
  `optellen` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`,`gerecht_bestanddeel_id`,`bestelling_lijn_id`),
  KEY `fk_lijn_bestanddeel_bestelling_lijn1` (`bestelling_lijn_id`),
  KEY `fk_lijn_bestanddeel_gerecht_bestanddeel1` (`gerecht_bestanddeel_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `lijn_bestanddeel`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lokatie`
--

CREATE TABLE IF NOT EXISTS `lokatie` (
  `id` bigint(15) NOT NULL AUTO_INCREMENT,
  `alpha` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `longitude` decimal(12,10) DEFAULT NULL,
  `latitude` decimal(12,10) DEFAULT NULL,
  `code` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `provincie_id` bigint(15) NOT NULL DEFAULT '0',
  `lokatie_zonenummer_id` bigint(15) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`provincie_id`),
  KEY `code` (`code`),
  KEY `alpha` (`alpha`),
  KEY `fk_lokatie_klant` (`id`),
  KEY `fk_lokatie_provincie1` (`provincie_id`),
  KEY `region` (`provincie_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=14297 ;

--
-- Gegevens worden uitgevoerd voor tabel `lokatie`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lokatie_zonenummer`
--

CREATE TABLE IF NOT EXISTS `lokatie_zonenummer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lokatie_id` int(4) NOT NULL,
  `zonenummer_id` int(4) NOT NULL,
  PRIMARY KEY (`id`,`lokatie_id`,`zonenummer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Link tussen lokatie en de telefoon zonenummers\n' AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `lokatie_zonenummer`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) DEFAULT NULL,
  `menu_code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `menu`
--

INSERT INTO `menu` (`id`, `naam`, `menu_code`) VALUES
(4, 'Pizza''s', '1000'),
(2, 'Dranken', '2000');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menukaart`
--

CREATE TABLE IF NOT EXISTS `menukaart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resto_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`menu_id`,`resto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `menukaart`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `optie_variant`
--

CREATE TABLE IF NOT EXISTS `optie_variant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) DEFAULT NULL,
  `optie_id` int(3) NOT NULL,
  `matrix` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`id`,`optie_id`),
  KEY `fk_variant_gerecht_opties1` (`optie_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Gegevens worden uitgevoerd voor tabel `optie_variant`
--

INSERT INTO `optie_variant` (`id`, `naam`, `optie_id`, `matrix`) VALUES
(7, 'Medium', 1, '1.20'),
(5, 'Normaal', 1, '1.00'),
(8, 'Panpizza', 2, '1.20'),
(9, 'Napolitaans (Normaal)', 2, '1.00'),
(10, 'Large', 1, '1.50'),
(11, 'Stuffed crust', 2, '1.50');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `provincie`
--

CREATE TABLE IF NOT EXISTS `provincie` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Gegevens worden uitgevoerd voor tabel `provincie`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `resto`
--

CREATE TABLE IF NOT EXISTS `resto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) DEFAULT NULL,
  `taal` varchar(45) DEFAULT NULL,
  `lokatie_adres` varchar(45) DEFAULT NULL,
  `lokatie_id` varchar(45) NOT NULL,
  `leveringkosten_minimaal` decimal(3,2) NOT NULL,
  PRIMARY KEY (`id`,`lokatie_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Alle gegevens die te maken hebben met het restaurant' AUTO_INCREMENT=1 ;

--
-- Gegevens worden uitgevoerd voor tabel `resto`
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `voedsel_categorie`
--

CREATE TABLE IF NOT EXISTS `voedsel_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=13 ;

--
-- Gegevens worden uitgevoerd voor tabel `voedsel_categorie`
--

INSERT INTO `voedsel_categorie` (`id`, `naam`) VALUES
(1, 'Groente'),
(2, 'Kruiden en Specerijen'),
(3, 'Vlees'),
(4, 'Noten'),
(5, 'Kazen'),
(6, 'Zeevruchten'),
(12, 'Fruit');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `zonenummers`
--

CREATE TABLE IF NOT EXISTS `zonenummers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zonenummer` int(4) NOT NULL,
  `naam` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Gegevens worden uitgevoerd voor tabel `zonenummers`
--

