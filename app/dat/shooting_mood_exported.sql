-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-01-2026 a las 22:41:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shooting_mood`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `alt` varchar(255) NOT NULL,
  `category` enum('day','night','home') NOT NULL,
  `commentary` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `is_blog` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `path`, `alt`, `category`, `commentary`, `date`, `is_blog`) VALUES
(1, NULL, 'web/img/budapest_tram.jpg', 'Girl in the tram', 'day', NULL, NULL, 0),
(2, NULL, 'web/img/luci_cesped_2.jpg', 'Girl in the grass', 'day', NULL, NULL, 0),
(3, 'Art in Berlin', 'web/img/graffiti.jpg', 'Graffiti in Berlin', 'day', 'My friend lived in Berlin for four years and showed me this abandoned place where they used to hold rave parties. To get there, we had to walk through a forest where we were eaten alive by mosquitoes.', '2024-08-20', 1),
(4, NULL, 'web/img/leer_playa.jpg', 'Reading on the beach', 'day', NULL, NULL, 0),
(5, NULL, 'web/img/bluelamp.jpg', 'Boy with a blue lamp light', 'day', NULL, NULL, 0),
(6, NULL, 'web/img/terraza.jpeg', 'Boy on a bar terrace', 'day', NULL, NULL, 0),
(7, NULL, 'web/img/axel_nat_sol_2.jpg', 'Friends in the sun', 'day', NULL, NULL, 0),
(8, NULL, 'web/img/glitter_wall.jpg', 'Girl in a glitter wall', 'day', NULL, NULL, 0),
(9, NULL, 'web/img/jav_nat_fiordos_noruega.jpg', 'Norwegian fjords', 'day', NULL, NULL, 0),
(10, NULL, 'web/img/papeles_lampara.jpg', 'Lamp with papers', 'day', NULL, NULL, 0),
(11, NULL, 'web/img/sudoku.jpg', 'Sudoku', 'day', NULL, NULL, 0),
(12, NULL, 'web/img/luci_makeup_2.JPG', 'Girl doing her make-up', 'day', NULL, NULL, 0),
(13, NULL, 'web/img/nieve_dav_mat_cel.jpg', 'Friends in the snow', 'day', NULL, NULL, 0),
(14, NULL, 'web/img/budapestcafe.jpg', 'Girl in a cafe-bar', 'day', NULL, NULL, 0),
(15, NULL, 'web/img/alert_tacones_2.jpg', 'Heels signal', 'day', NULL, NULL, 0),
(16, NULL, 'web/img/mar_toalla.jpg', 'Friends hugging at beach', 'day', NULL, NULL, 0),
(17, 'The Vintage Shop in Norway', 'web/img/vintage_shop_norway.jpg', 'Vintage shop', 'day', 'My brother and I visited a vintage store in Norway. When we walked in, the hippie shop assistants told us to take our time. We passed through an entrance hall and a kitchen, and to reach the actual shop we had to go down a narrow staircase. The store was set up like a basement, and it felt a bit creepy. At one point, I even lost sight of my brother, which really scared me because he wasn\'t answering and I couldn\'t hear anything.', '2025-07-09', 1),
(18, NULL, 'web/img/nat_bar.jpg', 'Girl in the mirror', 'day', NULL, NULL, 0),
(19, NULL, 'web/img/david_moto.jpg', 'Boy sunbathing', 'day', NULL, NULL, 0),
(20, NULL, 'web/img/lamparas.jpg', 'Lamp shop', 'day', NULL, NULL, 0),
(21, NULL, 'web/img/lavanderia.jpg', 'Girl in the laundry lights', 'night', NULL, NULL, 0),
(22, NULL, 'web/img/morrinsons.jpg', 'Friends at a party', 'night', NULL, NULL, 0),
(23, 'The Circus at Night', 'web/img/circus.jpg', 'Circus photo', 'night', 'There\'s never anything interesting in my neighborhood, which is why I never go out there. But on the one night I went for a walk there, there was a circus in a place where there\'s usually a vacant lot. My friend and I saw that the fence was open and went in to investigate.', '2025-01-20', 1),
(24, NULL, 'web/img/girldrinking.jpg', 'Girl drinking at a party', 'night', NULL, NULL, 0),
(25, NULL, 'web/img/floor_nightclub_praga.jpeg', 'Dance floor lights', 'night', NULL, NULL, 0),
(26, NULL, 'web/img/kiss.jpg', 'Friends kissing', 'night', NULL, NULL, 0),
(27, NULL, 'web/img/party_in_praga.jpeg', 'Girl at the party', 'night', NULL, NULL, 0),
(28, NULL, 'web/img/nat_cuenca.jpg', 'Girl on the bar wall', 'night', NULL, NULL, 0),
(29, NULL, 'web/img/beso_noria.jpg', 'Kiss with the ferris wheel', 'night', NULL, NULL, 0),
(30, NULL, 'web/img/rascacielos.jpg', 'Rooftop', 'night', NULL, NULL, 0),
(31, NULL, 'web/img/nightclub.jpg', 'Girl at the party', 'night', NULL, NULL, 0),
(32, NULL, 'web/img/miraflores_lights.jpg', 'Friends with party lights', 'night', NULL, NULL, 0),
(33, NULL, 'web/img/window_praga.jpeg', 'Girl looking at the window', 'home', NULL, NULL, 0),
(34, NULL, 'web/img/lamp.jpg', 'Lamp', 'home', NULL, NULL, 0),
(35, NULL, 'web/img/cooking.jpg', 'Friends cooking', 'home', NULL, NULL, 0),
(36, NULL, 'web/img/boy_window.jpeg', 'Boy in the window', 'home', NULL, NULL, 0),
(37, NULL, 'web/img/luz.jpg', 'Girl doing her make-up', 'home', NULL, NULL, 0),
(38, NULL, 'web/img/rest.jpg', 'Girl resting in bed', 'home', NULL, NULL, 0),
(39, NULL, 'web/img/cofees.jpg', 'Friends drinking coffee', 'home', NULL, NULL, 0),
(40, NULL, 'web/img/couple_embracing_terrace.jpg', 'Couple embracing on a terrace', 'home', NULL, NULL, 0),
(41, NULL, 'web/img/chamo.jpg', 'Guy smoking at the window', 'home', NULL, NULL, 0),
(42, NULL, 'web/img/david_cocinando_2.jpg', 'Boy cooking', 'home', NULL, NULL, 0),
(43, NULL, 'web/img/nat_axel_rosas.jpg', 'Friends talking', 'home', NULL, NULL, 0),
(44, NULL, 'web/img/fotos_tienda_noruega.jpg', 'Photo wall', 'home', NULL, NULL, 0),
(47, NULL, 'web/img/portal_pintado.jpg', 'Painted portal', 'home', NULL, NULL, 0),
(60, NULL, 'web/img/viewpoint_train.jpg', 'Boy with wine at a viewpoint', 'day', NULL, NULL, 0),
(61, NULL, 'web/img/friends_hugging.jpg', 'Friends hugging', 'day', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userapp`
--

CREATE TABLE `userapp` (
  `login` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `userapp`
--

INSERT INTO `userapp` (`login`, `name`, `password`, `email`) VALUES
('Agmbd', 'Adrián Guerra', '$2y$10$aGv.kSujKrTZ1CIIPeCxHuMwzeYEQe/z9M9h5vnPPJW/e9YvzDXAq', 'adriangmbd@gmail.com'),
('luberitta', 'Luz Bietti', '$2y$10$duCgKzmG97WAgfxWSgorsekKdPPetjFnRVRZfjb.m8MOwTMOAoyoi', 'luzbietti2@gmail.com'),
('Mam37', 'Mateo Álvaro', '$2y$10$.K5GQIU1MxRDhwHiPMcAzeK8FdYwTQzz37vLcfOL4woKuBkPh.oGa', 'mateoam37@gmail.com'),
('Nmm679', 'Nuria Moreno', '$2y$10$FdEoNgprU1L.F9aix9umEOXdL4dwjuJ3h3jv4MYXU2CjgjfPNkgXy', 'nuriamm679@gmail.com'),
('Smmcl', 'Silvia Moreno', '$2y$10$.tAiMbfXIpwg3ZYuAHJJLu3ANDgKGOgjQTohg29UxQjYtYMV5Az3C', 'silviammcl@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `userapp`
--
ALTER TABLE `userapp`
  ADD PRIMARY KEY (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;