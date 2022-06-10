-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31-Maio-2022 às 06:12
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vtes_2022`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `vtessets`
--
DROP TABLE IF EXISTS `vtessets`;

CREATE TABLE `vtessets` (
  `COL 1` varchar(6) DEFAULT NULL,
  `COL 2` varchar(7) DEFAULT NULL,
  `COL 3` varchar(12) DEFAULT NULL,
  `COL 4` varchar(29) DEFAULT NULL,
  `COL 5` varchar(35) DEFAULT NULL,
  `COL 6` varchar(2) DEFAULT NULL,
  `COL 7` int(8) DEFAULT NULL,
  `COL 8` varchar(13) DEFAULT NULL,
  `COL 9` varchar(35) DEFAULT NULL,
  `COL 10` varchar(2) DEFAULT NULL,
  `COL 11` int(8) DEFAULT NULL,
  `COL 12` varchar(14) DEFAULT NULL,
  `COL 13` varchar(35) DEFAULT NULL,
  `COL 14` varchar(9) DEFAULT NULL,
  `COL 15` int(8) DEFAULT NULL,
  `COL 16` varchar(9) DEFAULT NULL,
  `COL 17` varchar(24) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `vtessets`
--

INSERT INTO `vtessets` (`COL 1`, `COL 2`, `COL 3`, `COL 4`, `COL 5`, `COL 6`, `COL 7`, `COL 8`, `COL 9`, `COL 10`, `COL 11`, `COL 12`, `COL 13`, `COL 14`, `COL 15`, `COL 16`, `COL 17`) VALUES
('Id', 'Abbrev', 'Release Date', 'Full Name', 'Company', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300001', 'Jyhad', '19940816', 'Jyhad', 'Wizards of the Coast', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300002', 'VTES', '19950915', 'Vampire: The Eternal Struggle', 'Wizards of the Coast', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300003', 'DS', '19951215', 'Dark Sovereigns', 'Wizards of the Coast', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300004', 'AH', '19960529', 'Ancient Hearts', 'Wizards of the Coast', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300005', 'Sabbat', '19961028', 'Sabbat', 'Wizards of the Coast', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300006', 'SW', '20001031', 'Sabbat War', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300007', 'FN', '20010611', 'Final Nights', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300008', 'BL', '20011203', 'Bloodlines', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300009', 'CE', '20020819', 'Camarilla Edition', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300010', 'Anarchs', '20030519', 'Anarchs', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300011', 'BH', '20031117', 'Black Hand', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300012', 'Gehenna', '20040517', 'Gehenna', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300013', 'Tenth', '20041213', 'Tenth Anniversary', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300014', 'KMW', '20050221', 'Kindred Most Wanted', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300015', 'LoB', '20051114', 'Legacies of Blood', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300016', 'NoR', '20060410', 'Nights of Reckoning', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300017', 'Third', '20060904', 'Third Edition', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300018', 'SoC', '20070319', 'Sword of Caine', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300019', 'LotN', '20070926', 'Lords of the Night', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300020', 'BSC', '20080414', 'Blood Shadowed Court', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300021', 'TR', '20080528', 'Twilight Rebellion', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300022', 'KoT', '20081119', 'Keepers of Tradition', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300023', 'EK', '20090527', 'Ebony Kingdom', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300024', 'HttB', '20100203', 'Heirs to the Blood', 'White Wolf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300025', 'DM', '20131005', 'Danse Macabre', 'White Wolf Entertainment AB \n300026', 'TU', 20141004, 'The Unaligned', 'White Wolf Entertainment AB \n300027', 'AU', 20160117, 'Anarch Unbound', 'White Wolf Entertainment AB \n300028', 'Anthology', 20170511, 'Anthology', 'White Wolf Publishing AB'),
('300029', 'LK', '20180609', 'Lost Kindred', 'White Wolf Entertainment AB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300030', 'SP', '20190216', 'Sabbat Preconstructed', 'White Wolf Entertainment AB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300031', '25th', '20190816', 'Twenty-Fifth Anniversary', 'White Wolf Entertainment AB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300032', 'FB', '20191001', 'First Blood', 'White Wolf Entertainment AB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300033', 'V5', '20201130', 'Fifth Edition', 'Paradox Interactive AB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('300034', 'V5A', '20211201', 'Fifth Edition (Anarch)', 'Paradox Interactive AB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
