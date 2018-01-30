-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 30 2018 г., 18:02
-- Версия сервера: 5.6.26-log
-- Версия PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `incorex`
--

-- --------------------------------------------------------

--
-- Структура таблицы `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name_ru` varchar(100) DEFAULT NULL,
  `name_en` varchar(100) DEFAULT NULL,
  `code` varchar(2) DEFAULT NULL,
  `prefix` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `country`
--

INSERT INTO `country` (`id`, `name_ru`, `name_en`, `code`, `prefix`) VALUES
(1, 'Австралия', 'Australia', 'AU', 61),
(2, 'Малайзия', 'Malaysia', 'MY', 60),
(3, 'Республика Корея', 'Korea', 'KR', 0),
(4, 'Китай', 'China', 'CN', 86),
(5, 'Япония', 'Japan', 'JP', 81),
(6, 'Индия', 'India', 'IN', 0),
(7, 'Тайвань', 'Taiwan', 'TW', 886),
(8, 'Гонконг', 'Hong Kong', 'HK', 0),
(9, 'Таиланд', 'Thailand', 'TH', 66),
(11, 'Вьетнам', 'Vietnam', 'VN', 84),
(12, 'Франция', 'France', 'FR', 0),
(13, 'Италия', 'Italy', 'IT', 39),
(14, 'ОАЭ', 'United Arab Emirates', 'AE', 971),
(15, 'Швеция', 'Sweden', 'SE', 46),
(16, 'Казахстан', 'Kazakhstan', 'KZ', 7),
(17, 'Португалия', 'Portugal', 'PT', 351),
(18, 'Греция', 'Greece', 'GR', 30),
(19, 'Саудовская Аравия', 'Saudi Arabia', 'SA', 966),
(20, 'Российская Федерация', 'Russian Federation', 'RU', 7),
(21, 'Великобритания', 'United Kingdom', 'GB', 44),
(22, 'Дания', 'Denmark', 'DK', 45),
(23, 'США', 'United States', 'US', 0),
(24, 'Канада', 'Canada', 'CA', 1),
(25, 'Мексика', 'Mexico', 'MX', 52),
(26, 'Бермуды', 'Bermuda', 'BM', 1441),
(27, 'Пуэрто Рико', 'Puerto Rico', 'PR', 1787),
(28, 'Виргинские Острова США', 'Virgin Islands, U.S.', 'VI', 0),
(29, 'Германия', 'Germany', 'DE', 49),
(30, 'Иран', 'Iran', 'IR', 0),
(31, 'Боливия', 'Bolivia', 'BO', 591),
(32, 'Монтсеррат', 'Montserrat', 'MS', 1664),
(33, 'Нидерланды', 'Netherlands', 'NL', 31),
(34, 'Израиль', 'Israel', 'IL', 972),
(35, 'Испания', 'Spain', 'ES', 34),
(36, 'Багамские острова', 'Bahamas', 'BS', 1242),
(37, 'Сент-Винсент и Гренадины', 'Saint Vincent and the Grenadines', 'VC', 1784),
(38, 'Чили', 'Chile', 'CL', 56),
(39, 'Новая Каледония', 'New Caledonia', 'NC', 687),
(40, 'Аргентина', 'Argentina', 'AR', 54),
(41, 'Доминика', 'Dominica', 'DM', 1767),
(42, 'Сингапур', 'Singapore', 'SG', 65),
(43, 'Непал', 'Nepal', 'NP', 977),
(44, 'Филиппины', 'Philippines', 'PH', 63),
(45, 'Индонезия', 'Indonesia', 'ID', 62),
(46, 'Пакистан', 'Pakistan', 'PK', 92),
(47, 'Токелау', 'Tokelau', 'TK', 690),
(48, 'Новая Зеландия', 'New Zealand', 'NZ', 64),
(49, 'Камбоджа', 'Cambodia', 'KH', 855),
(50, 'Макау', 'Macau', 'MO', 0),
(51, 'Папуа Новая Гвинея', 'Papua New Guinea', 'PG', 675),
(52, 'Мальдивские острова', 'Maldives', 'MV', 960),
(53, 'Афганистан', 'Afghanistan', 'AF', 93),
(54, 'Бангладеш', 'Bangladesh', 'BD', 880),
(55, 'Ирландия', 'Ireland', 'IE', 353),
(56, 'Бельгия', 'Belgium', 'BE', 32),
(57, 'Белиз', 'Belize', 'BZ', 501),
(58, 'Бразилия', 'Brazil', 'BR', 55),
(59, 'Швейцария', 'Switzerland', 'CH', 41),
(60, 'Южно-Африканская Республика', 'South Africa', 'ZA', 27),
(61, 'Египет', 'Egypt', 'EG', 20),
(62, 'Нигерия', 'Nigeria', 'NG', 0),
(63, 'Танзания', 'Tanzania', 'TZ', 255),
(64, 'Замбия', 'Zambia', 'ZM', 260),
(65, 'Сенегал', 'Senegal', 'SN', 221),
(66, 'Гана', 'Ghana', 'GH', 233),
(67, 'Судан', 'Sudan', 'SD', 249),
(68, 'Камерун', 'Cameroon', 'CM', 237),
(69, 'Малави', 'Malawi', 'MW', 265),
(70, 'Ангола', 'Angola', 'AO', 244),
(71, 'Кения', 'Kenya', 'KE', 254),
(72, 'Габон', 'Gabon', 'GA', 241),
(73, 'Мали', 'Mali', 'ML', 223),
(74, 'Бенин', 'Benin', 'BJ', 229),
(75, 'Мадагаскар', 'Madagascar', 'MG', 261),
(76, 'Чад', 'Chad', 'TD', 235),
(77, 'Ботсвана', 'Botswana', 'BW', 267),
(78, 'Ливия', 'Libya', 'LY', 0),
(79, 'Кабо-Верде', 'Cape Verde', 'CV', 238),
(80, 'Руанда', 'Rwanda', 'RW', 250),
(81, 'Мозамбик', 'Mozambique', 'MZ', 258),
(82, 'Гамбия', 'Gambia', 'GM', 220),
(83, 'Лесото', 'Lesotho', 'LS', 266),
(84, 'Маврикий', 'Mauritius', 'MU', 230),
(85, 'Конго', 'Congo', 'CG', 242),
(86, 'Уганда', 'Uganda', 'UG', 256),
(87, 'Буркина Фасо', 'Burkina Faso', 'BF', 226),
(88, 'Сьерра-Леоне', 'Sierra Leone', 'SL', 232),
(89, 'Сомали', 'Somalia', 'SO', 252),
(90, 'Зимбабве', 'Zimbabwe', 'ZW', 263),
(91, 'Демократическая Республика Конго', 'Democratic Republic Of The Congo', 'CD', 243),
(92, 'Нигер', 'Niger', 'NE', 227),
(93, 'Центрально-Африканская Республика', 'Central African Republic', 'CF', 236),
(94, 'Свазиленд', 'Swaziland', 'SZ', 268),
(95, 'Того', 'Togo', 'TG', 228),
(96, 'Гвинея', 'Guinea', 'GN', 224),
(97, 'Либерия', 'Liberia', 'LR', 231),
(98, 'Сейшеллы', 'Seychelles', 'SC', 248),
(99, 'Марокко', 'Morocco', 'MA', 212),
(100, 'Алжир', 'Algeria', 'DZ', 213),
(101, 'Мавритания', 'Mauritania', 'MR', 222),
(102, 'Намибия', 'Namibia', 'NA', 264),
(103, 'Джибути', 'Djibouti', 'DJ', 253),
(105, 'Коморские острова', 'Comoros', 'KM', 269),
(106, 'Реюньон', 'Reunion', 'RE', 262),
(107, 'Экваториальная Гвинея', 'Equatorial Guinea', 'GQ', 240),
(108, 'Тунис', 'Tunisia', 'TN', 216),
(109, 'Турция', 'Turkey', 'TR', 0),
(110, 'Польша', 'Poland', 'PL', 48),
(111, 'Латвия', 'Latvia', 'LV', 371),
(112, 'Украина', 'Ukraine', 'UA', 380),
(113, 'Беларусь', 'Belarus', 'BY', 375),
(114, 'Чехия', 'Czech Republic', 'CZ', 420),
(115, 'Палестина', 'Palestinian Territory', 'PS', 970),
(116, 'Исландия', 'Iceland', 'IS', 354),
(117, 'Кипр', 'Cyprus', 'CY', 357),
(118, 'Венгрия', 'Hungary', 'HU', 36),
(119, 'Словакия', 'Slovakia', 'SK', 421),
(120, 'Сербия', 'Serbia', 'RS', 381),
(121, 'Болгария', 'Bulgaria', 'BG', 359),
(122, 'Оман', 'Oman', 'OM', 968),
(123, 'Румыния', 'Romania', 'RO', 40),
(124, 'Грузия', 'Georgia', 'GE', 995),
(125, 'Норвегия', 'Norway', 'NO', 47),
(126, 'Армения', 'Armenia', 'AM', 374),
(127, 'Австрия', 'Austria', 'AT', 43),
(128, 'Албания', 'Albania', 'AL', 355),
(129, 'Словения', 'Slovenia', 'SI', 386),
(130, 'Панама', 'Panama', 'PA', 507),
(131, 'Бруней', 'Brunei Darussalam', 'BN', 673),
(132, 'Шри-Ланка', 'Sri Lanka', 'LK', 94),
(133, 'Черногория', 'Montenegro', 'ME', 382),
(134, 'Европейский Союз', 'Europe', 'EU', 0),
(135, 'Таджикистан', 'Tajikistan', 'TJ', 992),
(136, 'Ирак', 'Iraq', 'IQ', 0),
(137, 'Ливан', 'Lebanon', 'LB', 961),
(138, 'Молдова', 'Moldova', 'MD', 373),
(139, 'Финляндия', 'Finland', 'FI', 358),
(140, 'Эстония', 'Estonia', 'EE', 0),
(141, 'Босния и Герцеговина', 'Bosnia and Herzegovina', 'BA', 387),
(142, 'Кувейт', 'Kuwait', 'KW', 965),
(143, 'Аландские острова', 'Aland Islands', 'AX', 358),
(144, 'Литва', 'Lithuania', 'LT', 370),
(145, 'Люксембург', 'Luxembourg', 'LU', 352),
(146, 'Антигуа и Барбуда', 'Antigua and Barbuda', 'AG', 1268),
(147, 'Македония', 'Macedonia', 'MK', 389),
(148, 'Сан-Марино', 'San Marino', 'SM', 378),
(149, 'Мальта', 'Malta', 'MT', 356),
(150, 'Фолклендские острова', 'Falkland Islands', 'FK', 500),
(151, 'Бахрейн', 'Bahrain', 'BH', 973),
(152, 'Узбекистан', 'Uzbekistan', 'UZ', 998),
(153, 'Азербайджан', 'Azerbaijan', 'AZ', 994),
(154, 'Монако', 'Monaco', 'MC', 377),
(155, 'Гаити', 'Haiti', 'HT', 509),
(156, 'Гуам', 'Guam', 'GU', 1671),
(157, 'Ямайка', 'Jamaica', 'JM', 1876),
(158, 'Внешние малые острова США', 'United States Minor Outlying Islands', 'UM', 0),
(159, 'Микронезия', 'Micronesia', 'FM', 691),
(160, 'Эквадор', 'Ecuador', 'EC', 593),
(161, 'Перу', 'Peru', 'PE', 51),
(162, 'Каймановы острова', 'Cayman Islands', 'KY', 1345),
(163, 'Колумбия', 'Colombia', 'CO', 57),
(164, 'Гондурас', 'Honduras', 'HN', 504),
(165, 'Антильские острова', 'Netherlands Antilles', 'AN', 599),
(166, 'Йемен', 'Yemen', 'YE', 967),
(167, 'Британские Виргинские острова', 'Virgin Islands, British', 'VG', 1284),
(168, 'Сирия', 'Syria', 'SY', 963),
(169, 'Никарагуа', 'Nicaragua', 'NI', 505),
(170, 'Доминиканская республика', 'Dominican Republic', 'DO', 1809),
(171, 'Гренада', 'Grenada', 'GD', 1473),
(172, 'Гватемала', 'Guatemala', 'GT', 502),
(173, 'Коста-Рика', 'Costa Rica', 'CR', 506),
(174, 'Сальвадор', 'El Salvador', 'SV', 503),
(175, 'Венесуэла', 'Venezuela', 'VE', 58),
(176, 'Барбадос', 'Barbados', 'BB', 1246),
(177, 'Тринидад и Тобаго', 'Trinidad and Tobago', 'TT', 1868),
(178, 'Буве', 'Bouvet Island', 'BV', 47),
(179, 'Маршалловы острова', 'Marshall Islands', 'MH', 692),
(180, 'Острова Кука', 'Cook Islands', 'CK', 682),
(181, 'Гибралтар', 'Gibraltar', 'GI', 350),
(182, 'Парагвай', 'Paraguay', 'PY', 595),
(247, 'Южный Судан', 'South Sudan', 'SS', 0),
(184, 'Самоа', 'Samoa', 'WS', 685),
(185, 'Сент Китс и Невис', 'Saint Kitts and Nevis', 'KN', 1869),
(186, 'Фиджи', 'Fiji', 'FJ', 679),
(187, 'Уругвай', 'Uruguay', 'UY', 598),
(188, 'Северные Марианские острова', 'Northern Mariana Islands', 'MP', 0),
(189, 'Палау', 'Palau', 'PW', 680),
(190, 'Катар', 'Qatar', 'QA', 974),
(191, 'Иордания', 'Jordan', 'JO', 962),
(192, 'Американское Самоа', 'American Samoa', 'AS', 0),
(193, 'Туркс и Кейкос', 'Turks and Caicos Islands', 'TC', 1649),
(194, 'Святая Люсия', 'Saint Lucia', 'LC', 1758),
(195, 'Монголия', 'Mongolia', 'MN', 976),
(196, 'Ватикан', 'Holy See', 'VA', 39),
(197, 'Арулько', 'Aruba', 'AW', 297),
(198, 'Гайана', 'Guyana', 'GY', 592),
(199, 'Суринам', 'Suriname', 'SR', 597),
(200, 'Остров Мэн', 'Isle of Man', 'IM', 44),
(201, 'Вануату', 'Vanuatu', 'VU', 678),
(202, 'Хорватия', 'Croatia', 'HR', 385),
(203, 'Ангуилья', 'Anguilla', 'AI', 1264),
(204, 'Сен-Пьер и Микелон', 'Saint Pierre and Miquelon', 'PM', 508),
(205, 'Гваделупа', 'Guadeloupe', 'GP', 590),
(206, 'Сен-Мартен', 'Saint Martin', 'MF', 0),
(207, 'Гернси', 'Guernsey', 'GG', 44),
(208, 'Бурунди', 'Burundi', 'BI', 257),
(209, 'Туркменистан', 'Turkmenistan', 'TM', 993),
(210, 'Кыргызстан', 'Kyrgyzstan', 'KG', 996),
(211, 'Мьянма', 'Myanmar', 'MM', 95),
(212, 'Бутан', 'Bhutan', 'BT', 975),
(213, 'Лихтенштейн', 'Liechtenstein', 'LI', 423),
(214, 'Фарерские острова', 'Faroe Islands', 'FO', 298),
(215, 'Эфиопия', 'Ethiopia', 'ET', 251),
(216, 'Мартиника', 'Martinique', 'MQ', 596),
(217, 'Джерси', 'Jersey', 'JE', 44),
(218, 'Андорра', 'Andorra', 'AD', 376),
(219, 'Антарктида', 'Antarctica', 'AQ', 672),
(220, 'Британская территория в Индийском океане', 'British Indian Ocean Territory', 'IO', 246),
(221, 'Гренландия', 'Greenland', 'GL', 299),
(222, 'Гвинея-Бисау', 'Guinea-Bissau', 'GW', 245),
(223, 'Эритрея', 'Eritrea', 'ER', 291),
(224, 'Уоллис и Футуна', 'Wallis and Futuna', 'WF', 681),
(225, 'Французская Полинезия', 'French Polynesia', 'PF', 0),
(226, 'Куба', 'Cuba', 'CU', 0),
(227, 'Тонга', 'Tonga', 'TO', 676),
(228, 'Восточный Тимор', 'Timor-Leste', 'TL', 670),
(229, 'Сан-Томе и Принсипи', 'Sao Tome and Principe', 'ST', 239),
(230, 'Французская Гвинея', 'French Guiana', 'GF', 0),
(231, 'Соломоновы острова', 'Solomon Islands', 'SB', 677),
(232, 'Тувалу', 'Tuvalu', 'TV', 688),
(233, 'Кирибати', 'Kiribati', 'KI', 686),
(234, 'Ниуэ', 'Niue', 'NU', 683),
(235, 'Норфолк', 'Norfolk Island', 'NF', 672),
(236, 'Науру', 'Nauru', 'NR', 674),
(237, 'Майотта', 'Mayotte', 'YT', 269),
(238, 'Питкэрн', 'Pitcairn Islands', 'PN', 872),
(239, 'Кот-д''Ивуар', 'Cote D''Ivoire', 'CI', 225),
(240, 'Лаос', 'Lao', 'LA', 856),
(241, 'Корейская Народно-Демократическая Республика', 'Democratic People''s Republic of Korea', 'KP', 0),
(242, 'Свальбард и Ян-Майен', 'Svalbard and Jan Mayen', 'SJ', 47),
(243, 'Остров Святой Елены', 'Saint Helena', 'SH', 290),
(244, 'Кокосовые острова', 'Cocos (Keeling) Islands', 'CC', 61),
(245, 'Западная Сахара', 'Western Sahara', 'EH', 212);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL DEFAULT '',
  `lastname` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(250) NOT NULL DEFAULT '',
  `country` int(11) DEFAULT NULL,
  `email` varchar(250) NOT NULL DEFAULT '',
  `birthday` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `partner_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `bad_auth` tinyint(2) NOT NULL DEFAULT '0',
  `bad_auth_time` int(11) DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(250) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `phone`, `password`, `country`, `email`, `birthday`, `partner_id`, `status`, `bad_auth`, `bad_auth_time`, `last_login`, `last_modified`, `last_ip`, `date`) VALUES
(26, '', '', '', '0a517247007b7ce622ecc20b5ead0088:Iz53xz27VC8unBOY', NULL, '279229931@qip.ru', '0000-00-00 00:00:00', 0, 1, 0, NULL, '2018-01-29 14:01:51', '2018-01-29 14:01:36', '127.0.0.1', '2018-01-28 22:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `x_session`
--

CREATE TABLE `x_session` (
  `id` int(11) NOT NULL,
  `session_id` varchar(45) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `device_id` varchar(255) NOT NULL DEFAULT '',
  `mac` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `guest` tinyint(4) NOT NULL DEFAULT '1',
  `guest_key` varchar(50) NOT NULL DEFAULT '',
  `usertype` varchar(50) NOT NULL DEFAULT '',
  `status` int(2) DEFAULT '1',
  `remember` tinyint(4) NOT NULL DEFAULT '0',
  `gid` int(10) NOT NULL DEFAULT '1',
  `ip` varchar(20) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `x_session`
--

INSERT INTO `x_session` (`id`, `session_id`, `time`, `userid`, `device_id`, `mac`, `username`, `guest`, `guest_key`, `usertype`, `status`, `remember`, `gid`, `ip`, `user_agent`) VALUES
(1373, 'feb3448fc316c5763bfec14dfc27bd1e', 1517240257, 26, '', '', '279229931@qip.ru', 0, '', 'user', 1, 0, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0'),
(1374, '1a59adf28bef0904a869f782d7a50e26', 1517234480, 0, '', '', '', 1, '', '', 1, 0, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0'),
(1375, 'c158975c9bdfd5b24dbe4980a0ff3c73', 1517234511, 0, '', '', '', 1, '', '', 1, 0, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0'),
(1376, '5bc7fd0cd117923a3c549d1432f49a81', 1517236940, 0, '', '', '', 1, '', '', 1, 0, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0'),
(1377, '5e32ed8d94ff9be56a9c3163bbb72978', 1517236967, 0, '', '', '', 1, '', '', 1, 0, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0'),
(1378, 'c13b31ea564d7172ae7ec263050c26cb', 1517237006, 0, '', '', '', 1, '', '', 1, 0, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0'),
(1379, '01326b72eced10ed74bfef92302cfaea', 1517237053, 0, '', '', '', 1, '', '', 1, 0, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0'),
(1380, '8ef336327e165b2705d65e02eab1f665', 1517237071, 0, '', '', '', 1, '', '', 1, 0, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0'),
(1381, '8a3b357be891cc1a9d9a482dc87dff4f', 1517237103, 0, '', '', '', 1, '', '', 1, 0, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0'),
(1382, '10c2254a9e8f8dbc16e8598dee5fea9f', 1517237119, 0, '', '', '', 1, '', '', 1, 0, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0'),
(1383, 'e62936e68412e997913120ea2e9c8804', 1517239016, 0, '', '', '', 1, '', '', 1, 0, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `name_en` (`name_en`),
  ADD KEY `name_ru` (`name_ru`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Индексы таблицы `x_session`
--
ALTER TABLE `x_session`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session` (`session_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT для таблицы `x_session`
--
ALTER TABLE `x_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1384;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
