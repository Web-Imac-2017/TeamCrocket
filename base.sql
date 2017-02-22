SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `teamcrocket` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `teamcrocket`;

CREATE TABLE `ajkl7_animal` (
  `id` int(10) UNSIGNED NOT NULL,
  `owner_id` int(10) UNSIGNED NOT NULL,
  `species_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `weight` float DEFAULT NULL,
  `date_birth` date DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

CREATE TABLE `ajkl7_animal_gallery` (
  `animal_id` int(10) UNSIGNED NOT NULL,
  `image_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ajkl7_country` (
  `id` int(10) UNSIGNED NOT NULL,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  `modification_date` datetime DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

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
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225, NULL, NULL, 1),
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
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850, NULL, NULL, 1),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82, NULL, NULL, 1),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965, NULL, NULL, 1),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996, NULL, NULL, 1),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856, NULL, NULL, 1),
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

CREATE TABLE `ajkl7_image` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(48) NOT NULL,
  `creator_id` int(10) UNSIGNED NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ajkl7_message` (
  `id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ajkl7_message_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(32) NOT NULL,
  `user_a_id` int(10) UNSIGNED NOT NULL,
  `user_b_id` int(10) UNSIGNED NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ajkl7_species` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ajkl7_todo` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  `done` tinyint(1) NOT NULL,
  `creator_id` int(10) UNSIGNED DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ajkl7_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `nickname` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `sex` char(1) NOT NULL DEFAULT 'h' COMMENT 'h/f',
  `image_id` int(10) UNSIGNED DEFAULT NULL,
  `description` text NOT NULL,
  `city` varchar(32) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `date_birth` date DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ajkl7_user` (`id`, `nickname`, `password`, `lastname`, `firstname`, `email`, `sex`, `image_id`, `description`, `city`, `latitude`, `longitude`, `country_id`, `date_birth`, `verified`, `creation_date`, `modification_date`, `active`) VALUES
(135, 'metterrothan', 'c988bcd6db651257fc3812b021b9a8acae87831c', '', '', 'jmetterrothan@gmail.com', 'h', 41, '', 'Noisiel', 48.8548, 2.6287, 73, '1993-05-09', 1, '2017-02-22 21:59:36', '2017-02-22 22:00:40', 1);

CREATE TABLE `ajkl7_user_log_connexion` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `ip_adress` varchar(48) NOT NULL,
  `user_agent` varchar(32) NOT NULL,
  `last_connexion_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

CREATE TABLE `ajkl7_user_reset_password` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(32) NOT NULL,
  `date_exp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ajkl7_user_verification` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(32) NOT NULL,
  `date_exp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `ajkl7_animal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `species_id` (`species_id`);

ALTER TABLE `ajkl7_animal_gallery`
  ADD KEY `ajkl7_animal_gallery_ibfk_1` (`animal_id`),
  ADD KEY `image_id` (`image_id`);

ALTER TABLE `ajkl7_country`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

ALTER TABLE `ajkl7_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ajkl7_image_ibfk_1` (`creator_id`);

ALTER TABLE `ajkl7_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ajkl7_message_ibfk_1` (`group_id`),
  ADD KEY `author_id` (`author_id`);

ALTER TABLE `ajkl7_message_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_a` (`user_a_id`),
  ADD KEY `user_b` (`user_b_id`);

ALTER TABLE `ajkl7_species`
  ADD PRIMARY KEY (`id`);

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

ALTER TABLE `ajkl7_user_reset_password`
  ADD UNIQUE KEY `user_id` (`user_id`);

ALTER TABLE `ajkl7_user_verification`
  ADD UNIQUE KEY `user_id` (`user_id`);


ALTER TABLE `ajkl7_animal`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `ajkl7_country`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;
ALTER TABLE `ajkl7_image`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
ALTER TABLE `ajkl7_message`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `ajkl7_message_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `ajkl7_species`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `ajkl7_todo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `ajkl7_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

ALTER TABLE `ajkl7_animal`
  ADD CONSTRAINT `ajkl7_animal_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ajkl7_animal_ibfk_2` FOREIGN KEY (`species_id`) REFERENCES `ajkl7_species` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_animal_gallery`
  ADD CONSTRAINT `ajkl7_animal_gallery_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `ajkl7_animal` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ajkl7_animal_gallery_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `ajkl7_image` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_image`
  ADD CONSTRAINT `ajkl7_image_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_message`
  ADD CONSTRAINT `ajkl7_message_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `ajkl7_message_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ajkl7_message_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_message_group`
  ADD CONSTRAINT `ajkl7_message_group_ibfk_1` FOREIGN KEY (`user_a_id`) REFERENCES `ajkl7_user` (`id`),
  ADD CONSTRAINT `ajkl7_message_group_ibfk_2` FOREIGN KEY (`user_b_id`) REFERENCES `ajkl7_user` (`id`);

ALTER TABLE `ajkl7_todo`
  ADD CONSTRAINT `ajkl7_todo_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_user`
  ADD CONSTRAINT `ajkl7_user_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `ajkl7_country` (`id`),
  ADD CONSTRAINT `ajkl7_user_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `ajkl7_image` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_user_log_connexion`
  ADD CONSTRAINT `ajkl7_user_log_connexion_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_user_reset_password`
  ADD CONSTRAINT `uid_urp_fk` FOREIGN KEY (`user_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `ajkl7_user_verification`
  ADD CONSTRAINT `uid_fk` FOREIGN KEY (`user_id`) REFERENCES `ajkl7_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
