-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS invenalcaldia;
USE invenalcaldia;

-- Tabla de roles/permisos
CREATE TABLE `permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `permisos` (`id`, `role`) VALUES
(1, 'administrador'),
(2, 'usuario');


-- Tabla de usuarios para el sistema de inicio de sesión
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `recordar_token` varchar(255) DEFAULT NULL,
  `token_expires` datetime DEFAULT NULL,
  `creado_a_las` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_a_las` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Usuarios de ejemplo (contraseñas en texto plano)
INSERT INTO `usuarios` (`username`, `password`, `role`) VALUES
('marcein', 'MA1234P*', 'administrador'),
('karen', 'KJ1234A*', 'usuario'),
('marta', 'MA1234A*', 'usuario');


-- Tabla de Equipos de computo hardware
CREATE TABLE `equipos_computo_hardware` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `tipo_de_equipo` VARCHAR(100),
    `tamaño_torre` VARCHAR(50),
    `modelo` VARCHAR(100),
    `marca_torre` VARCHAR(100),
    `estado_del_equipo` VARCHAR(50),
    `vida_util` VARCHAR(20),
    `adaptador_de_voltaje` VARCHAR(50),
    `serial_equi` VARCHAR(100),
    `bateria` VARCHAR(50),
    `puertos` VARCHAR(200),
    `tipo_de_torre` VARCHAR(50),
    `tipo_de_pantalla` VARCHAR(50),
    `modelo_monitor` VARCHAR(100),
    `puertos_monitor` VARCHAR(200),
    `marca_monitor` VARCHAR(100),
    `estado_monitor` VARCHAR(50),
    `activo_perteneciente` BOOLEAN DEFAULT TRUE,
    `img_frontal_equipo` VARCHAR(200),
    `img_serial_modelo` VARCHAR(200),
    `asignado_A` VARCHAR(100)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;                                                   


-- Tabla de Equipos de computo software
CREATE TABLE `equipos_computo_software` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `sistema_operativo` VARCHAR(100),
    `tipo_sist_operativo` VARCHAR(50),
    `s_o_licencia` VARCHAR(100),
    `ofimatica` VARCHAR(100),
    `office_licenciado` VARCHAR(100),
    `compresor_arch_rar` VARCHAR(100),
    `lector_PDF` VARCHAR(100),
    `Skype` VARCHAR(100),
    `sistema_nomina` VARCHAR(100),
    `id_web_nomina` VARCHAR(100),
    `backup_auto` VARCHAR(100),
    `antivirus` VARCHAR(100),
    `tipo_antivirus` VARCHAR(50),
    `nombre_asig_equipo` VARCHAR(100),
    `equipo_hardware_id` INT,
    FOREIGN KEY (equipo_hardware_id) REFERENCES equipos_computo_hardware(id)
);

-- Tabla de Equipos de telefonia
CREATE TABLE `equipos_telefonia` (
    `id` int(11) NOT NULL,
    `tipo_de_equipo` VARCHAR(100),
    `modelo` VARCHAR(100),
    `marca` VARCHAR(100),
    `n_puertos_LAN` VARCHAR(50),
    `n_asignado` VARCHAR(50),
    `IMEI_IMSI2` VARCHAR(100),
    `serial_telef` VARCHAR(100),
    `esta_fisico_general` VARCHAR(50),
    `esta_de_funcionalidad` VARCHAR(50),
    `nombre_asig_equipo` VARCHAR(100),
    `activo` VARCHAR(100),
    `ip_asignada` VARCHAR(50),
    `dependencia` VARCHAR(100),   
    `oficina` VARCHAR(100),
    `lugar` VARCHAR(100),
    `img_frontal_equipo` VARCHAR(200),
    `img_serial_modelo` VARCHAR(200),
    `asignado_A` VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `equipos_telefonia` (
   `id`, `tipo_de_equipo`, `modelo`, `marca`, `n_puertos_LAN`,  `n_asignado`, 
   `IMEI_IMSI2`, `serial_telef`,  `esta_fisico_general`, `esta_de_funcionalidad`, 
   `nombre_asig_equipo`, `activo`, `ip_asignada`,`dependencia`, `oficina`, `lugar`, 
   `img_frontal_equipo`, `img_serial_modelo`, `asignado_A`
)VALUES(60,                                                                                                              
   'IP', 'Gxp1400', 'GRANDSTREAM', '1', '71', 'N/a', 'N/a', 
   'Se ve bueno ', 'Funcional', 'Gobierno', 'Propio:Pertenece a la alcaldía', 
   '172 17.50.41', 'Secretaría de Gobierno, Paz y Convivencia', 'Gobierno', 'CAM', 
   'https://drive.google.com/open?id=1TJxgDEbkzlT8d0-d1SyfPLrnmycAV5M8', 
   'https://drive.google.com/open?id=1e5eLJimIuUc3EAOpq1JuevxMqCgcAVAL', 'Secretaria 44002'
);


-- Tabla de Equipos de impresion
CREATE TABLE `equipos_impresion` (
    `id` int(11) NOT NULL,
    `tipo_de_equipo` VARCHAR(100),
    `modelo` VARCHAR(100),
    `marca` VARCHAR(100),
    `tiene_puertos_LAN` VARCHAR(50),
    `tiene_wifi` VARCHAR(20),
    `serial_impre` VARCHAR(100),
    `nombre_asig_equipo` VARCHAR(100),
    `activo` VARCHAR(100),
    `ip_asignada` VARCHAR(50),
    `dependencia` VARCHAR(100),
    `oficina` VARCHAR(100),
    `lugar` VARCHAR(100),
    `esta_general_equipo` VARCHAR(50),
    `observaciones` TEXT,
    `img_frontal_equipo` VARCHAR(200),
    `img_serial_modelo` VARCHAR(200),
    `asignado_A` VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `equipos_impresion` (
    `id`, `tipo_de_equipo`, `modelo`, `marca`,`tiene_puertos_LAN`, 
    `tiene_wifi`, `serial_impre`, `nombre_asig_equipo`, `activo`, 
    `ip_asignada`, `dependencia`, `oficina`, `lugar`, `esta_general_equipo`, 
    `observaciones`, `img_frontal_equipo`, `img_serial_modelo`, `asignado_A`
) VALUES (70, 
    'Laser', 'M320F', 'RICOH', 'SI', 'NO', '5853Z210205', 'SISTEMAS', 
    'Propio: Pertenece a la alcaldía ', '200.21.21.202', 'Departamento Administrativo de Desarrollo Institucional', 
    'TIC', 'CAM', 'Bueno', 'no tiene', 'img/mouse_frontal.jpg', 'img/mouse_serial.jpg', 'no tiene'
);

-- Tabla de Equipos de red
CREATE TABLE `equipos_red` (
    `id` int(11) NOT NULL,
    `tipo_de_equipo` VARCHAR(100),
    `modelo` VARCHAR(100),
    `marca` VARCHAR(100),
    `n_puertos_LAN_optica` VARCHAR(50),
    `n_de_fibras` VARCHAR(50),
    `serial_red` VARCHAR(100),
    `nombre_asig_equipo` VARCHAR(100),
    `propietario_activo` VARCHAR(100),
    `ip_asignado` VARCHAR(50),
    `identi_de_red_SSID` VARCHAR(100),
    `clave_wifi` VARCHAR(100),
    `dependencia` VARCHAR(100),
    `lugar` VARCHAR(100),
    `img_frontal_equipo` VARCHAR(200),
    `img_serial_modelo` VARCHAR(200),
    `asignado_A` VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `equipos_red` (
    `id`, `tipo_de_equipo`, `modelo, marca`, `n_puertos_LAN_optica`,
    `n_de_fibras`, `serial_red`, `nombre_asig_equipo`, `propietario_activo`, `ip_asignado`,
    `identi_de_red_SSID`, `clave_wifi`, `dependencia`, `lugar`,
    `img_frontal_equipo`, `img_serial_modelo, asignado_A`
) VALUES (80,
    'Cisco', 'Router', 'RV340', 'Cisco Systems', '4',
    '2', 'SN1234567890', 'Router Principal', 'TRUE', '192.168.1.1',
    'departamento administrativo', 'CAM', 'TI', 'Oficina Central',
    'img/router_frontal.jpg', 'img/router_serial.jpg', 'Juan Pérez'
);



-- Tabla de categorías de equipos
CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- Insertar categorías básicas
INSERT INTO categorias (nombre, descripcion) VALUES
('Equipos de Computo', 'Computadoras y equipos relacionados'),
('Equipos de Telefonia', 'Equipos de comunicación telefónica'),
('Equipos de Impresión', 'Impresoras y equipos relacionados'),
('Equipos de red', 'Equipos de networking y conectividad'); 





--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--


--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `role` FOREIGN KEY (`role`) REFERENCES `permisos` (`rol`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Indices de la tabla `equipos_telefonia`
--
ALTER TABLE `equipos_telefonia`
  ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT de la tabla `equipos_telefonia`
--
ALTER TABLE `equipos_telefonia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
