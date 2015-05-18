-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Gegenereerd op: 15 apr 2015 om 12:13
-- Serverversie: 5.6.20
-- PHP-versie: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `personeelsfeest`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerechten`
--

CREATE TABLE IF NOT EXISTS `gerechten` (
`id` smallint(11) NOT NULL,
  `naam_gerecht` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Gegevens worden geëxporteerd voor tabel `gerechten`
--

INSERT INTO `gerechten` (`id`, `naam_gerecht`, `type`) VALUES
(1, 'Tomatensoep', 'voorgerecht'),
(2, 'Tomaat-garnaal', 'voorgerecht'),
(3, 'Steak met frieten', 'hoofdgerecht'),
(4, 'Koolvis met tomaat', 'hoofdgerecht'),
(5, 'Dame Blanche', 'dessert'),
(6, 'Chocolademousse', 'dessert');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menukeuze`
--

CREATE TABLE IF NOT EXISTS `menukeuze` (
`id` int(11) NOT NULL,
  `id_personeel` int(11) NOT NULL,
  `voorgerecht` varchar(50) NOT NULL,
  `hoofdgerecht` varchar(50) NOT NULL,
  `dessert` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Gegevens worden geëxporteerd voor tabel `menukeuze`
--

INSERT INTO `menukeuze` (`id`, `id_personeel`, `voorgerecht`, `hoofdgerecht`, `dessert`) VALUES
(1, 2, 'Tomaat-garnaal', 'Steak met frieten', 'Dame Blanche');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `personeel`
--

CREATE TABLE IF NOT EXISTS `personeel` (
`id` int(11) NOT NULL,
  `voornaam` varchar(100) NOT NULL,
  `familienaam` varchar(150) NOT NULL,
  `mailadres` varchar(200) NOT NULL,
  `wachtwoord` varchar(250) NOT NULL,
  `gebruikerstype` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden geëxporteerd voor tabel `personeel`
--

INSERT INTO `personeel` (`id`, `voornaam`, `familienaam`, `mailadres`, `wachtwoord`, `gebruikerstype`) VALUES
(1, 'Glen', 'Lauwers', 'glenlauwers@hotmail.com', '123', 'webmaster'),
(2, 'Rina', 'Verheyden', 'rina@hotmail.com', '123', 'gebruiker');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `gerechten`
--
ALTER TABLE `gerechten`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `menukeuze`
--
ALTER TABLE `menukeuze`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `personeel`
--
ALTER TABLE `personeel`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gerechten`
--
ALTER TABLE `gerechten`
MODIFY `id` smallint(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT voor een tabel `menukeuze`
--
ALTER TABLE `menukeuze`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `personeel`
--
ALTER TABLE `personeel`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
