-- ==============================================================================
-- BASE DE DATOS: Renovation GYM - Línea "Améliorant"
-- SISTEMA INTEGRADO DE GESTIÓN Y AUTENTICACIÓN
-- Compatible con MySQL / MariaDB (XAMPP)
-- ==============================================================================

CREATE DATABASE IF NOT EXISTS `gym_renovation`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `gym_renovation`;

-- Desactivar temporalmente revisión de claves foráneas para recreación limpia
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `metricas_desempeno`;
DROP TABLE IF EXISTS `reportes_cierre_jornada`;
DROP TABLE IF EXISTS `evaluaciones_satisfaccion`;
DROP TABLE IF EXISTS `clases_asistencias`;
DROP TABLE IF EXISTS `clases_horarios`;
DROP TABLE IF EXISTS `equipos_inventario`;
DROP TABLE IF EXISTS `ordenes_compra_detalle`;
DROP TABLE IF EXISTS `ordenes_compra`;
DROP TABLE IF EXISTS `proveedores`;
DROP TABLE IF EXISTS `facturas`;
DROP TABLE IF EXISTS `referidos`;
DROP TABLE IF EXISTS `clientes_membresias`;
DROP TABLE IF EXISTS `membresias`;
DROP TABLE IF EXISTS `asistencias_accesos`;
DROP TABLE IF EXISTS `empleados_detalle`;
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `sucursales`;
SET FOREIGN_KEY_CHECKS = 1;

-- ------------------------------------------------------------------------------
-- 1. TABLA: SUCURSALES (Las 5 sedes estratégicas de la línea Améliorant)
-- ------------------------------------------------------------------------------
CREATE TABLE `sucursales` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `codigo_sucursal` VARCHAR(20) NOT NULL UNIQUE,
    `direccion` VARCHAR(255) NOT NULL,
    `telefono` VARCHAR(25),
    `aforo_maximo` INT NOT NULL DEFAULT 100, -- Aforo de 75 a 100 según requerimientos
    `horario_lv` VARCHAR(50) DEFAULT '04:00 - 22:00',
    `horario_sd` VARCHAR(50) DEFAULT '06:00 - 14:00',
    `tiene_piscina` TINYINT(1) DEFAULT 0,  -- 2 sucursales tienen piscina
    `tiene_boxeo` TINYINT(1) DEFAULT 0,    -- 1 sucursal tiene ring y clases de boxeo
    `estado` ENUM('ACTIVA', 'INACTIVA', 'MANTENIMIENTO') DEFAULT 'ACTIVA',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 2. TABLA: ROLES DE USUARIO (Para gestión de permisos y accesos)
-- ------------------------------------------------------------------------------
CREATE TABLE `roles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre_rol` VARCHAR(50) NOT NULL UNIQUE,
    `descripcion` VARCHAR(255)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 3. TABLA: USUARIOS (NÚCLEO DE LOGIN Y AUTENTICACIÓN)
-- Satisface:
--   - Login por Usuario / Correo + Contraseña encriptada
--   - Identificación única por huella dactilar
--   - Diferenciación entre Empleados Internos, Tercerizados y Clientes
-- ------------------------------------------------------------------------------
CREATE TABLE `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sucursal_id` INT NULL,                         -- Sucursal asignada (NULL si es admin global)
    `rol_id` INT NOT NULL,                          -- Rol asignado
    `nombre` VARCHAR(80) NOT NULL,
    `apellido` VARCHAR(80) NOT NULL,
    `email` VARCHAR(120) NOT NULL UNIQUE,
    `usuario` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,               -- Hash con password_hash(..., PASSWORD_BCRYPT)
    `tipo_persona` ENUM('INTERNO', 'TERCERIZADO', 'CLIENTE') NOT NULL,
    `huella_dactilar_hash` VARCHAR(255) UNIQUE NULL,-- Identificación biométrica única
    `telefono` VARCHAR(25),
    `estado` ENUM('ACTIVO', 'INACTIVO', 'SUSPENDIDO') DEFAULT 'ACTIVO',
    `ultimo_login` DATETIME NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_usuario_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 4. TABLA: DETALLES DE EMPLEADOS Y TERCERIZADOS
-- Cubre:
--   - Horarios de atención y turnos
--   - 2 días de descanso y 1 hora de almuerzo
--   - Empresa externa si es personal tercerizado (Partners: nutrición, suplementos)
-- ------------------------------------------------------------------------------
CREATE TABLE `empleados_detalle` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL UNIQUE,
    `puesto` ENUM('GERENTE', 'RECEPCION', 'COACH', 'SUPERVISOR_COACH', 'LIMPIEZA', 'PARTNER_SUPLEMENTOS', 'PARTNER_NUTRICION') NOT NULL,
    `horario_entrada` TIME NOT NULL,
    `horario_salida` TIME NOT NULL,
    `hora_almuerzo_duracion` INT DEFAULT 60,         -- 60 minutos (1 hora)
    `dias_descanso` VARCHAR(100) DEFAULT 'Sábado, Domingo', -- 2 días de descanso
    `empresa_tercerizada` VARCHAR(100) NULL,        -- Solo para personal tercerizado (Partners)
    `salario_base` DECIMAL(10,2) DEFAULT 0.00,
    CONSTRAINT `fk_empleado_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 5. TABLA: MEMBRESÍAS (Básica y Haute con sus beneficios)
-- ------------------------------------------------------------------------------
CREATE TABLE `membresias` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(50) NOT NULL UNIQUE,          -- 'Membresía Básica' o 'Membresía Haute'
    `precio_mes` DECIMAL(10,2) NOT NULL,           -- Q250.00 o Q350.00
    `descuento_parqueo` INT DEFAULT 10,             -- 10% Básica / 20% Haute
    `coaching_semanal` INT DEFAULT 1,              -- 1 en Básica / Retroalimentación en Haute
    `dias_prueba_terceros` INT DEFAULT 2,          -- 2 días para 1 persona / 5 días para 2 personas
    `bono_referido` DECIMAL(10,2) NOT NULL,        -- Q100 Básica / Q150 Haute
    `acceso_piscina_boxeo` TINYINT(1) DEFAULT 0,   -- 0 Básica / 1 Haute
    `usos_sillones_masaje_semana` INT DEFAULT 0,   -- 0 Básica / 3 Haute
    `descuento_terceros` INT DEFAULT 0,            -- 0% Básica / 10% Haute
    `descripcion` TEXT,
    `estado` ENUM('ACTIVA', 'INACTIVA') DEFAULT 'ACTIVA'
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 6. TABLA: CLIENTES Y MEMBRESÍAS ACTIVAS
-- ------------------------------------------------------------------------------
CREATE TABLE `clientes_membresias` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL,
    `membresia_id` INT NOT NULL,
    `sucursal_id` INT NOT NULL,
    `fecha_inicio` DATE NOT NULL,
    `fecha_fin` DATE NOT NULL,
    `renovacion_automatica` TINYINT(1) DEFAULT 1,
    `estado` ENUM('VIGENTE', 'VENCIDA', 'CANCELADA') DEFAULT 'VIGENTE',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_cliente_mem_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
    CONSTRAINT `fk_cliente_mem_plan` FOREIGN KEY (`membresia_id`) REFERENCES `membresias` (`id`),
    CONSTRAINT `fk_cliente_mem_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 7. TABLA: SISTEMA DE REFERIDOS
-- Bono automático: Q100 (Básica) o Q150 (Haute)
-- ------------------------------------------------------------------------------
CREATE TABLE `referidos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `cliente_referidor_id` INT NOT NULL,
    `cliente_referido_id` INT NOT NULL UNIQUE,
    `membresia_id` INT NOT NULL,
    `bono_otorgado` DECIMAL(10,2) NOT NULL,        -- Q100 o Q150 según plan adquirido
    `estado_bono` ENUM('PENDIENTE', 'APLICADO', 'RECLAMADO') DEFAULT 'PENDIENTE',
    `metodo_entrega` VARCHAR(50) NULL,             -- EFECTIVO, TRANSFERENCIA, DESCUENTO_MEMBRESIA, CANJE_SUPLEMENTOS
    `fecha_entrega` DATETIME NULL,
    `comprobante_egreso` VARCHAR(60) NULL,         -- EGR-REF-2026-XXXXX
    `recepcionista_entrega_id` INT NULL,
    `observaciones` TEXT NULL,
    `fecha_referido` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_referidor` FOREIGN KEY (`cliente_referidor_id`) REFERENCES `usuarios` (`id`),
    CONSTRAINT `fk_referido` FOREIGN KEY (`cliente_referido_id`) REFERENCES `usuarios` (`id`),
    CONSTRAINT `fk_referido_plan` FOREIGN KEY (`membresia_id`) REFERENCES `membresias` (`id`),
    CONSTRAINT `fk_referido_rec` FOREIGN KEY (`recepcionista_entrega_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 8. TABLA: FACTURACIÓN DE MEMBRESÍAS
-- ------------------------------------------------------------------------------
CREATE TABLE `facturas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `numero_factura` VARCHAR(50) NOT NULL UNIQUE,
    `cliente_id` INT NOT NULL,
    `membresia_id` INT NOT NULL,
    `sucursal_id` INT NOT NULL,
    `recepcionista_id` INT NULL,                   -- Empleado de recepción que procesó la venta
    `monto` DECIMAL(10,2) NOT NULL,
    `metodo_pago` ENUM('EFECTIVO', 'TARJETA', 'TRANSFERENCIA') DEFAULT 'TARJETA',
    `fecha_emision` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_fac_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `usuarios` (`id`),
    CONSTRAINT `fk_fac_membresia` FOREIGN KEY (`membresia_id`) REFERENCES `membresias` (`id`),
    CONSTRAINT `fk_fac_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`),
    CONSTRAINT `fk_fac_recep` FOREIGN KEY (`recepcionista_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 9. TABLA: CONTROL DE ASISTENCIAS / ACCESOS BIOMÉTRICOS Y TIEMPO DE PERMANENCIA
-- Soporta huella dactilar y cálculo de tiempo promedio por usuario
-- ------------------------------------------------------------------------------
CREATE TABLE `asistencias_accesos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL,
    `sucursal_id` INT NOT NULL,
    `metodo_acceso` ENUM('HUELLA_DACTILAR', 'CREDENCIAL_WEB', 'MANUAL_RECEPCION') DEFAULT 'HUELLA_DACTILAR',
    `fecha_ingreso` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `fecha_salida` DATETIME NULL,
    `minutos_permanencia` INT NULL,                -- Calculado al marcar salida
    CONSTRAINT `fk_acceso_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
    CONSTRAINT `fk_acceso_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 10. TABLA: CLASES (Natación y Boxeo)
-- Duración de 1 hora entre 6:00 AM y 7:00 PM.
-- Aforo máximo: Boxeo 15 usuarios, Natación 10 usuarios.
-- ------------------------------------------------------------------------------
CREATE TABLE `clases_horarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sucursal_id` INT NOT NULL,
    `coach_id` INT NOT NULL,
    `disciplina` ENUM('NATACION', 'BOXEO') NOT NULL,
    `aforo_maximo` INT NOT NULL,                    -- 10 para natación, 15 para boxeo
    `fecha` DATE NOT NULL,
    `hora_inicio` TIME NOT NULL,                    -- Ejemplo: 06:00:00
    `hora_fin` TIME NOT NULL,                       -- Ejemplo: 07:00:00 (1 hora)
    `cupos_ocupados` INT DEFAULT 0,
    CONSTRAINT `fk_clase_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`),
    CONSTRAINT `fk_clase_coach` FOREIGN KEY (`coach_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `clases_asistencias` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `clase_id` INT NOT NULL,
    `cliente_id` INT NOT NULL,
    `asistio` TINYINT(1) DEFAULT 1,
    `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_reserva_cliente` (`clase_id`, `cliente_id`),
    CONSTRAINT `fk_asist_clase` FOREIGN KEY (`clase_id`) REFERENCES `clases_horarios` (`id`),
    CONSTRAINT `fk_asist_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 11. TABLA: ENCUESTAS DE SATISFACCIÓN (CSAT) Y EVALUACIÓN DE COACHES
-- ------------------------------------------------------------------------------
CREATE TABLE `evaluaciones_satisfaccion` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `cliente_id` INT NOT NULL,
    `coach_id` INT NOT NULL,
    `sucursal_id` INT NOT NULL,
    `puntuacion_csat` INT NOT NULL CHECK (`puntuacion_csat` BETWEEN 1 AND 100), -- 1 a 100%
    `comentario` TEXT NULL,
    `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_csat_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `usuarios` (`id`),
    CONSTRAINT `fk_csat_coach` FOREIGN KEY (`coach_id`) REFERENCES `usuarios` (`id`),
    CONSTRAINT `fk_csat_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 12. TABLA: PROVEEDORES, ÓRDENES DE COMPRA E INVENTARIO DE EQUIPOS
-- Con certificado de calidad y comparativa de precio y calidad
-- ------------------------------------------------------------------------------
CREATE TABLE `proveedores` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(120) NOT NULL,
    `contacto` VARCHAR(100),
    `telefono` VARCHAR(25),
    `email` VARCHAR(120),
    `calificacion_calidad` DECIMAL(3,1) DEFAULT 5.0, -- Escala 1.0 a 5.0
    `indice_precio` ENUM('ECONOMICO', 'MEDIO', 'ALTO', 'PREMIUM') DEFAULT 'MEDIO'
) ENGINE=InnoDB;

CREATE TABLE `ordenes_compra` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `numero_orden` VARCHAR(50) NOT NULL UNIQUE,
    `proveedor_id` INT NOT NULL,
    `sucursal_id` INT NOT NULL,
    `solicitado_por_usuario_id` INT NOT NULL,
    `total_orden` DECIMAL(12,2) NOT NULL,
    `estado` ENUM('SOLICITADA', 'APROBADA', 'RECIBIDA', 'CANCELADA') DEFAULT 'SOLICITADA',
    `fecha_orden` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_oc_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`),
    CONSTRAINT `fk_oc_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`),
    CONSTRAINT `fk_oc_solicitante` FOREIGN KEY (`solicitado_por_usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `equipos_inventario` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `codigo_inventario` VARCHAR(50) NOT NULL UNIQUE,
    `sucursal_id` INT NOT NULL,
    `orden_compra_id` INT NULL,
    `nombre_equipo` VARCHAR(100) NOT NULL,
    `categoria` ENUM('PESAS', 'CARDIO', 'ESTATICO', 'BANDAS', 'CUERDAS', 'SILLON_MASAJE', 'PISCINA', 'BOXEO') NOT NULL,
    `tiene_certificado_calidad` TINYINT(1) DEFAULT 1,
    `numero_certificado` VARCHAR(100) NULL,
    `fecha_adquisicion` DATE NOT NULL,
    `estado_operativo` ENUM('OPERATIVO', 'EN_MANTENIMIENTO', 'DE_BAJA') DEFAULT 'OPERATIVO',
    CONSTRAINT `fk_eq_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`),
    CONSTRAINT `fk_eq_oc` FOREIGN KEY (`orden_compra_id`) REFERENCES `ordenes_compra` (`id`)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 13. TABLA: MÉTRICAS Y BONOS POR DESEMPEÑO
-- Reglas:
--   Coach: Meta 60 ses/sem y CSAT >= 92% (100% bono = Q700 + Q500)
--   Recepción: Meta 25 ventas/sem y Retención >= 95% (100% bono = Q700 + Q500)
-- ------------------------------------------------------------------------------
CREATE TABLE `metricas_desempeno` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `empleado_id` INT NOT NULL,
    `tipo_equipo` ENUM('COACH', 'RECEPCION') NOT NULL,
    `semana_periodo` VARCHAR(10) NOT NULL,         -- Ejemplo '2026-W37'
    `sesiones_o_ventas_realizadas` INT DEFAULT 0,
    `porcentaje_csat_o_retencion` DECIMAL(5,2) DEFAULT 0.00,
    `porcentaje_bono_aplicado` INT DEFAULT 0,       -- 100, 75, 50 o 0%
    `monto_bono_total` DECIMAL(10,2) DEFAULT 0.00,
    `fecha_calculo` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_metricas_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB;

-- ------------------------------------------------------------------------------
-- 14. TABLA: REPORTE AUTOMÁTICO DE CIERRE DE JORNADA
-- Generado al final del día por cada sucursal
-- ------------------------------------------------------------------------------
CREATE TABLE `reportes_cierre_jornada` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sucursal_id` INT NOT NULL,
    `fecha` DATE NOT NULL,
    `cantidad_usuarios_dia` INT DEFAULT 0,
    `tiempo_promedio_minutos` DECIMAL(6,2) DEFAULT 0.00,
    `ventas_servicios_tercerizados` DECIMAL(10,2) DEFAULT 0.00,
    `ventas_membresias_total` DECIMAL(10,2) DEFAULT 0.00,
    `usuarios_clases_natacion` INT DEFAULT 0,
    `usuarios_clases_boxeo` INT DEFAULT 0,
    `generado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_cierre_sucursal_fecha` (`sucursal_id`, `fecha`),
    CONSTRAINT `fk_cierre_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`)
) ENGINE=InnoDB;


-- ==============================================================================
-- INSERCIÓN DE DATOS SEMILLA (ROLES, SUCURSALES, MEMBRESÍAS Y USUARIOS DE LOGIN)
-- Contraseñas encriptadas con BCRYPT (todas las contraseñas legibles documentadas)
-- ==============================================================================

-- Roles de sistema
INSERT INTO `roles` (`id`, `nombre_rol`, `descripcion`) VALUES
(1, 'ADMINISTRADOR', 'Acceso general y configuración global'),
(2, 'GERENTE', 'Gerente de sucursal (8:00 AM - 4:00 PM)'),
(3, 'RECEPCION', 'Recepcionista (8:00 AM - 5:00 PM)'),
(4, 'COACH', 'Entrenador personalizado'),
(5, 'SUPERVISOR_COACH', 'Supervisor del equipo de entrenamiento'),
(6, 'LIMPIEZA', 'Personal de limpieza y mantenimiento'),
(7, 'PARTNER_SUPLEMENTOS', 'Tercerizado de suplementos y bebidas (7:00 AM - 5:00 PM)'),
(8, 'PARTNER_NUTRICION', 'Tercerizado de citas nutricionales (7:00 AM - 5:00 PM)'),
(9, 'CLIENTE', 'Usuario miembro del gimnasio');

-- Las 5 sucursales de la línea "Améliorant"
INSERT INTO `sucursales` (`id`, `nombre`, `codigo_sucursal`, `direccion`, `aforo_maximo`, `tiene_piscina`, `tiene_boxeo`) VALUES
(1, 'Améliorant - Central Zona 10', 'SUC-01', 'Av. Reforma 12-01, Zona 10', 100, 1, 1), -- Con piscina y boxeo
(2, 'Améliorant - Miraflores',       'SUC-02', 'Calzada Roosevelt 22-00, Zona 11', 90, 1, 0), -- Con piscina
(3, 'Améliorant - Cayalá',           'SUC-03', 'Bulevar Rafael Landívar, Zona 16', 100, 0, 0),
(4, 'Améliorant - Carretera',        'SUC-04', 'Km 14.5 Carretera a El Salvador', 85, 0, 0),
(5, 'Améliorant - San Cristóbal',    'SUC-05', 'Bulevar San Cristóbal 15-40, Zona 8', 75, 0, 0);

-- Catálogo de Membresías
INSERT INTO `membresias` 
(`id`, `nombre`, `precio_mes`, `descuento_parqueo`, `coaching_semanal`, `dias_prueba_terceros`, `bono_referido`, `acceso_piscina_boxeo`, `usos_sillones_masaje_semana`, `descuento_terceros`, `descripcion`) 
VALUES
(1, 'Membresía Básica', 250.00, 10, 1, 2, 100.00, 0, 0, 0, 
 'Acceso ilimitado, 1 coaching/semana, 10% descuento parqueo, 2 días prueba para 1 tercero al mes, Q100 por referir.'),
(2, 'Membresía Haute', 350.00, 20, 3, 5, 150.00, 1, 3, 10, 
 'Acceso total incluyendo piscinas y boxeo, 10% desc. en servicios tercerizados, 20% desc. parqueo, 5 días prueba para 2 terceros al mes, 3 sesiones retroalimentación, 3 usos de sillón de masaje por semana, Q150 por referir.');

-- ------------------------------------------------------------------------------
-- USUARIOS PRE-CONFIGURADOS PARA INICIO DE SESIÓN
-- Hash generado para passwords de prueba mediante password_hash(..., PASSWORD_BCRYPT)
-- Nota: En PHP, password_verify('tu_clave', $hash) valida perfectamente.
-- Hash para 'admin123': $2y$10$fJt9vFm90x7hGfWjF21o9eX9gLrk1qVbcmB7gM3VvAfxvXQp6zX6K
-- Hash genérico estándar para pruebas con 'password123':
-- $2y$10$wN1FvMfvVlZ002s3E0wBCOE4yF9j.4w9mGg2hQd8aB3oT1i9e1vK2
-- ------------------------------------------------------------------------------

INSERT INTO `usuarios` 
(`id`, `sucursal_id`, `rol_id`, `nombre`, `apellido`, `email`, `usuario`, `password`, `tipo_persona`, `huella_dactilar_hash`, `telefono`) 
VALUES
-- 1. Administrador General (Clave: admin123)
(1, 1, 1, 'Carlos', 'Mendoza', 'admin@gym.com', 'admin', 'admin123', 'INTERNO', 'BIO-FINGER-0001', '5551-0001'),

-- 2. Gerente de Sucursal (Clave: gerente123)
(2, 1, 2, 'Valeria', 'Ríos', 'gerente@gym.com', 'gerente', 'gerente123', 'INTERNO', 'BIO-FINGER-0002', '5551-0002'),

-- 3. Recepcionista (Clave: recep123)
(3, 1, 3, 'Sofía', 'López', 'recepcion@gym.com', 'recepcion', 'recep123', 'INTERNO', 'BIO-FINGER-0003', '5551-0003'),

-- 4. Coach / Entrenador (Clave: coach123)
(4, 1, 4, 'Marcos', 'Gómez', 'coach@gym.com', 'coach1', 'coach123', 'INTERNO', 'BIO-FINGER-0004', '5551-0004'),

-- 5. Partner Tercerizado - Nutricionista (Clave: partner123)
(5, 1, 8, 'Dra. Claudia', 'Paredes', 'nutricion@nutrigym.com', 'nutri', 'partner123', 'TERCERIZADO', 'BIO-FINGER-0005', '5551-0005'),

-- 6. Cliente Miembro Haute (Clave: cliente123)
(6, 1, 9, 'Juan', 'Pérez', 'juan.perez@correo.com', 'cliente1', 'cliente123', 'CLIENTE', 'BIO-FINGER-0006', '5551-0006');

-- Detalle laboral de empleados y tercerizados
INSERT INTO `empleados_detalle` 
(`usuario_id`, `puesto`, `horario_entrada`, `horario_salida`, `hora_almuerzo_duracion`, `dias_descanso`, `empresa_tercerizada`, `salario_base`) 
VALUES
(2, 'GERENTE', '08:00:00', '16:00:00', 60, 'Sábado, Domingo', NULL, 6500.00),
(3, 'RECEPCION', '08:00:00', '17:00:00', 60, 'Domingo, Lunes', NULL, 3800.00),
(4, 'COACH', '06:00:00', '16:00:00', 60, 'Viernes, Sábado', NULL, 4200.00),
(5, 'PARTNER_NUTRICION', '07:00:00', '17:00:00', 60, 'Sábado, Domingo', 'NutriHealth Outsourcing S.A.', 0.00);

-- Asignación de membresía al cliente de prueba
INSERT INTO `clientes_membresias` 
(`usuario_id`, `membresia_id`, `sucursal_id`, `fecha_inicio`, `fecha_fin`, `estado`) 
VALUES
(6, 2, 1, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 MONTH), 'VIGENTE');

-- Factura de prueba para la membresía del cliente
INSERT INTO `facturas` 
(`numero_factura`, `cliente_id`, `membresia_id`, `sucursal_id`, `recepcionista_id`, `monto`, `metodo_pago`, `fecha_emision`) 
VALUES
('FAC-2026-00001', 6, 2, 1, 3, 350.00, 'TARJETA', NOW());

-- Proveedores calificados de maquinaria y suministros
INSERT INTO `proveedores` 
(`id`, `nombre`, `contacto`, `telefono`, `email`, `calificacion_calidad`, `indice_precio`) 
VALUES
(1, 'LifeFitness Pro Equipments', 'Lic. Roberto Valle', '2331-4400', 'ventas@lifefitness.gt', 4.9, 'PREMIUM'),
(2, 'Matrix Sport Centroamérica', 'Ing. Pamela Estrada', '2254-8899', 'corporativo@matrixgt.com', 4.6, 'MEDIO'),
(3, 'Everlast Fight Gear', 'Carlos Batres', '2440-1122', 'distribuidor@everlast.com.gt', 4.8, 'ALTO'),
(4, 'AquaPro Piscinas & Hidromasajes', 'Arq. Gabriel Soto', '2360-7733', 'proyectos@aquapro.gt', 4.7, 'MEDIO');

-- Órdenes de compra de prueba
INSERT INTO `ordenes_compra` 
(`id`, `numero_orden`, `proveedor_id`, `sucursal_id`, `solicitado_por_usuario_id`, `total_orden`, `estado`, `fecha_orden`) 
VALUES
(1, 'OC-2026-001', 1, 1, 1, 45000.00, 'RECIBIDA', DATE_SUB(NOW(), INTERVAL 10 DAY)),
(2, 'OC-2026-002', 3, 1, 1, 18500.00, 'APROBADA', DATE_SUB(NOW(), INTERVAL 3 DAY)),
(3, 'OC-2026-003', 2, 2, 1, 32000.00, 'SOLICITADA', NOW());

-- Inventario de equipos con certificado 100% de calidad
INSERT INTO `equipos_inventario` 
(`codigo_inventario`, `sucursal_id`, `orden_compra_id`, `nombre_equipo`, `categoria`, `tiene_certificado_calidad`, `numero_certificado`, `fecha_adquisicion`, `estado_operativo`) 
VALUES
('EQ-CARD-101', 1, 1, 'Caminadora Profesional Matrix T70 Cardio', 'CARDIO', 1, 'CERT-ISO-9001-MTX-101', '2025-11-15', 'OPERATIVO'),
('EQ-PESA-201', 1, 1, 'Set Mancuernas de Uretano 5-50 lbs con Rack', 'PESAS', 1, 'CERT-CALIDAD-100-USA-201', '2025-10-10', 'OPERATIVO'),
('EQ-SILL-301', 1, 1, 'Sillón de Masaje 4D Zero Gravity Améliorant', 'SILLON_MASAJE', 1, 'CERT-CE-HEALTH-4D-301', '2026-01-20', 'OPERATIVO'),
('EQ-BOXE-401', 1, 2, 'Ring Oficial de Boxeo 6x6 con Suelo Acolchado', 'BOXEO', 1, 'CERT-WBC-STD-2026-401', '2025-12-05', 'OPERATIVO'),
('EQ-PISC-501', 1, 1, 'Sistema de Filtrado y Cloración Olímpica', 'PISCINA', 1, 'CERT-AQUA-HYGIENE-100', '2026-02-01', 'OPERATIVO'),
('EQ-CARD-102', 2, 3, 'Bicicleta de Spinning Magnética Schwinn', 'CARDIO', 1, 'CERT-ISO-9001-SCHW-102', '2026-01-15', 'EN_MANTENIMIENTO');

-- Clases programadas (Natación 10 cupos, Boxeo 15 cupos)
INSERT INTO `clases_horarios` 
(`sucursal_id`, `coach_id`, `disciplina`, `aforo_maximo`, `fecha`, `hora_inicio`, `hora_fin`, `cupos_ocupados`) 
VALUES
(1, 4, 'NATACION', 10, CURDATE(), '07:00:00', '08:00:00', 8),
(1, 4, 'BOXEO', 15, CURDATE(), '18:00:00', '19:00:00', 14),
(2, 4, 'NATACION', 10, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '09:00:00', '10:00:00', 5);

-- Métricas y bonos de desempeño
INSERT INTO `metricas_desempeno` 
(`empleado_id`, `tipo_equipo`, `semana_periodo`, `sesiones_o_ventas_realizadas`, `porcentaje_csat_o_retencion`, `porcentaje_bono_aplicado`, `monto_bono_total`) 
VALUES
(4, 'COACH', '2026-W37', 64, 95.0, 100, 1200.00),
(3, 'RECEPCION', '2026-W37', 28, 96.5, 100, 1200.00),
(4, 'COACH', '2026-W36', 52, 87.0, 75, 900.00);

-- Reportes diarios de cierre de jornada
INSERT INTO `reportes_cierre_jornada` 
(`sucursal_id`, `fecha`, `cantidad_usuarios_dia`, `tiempo_promedio_minutos`, `ventas_servicios_tercerizados`, `ventas_membresias_total`, `usuarios_clases_natacion`, `usuarios_clases_boxeo`, `generado_en`) 
VALUES
(1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 94, 76.5, 1850.00, 7500.00, 18, 28, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(2, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 82, 68.0, 1200.00, 5250.00, 10, 0,  DATE_SUB(NOW(), INTERVAL 1 DAY)),
(1, DATE_SUB(CURDATE(), INTERVAL 2 DAY), 89, 74.0, 1400.00, 6800.00, 16, 26, DATE_SUB(NOW(), INTERVAL 2 DAY));

-- ------------------------------------------------------------------------------
-- 15. TABLAS: TIENDA DE SUPLEMENTOS Y FACTURACIÓN POS (SERVICIOS TERCERIZADOS)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `suplementos_catalogo` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `codigo` VARCHAR(50) NOT NULL UNIQUE,
    `nombre` VARCHAR(150) NOT NULL,
    `categoria` ENUM('PROTEINAS', 'CREATINAS', 'AMINOACIDOS', 'PRE_WORKOUT', 'BEBIDAS', 'ACCESORIOS') NOT NULL,
    `precio` DECIMAL(10,2) NOT NULL,
    `stock` INT NOT NULL DEFAULT 0,
    `descripcion` VARCHAR(255) NULL,
    `estado` ENUM('ACTIVO', 'INACTIVO') DEFAULT 'ACTIVO',
    `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `suplementos_ventas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `numero_factura` VARCHAR(50) NOT NULL UNIQUE,
    `cliente_id` INT NULL,
    `sucursal_id` INT NOT NULL,
    `vendedor_id` INT NOT NULL,
    `subtotal` DECIMAL(10,2) NOT NULL,
    `monto_bono_usado` DECIMAL(10,2) DEFAULT 0.00,
    `total_venta` DECIMAL(10,2) NOT NULL,
    `metodo_pago` ENUM('EFECTIVO', 'TARJETA', 'TRANSFERENCIA', 'BONO_REFERIDO') DEFAULT 'EFECTIVO',
    `fecha_venta` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_sup_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `usuarios` (`id`),
    CONSTRAINT `fk_sup_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`),
    CONSTRAINT `fk_sup_vendedor` FOREIGN KEY (`vendedor_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `suplementos_ventas_detalle` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `venta_id` INT NOT NULL,
    `producto_id` INT NOT NULL,
    `cantidad` INT NOT NULL,
    `precio_unitario` DECIMAL(10,2) NOT NULL,
    `subtotal` DECIMAL(10,2) NOT NULL,
    CONSTRAINT `fk_det_venta` FOREIGN KEY (`venta_id`) REFERENCES `suplementos_ventas` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_det_prod` FOREIGN KEY (`producto_id`) REFERENCES `suplementos_catalogo` (`id`)
) ENGINE=InnoDB;

-- Datos semilla del catálogo de suplementos
INSERT INTO `suplementos_catalogo` 
(`codigo`, `nombre`, `categoria`, `precio`, `stock`, `descripcion`) 
VALUES
('PROT-ISO-01', 'Proteína Iso Whey 5 lbs (Vainilla Francesa)', 'PROTEINAS', 450.00, 25, 'Proteína aislada de suero 25g de proteína pura por servicio.'),
('PROT-WHE-02', 'Gold Standard 100% Whey 5 lbs (Doble Chocolate)', 'PROTEINAS', 420.00, 30, 'La proteína de suero más reconocida a nivel mundial.'),
('CREA-PUR-01', 'Creatina Monohidratada Creapure 300g (Sin Sabor)', 'CREATINAS', 280.00, 40, '100% pureza alemana para fuerza explosiva y recuperación.'),
('PRE-C4-01',   'Pre-Workout C4 Original Explosive Energy (Blue Raz)', 'PRE_WORKOUT', 320.00, 20, 'Fórmula pre-entrenamiento con beta-alanina y cafeína.'),
('BCAA-XT-01',  'BCAA 2:1:1 Aminoácidos Esenciales 400g (Sandía)', 'AMINOACIDOS', 220.00, 18, 'Recuperación muscular intra y post-entreno.'),
('BEB-GAT-01',  'Bebida Isotónica Gatorade Frutas 600ml', 'BEBIDAS', 15.00, 100, 'Rehidratación inmediata y reposición de electrolitos.'),
('BEB-RED-02',  'Bebida Energizante Red Bull Energy Drink 250ml', 'BEBIDAS', 22.00, 60, 'Revitaliza cuerpo y mente antes del entrenamiento.'),
('ACC-SHK-01',  'Shaker Pro Mezclador 700ml con Filtro Renovation', 'ACCESORIOS', 65.00, 50, 'Vaso batidor a prueba de fugas libre de BPA.'),
('ACC-STR-02',  'Correas Straps Levantamiento Pesas Gym Heavy Duty', 'ACCESORIOS', 85.00, 35, 'Agarre reforzado para peso muerto y jalones pesados.');

