--
-- Base de datos: `shooting_mood`
--

SET AUTOCOMMIT = 0;
START TRANSACTION;

--
-- Estructura de tabla para la tabla `userapp`
--

CREATE TABLE IF NOT EXISTS `userapp` (
  `login` VARCHAR(10) PRIMARY KEY, -- login como dato principal para identificar a cada usuario
  `name` VARCHAR(20) NOT NULL,
  `password` VARCHAR(255) NOT NULL -- Un hash ocupa ~255 caracteres
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE userapp ADD COLUMN email VARCHAR(50) NULL;

--
-- Volcado de datos para la tabla `userapp`
--

INSERT INTO `userapp` (`login`, `name`, `password`) VALUES
('Nmm679', 'Nuria Moreno', '$2y$10$FdEoNgprU1L.F9aix9umEOXdL4dwjuJ3h3jv4MYXU2CjgjfPNkgXy'),
('Smmcl', 'Silvia Moreno', '$2y$10$.tAiMbfXIpwg3ZYuAHJJLu3ANDgKGOgjQTohg29UxQjYtYMV5Az3C'),
('Mam37', 'Mateo Álvaro', '$2y$10$.K5GQIU1MxRDhwHiPMcAzeK8FdYwTQzz37vLcfOL4woKuBkPh.oGa'),
('Agmbd', 'Adrián Guerra', '$2y$10$aGv.kSujKrTZ1CIIPeCxHuMwzeYEQe/z9M9h5vnPPJW/e9YvzDXAq');

UPDATE userapp SET email = 'nuriamm679@gmail.com' WHERE login = 'Nmm679'; 
UPDATE userapp SET email = 'silviammcl@gmail.com' WHERE login = 'Smmcl'; 
UPDATE userapp SET email = 'mateoam37@gmail.com' WHERE login = 'Mam37'; 
UPDATE userapp SET email = 'adriangmbd@gmail.com' WHERE login = 'Agmbd';

-- Después de registrarse Luz (login = 'luberitta') a través de la interfaz:
UPDATE userapp SET email = 'luzbietti2@gmail.com' WHERE login = 'EL_LOGIN_DEL_USUARIO';

--
-- Estructura de tabla para la tabla `gallery`
--

CREATE TABLE IF NOT EXISTS gallery ( 
  `id` INT AUTO_INCREMENT PRIMARY KEY, 
  `file` VARCHAR(255) NOT NULL, 
  `alt` VARCHAR(255) NOT NULL, 
  `category` ENUM('day','night','home') NOT NULL, 
  `commentary` TEXT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `gallery`
--

INSERT INTO `gallery` (`file`, `alt`, `category`) VALUES 
-- DAYLIFE 
('web/img/budapest_tram.jpg', 'Girl in the tram', 'day'),
('web/img/luci_cesped_2.jpg', 'Girl in the grass', 'day'),
('web/img/graffiti.jpg', 'Graffiti in Berlin', 'day'),
('web/img/leer_playa.jpg', 'Reading on the beach', 'day'),
('web/img/bluelamp.jpg', 'Boy with a blue lamp light', 'day'),
('web/img/terraza.jpeg', 'Boy on a bar terrace', 'day'),
('web/img/axel_nat_sol_2.jpg', 'Friends in the sun', 'day'),
('web/img/glitter_wall.jpg', 'Girl in a glitter wall', 'day'),
('web/img/jav_nat_fiordos_noruega.jpg', 'Norwegian fjords', 'day'),
('web/img/papeles_lampara.jpg', 'Lamp with papers', 'day'),
('web/img/sudoku.jpg', 'Sudoku', 'day'),
('web/img/luci_makeup_2.JPG', 'Girl doing her make-up', 'day'),
('web/img/nieve_dav_mat_cel.jpg', 'Friends in the snow', 'day'),
('web/img/budapestcafe.jpg', 'Girl in a cafe-bar', 'day'),
('web/img/alert_tacones_2.jpg', 'Heels signal', 'day'),
('web/img/mar_toalla.jpg', 'Friends hugging at beach', 'day'),
('web/img/vintage_shop_norway.jpg', 'Vintage shop', 'day'),
('web/img/nat_bar.jpg', 'Girl in the mirror', 'day'),
('web/img/david_moto.jpg', 'Boy sunbathing', 'day'), 
('web/img/lamparas.jpg', 'Lamp shop', 'day'),

-- NIGHTLIFE
('web/img/lavanderia.jpg', 'Girl in the laundry lights', 'night'),
('web/img/morrinsons.jpg', 'Friends at a party', 'night'),
('web/img/circus.jpg', 'Circus photo', 'night'),
('web/img/girldrinking.jpg', 'Girl drinking at a party', 'night'),
('web/img/floor_nightclub_praga.jpeg', 'Dance floor lights', 'night'),
('web/img/kiss.jpg', 'Friends kissing', 'night'),
('web/img/party_in_praga.jpeg', 'Girl at the party', 'night'),
('web/img/nat_cuenca.jpg', 'Girl on the bar wall', 'night'),
('web/img/beso_noria.jpg', 'Kiss with the ferris wheel', 'night'),
('web/img/rascacielos.jpg', 'Rooftop', 'night'),
('web/img/nightclub.jpg', 'Girl at the party', 'night'),
('web/img/miraflores_lights.jpg', 'Friends with party lights', 'night'),

-- HOME
('web/img/window_praga.jpeg', 'Girl looking at the window', 'home'),
('web/img/lamp.jpg', 'Lamp', 'home'),
('web/img/cooking.jpg', 'Friends cooking', 'home'),
('web/img/boy_window.jpeg', 'Boy in the window', 'home'),
('web/img/luz.jpg', 'Girl doing her make-up', 'home'),
('web/img/rest.jpg', 'Girl resting in bed', 'home'),
('web/img/cofees.jpg', 'Friends drinking coffee', 'home'),
('web/img/couple_embracing_terrace.jpg', 'Couple embracing on a terrace', 'home'),
('web/img/chamo.jpg', 'Guy smoking at the window', 'home'),
('web/img/david_cocinando_2.jpg', 'Boy cooking', 'home'),
('web/img/nat_axel_rosas.jpg', 'Friends talking', 'home'),
('web/img/fotos_tienda_noruega.jpg', 'Photo wall', 'home'),
('web/img/sarita_paez.jpg', 'Friends laughing and hugging', 'home'),
('web/img/wurli2.jpg', 'Friends talking', 'night'),
('web/img/portal_pintado.jpg', 'Painted portal', 'home');


COMMIT;
