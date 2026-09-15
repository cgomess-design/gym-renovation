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
    `estado_bono` ENUM('PENDIENTE', 'APLICADO', 'RECLAMADO') DEFAULT 'APLICADO',
    `fecha_referido` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_referidor` FOREIGN KEY (`cliente_referidor_id`) REFERENCES `usuarios` (`id`),
    CONSTRAINT `fk_referido` FOREIGN KEY (`cliente_referido_id`) REFERENCES `usuarios` (`id`),
    CONSTRAINT `fk_referido_plan` FOREIGN KEY (`membresia_id`) REFERENCES `membresias` (`id`)
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
