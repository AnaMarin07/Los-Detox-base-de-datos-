-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2026 a las 07:25:58
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
-- Base de datos: `detoxnashei`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--
USE detoxnashei;

CREATE TABLE `cliente` (
  `Dni` int(11) NOT NULL,
  `Nombre` varchar(40) NOT NULL,
  `Apellido` varchar(80) NOT NULL,
  `Telefono` varchar(25) NOT NULL,
  `Mail` varchar(30) NOT NULL,
  `Direccion` varchar(40) NOT NULL,
  `cod_postal` varchar(8) NOT NULL,
  `Ciudad` varchar(35) NOT NULL,
  `Contraseña` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`Dni`, `Nombre`, `Apellido`, `Telefono`, `Mail`, `Direccion`, `cod_postal`, `Ciudad`, `Contraseña`) VALUES
(49008232, 'Thiago', 'De Toffoli', '11 2236-2733', 'detox@gmail.com', 'Bucarelli 2733', '1431', 'CABA', '$2y$10$eBKMRMVNxbobNOXAzruGp.M2hKWeBkv0GcxJno6WW/dRcTQR7Riq.'),
(49008681, 'thiago', 'detoffoli', '+54 9 11 2236-2783', 'cuentadeprueba@gmail.com', 'Bolivia 1020', '1431', 'CABA', '$2y$10$byspJIx6MkUdGREGF6tdru350PjQM2CZWg6os1GaW2krTD0Etarvq');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contiene`
--

CREATE TABLE `contiene` (
  `Id_contiene` int(11) NOT NULL,
  `Nro_pedido` int(11) NOT NULL,
  `Id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contiene`
--

INSERT INTO `contiene` (`Id_contiene`, `Nro_pedido`, `Id_producto`) VALUES
(1, 1, 1),
(2, 1, 9),
(3, 2, 7),
(4, 3, 6),
(5, 4, 2),
(6, 5, 7),
(13, 12, 12),
(16, 15, 12),
(17, 16, 10),
(18, 17, 17),
(19, 18, 8),
(20, 18, 12),
(25, 21, 17),
(29, 23, 10),
(28, 23, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega`
--

CREATE TABLE `entrega` (
  `Id_entrega` int(11) NOT NULL,
  `Fecha_entrega` date NOT NULL,
  `Hora_entrega` datetime NOT NULL,
  `Observaciones` varchar(40) NOT NULL,
  `Id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

CREATE TABLE `envios` (
  `Id_Envio` int(11) NOT NULL,
  `Nro_seguimieto` int(11) NOT NULL,
  `Fecha_envio` date NOT NULL,
  `Recibo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_de_pedido`
--

CREATE TABLE `estado_de_pedido` (
  `id_Estado` int(11) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `Nombre_Estado` varchar(25) NOT NULL,
  `Id_envio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_de_pago`
--

CREATE TABLE `metodos_de_pago` (
  `Recibo` int(11) NOT NULL,
  `Metodo` varchar(20) NOT NULL,
  `Precio` decimal(10,0) NOT NULL,
  `Nro_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodos_de_pago`
--

INSERT INTO `metodos_de_pago` (`Recibo`, `Metodo`, `Precio`, `Nro_pedido`) VALUES
(1, 'Transferencia', 0, 1),
(2, 'Efectivo', 0, 2),
(3, 'Efectivo', 179998, 3),
(4, 'Efectivo', 140000, 4),
(5, 'Efectivo', 1785000, 12),
(6, 'Efectivo', 255000, 15),
(7, 'Tarjeta', 135600, 16),
(8, 'Transferencia', 290000, 17),
(9, 'Efectivo', 333700, 18),
(10, 'Efectivo', 1595000, 21),
(11, 'Efectivo', 335200, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `Nro_pedido` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Total` decimal(10,0) NOT NULL,
  `Dni` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`Nro_pedido`, `Fecha`, `Total`, `Dni`) VALUES
(1, '2026-04-29', 0, 49008681),
(2, '2026-04-29', 0, 49008681),
(3, '2026-04-29', 179998, 49008681),
(4, '2026-04-29', 140000, 49008681),
(5, '2026-04-30', 170999, 49008681),
(12, '2026-04-30', 1785000, 49008232),
(15, '2026-04-30', 255000, 49008232),
(16, '2026-04-30', 135600, 49008232),
(17, '2026-04-30', 290000, 49008232),
(18, '2026-04-30', 333700, 49008232),
(21, '2026-04-30', 1595000, 49008681),
(23, '2026-04-30', 335200, 49008681);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `Id_producto` int(11) NOT NULL,
  `Descripcion` varchar(2000) DEFAULT NULL,
  `Marca` varchar(20) NOT NULL,
  `Precio_unitario` decimal(10,0) NOT NULL,
  `Visualizacion` varchar(255) NOT NULL,
  `Genero` enum('Masculino','Femenino','Niños','Unisex') DEFAULT NULL,
  `Nombre_producto` varchar(20) NOT NULL,
  `Prioridad` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`Id_producto`, `Descripcion`, `Marca`, `Precio_unitario`, `Visualizacion`, `Genero`, `Nombre_producto`, `Prioridad`) VALUES
(1, 'Este chaleco está diseñado para mantener tu torso caliente con tecnología de regulación del calor y repelente al agua. Hecho con pelaje de leon 100% natural.ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ\nColor: NEGRO', 'NIKE', 245000, 'CSS/IMAGENES/lavaFLOW.jpg', 'Unisex', 'CHALECO LAVAFLOW', 1),
(2, 'La campera The North Face Antora color negro para hombre está confeccionada con tejido DryVent™ impermeable, a prueba de viento y 100 % reciclado, ofreciendo protección confiable tanto en la ciudad como en el sendero.ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤColor: GRIS HUMO', 'NORTH FACE', 140000, 'CSS/IMAGENES/northface.jpg', 'Unisex', 'Campera', 1),
(4, 'Sandalias en ternera Epsom con el emblemático detalle \"H\" calado y tira de tobillo ajustable, para una silueta veraniega y elegante.\r\n\r\nFabricado en Italia\r\nColor: NEGRO', 'HERMES', 85000, 'CSS/IMAGENES/sandalias santorini.webp', 'Femenino', 'Sandalias santorini', 0),
(6, 'Atate los cordones con un estilo legendario. Estas zapatillas adidas Samba LT aportan un aire deportivo retro a tu estilo diario. Originalmente una zapatilla de entrenamiento de cancha cubierta, hoy un ícono de lo urbano, esta edición presenta una lengüeta extragrande con inspiración futbolera que no pasa inadvertida. Confeccionadas en cuero premium con una elegante puntera de nobuk, aportan un toque sofisticado a todo, desde el tejido denim hasta los pantalones con puño. La suela de caucho proporciona tracción liviana y un aspecto clásico.ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤColor: NEGRO / BEIGE', 'ADIDAS', 89999, 'CSS/IMAGENES/zapatillas unisex.avif', 'Unisex', 'Zapatillas Samba LT', 1),
(7, 'El buzo Cutline de cuello redondo es un guiño a nuestro pasado, que celebra el estilo vintage de adidas con un giro. Reimaginamos un diseño clásico con este buzo de nuestra serie de clásica.ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤColor: NEGRO / AZUL REY', 'ADIDAS', 170999, 'CSS/IMAGENES/buzo.avif', 'Femenino', 'Buzo Cutline Cuello', 1),
(8, 'El pantalón Firebird Adicolor de tejido denim es un guiño al icónico modelo clásico de Originals, pero rediseñado para el presente. Con un acabado denim vintage, aporta un toque retro a tu estilo de todos los días.\r\n\r\nLas 3 Tiras añaden un sutil pero inconfundible toque de adidas. La cintura de tiro medio con cierre fijo de bragueta aporta un ajuste seguro, convirtiéndolo en una opción ideal para salidas informales o findes relajados.ㅤㅤㅤㅤㅤㅤㅤㅤㅤColor: AZUL', 'ADIDAS', 78700, 'CSS/IMAGENES/ADIAS PANTALON.avif', 'Masculino', 'Pantalón Firebird Ad', 1),
(9, 'Camisetas en punto de algodón ligero con cuello redondo ribeteado y bajo recto. Corte estándar para una silueta clásica y cómoda. ㅤㅤㅤㅤㅤㅤㅤㅤㅤColor: BEIGE', 'H&M', 35600, 'CSS/IMAGENES/H&M.avif', 'Masculino', 'Camiseta Regular Fit', 0),
(10, 'Conjunto de dos piezas en sirsaca suave. Top con escote cuadrado, tirantes finos ajustables, lazada decorativas en los laterales y peplum con vuelo. Pantalón a juego con cintura elástica, bolsillos al bies y perneras rectas.ㅤㅤColor: Blanco / Rosado', 'H&M', 45200, 'CSS/IMAGENES/H&M NENAS.avif', 'Niños', 'Conjunto de 2 piezas', 1),
(11, 'Porta todo el estilo que la marca Puma tiene para ti con la nueva playera Classics Logo para hombre. Esta playera se presenta con un corte normal, notaras que cuenta con el cuello redondo y las mangas cortas, de este modo no se limitara tu rango de movimiento. Su diseño en color negro hace de esta playera un articulo que puede combinarse de manera fácil con tus atuendos casuales.ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤColor: NEGRO / CYAN', 'PUMA', 26999, 'CSS/IMAGENES/playera puma.jpg', 'Masculino', 'Playera Puma Classic', 0),
(12, 'Esta chamarra acolchada es amplia y está lista para la intemperie. Está hecha con una cubierta exterior de tejido Woven repelente al agua y tiene aislamiento sintético y tecnología Nike ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤColor: NEGRO GRISACEO', 'NIKE', 255000, 'CSS/IMAGENES/camperota.webp', 'Masculino', 'Campera Jordan Brook', 1),
(13, 'Añadile un toque de magia a tu look con PUMA x HARRY POTTER. Esta nueva colección combina fútbol con Quidditch, el deporte favorito de los hechiceros, reinterpretando los uniformes de los equipos Gryffindor y Slytherin con un estilo urbano y toques de la moda usada en las tribunas. Nuestras camisetas de fútbol, camperas T7 y otros básicos ahora lucen detalles inspirados en Hogwarts y cada prenda presenta un bordado Golden Snitch™ oculto. La colección, que también incluye nuestras clásicas zapatillas Palermo y Easy Rider, te ofrece un estilo perfecto tanto para el mundo mágico como para el mundo Muggle.ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤColor: VERDE BOTELLA', 'PUMA', 130000, 'CSS/IMAGENES/buzonenes.avif', 'Niños', 'Buzo holgado PUMA x ', 1),
(14, 'La reedición de las 1000 rescata de los archivos un clásico de principios de siglo. Lanzada originalmente en 1999, la 1000 personificó el estilo audaz y futurista de la época con un diseño aerodinámico pero con detalles intrincados. El diseño estándar de la parte superior de malla y la superposición de gamuza se invierte, con capas inferiores de malla que emergen de los paneles superpuestos más prominentes, para una apariencia refinada e inspirada en la tecnología. La suela segmentada cuenta con amortiguación ABZORB en el talón y el antepié, con una placa de soporte Stability Web en el mediopié.ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤColor: GRIS / BLANCO / NEGRO\r\n\r\n', 'NEW BALANCE', 145000, 'CSS/IMAGENES/OIP.jpg', 'Unisex', '1000 Shoes', 0),
(17, 'LOGO DE ADIDAS COMO VENTA FALSA PORFA COMPRAR \r\n\r\nCOLOR NEGROO', 'ADIDAS', 145000, 'CSS/IMAGENES/WIN_20260408_10_38_03_Pro.jpg', 'Masculino', 'Remera', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `Id_variante` int(11) NOT NULL,
  `Id_producto` int(11) NOT NULL,
  `Talle` varchar(10) NOT NULL,
  `Stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`Id_variante`, `Id_producto`, `Talle`, `Stock`) VALUES
(2, 13, 'S', 14),
(3, 12, 'L', 3),
(4, 11, 'M', 11),
(5, 10, 'L', 4),
(6, 9, 'S', 9),
(7, 8, 'M', 11),
(8, 7, '12', 22),
(9, 6, '39', 10),
(10, 4, '37', 2),
(11, 2, 'S', 12),
(12, 1, 'L', 7),
(17, 17, 'M', 7),
(18, 17, 'L', 21),
(19, 17, 'S', 1),
(20, 14, '38', 8),
(21, 14, '39', 6),
(22, 14, '40', 12);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`Dni`);

--
-- Indices de la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD PRIMARY KEY (`Id_contiene`),
  ADD UNIQUE KEY `Nro_pedido` (`Nro_pedido`,`Id_producto`),
  ADD KEY `Id_producto` (`Id_producto`);

--
-- Indices de la tabla `entrega`
--
ALTER TABLE `entrega`
  ADD PRIMARY KEY (`Id_entrega`),
  ADD KEY `Id_estado` (`Id_estado`);

--
-- Indices de la tabla `envios`
--
ALTER TABLE `envios`
  ADD PRIMARY KEY (`Id_Envio`),
  ADD KEY `Recibo` (`Recibo`);

--
-- Indices de la tabla `estado_de_pedido`
--
ALTER TABLE `estado_de_pedido`
  ADD PRIMARY KEY (`id_Estado`),
  ADD KEY `Id_envio` (`Id_envio`);

--
-- Indices de la tabla `metodos_de_pago`
--
ALTER TABLE `metodos_de_pago`
  ADD PRIMARY KEY (`Recibo`),
  ADD KEY `Nro_pedido` (`Nro_pedido`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`Nro_pedido`),
  ADD KEY `Dni` (`Dni`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`Id_producto`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`Id_variante`),
  ADD KEY `Id_producto` (`Id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contiene`
--
ALTER TABLE `contiene`
  MODIFY `Id_contiene` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `entrega`
--
ALTER TABLE `entrega`
  MODIFY `Id_entrega` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `envios`
--
ALTER TABLE `envios`
  MODIFY `Id_Envio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado_de_pedido`
--
ALTER TABLE `estado_de_pedido`
  MODIFY `id_Estado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `metodos_de_pago`
--
ALTER TABLE `metodos_de_pago`
  MODIFY `Recibo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `Nro_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `Id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `Id_variante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD CONSTRAINT `contiene_ibfk_1` FOREIGN KEY (`Nro_pedido`) REFERENCES `pedidos` (`Nro_pedido`),
  ADD CONSTRAINT `contiene_ibfk_2` FOREIGN KEY (`Id_producto`) REFERENCES `producto` (`Id_producto`);

--
-- Filtros para la tabla `entrega`
--
ALTER TABLE `entrega`
  ADD CONSTRAINT `entrega_ibfk_1` FOREIGN KEY (`Id_estado`) REFERENCES `estado_de_pedido` (`id_Estado`);

--
-- Filtros para la tabla `envios`
--
ALTER TABLE `envios`
  ADD CONSTRAINT `envios_ibfk_1` FOREIGN KEY (`Recibo`) REFERENCES `metodos_de_pago` (`Recibo`);

--
-- Filtros para la tabla `estado_de_pedido`
--
ALTER TABLE `estado_de_pedido`
  ADD CONSTRAINT `estado_de_pedido_ibfk_1` FOREIGN KEY (`Id_envio`) REFERENCES `envios` (`Id_Envio`);

--
-- Filtros para la tabla `metodos_de_pago`
--
ALTER TABLE `metodos_de_pago`
  ADD CONSTRAINT `metodos_de_pago_ibfk_1` FOREIGN KEY (`Nro_pedido`) REFERENCES `pedidos` (`Nro_pedido`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`Dni`) REFERENCES `cliente` (`Dni`);

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`Id_producto`) REFERENCES `producto` (`Id_producto`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
