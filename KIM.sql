--
-- Database: `KIM`
--

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------

BEGIN;
DROP DATABASE IF EXISTS `KIM`;
CREATE DATABASE `KIM`;
COMMIT;

USE `KIM`;


-- --------------------------------------------------------
--
-- Struttura della tabella `Appointment`
--

DROP TABLE IF EXISTS `Appointment`;
CREATE TABLE `Appointment` (
  `Id_Appointment` int(11) NOT NULL AUTO_INCREMENT,
  `DateRequest` date DEFAULT NULL,
  `Doctor` varchar(16) NOT NULL,
  `Patient` varchar(16) NOT NULL,
  `DateTime` datetime NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '0',
  `Request` blob,
  PRIMARY KEY (`Id_Appointment`),
  FOREIGN KEY(`Doctor`) REFERENCES `Doctor`(`CodFiscale`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(`Patient`) REFERENCES `Patient`(`CodFiscale`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Dump dei dati per la tabella `Appointment`
--

INSERT INTO `Appointment` (`Id_Appointment`, `DateRequest`, `Doctor`, `Patient`, `DateTime`, `Status`, `Request`) VALUES
(4, '2013-12-27', 'BNCGMR90P17A657I', 'RSSMRA80P10A345W', '2014-01-25 17:00:00', 1, NULL),
(9, '2013-12-28', 'BNCGMR90P17A657I', 'RSSMRA80P10A345W', '2014-01-25 17:05:00', 2, NULL),
(12, NULL, 'BNCGMR90P17A657I', 'GLLFRN66P10A456I', '2014-01-21 10:20:00', 2, NULL),
(13, NULL, 'BNCGMR90P17A657I', 'AMRJNF87P59P345Y', '2014-01-20 11:00:00', 2, NULL),
(14, NULL, 'BNCGMR90P17A657I', 'MRCBND77P06A345I', '2014-01-18 15:00:00', 2, NULL),
(15, NULL, 'BNCGMR90P17A657I', 'BNCGSP90P12A456R', '2014-01-17 18:00:00', 2, NULL),
(16, NULL, 'BNCGMR90P17A657I', 'VRDLCU50P12Q345A', '2014-01-17 19:00:00', 2, NULL),
(17, NULL, 'BNCGMR90P17A657I', 'RSSMRA75R55E821L', '2014-01-17 18:30:00', 2, NULL),
(21, NULL, 'BNCGMR90P17A657I', 'RNCLRI82G45P908A', '2014-01-13 18:00:00', 2, NULL),
(22, NULL, 'BNCGMR90P17A657I', 'BRDLRN00P59A234Q', '2014-01-28 10:00:00', 2, NULL),
(49, '2014-01-13', 'BNCGMR90P17A657I', 'CROMRA95P45A234Y', '2014-01-20 10:00:00', 0, 0x3c7374726f6e673e4d617261204f6372613c2f7374726f6e673e206861207363726974746f3a3c62723e566f7272656920756e20617070756e74616d656e746f2e3c6272202f3e0d0a42756f6e612067696f726e6174612e3c62723e3c62723e);

-- --------------------------------------------------------

--
-- Struttura della tabella `Doctor`
--

DROP TABLE IF EXISTS `Doctor`;
CREATE TABLE `Doctor` (
  `CodFiscale` varchar(16) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Surname` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Phone` varchar(40) NOT NULL,
  `Birthday` date NOT NULL,
  `Specialization` varchar(50) NOT NULL,
  PRIMARY KEY (`CodFiscale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `Doctor`
--

INSERT INTO `Doctor` (`CodFiscale`, `Password`, `Name`, `Surname`, `Email`, `Phone`, `Birthday`, `Specialization`) VALUES
('BNCGMR90P17A657I', '636808073f1b055d7390df5304bf2b8635661584', 'Giamir', 'Buoncristiani', 'giamir.buoncristiani@gmail.com', '3489340938', '1990-09-17', 'Oncologo');

-- --------------------------------------------------------

--
-- Struttura della tabella `Patient`
--

DROP TABLE IF EXISTS `Patient`;
CREATE TABLE `Patient` (
  `CodFiscale` varchar(16) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Surname` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Phone` varchar(40) NOT NULL,
  `Birthday` date NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `Address` varchar(50) DEFAULT NULL,
  `City` varchar(40) DEFAULT NULL,
  `Province` varchar(40) DEFAULT NULL,
  `Region` varchar(50) DEFAULT NULL,
  `CAP` int(5) DEFAULT NULL,
  PRIMARY KEY (`CodFiscale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `Patient`
--

INSERT INTO `Patient` (`CodFiscale`, `Password`, `Name`, `Surname`, `Email`, `Phone`, `Birthday`, `Gender`, `Address`, `City`, `Province`, `Region`, `CAP`) VALUES
('AMRJNF87P59P345Y', 'a41074d9203796c4a0e585ccb4cfe5ecfbc92b3a', 'Jennifer', 'Amaranti', 'jennifer.amaranti@gmail.com', '3471234567', '1987-11-29', 'F', 'Via dell''Albero, 100', 'Scandicci', 'Firenze', 'Toscana', 55679),
('BNCGSP90P12A456R', 'd592a74473ae301f92f9d6167081198b563ab099', 'Giuseppe', 'Bianchi', 'g.bianchi@gmail.com', '3421234567', '1990-02-12', 'M', 'Via del Pino, 35', 'San Giuliano Terme', 'Pisa', 'Toscana', 50043),
('BRDLRN00P59A234Q', '0a7e3d8afad2439cdd85e5a367fd3ba428f5e8ed', 'Eleonora', 'Bordeaux', 'eleonora.bordeaux@yahoo.org', '3423456787', '2000-01-01', 'F', 'Via Diotisalvi, 10', 'Pisa', 'Pisa', 'Toscana', 56529),
('CROMRA95P45A234Y', 'd97757476a6f679abcab8d58ac1969d9edc3788e', 'Mara', 'Ocra', 'mara.ocra@gmail.com', '325765435', '1995-09-05', 'F', '', '', '', '', 0),
('GLLFRN66P10A456I', '3b098f7810aeac7e34e8fd89558358bf96fa9063', 'Francesco', 'Gialli', 'francesco.gialli@yahoo.it', '3201234567', '1966-06-30', 'M', 'Via dell''Albero, 234', 'Bagnoli', 'Napoli', 'Campania', 76543),
('MRCBND77P06A345I', '67edb5f828cc789a0be92aa392123af47aaae5a2', 'Marco', 'Benedetti', 'marco.benedetti@gmail.com', '321654325', '1977-10-06', 'M', 'Via Dante, 54', 'Arezzo', 'Arezzo', 'Toscana', 54321),
('NCCFRN95P29O987A', '555b4af6b8cc428acf3716c59f0f9841c4eb403f', 'Francesco', 'Nocciola', 'francesco.nocciola@gmail.com', '3247654323', '1995-09-29', 'M', 'Via Leopardi, 4', 'Figline', 'Arezzo', 'Toscana', 45683),
('RNCLRI82G45P908A', '7e8a2dac6a6dea69ac399c179214af4f5fae8255', 'Ilaria', 'Arancioni', 'ilaria.arancioni@gmail.com', '3409876543', '1982-07-05', 'F', 'Via Sbarra, 7', 'Livorno', 'Livorno', 'Toscana', 53654),
('RSSMRA75R55E821L', '2fe50530d1ff21dbbc46b986aa13845e941abe75', 'Maria', 'Rossi', 'm.rossi@live.com', '3401234567', '1975-06-15', 'F', 'Via Dante, 35', 'Altopascio', 'LU', 'Toscana', 55010),
('RSSMRA80P10A345W', 'be55c124b784f5c98c7abacc6fea28b3de6cb7d5', 'Mario', 'Rossi', 'mario.rossi@yahoo.it', '3492345678', '1980-01-10', 'M', 'Via Dante, 35', 'Firenze', 'Firenze', 'Toscana', 50050),
('VRDLCU50P12Q345A', 'c404d938dda181d1e6ce615669765960aec1827c', 'Luca', 'Verdi', 'luca.verdi@yahoo.it', '3240987652', '1950-10-12', 'M', 'Via Sql, 404', 'Lucca', 'Lucca', 'Toscana', 55100);

-- --------------------------------------------------------

--
-- Struttura della tabella `Visit`
--

DROP TABLE IF EXISTS `Visit`;
CREATE TABLE `Visit` (
  `Id_Visit` int(11) NOT NULL AUTO_INCREMENT,
  `Doctor` varchar(16) NOT NULL,
  `Patient` varchar(16) NOT NULL,
  `DateTime` datetime NOT NULL,
  `Diagnosi` blob,
  `Ricetta` blob,
  PRIMARY KEY (`Id_Visit`),
  FOREIGN KEY(`Doctor`) REFERENCES `Doctor`(`CodFiscale`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(`Patient`) REFERENCES `Patient`(`CodFiscale`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dump dei dati per la tabella `Visit`
--

INSERT INTO `Visit` (`Id_Visit`, `Doctor`, `Patient`, `DateTime`, `Diagnosi`, `Ricetta`) VALUES
(14, 'BNCGMR90P17A657I', 'AMRJNF87P59P345Y', '2013-12-05 13:00:00', 0x446961676e6f7369, 0x52696365747461),
(15, 'BNCGMR90P17A657I', 'RSSMRA80P10A345W', '2014-01-07 14:00:00', 0x4c6120446961676e6f736921, 0x4c612052696365747461),
(16, 'BNCGMR90P17A657I', 'GLLFRN66P10A456I', '2012-06-07 15:00:00', 0x50726f7661200d0a0d0a41206361706f, 0x52696365747461),
(29, 'BNCGMR90P17A657I', 'AMRJNF87P59P345Y', '2014-01-09 17:42:00', 0x70726f7661, 0x4c61207269636574746121);

-- --------------------------------------------------------

--
-- Struttura della tabella `istat_province`
--

DROP TABLE IF EXISTS `istat_province`;
CREATE TABLE `istat_province` (
  `codice_regione` varchar(14) DEFAULT NULL,
  `codice_provincia` varchar(16) NOT NULL DEFAULT '',
  `nome_provincia` varchar(28) DEFAULT NULL,
  `sigla_provincia` varchar(21) NOT NULL DEFAULT '',
  PRIMARY KEY (`codice_provincia`),
  UNIQUE KEY `codice_regione` (`codice_regione`,`codice_provincia`,`nome_provincia`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `istat_province`
--

INSERT INTO `istat_province` (`codice_regione`, `codice_provincia`, `nome_provincia`, `sigla_provincia`) VALUES
('01', '001', 'Torino', 'TO'),
('01', '002', 'Vercelli', 'VC'),
('01', '003', 'Novara', 'NO'),
('01', '004', 'Cuneo', 'CN'),
('01', '005', 'Asti', 'AT'),
('01', '006', 'Alessandria', 'AL'),
('01', '096', 'Biella', 'BI'),
('01', '103', 'Verbano-Cusio-Ossola', 'VB'),
('02', '007', 'Valle d''Aosta', 'AO'),
('03', '012', 'Varese', 'VA'),
('03', '013', 'Como', 'CO'),
('03', '014', 'Sondrio', 'SO'),
('03', '015', 'Milano', 'MI'),
('03', '016', 'Bergamo', 'BG'),
('03', '017', 'Brescia', 'BS'),
('03', '018', 'Pavia', 'PV'),
('03', '019', 'Cremona', 'CR'),
('03', '020', 'Mantova', 'MN'),
('03', '097', 'Lecco', 'LC'),
('03', '098', 'Lodi', 'LO'),
('03', '108', 'Monza e della Brianza', 'MB'),
('04', '021', 'Bolzano', 'BZ'),
('04', '022', 'Trento', 'TN'),
('05', '023', 'Verona', 'VR'),
('05', '024', 'Vicenza', 'VI'),
('05', '025', 'Belluno', 'BL'),
('05', '026', 'Treviso', 'TV'),
('05', '027', 'Venezia', 'VE'),
('05', '028', 'Padova', 'PD'),
('05', '029', 'Rovigo', 'RO'),
('06', '030', 'Udine', 'UD'),
('06', '031', 'Gorizia', 'GO'),
('06', '032', 'Trieste', 'TS'),
('06', '093', 'Pordenone', 'PN'),
('07', '008', 'Imperia', 'IM'),
('07', '009', 'Savona', 'SV'),
('07', '010', 'Genova', 'GE'),
('07', '011', 'La Spezia', 'SP'),
('08', '033', 'Piacenza', 'PC'),
('08', '034', 'Parma', 'PR'),
('08', '035', 'Reggio nell''Emilia', 'RE'),
('08', '036', 'Modena', 'MO'),
('08', '037', 'Bologna', 'BO'),
('08', '038', 'Ferrara', 'FE'),
('08', '039', 'Ravenna', 'RA'),
('08', '040', 'Forl', 'FC'),
('08', '099', 'Rimini', 'RN'),
('09', '045', 'Massa-Carrara', 'MS'),
('09', '046', 'Lucca', 'LU'),
('09', '047', 'Pistoia', 'PT'),
('09', '048', 'Firenze', 'FI'),
('09', '049', 'Livorno', 'LI'),
('09', '050', 'Pisa', 'PI'),
('09', '051', 'Arezzo', 'AR'),
('09', '052', 'Siena', 'SI'),
('09', '053', 'Grosseto', 'GR'),
('09', '100', 'Prato', 'PO'),
('10', '054', 'Perugia', 'PG'),
('10', '055', 'Terni', 'TR'),
('11', '041', 'Pesaro e Urbino', 'PU'),
('11', '042', 'Ancona', 'AN'),
('11', '043', 'Macerata', 'MC'),
('11', '044', 'Ascoli Piceno', 'AP'),
('11', '109', 'Fermo', 'FM'),
('12', '056', 'Viterbo', 'VT'),
('12', '057', 'Rieti', 'RI'),
('12', '058', 'Roma', 'RM'),
('12', '059', 'Latina', 'LT'),
('12', '060', 'Frosinone', 'FR'),
('13', '066', 'L''Aquila', 'AQ'),
('13', '067', 'Teramo', 'TE'),
('13', '068', 'Pescara', 'PE'),
('13', '069', 'Chieti', 'CH'),
('14', '070', 'Campobasso', 'CB'),
('14', '094', 'Isernia', 'IS'),
('15', '061', 'Caserta', 'CE'),
('15', '062', 'Benevento', 'BN'),
('15', '063', 'Napoli', 'NA'),
('15', '064', 'Avellino', 'AV'),
('15', '065', 'Salerno', 'SA'),
('16', '071', 'Foggia', 'FG'),
('16', '072', 'Bari', 'BA'),
('16', '073', 'Taranto', 'TA'),
('16', '074', 'Brindisi', 'BR'),
('16', '075', 'Lecce', 'LE'),
('16', '110', 'Barletta-Andria-Trani', 'BT'),
('17', '076', 'Potenza', 'PZ'),
('17', '077', 'Matera', 'MT'),
('18', '078', 'Cosenza', 'CS'),
('18', '079', 'Catanzaro', 'CZ'),
('18', '080', 'Reggio di Calabria', 'RC'),
('18', '101', 'Crotone', 'KR'),
('18', '102', 'Vibo Valentia', 'VV'),
('19', '081', 'Trapani', 'TP'),
('19', '082', 'Palermo', 'PA'),
('19', '083', 'Messina', 'ME'),
('19', '084', 'Agrigento', 'AG'),
('19', '085', 'Caltanissetta', 'CL'),
('19', '086', 'Enna', 'EN'),
('19', '087', 'Catania', 'CT'),
('19', '088', 'Ragusa', 'RG'),
('19', '089', 'Siracusa', 'SR'),
('20', '090', 'Sassari', 'SS'),
('20', '091', 'Nuoro', 'NU'),
('20', '092', 'Cagliari', 'CA'),
('20', '095', 'Oristano', 'OR'),
('20', '104', 'Olbia-Tempio', 'OT'),
('20', '105', 'Ogliastra', 'OG'),
('20', '106', 'Medio Campidano', 'VS'),
('20', '107', 'Carbonia-Iglesias', 'CI');

-- --------------------------------------------------------

--
-- Struttura della tabella `istat_regioni`
--

DROP TABLE IF EXISTS `istat_regioni`;
CREATE TABLE `istat_regioni` (
  `codice_regione` varchar(255) NOT NULL,
  `nome_regione` varchar(255) NOT NULL,
  PRIMARY KEY (`codice_regione`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `istat_regioni`
--

INSERT INTO `istat_regioni` (`codice_regione`, `nome_regione`) VALUES
('01', 'Piemonte'),
('02', 'Valle d''Aosta'),
('03', 'Lombardia'),
('04', 'Trentino-Alto Adige'),
('05', 'Veneto'),
('06', 'Friuli-Venezia Giulia'),
('07', 'Liguria'),
('08', 'Emilia-Romagna'),
('09', 'Toscana'),
('10', 'Umbria'),
('11', 'Marche'),
('12', 'Lazio'),
('13', 'Abruzzo'),
('14', 'Molise'),
('15', 'Campania'),
('16', 'Puglia'),
('17', 'Basilicata'),
('18', 'Calabria'),
('19', 'Sicilia'),
('20', 'Sardegna');

-- --------------------------------------------------------


--
-- Struttura del trigger per la rimozione degli appuntamenti scaduti
--

CREATE EVENT `RimuoviAppuntamento`
ON SCHEDULE EVERY 1 DAY
DO
DELETE FROM `Appointment`
WHERE DATE(`DateTime`) < DATE(NOW());


SET FOREIGN_KEY_CHECKS = 1;
SET GLOBAL EVENT_SCHEDULER = ON;
