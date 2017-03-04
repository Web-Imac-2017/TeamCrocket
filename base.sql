CREATE TABLE IF NOT EXISTS `ajkl7_animal` (
  `id` int(10) unsigned NOT NULL,
  `creator_id` int(10) unsigned NOT NULL,
  `species_id` int(10) unsigned DEFAULT NULL,
  `cover_image_id` int(10) unsigned DEFAULT NULL,
  `profile_image_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(32) NOT NULL,
  `sex` char(1) NOT NULL DEFAULT 'm',
  `description` text NOT NULL,
  `info_like` varchar(64) NOT NULL,
  `info_dislike` varchar(64) NOT NULL,
  `date_birth` date DEFAULT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO `ajkl7_animal` (`id`, `creator_id`, `species_id`, `cover_image_id`, `profile_image_id`, `name`, `sex`, `description`, `info_like`, `info_dislike`, `date_birth`, `banned`, `creation_date`, `modification_date`, `active`) VALUES
(22, 140, 9, 64, 63, 'Totor', 'f', 'Totor est ma première golden retriever. C''est une chienne douce, affectueuse et une maman extraordinaire', '', '', '2013-03-07', 0, '2017-03-01 15:05:07', '2017-03-04 15:37:14', 1),
(24, 140, 17, 24, 66, 'Didier', 'm', 'Avec les gros sabots. Si on voit les marques, ou si on voit les logos de l''entreprise, pas de soucis !', 'Le droit', 'Les retards', '2010-03-07', 0, '2017-03-01 15:14:12', '2017-03-04 15:38:47', 1),
(26, 140, 6, 67, 68, 'Sully', 'f', 'J''adore mes maitres Anna et Dudule !', 'La sieste et les croquettes', '', '2017-01-01', 0, '2017-03-01 16:35:07', '2017-03-04 15:41:44', 1),
(27, 135, 9, 55, 57, 'Rex', 'm', '', 'Os', '', '2016-03-01', 0, '2017-03-01 16:35:43', '2017-03-04 15:29:26', 1),
(28, 140, 13, 29, 70, 'Lézio', 'm', 'Mort de rire', 'La chaleur et les jours d''été', '', '2015-06-12', 0, '2017-03-01 16:36:44', '2017-03-04 15:46:27', 1),
(29, 140, 14, 31, 71, 'Mado', 'f', '', 'La salade et le concombre', '', '2014-02-02', 0, '2017-03-01 16:38:46', '2017-03-04 15:47:36', 1),
(30, 141, 11, 33, NULL, 'Pouik', 'm', '', '', '', '1996-08-10', 0, '2017-03-01 16:42:27', '2017-03-01 16:44:50', 1),
(31, 135, 6, 37, 59, 'Tigrou', 'm', 'Chat adopté', 'Grenouilles', 'Herbe', '2008-05-09', 0, '2017-03-02 10:51:31', '2017-03-04 15:30:13', 1),
(32, 142, 17, NULL, 72, 'Michou', 'm', '', '', '', '1954-05-09', 0, '2017-03-04 13:20:01', '2017-03-04 15:53:13', 1),
(33, 143, 9, 74, 75, 'Albert', 'm', 'Jeune, doux, attentionné, cherche jeune damoiselle pour mes sorties à Pompidou.  \r\nTatouage sur la fesse gauche', 'La musique Indé', 'La faim dans le monde', '2016-02-02', 0, '2017-03-04 16:10:03', NULL, 1);

CREATE TABLE IF NOT EXISTS `ajkl7_animal_characteristic` (
  `animal_id` int(10) unsigned NOT NULL,
  `characteristic_id` int(10) unsigned NOT NULL,
  `value` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO `ajkl7_animal_characteristic` (`animal_id`, `characteristic_id`, `value`) VALUES
(22, 4, '0'),
(22, 5, '0'),
(22, 8, 'ééééé\\\\\\\\\\\\|@'),
(22, 9, ''),
(24, 4, '175'),
(24, 5, '80'),
(24, 8, 'Grognon'),
(24, 9, ''),
(26, 4, '30'),
(26, 5, '4'),
(26, 8, ''),
(26, 9, ''),
(27, 4, '20'),
(27, 5, '3'),
(27, 8, 'Timide'),
(27, 9, 'Croquettes'),
(28, 4, '40'),
(28, 5, '1'),
(28, 8, 'Fénéant'),
(28, 9, 'Les mouches et les araignées'),
(29, 4, '20'),
(29, 5, '1.5'),
(29, 8, ''),
(29, 9, ''),
(30, 4, '0'),
(30, 5, '0'),
(30, 8, ''),
(30, 9, ''),
(31, 4, '40'),
(31, 5, '2'),
(31, 8, 'Joueur'),
(31, 9, ''),
(32, 4, '170'),
(32, 5, '85'),
(32, 8, 'Joueur'),
(32, 9, ''),
(33, 4, '50'),
(33, 5, '4'),
(33, 8, 'sérieux'),
(33, 9, 'croquette végétarienne');

CREATE TABLE IF NOT EXISTS `ajkl7_animal_comment` (
  `id` int(10) unsigned NOT NULL,
  `animal_id` int(10) unsigned NOT NULL,
  `creator_id` int(10) unsigned NOT NULL,
  `content` varchar(255) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ajkl7_animal_gallery` (
  `animal_id` int(10) unsigned NOT NULL,
  `image_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ajkl7_animal_gallery` (`animal_id`, `image_id`) VALUES
(27, 50),
(28, 69);

CREATE TABLE IF NOT EXISTS `ajkl7_animal_match` (
  `animal_a_id` int(10) unsigned NOT NULL,
  `animal_b_id` int(10) unsigned NOT NULL,
  `interested` tinyint(1) NOT NULL,
  `date_swipe` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO `ajkl7_animal_match` (`animal_a_id`, `animal_b_id`, `interested`, `date_swipe`) VALUES
(27, 22, 1, '2017-03-04 15:54:58'),
(27, 24, 0, '2017-03-04 15:55:26'),
(27, 26, 1, '2017-03-04 15:55:05'),
(27, 28, 0, '2017-03-04 15:55:23'),
(27, 29, 0, '2017-03-04 15:55:08'),
(27, 30, 0, '2017-03-04 15:55:01'),
(27, 32, 0, '2017-03-04 15:55:12'),
(31, 22, 1, '2017-03-04 15:54:48'),
(31, 24, 1, '2017-03-04 15:54:17'),
(31, 26, 1, '2017-03-04 15:54:29'),
(31, 28, 0, '2017-03-04 15:54:51'),
(31, 29, 0, '2017-03-04 15:54:44'),
(31, 30, 0, '2017-03-04 15:54:40'),
(31, 32, 0, '2017-03-04 15:54:22');

CREATE TABLE IF NOT EXISTS `ajkl7_characteristic` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `common` tinyint(1) NOT NULL DEFAULT '0',
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO `ajkl7_characteristic` (`id`, `name`, `common`, `required`, `type`, `creation_date`, `modification_date`, `active`) VALUES
(4, 'Taille (cm)', 1, 0, 1, '2017-02-25 00:00:00', NULL, 1),
(5, 'Poids (kg)', 1, 0, 2, '2017-02-25 00:00:00', NULL, 1),
(6, 'Pelage', 0, 0, 0, '2017-02-25 00:00:00', NULL, 1),
(7, 'Robe', 0, 0, 0, '2017-02-25 00:00:00', NULL, 1),
(8, 'Caractère', 1, 0, 0, '2017-02-25 00:00:00', NULL, 1),
(9, 'Nourriture préférée', 1, 0, 0, '2017-02-25 00:00:00', NULL, 1),
(10, 'Jouet préféré', 0, 0, 0, '2017-02-26 00:00:00', NULL, 1);

CREATE TABLE IF NOT EXISTS `ajkl7_country` (
  `id` int(10) unsigned NOT NULL,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  `modification_date` datetime DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `ajkl7_country` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`, `modification_date`, `creation_date`, `active`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93, NULL, NULL, 1),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355, NULL, NULL, 1),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213, NULL, NULL, 1),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684, NULL, NULL, 1),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376, NULL, NULL, 1),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244, NULL, NULL, 1),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264, NULL, NULL, 1),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0, NULL, NULL, 1),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268, NULL, NULL, 1),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54, NULL, NULL, 1),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374, NULL, NULL, 1),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297, NULL, NULL, 1),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61, NULL, NULL, 1),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43, NULL, NULL, 1),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994, NULL, NULL, 1),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242, NULL, NULL, 1),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973, NULL, NULL, 1),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880, NULL, NULL, 1),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246, NULL, NULL, 1),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375, NULL, NULL, 1),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32, NULL, NULL, 1),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501, NULL, NULL, 1),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229, NULL, NULL, 1),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441, NULL, NULL, 1),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975, NULL, NULL, 1),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591, NULL, NULL, 1),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387, NULL, NULL, 1),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267, NULL, NULL, 1),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0, NULL, NULL, 1),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55, NULL, NULL, 1),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246, NULL, NULL, 1),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673, NULL, NULL, 1),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359, NULL, NULL, 1),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226, NULL, NULL, 1),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257, NULL, NULL, 1),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855, NULL, NULL, 1),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237, NULL, NULL, 1),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1, NULL, NULL, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238, NULL, NULL, 1),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345, NULL, NULL, 1),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236, NULL, NULL, 1),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235, NULL, NULL, 1),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56, NULL, NULL, 1),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86, NULL, NULL, 1),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61, NULL, NULL, 1),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672, NULL, NULL, 1),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57, NULL, NULL, 1),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269, NULL, NULL, 1),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242, NULL, NULL, 1),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242, NULL, NULL, 1),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682, NULL, NULL, 1),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506, NULL, NULL, 1),
(53, 'CI', 'COTE D''IVOIRE', 'Cote D''Ivoire', 'CIV', 384, 225, NULL, NULL, 1),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385, NULL, NULL, 1),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53, NULL, NULL, 1),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357, NULL, NULL, 1),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420, NULL, NULL, 1),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45, NULL, NULL, 1),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253, NULL, NULL, 1),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767, NULL, NULL, 1),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809, NULL, NULL, 1),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593, NULL, NULL, 1),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20, NULL, NULL, 1),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503, NULL, NULL, 1),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240, NULL, NULL, 1),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291, NULL, NULL, 1),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372, NULL, NULL, 1),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251, NULL, NULL, 1),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500, NULL, NULL, 1),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298, NULL, NULL, 1),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679, NULL, NULL, 1),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358, NULL, NULL, 1),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33, NULL, NULL, 1),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594, NULL, NULL, 1),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689, NULL, NULL, 1),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0, NULL, NULL, 1),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241, NULL, NULL, 1),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220, NULL, NULL, 1),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995, NULL, NULL, 1),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49, NULL, NULL, 1),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233, NULL, NULL, 1),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350, NULL, NULL, 1),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30, NULL, NULL, 1),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299, NULL, NULL, 1),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473, NULL, NULL, 1),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590, NULL, NULL, 1),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671, NULL, NULL, 1),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502, NULL, NULL, 1),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224, NULL, NULL, 1),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245, NULL, NULL, 1),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592, NULL, NULL, 1),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509, NULL, NULL, 1),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0, NULL, NULL, 1),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39, NULL, NULL, 1),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504, NULL, NULL, 1),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852, NULL, NULL, 1),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36, NULL, NULL, 1),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354, NULL, NULL, 1),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91, NULL, NULL, 1),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62, NULL, NULL, 1),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98, NULL, NULL, 1),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964, NULL, NULL, 1),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353, NULL, NULL, 1),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972, NULL, NULL, 1),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39, NULL, NULL, 1),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876, NULL, NULL, 1),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81, NULL, NULL, 1),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962, NULL, NULL, 1),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7, NULL, NULL, 1),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254, NULL, NULL, 1),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686, NULL, NULL, 1),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE''S REPUBLIC OF', 'Korea, Democratic People''s Republic of', 'PRK', 408, 850, NULL, NULL, 1),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82, NULL, NULL, 1),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965, NULL, NULL, 1),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996, NULL, NULL, 1),
(116, 'LA', 'LAO PEOPLE''S DEMOCRATIC REPUBLIC', 'Lao People''s Democratic Republic', 'LAO', 418, 856, NULL, NULL, 1),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371, NULL, NULL, 1),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961, NULL, NULL, 1),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266, NULL, NULL, 1),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231, NULL, NULL, 1),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218, NULL, NULL, 1),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423, NULL, NULL, 1),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370, NULL, NULL, 1),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352, NULL, NULL, 1),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853, NULL, NULL, 1),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389, NULL, NULL, 1),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261, NULL, NULL, 1),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265, NULL, NULL, 1),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60, NULL, NULL, 1),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960, NULL, NULL, 1),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223, NULL, NULL, 1),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356, NULL, NULL, 1),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692, NULL, NULL, 1),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596, NULL, NULL, 1),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222, NULL, NULL, 1),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230, NULL, NULL, 1),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269, NULL, NULL, 1),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52, NULL, NULL, 1),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691, NULL, NULL, 1),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373, NULL, NULL, 1),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377, NULL, NULL, 1),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976, NULL, NULL, 1),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664, NULL, NULL, 1),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212, NULL, NULL, 1),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258, NULL, NULL, 1),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95, NULL, NULL, 1),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264, NULL, NULL, 1),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674, NULL, NULL, 1),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977, NULL, NULL, 1),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31, NULL, NULL, 1),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599, NULL, NULL, 1),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687, NULL, NULL, 1),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64, NULL, NULL, 1),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505, NULL, NULL, 1),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227, NULL, NULL, 1),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234, NULL, NULL, 1),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683, NULL, NULL, 1),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672, NULL, NULL, 1),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670, NULL, NULL, 1),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47, NULL, NULL, 1),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968, NULL, NULL, 1),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92, NULL, NULL, 1),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680, NULL, NULL, 1),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970, NULL, NULL, 1),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507, NULL, NULL, 1),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675, NULL, NULL, 1),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595, NULL, NULL, 1),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51, NULL, NULL, 1),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63, NULL, NULL, 1),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0, NULL, NULL, 1),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48, NULL, NULL, 1),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351, NULL, NULL, 1),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787, NULL, NULL, 1),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974, NULL, NULL, 1),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262, NULL, NULL, 1),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40, NULL, NULL, 1),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70, NULL, NULL, 1),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250, NULL, NULL, 1),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290, NULL, NULL, 1),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869, NULL, NULL, 1),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758, NULL, NULL, 1),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508, NULL, NULL, 1),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784, NULL, NULL, 1),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684, NULL, NULL, 1),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378, NULL, NULL, 1),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239, NULL, NULL, 1),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966, NULL, NULL, 1),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221, NULL, NULL, 1),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381, NULL, NULL, 1),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248, NULL, NULL, 1),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232, NULL, NULL, 1),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65, NULL, NULL, 1),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421, NULL, NULL, 1),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386, NULL, NULL, 1),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677, NULL, NULL, 1),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252, NULL, NULL, 1),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27, NULL, NULL, 1),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0, NULL, NULL, 1),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34, NULL, NULL, 1),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94, NULL, NULL, 1),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249, NULL, NULL, 1),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597, NULL, NULL, 1),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47, NULL, NULL, 1),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268, NULL, NULL, 1),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46, NULL, NULL, 1),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41, NULL, NULL, 1),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963, NULL, NULL, 1),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886, NULL, NULL, 1),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992, NULL, NULL, 1),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255, NULL, NULL, 1),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66, NULL, NULL, 1),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670, NULL, NULL, 1),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228, NULL, NULL, 1),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690, NULL, NULL, 1),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676, NULL, NULL, 1),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868, NULL, NULL, 1),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216, NULL, NULL, 1),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90, NULL, NULL, 1),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370, NULL, NULL, 1),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649, NULL, NULL, 1),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688, NULL, NULL, 1),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256, NULL, NULL, 1),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380, NULL, NULL, 1),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971, NULL, NULL, 1),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44, NULL, NULL, 1),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1, NULL, NULL, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1, NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598, NULL, NULL, 1),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998, NULL, NULL, 1),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678, NULL, NULL, 1),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58, NULL, NULL, 1),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84, NULL, NULL, 1),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284, NULL, NULL, 1),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340, NULL, NULL, 1),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681, NULL, NULL, 1),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212, NULL, NULL, 1),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967, NULL, NULL, 1),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260, NULL, NULL, 1),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263, NULL, NULL, 1);

CREATE TABLE IF NOT EXISTS `ajkl7_image` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(48) NOT NULL,
  `extension` varchar(8) NOT NULL,
  `creator_id` int(10) unsigned NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

INSERT INTO `ajkl7_image` (`id`, `name`, `extension`, `creator_id`, `creation_date`, `modification_date`, `active`) VALUES
(21, '44576617b0efb730970135963f27d027', 'jpeg', 140, '2017-03-01 15:03:01', NULL, 1),
(23, '127629b20e91cd95beaa6c3711bd504e', 'jpeg', 140, '2017-03-01 15:06:21', NULL, 1),
(24, '9f03d8c110cebf28fd053b1e9839550f', 'jpeg', 140, '2017-03-01 15:14:12', NULL, 1),
(26, 'db638ce598b3cfd5d1fce5f82956199d', 'jpeg', 140, '2017-03-01 16:35:24', NULL, 1),
(28, '3d2b114ed75dadae5b33ebf736567493', 'jpeg', 135, '2017-03-01 16:35:57', NULL, 1),
(29, '28ad158297790a03d5b302221c6e4a0d', 'jpeg', 140, '2017-03-01 16:36:44', NULL, 1),
(30, 'd4bbdf1dabfad6f6300c32e3fe7a5cdf', 'gif', 140, '2017-03-01 16:36:52', NULL, 1),
(31, 'de96059fba13c045286e3fb153fa3574', 'jpeg', 140, '2017-03-01 16:38:46', NULL, 1),
(32, 'c6bafe6eee26db4bbf716062ff914597', 'jpeg', 140, '2017-03-01 16:38:57', NULL, 1),
(33, 'db9a552aef87c69d529e37f6d1ca7073', 'jpeg', 141, '2017-03-01 16:42:27', NULL, 1),
(34, '6a47969e6d60f316a823c32640efe1c9', 'jpeg', 141, '2017-03-01 16:42:39', NULL, 1),
(35, 'd365c1b6290c96b5d923b2e67b457617', 'jpeg', 135, '2017-03-01 19:40:38', NULL, 1),
(37, '8cc5b70124a7a39d71e0fc025c7ac935', 'jpeg', 135, '2017-03-02 10:51:31', NULL, 1),
(38, 'b0dea2afa0be158026cc96e09ff7b567', 'jpeg', 135, '2017-03-02 10:51:44', NULL, 1),
(39, '240c3177428111c64d03bdb3caf5f8c7', 'jpeg', 135, '2017-03-02 13:11:28', NULL, 1),
(50, '514a750f6cabbd8a1fc57bbef4c7f0ce', 'jpeg', 135, '2017-03-04 15:27:51', NULL, 1),
(55, 'a07cc434f89d6ff624316fe84afc07b6', 'jpeg', 135, '2017-03-04 15:28:17', NULL, 1),
(57, '737c89485a261dc8b37da9ab90ede950', 'jpeg', 135, '2017-03-04 15:29:25', NULL, 1),
(59, '49bf26eb17d3c28c81a812d5c2061408', 'jpeg', 135, '2017-03-04 15:30:13', NULL, 1),
(62, 'bf320786417bfb3c31cd09b64b271cec', 'jpeg', 135, '2017-03-04 15:33:07', NULL, 1),
(63, 'aa2f2bcbab37a0c89f6262f7634cb2bc', 'jpeg', 140, '2017-03-04 15:35:27', NULL, 1),
(64, '24c0a9b6bac05ccbf549261df5c2bd47', 'jpeg', 140, '2017-03-04 15:35:43', NULL, 1),
(66, '313b032e0a007a06c2d19e951d7bf619', 'jpeg', 140, '2017-03-04 15:38:12', NULL, 1),
(67, 'ab4599cbc53083239da33b89b70cc649', 'jpeg', 140, '2017-03-04 15:41:44', NULL, 1),
(68, '54099ba190aad6ecc73fe424576b8ca1', 'jpeg', 140, '2017-03-04 15:41:44', NULL, 1),
(69, 'a93f2a7f25e2152b0865af18680b738a', 'jpeg', 140, '2017-03-04 15:45:48', NULL, 1),
(70, '41a3fa6e6dd9c0d27daa00899603d953', 'jpeg', 140, '2017-03-04 15:46:26', NULL, 1),
(71, '131576ae19f642126d997217e97e2bb2', 'jpeg', 140, '2017-03-04 15:47:36', NULL, 1),
(72, '3bb4fa7a2a5c113d7a7c6c56f777d76e', 'jpeg', 142, '2017-03-04 15:53:12', NULL, 1),
(73, '92d094632603e560cc05e7d157b91ddd', 'jpeg', 143, '2017-03-04 16:10:01', NULL, 1),
(74, 'c128464526f5edb857d908a20e1869e0', 'jpeg', 143, '2017-03-04 16:10:03', NULL, 1),
(75, '52bb24dcdf59e653e333e45666606052', 'jpeg', 143, '2017-03-04 16:10:03', NULL, 1);

CREATE TABLE IF NOT EXISTS `ajkl7_message` (
  `id` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `creator_id` int(10) unsigned NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ajkl7_message_group` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(32) NOT NULL,
  `user_a_id` int(10) unsigned NOT NULL,
  `user_b_id` int(10) unsigned NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ajkl7_permission_group` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(16) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO `ajkl7_permission_group` (`id`, `name`, `active`) VALUES
(1, 'animal_profile', 1),
(2, 'messenger', 1),
(3, 'todo', 1),
(4, 'user_profile', 1),
(5, 'image', 1),
(6, 'parameter', 1);

CREATE TABLE IF NOT EXISTS `ajkl7_species` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

INSERT INTO `ajkl7_species` (`id`, `name`, `creation_date`, `modification_date`, `active`) VALUES
(6, 'Chat', '2017-02-25 00:00:00', NULL, 1),
(7, 'Vache', '2017-02-25 00:00:00', NULL, 1),
(8, 'Cheval', '2017-02-25 00:00:00', NULL, 1),
(9, 'Chien', '2017-02-25 00:00:00', NULL, 1),
(10, 'Serpent', '2017-02-26 00:00:00', NULL, 1),
(11, 'Insecte', '2017-02-26 00:00:00', NULL, 1),
(12, 'Arthropode', '2017-02-26 00:00:00', NULL, 1),
(13, 'Lézard', '2017-02-26 00:00:00', NULL, 1),
(14, 'Tortue', '2017-02-26 00:00:00', NULL, 1),
(15, 'Poisson', '2017-02-26 00:00:00', NULL, 1),
(16, 'Rongeur', '2017-02-26 00:00:00', NULL, 1),
(17, 'Autre', '2017-02-26 00:00:00', NULL, 1);

CREATE TABLE IF NOT EXISTS `ajkl7_species_characteristic` (
  `species_id` int(10) unsigned NOT NULL,
  `characteristic_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ajkl7_species_characteristic` (`species_id`, `characteristic_id`) VALUES
(8, 7);

CREATE TABLE IF NOT EXISTS `ajkl7_species_characteristic_order` (
  `species_id` int(10) unsigned NOT NULL,
  `characteristic_id` int(10) unsigned NOT NULL,
  `custom_order` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ajkl7_todo` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `done` tinyint(1) NOT NULL,
  `creator_id` int(10) unsigned DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ajkl7_user` (
  `id` int(10) unsigned NOT NULL,
  `nickname` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `sex` char(1) NOT NULL DEFAULT 'h' COMMENT 'h/f',
  `image_id` int(10) unsigned DEFAULT NULL,
  `description` text NOT NULL,
  `city` varchar(32) NOT NULL,
  `latitude` float(9,6) NOT NULL,
  `longitude` float(9,6) NOT NULL,
  `country_id` int(10) unsigned NOT NULL,
  `date_birth` date DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;

INSERT INTO `ajkl7_user` (`id`, `nickname`, `password`, `lastname`, `firstname`, `email`, `sex`, `image_id`, `description`, `city`, `latitude`, `longitude`, `country_id`, `date_birth`, `verified`, `banned`, `creation_date`, `modification_date`, `active`) VALUES
(135, 'metterrothan', 'c988bcd6db651257fc3812b021b9a8acae87831c', '', '', 'jmetterrothan@gmail.com', 'm', 62, '<br/>222', 'Paris', 48.854778, 2.628701, 73, '1993-05-10', 1, 0, '2017-02-22 21:59:36', '2017-03-04 15:33:07', 1),
(140, 'cedric', 'ac6ce1ec537c3bcee085826621658f0ade4055b9', '', '', 'porcher.cedric27@gmail.com', 'm', 21, '', 'Marne-La-Vallée', 48.859276, 2.598505, 73, '2000-03-16', 1, 0, '2017-03-01 15:01:35', '2017-03-01 15:03:01', 1),
(141, 'olivier', 'ac6ce1ec537c3bcee085826621658f0ade4055b9', '', '', 'olivier@faugere.com', 'm', NULL, '', 'Noisiel', 48.854778, 2.628701, 73, '1996-04-10', 1, 0, '2017-03-01 16:41:16', NULL, 1),
(142, 'metterrothan2', 'c988bcd6db651257fc3812b021b9a8acae87831c', '', '', 'jmetterrothan2@gmail.com', 'm', NULL, '', 'Noisiel', 48.854778, 2.628701, 73, '1993-05-10', 1, 0, '2017-02-22 21:59:36', '2017-03-03 18:48:33', 1),
(143, 'Maiion', '4447c631d562e1094272593a0d376fb396cfd85c', '', '', 'mar.laur@hotmail.fr', 'f', 73, 'La tartiflette c''est la vie.\r\n', 'rezé', 0.000000, 0.000000, 73, '1994-01-24', 0, 0, '2017-03-04 16:01:23', '2017-03-04 17:06:12', 1),
(144, 'zefe', '452019bd8b734a196fb07b326012a3b4f0eedcbc', '', '', 'prigent.gwenn@gmail.com', 'm', NULL, '', 'rezé', 0.000000, 0.000000, 73, '1994-01-24', 0, 0, '2017-03-04 17:13:19', '2017-03-04 17:14:39', 1);

CREATE TABLE IF NOT EXISTS `ajkl7_user_log_connexion` (
  `user_id` int(11) unsigned NOT NULL,
  `ip_adress` varchar(48) NOT NULL,
  `user_agent` varchar(32) NOT NULL,
  `last_connexion_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO `ajkl7_user_log_connexion` (`user_id`, `ip_adress`, `user_agent`, `last_connexion_date`) VALUES
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '193.50.159.59', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(140, '193.50.159.52', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '193.50.159.59', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(140, '193.50.159.52', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(141, '193.50.159.52', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '78.221.246.18', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '193.50.159.70', 'Mozilla/5.0 (X11; Linux x86_64; ', '0000-00-00 00:00:00'),
(135, '193.50.159.59', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '193.50.159.52', 'Mozilla/5.0 (Windows NT 6.3; WOW', '0000-00-00 00:00:00'),
(135, '37.163.118.194', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(142, '::1', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '46.193.1.205', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '46.193.1.205', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '46.193.1.205', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '46.193.1.205', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '46.193.1.205', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '46.193.1.205', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '46.193.1.205', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '46.193.1.205', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(140, '46.193.1.205', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '46.193.1.205', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(142, '46.193.1.205', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(135, '46.193.1.205', 'Mozilla/5.0 (Macintosh; Intel Ma', '0000-00-00 00:00:00'),
(143, '90.63.236.254', 'Mozilla/5.0 (Windows NT 6.3; WOW', '0000-00-00 00:00:00'),
(144, '90.63.236.254', 'Mozilla/5.0 (Windows NT 6.3; WOW', '0000-00-00 00:00:00');

CREATE TABLE IF NOT EXISTS `ajkl7_user_permission` (
  `group_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `r` tinyint(1) NOT NULL DEFAULT '0',
  `c` tinyint(1) NOT NULL DEFAULT '0',
  `u` tinyint(1) NOT NULL DEFAULT '0',
  `d` tinyint(1) NOT NULL DEFAULT '0',
  `a` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO `ajkl7_user_permission` (`group_id`, `user_id`, `r`, `c`, `u`, `d`, `a`) VALUES
(1, 135, 1, 1, 0, 0, 0),
(4, 135, 0, 0, 0, 0, 1),
(5, 135, 1, 1, 0, 0, 0),
(1, 140, 1, 1, 0, 0, 0),
(5, 140, 1, 1, 0, 0, 0),
(1, 141, 1, 1, 0, 0, 0),
(5, 141, 1, 1, 0, 0, 0),
(1, 142, 1, 1, 0, 0, 0),
(5, 142, 1, 1, 0, 0, 0),
(1, 143, 1, 1, 0, 0, 0),
(5, 143, 1, 1, 0, 0, 0),
(1, 144, 1, 1, 0, 0, 0),
(5, 144, 1, 1, 0, 0, 0);

CREATE TABLE IF NOT EXISTS `ajkl7_user_reset_password` (
  `user_id` int(10) unsigned NOT NULL,
  `token` varchar(32) NOT NULL,
  `date_exp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ajkl7_user_reset_password` (`user_id`, `token`, `date_exp`) VALUES
(135, 'Ya5xkhDdOZe7AG4pgX3okIk3dMDyaUTK', '2017-03-05 17:55:26');

CREATE TABLE IF NOT EXISTS `ajkl7_user_verification` (
  `user_id` int(10) unsigned NOT NULL,
  `token` varchar(32) NOT NULL,
  `date_exp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ajkl7_user_verification` (`user_id`, `token`, `date_exp`) VALUES
(141, '3ZLoFHA2cujPFzmXPOrslNE242kASVBa', '2017-03-03 16:41:16');


ALTER TABLE `ajkl7_animal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`creator_id`),
  ADD KEY `species_id` (`species_id`),
  ADD KEY `cover_id` (`cover_image_id`),
  ADD KEY `profile_image_id` (`profile_image_id`);

ALTER TABLE `ajkl7_animal_characteristic`
  ADD UNIQUE KEY `animal_id` (`animal_id`,`characteristic_id`),
  ADD KEY `ajkl7_animal_characteristic_ibfk_2` (`characteristic_id`);

ALTER TABLE `ajkl7_animal_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ajkl7_animal_comment_ibfk_1` (`animal_id`),
  ADD KEY `user_id` (`creator_id`);

ALTER TABLE `ajkl7_animal_gallery`
  ADD KEY `ajkl7_animal_gallery_ibfk_1` (`animal_id`),
  ADD KEY `image_id` (`image_id`);

ALTER TABLE `ajkl7_animal_match`
  ADD UNIQUE KEY `user_id` (`animal_a_id`,`animal_b_id`),
  ADD KEY `user_prop_id` (`animal_b_id`);

ALTER TABLE `ajkl7_characteristic`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ajkl7_country`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

ALTER TABLE `ajkl7_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ajkl7_image_ibfk_1` (`creator_id`);

ALTER TABLE `ajkl7_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ajkl7_message_ibfk_1` (`group_id`),
  ADD KEY `author_id` (`creator_id`);

ALTER TABLE `ajkl7_message_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_a` (`user_a_id`),
  ADD KEY `user_b` (`user_b_id`);

ALTER TABLE `ajkl7_permission_group`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ajkl7_species`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ajkl7_species_characteristic`
  ADD KEY `species_id` (`species_id`),
  ADD KEY `characteristic_id` (`characteristic_id`);

ALTER TABLE `ajkl7_todo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

ALTER TABLE `ajkl7_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `image_id` (`image_id`);

ALTER TABLE `ajkl7_user_log_connexion`
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `ajkl7_user_permission`
  ADD UNIQUE KEY `module_id` (`group_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `ajkl7_user_reset_password`
  ADD UNIQUE KEY `user_id` (`user_id`);

ALTER TABLE `ajkl7_user_verification`
  ADD UNIQUE KEY `user_id` (`user_id`);


ALTER TABLE `ajkl7_animal`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
ALTER TABLE `ajkl7_animal_comment`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `ajkl7_characteristic`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
ALTER TABLE `ajkl7_country`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=240;
ALTER TABLE `ajkl7_image`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
ALTER TABLE `ajkl7_message`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `ajkl7_message_group`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `ajkl7_permission_group`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
ALTER TABLE `ajkl7_species`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
ALTER TABLE `ajkl7_todo`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `ajkl7_user`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=145;

ALTER TABLE `ajkl7_animal`
  ADD CONSTRAINT `ajkl7_animal_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ajkl7_animal_ibfk_2` FOREIGN KEY (`species_id`) REFERENCES `ajkl7_species` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `ajkl7_animal_ibfk_3` FOREIGN KEY (`cover_image_id`) REFERENCES `ajkl7_image` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `ajkl7_animal_ibfk_4` FOREIGN KEY (`profile_image_id`) REFERENCES `ajkl7_image` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_animal_characteristic`
  ADD CONSTRAINT `ajkl7_animal_characteristic_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `ajkl7_animal` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ajkl7_animal_characteristic_ibfk_2` FOREIGN KEY (`characteristic_id`) REFERENCES `ajkl7_characteristic` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_animal_comment`
  ADD CONSTRAINT `ajkl7_animal_comment_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `ajkl7_animal` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ajkl7_animal_comment_ibfk_2` FOREIGN KEY (`creator_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_animal_gallery`
  ADD CONSTRAINT `ajkl7_animal_gallery_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `ajkl7_animal` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ajkl7_animal_gallery_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `ajkl7_image` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_animal_match`
  ADD CONSTRAINT `ajkl7_animal_match_ibfk_1` FOREIGN KEY (`animal_a_id`) REFERENCES `ajkl7_animal` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ajkl7_animal_match_ibfk_2` FOREIGN KEY (`animal_b_id`) REFERENCES `ajkl7_animal` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_image`
  ADD CONSTRAINT `ajkl7_image_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_message`
  ADD CONSTRAINT `ajkl7_message_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `ajkl7_message_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ajkl7_message_ibfk_2` FOREIGN KEY (`creator_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_message_group`
  ADD CONSTRAINT `ajkl7_message_group_ibfk_1` FOREIGN KEY (`user_a_id`) REFERENCES `ajkl7_user` (`id`),
  ADD CONSTRAINT `ajkl7_message_group_ibfk_2` FOREIGN KEY (`user_b_id`) REFERENCES `ajkl7_user` (`id`);

ALTER TABLE `ajkl7_species_characteristic`
  ADD CONSTRAINT `ajkl7_species_characteristic_ibfk_1` FOREIGN KEY (`species_id`) REFERENCES `ajkl7_species` (`id`),
  ADD CONSTRAINT `ajkl7_species_characteristic_ibfk_2` FOREIGN KEY (`characteristic_id`) REFERENCES `ajkl7_characteristic` (`id`);

ALTER TABLE `ajkl7_todo`
  ADD CONSTRAINT `ajkl7_todo_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_user`
  ADD CONSTRAINT `ajkl7_user_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `ajkl7_country` (`id`),
  ADD CONSTRAINT `ajkl7_user_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `ajkl7_image` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_user_log_connexion`
  ADD CONSTRAINT `ajkl7_user_log_connexion_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_user_permission`
  ADD CONSTRAINT `ajkl7_user_permission_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `ajkl7_permission_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ajkl7_user_permission_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_user_reset_password`
  ADD CONSTRAINT `uid_urp_fk` FOREIGN KEY (`user_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_user_verification`
  ADD CONSTRAINT `uid_fk` FOREIGN KEY (`user_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
