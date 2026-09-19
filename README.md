# 🏋️ Renovation GYM - Sistema de Control Operativo (Línea Améliorant)

Sistema web integral de gestión operativa y administrativa para la cadena de gimnasios **Renovation GYM**, diseñado para soportar la expansión y operación simultánea de sus **5 sucursales**, administración de personal biométrico, catálogo de membresías exclusivas (*Básica* y *Haute*), control de aforo por clases, órdenes de compra y mantenimiento de usuarios.

---

## 📋 Tabla de Contenidos

1. [Descripción General](#-descripción-general)
2. [Reglas del Negocio y Características](#-reglas-del-negocio-y-características)
3. [Arquitectura del Proyecto](#-arquitectura-del-proyecto)
4. [Estructura de Directorios](#-estructura-de-directorios)
5. [Tecnologías Utilizadas](#-tecnologías-utilizadas)
6. [Instalación y Configuración](#-instalación-y-configuración)
7. [Usuarios y Credenciales de Prueba](#-usuarios-y-credenciales-de-prueba)
8. [Módulos Implementados](#-módulos-implementados)
9. [Seguridad y Buenas Prácticas](#-seguridad-y-buenas-prácticas)

---

## 📌 Descripción General

El sistema permite centralizar la administración de la cadena **Renovation GYM**, garantizando:
- Autenticación segura de usuarios con separación por roles y permisos.
- Visualización de indicadores operativos en tiempo real (KPIs) en un **Dashboard** interactivo.
- Mantenimiento completo (CRUD) de usuarios internos, tercerizados y clientes mediante interfaces modales asíncronas.
- Separación de responsabilidades: lógica de negocio en PHP puro, estilos en hojas CSS dedicadas y dinamismo en JavaScript nativo.

---

## 🎯 Reglas del Negocio y Características

El proyecto responde a los requerimientos operativos de la cadena:

1. **Gestión de 5 Sucursales:**
   - Control individual y consolidado por sucursal con aforo estimado de **75 a 100 usuarios**.
2. **Tipos de Personal y Control Biométrico:**
   - **Personal Interno:** Jornadas laborales de 8 horas diarias + 1 hora de almuerzo, con registro biométrico de huella dactilar.
   - **Personal Tercerizado:** Profesionales independientes (nutricionistas, fisioterapeutas) asociados por convenio.
   - **Clientes:** Usuarios con membresía activa y acceso según plan contratado.
3. **Membresías Línea Améliorant:**
   - **Membresía Básica (Q250.00 / mes):** Acceso ilimitado a áreas estándar, 1 sesión de coaching semanal, 10% de descuento en parqueo, 2 días de pase de prueba al mes para 1 tercero, bono de **Q100.00** por referido.
   - **Membresía Haute (Q350.00 / mes):** Acceso integral incluyendo piscinas y área de boxeo, 10% de descuento en servicios tercerizados, 20% de descuento en parqueo, 5 días de prueba al mes para 2 terceros, 3 sesiones de retroalimentación, 3 usos semanales de sillón de masaje, bono de **Q150.00** por referido.
4. **Clases Especializadas y Aforo:**
   - **Natación:** Aforo máximo de 10 personas.
   - **Boxeo:** Aforo máximo de 15 personas.
   - Sesiones de 1 hora programadas en horario de 6:00 AM a 7:00 PM.
5. **Metas y Bonos de Desempeño:**
   - **Coaches / Entrenadores:** Bonos mensuales de **Q700.00** (1er lugar) y **Q500.00** (2do lugar) por métricas de retención, referidos y fidelización.
   - **Recepción:** Bonos de **Q700.00** y **Q500.00** por volumen de inscripciones, ventas cruzadas y cobro de parqueo.
6. **Inventario y Proveedores:**
   - Identificación y evaluación de maquinaria, equipos certificados al 100% y comparación competitiva de proveedores.

---

## 🏗️ Arquitectura del Proyecto

El sistema está estructurado bajo el principio de **Separación de Responsabilidades (SoC)**:

```
[ Frontend (HTML / CSS / JS) ]
       │
       ▼  Peticiones HTTP (GET / POST)
[ Controladores PHP (Backend / Lógica) ]
       │
       ▼  Consultas Preparadas (PDO)
[ Base de Datos MySQL (gym_renovation) ]
```

- **Vistas (Presentation):** Archivos PHP limpios que solo renderizan el DOM y los componentes visuales.
- **Controladores (Business Logic):** Scripts independientes en PHP que validan peticiones, procesan datos y ejecutan consultas SQL.
- **Estilos (CSS):** Hojas de diseño desacopladas bajo una paleta atlética moderna (*Dark Athletic Theme*).
- **Interactividad (JS):** Scripts que gestionan eventos del DOM, validaciones en cliente y modales interactivos de Bootstrap.

---

## 📁 Estructura de Directorios

```plaintext
c:\xampp\htdocs\Gym\
│
├── DB/
│   └── conexion.php               # Conexión centralizada a MySQL con PDO
│
├── login/
│   ├── validar_login.php          # Lógica backend de autenticación y sesiones
│   └── logout.php                 # Cierre seguro de sesión y redirección
│
├── menu/
│   ├── dashboard.php              # Vista principal del Dashboard y navegación
│   └── controlador_dashboard.php  # Lógica del dashboard y validación de acceso
│
├── usuarios/
│   ├── index.php                  # Vista de Mantenimiento de Usuarios (Tabla + Modales)
│   └── controlador_usuarios.php   # Lógica CRUD de usuarios (Crear, Editar, Eliminar)
│
├── inscripciones/
│   ├── index.php                  # Vista de Inscripciones y Membresías (Tabla + Modales)
│   └── controlador_inscripciones.php # CRUD de membresías, asignación de planes y facturación
│
├── ordenes_compra/
│   ├── index.php                  # Vista de Órdenes de Compra y Proveedores
│   └── controlador_ordenes.php    # CRUD de compras, estados y comparativa de proveedores
│
├── inventario/
│   ├── index.php                  # Vista de Inventario de Maquinaria y Equipos
│   └── controlador_inventario.php # CRUD de equipos, certificados 100% calidad y estados
│
├── clases/
│   ├── index.php                  # Vista de Clases y Control de Aforo (Natación y Boxeo)
│   └── controlador_clases.php     # Programación de clases, aforos (10 y 15) y coaches
│
├── metricas/
│   ├── index.php                  # Vista de Métricas y Liquidación de Bonos
│   └── controlador_metricas.php   # Evaluación de metas semanales y bonos Q700/Q500
│
├── cierre/
│   ├── index.php                  # Vista de Reporte Diario de Cierre de Jornada
│   └── controlador_cierre.php     # Balance diario operativo y financiero por sucursal
│
├── suplementos/
│   ├── index.php                  # Vista de Tienda de Suplementos y POS
│   └── controlador_suplementos.php # Facturación de suplementos, control de stock y canje de bonos
│
├── referidos/
│   ├── index.php                  # Vista de Referidos y Entrega de Dinero
│   └── controlador_referidos.php  # Liquidación de bonos (Efectivo/Transf/Descuento) y egresos
│
├── css/
│   ├── bootstrap.min.css          # Framework Bootstrap 5.3 (local)
│   ├── login.css                  # Estilos visuales del Login
│   ├── dashboard.css              # Estilos del Dashboard, Sidebar y KPIs
│   ├── usuarios.css               # Estilos del Mantenimiento de Usuarios y Tablas
│   ├── inscripciones.css          # Estilos de planes y beneficios de membresías
│   ├── ordenes.css                # Estilos de estados de compra y proveedores
│   ├── inventario.css             # Estilos de estados operativos y certificados
│   ├── clases.css                 # Estilos de disciplinas y barras de aforo
│   ├── metricas.css               # Estilos de metas y porcentajes de bono
│   ├── cierre.css                 # Estilos de balance diario y recibos ejecutivos
│   ├── suplementos.css            # Estilos de tarjetas de producto y panel de carrito POS
│   └── referidos.css              # Estilos de badges de bonos y comprobantes de egreso
│
├── js/
│   ├── bootstrap.bundle.min.js    # Bootstrap 5 JS Bundle (local)
│   ├── login.js                   # Interactividad y validaciones del Login
│   ├── usuarios.js                # Control de modales de Usuarios
│   ├── inscripciones.js           # Lógica interactiva de Inscripciones y Precios
│   ├── ordenes.js                 # Control de modales y visor de Proveedores
│   ├── inventario.js              # Ficha técnica y códigos de Inventario
│   ├── clases.js                  # Control de aforo dinámico y horarios de Clases
│   ├── metricas.js                # Cálculo dinámico de bonos y porcentajes
│   ├── cierre.js                  # Comprobante ejecutivo de Cierre Diario
│   ├── suplementos.js             # Carrito POS interactivo y canje de saldos de referidos
│   └── referidos.js               # Control de entrega de dinero y recibos de egreso
│
├── index.php                      # Página de inicio / Login del sistema
├── database.sql                   # Script DDL/DML con 17 tablas relacionales y datos semilla
└── README.md                      # Documentación general y completa del proyecto
```

---

## 💻 Tecnologías Utilizadas

- **Lenguaje Backend:** PHP 7.4+ / 8.x (Programación estructurada limpia, PDO, Password Hashing BCRYPT).
- **Base de Datos:** MySQL 5.7+ / MariaDB 10.4+ (Motor InnoDB, claves foráneas, restricciones de integridad).
- **Frontend:**
  - HTML5 Semántico.
  - CSS3 con variables personalizadas (*Custom Properties*), Flexbox y CSS Grid.
  - JavaScript ES6+ nativo (Vanilla JS).
  - Bootstrap 5.3 (empaquetado localmente, sin dependencia de CDNs externos).
- **Entorno de Servidor:** XAMPP (Apache + MySQL).

---

## 🚀 Instalación y Configuración

### 1. Prerrequisitos
- Tener instalado [XAMPP](https://www.apachefriends.org/) (o cualquier stack Apache + MySQL + PHP).
- PHP con la extensión `pdo_mysql` habilitada.

### 2. Ubicación del Código
Coloca la carpeta del proyecto dentro del directorio raíz de Apache:
```plaintext
C:\xampp\htdocs\Gym
```

### 3. Configuración de la Base de Datos
1. Inicia los servicios de **Apache** y **MySQL** desde el Panel de Control de XAMPP.
2. Abre **phpMyAdmin** en tu navegador: [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Crea una nueva base de datos llamada:
   ```sql
   CREATE DATABASE gym_renovation CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
4. Importa el archivo [`database.sql`](file:///c:/xampp/htdocs/Gym/database.sql) incluido en la raíz del proyecto.

### 4. Configurar Conexión (`DB/conexion.php`)
Si tu instalación de MySQL utiliza un puerto o credenciales distintas a las predeterminadas, edita el archivo [`DB/conexion.php`](file:///c:/xampp/htdocs/Gym/DB/conexion.php):

```php
$host = '127.0.0.1:3307';      // Cambiar a '127.0.0.1' o tu puerto correspondiente (ej. 3306)
$dbname = 'gym_renovation';
$user = 'root';
$pass = '123456';               // Contraseña de tu motor MySQL
```

### 5. Acceder a la Aplicación
Abre tu navegador e ingresa a:
```
http://localhost/Gym/
```

---

## 🔑 Usuarios y Credenciales de Prueba

El script de base de datos incluye cuentas sembradas para los diferentes roles y perfiles:

| Rol | Usuario | Contraseña | Nombre | Tipo Personal | Sucursal |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Administrador General** | `admin` | `admin123` | Carlos Mendoza | INTERNO | Central |
| **Gerente de Sucursal** | `gerente` | `gerente123` | Valeria Ríos | INTERNO | Central |
| **Recepcionista** | `recepcion` | `recep123` | Sofía López | INTERNO | Central |
| **Coach / Entrenador** | `coach1` | `coach123` | Marcos Gómez | INTERNO | Central |
| **Partner Tercerizado** | `nutri` | `partner123` | Dra. Claudia Paredes | TERCERIZADO | Central |
| **Cliente Membresía Haute** | `cliente1` | `cliente123` | Juan Pérez | CLIENTE | Central |

---

## 📦 Módulos Implementados

### 1. Inicio de Sesión (`index.php`)
- Interfaz moderna con tema oscuro atlético y efectos de foco naranja neón.
- Verificación segura de contraseñas con soporte híbrido (`password_verify` y compatibilidad para contraseñas de prueba).
- Detección de rol y almacenamiento de sesión (`$_SESSION['usuario_id']`, nombre, rol, avatar, etc.).
- Mensajes informativos ante credenciales erróneas o cierre de sesión.

### 2. Dashboard General (`menu/dashboard.php`)
- **Control de Acceso:** Redirección automática al login si no existe una sesión válida.
- **Menú Lateral (Sidebar):** Módulos agrupados (Principal, Gestión y Operación, Reportes).
- **Hero Central de Perfil:**
  - Avatar con iniciales dinámicas.
  - Badge distintivo del rol con colores específicos por nivel de acceso.
  - Cajas de detalle para correo, sucursal activa, vinculación laboral y fecha/hora del último acceso.
- **Tarjetas de Indicadores Operativos (KPIs):** Aforo por sucursal, membresías de la Línea Améliorant, clases con cupos y control de inventario.
- **Módulos del Sistema:** Insignias de acceso rápido a los módulos requeridos.

### 3. Mantenimiento de Usuarios (`usuarios/index.php`)
- **Listado Dinámico:** Tabla responsive con paginación visual, datos del usuario, rol, sucursal y estado activo/inactivo.
- **Creación de Usuarios:** Botón superior `+ Nuevo Usuario` que abre una ventana modal con validación de datos, selección de rol, sucursal, tipo de personal y encriptación de contraseña (`PASSWORD_BCRYPT`).
- **Acciones por Registro:**
  - 👁️ **Ver:** Modal con vista completa del expediente del usuario, datos biométricos (hash de huella dactilar) y registro de auditoría.
  - ✏️ **Editar:** Modal para actualizar nombres, correo, teléfono, rol, sucursal, tipo de persona y estado.
  - 🗑️ **Eliminar:** Modal de confirmación con borrado inteligente: si el usuario cuenta con historial operativo, se desactiva lógicamente para proteger la integridad referencial.

### 4. Inscripción & Membresías (`inscripciones/index.php`)
- **Afiliación de Clientes:** Asignación de planes exclusivos (Membresía Básica Q250.00 y Membresía Haute Q350.00).
- **Facturación Automática:** Emisión en tiempo real de factura correlativa (`FAC-2026-XXXXX`), registro de método de pago y recepcionista emisor.
- **Ficha de Beneficios:** Desglose interactivo en modal de descuentos en parqueo, sesiones de coaching, pases de prueba a terceros, bonos por referidos (Q100/Q150), acceso a piscinas, boxeo y sillones de masaje.
- **Acciones:** Ver detalles y beneficios, editar vigencia/renovación automática, y cancelación de membresía.

### 5. Órdenes de Compra & Proveedores (`ordenes_compra/index.php`)
- **Directorio Calificado:** Comparativa de proveedores evaluando calificación de calidad (1.0 a 5.0) e índice de precios (*Económico, Medio, Alto, Premium*).
- **Control Presupuestario:** Emisión de órdenes con número correlativo (`OC-2026-XXXX`), sucursal destino y usuario solicitante.
- **Flujo de Estados:** Transición entre estados (*SOLICITADA, APROBADA, RECIBIDA, CANCELADA*).

### 6. Inventario de Maquinaria & Equipos (`inventario/index.php`)
- **Control de Maquinaria:** Registro por categorías (*Cardio, Pesas, Estático, Sillones de Masaje, Piscina, Boxeo*).
- **Certificación de Calidad al 100%:** Acreditación formal de calidad y seguridad con número de certificado único.
- **Ciclo Operativo:** Gestión de estados (*OPERATIVO, EN MANTENIMIENTO, DE BAJA*) para auditoría de activos.

### 7. Clases & Control de Aforo (`clases/index.php`)
- **Disciplinas Deportivas:** Clases especializadas de **Natación Olímpica** (aforo máximo 10 cupos) y **Boxeo Deportivo** (aforo máximo 15 cupos).
- **Horarios Reglamentarios:** Bloques de 1 hora entre 6:00 AM y 7:00 PM con asignación de Coach instructor.
- **Monitoreo de Aforo en Vivo:** Barra de progreso visual con porcentajes y contador dinámico de cupos ocupados y disponibles.

### 8. Métricas & Bonos de Desempeño (`metricas/index.php`)
- **Reglas de Negocio:**
  - *Coaches:* Meta de 60 sesiones semanales y satisfacción CSAT &ge; 92%.
  - *Recepción:* Meta de 25 ventas/inscripciones semanales y retención &ge; 95%.
- **Liquidación Automática:** Cálculo de bonos de hasta **Q1,200.00** (Q700 primer lugar + Q500 segundo lugar/meta) según el porcentaje de cumplimiento (100%, 75%, 50% o 0%).

### 9. Reporte Diario de Cierre de Jornada (`cierre/index.php`)
- **Consolidación Diaria:** Aforo total de usuarios recibidos por sucursal y cálculo del tiempo promedio de permanencia (minutos).
- **Balance Financiero:** Ingresos consolidados por venta de membresías y servicios tercerizados (suplementos, bebidas, nutrición).
- **Comprobante Ejecutivo:** Generación de recibo/balance diario imprimible y auditable.

### 10. Tienda de Suplementos & Punto de Venta (POS) (`suplementos/index.php`)
- **Facturación de Servicios Tercerizados:** Venta ágil de suplementos oficiales (proteínas Whey, creatina Creapure, pre-entrenos C4, aminoácidos BCAA, bebidas energéticas e isotónicas, shakers y accesorios).
- **Punto de Venta con Carrito Interactivo:** Panel sticky lateral con cálculo en vivo de subtotales, totales y soporte para cliente mostrador o miembro registrado.
- **Canje Directo de Bonos de Referidos:** Detección automática del saldo disponible por referidos del cliente seleccionado, permitiendo cubrir parcial o totalmente la factura con su saldo acumulado.
- **Facturación y Tickets Correlativos:** Generación automática de facturas exclusivas (`FAC-SUP-2026-XXXXX`), control de stock en tiempo real y modal de impresión de tickets.

### 11. Programa de Referidos & Bonos en Efectivo (`referidos/index.php`)
- **Fidelización y Recompensa Automática:** Generación de bonos al inscribir nuevos miembros recomendados:
  - **Q100.00** por afiliación al Plan Básico.
  - **Q150.00** por afiliación al Plan Haute.
- **Modalidades de Entrega de Dinero:**
  - 💵 **Efectivo en Caja / Recepción:** Liquidación física inmediata con generación de **Comprobante de Egreso de Caja** (`EGR-REF-2026-XXXXX`) firmado por el cliente.
  - 🏦 **Transferencia Bancaria:** Registro de banco receptor y número de boleta/referencia.
  - 🎟️ **Descuento en Mensualidad:** Aplicación directa a la próxima cuota de membresía del socio.
  - 🥤 **Canje en Tienda:** Utilizable como saldo en la tienda de suplementos del gimnasio.
- **Trazabilidad y Auditoría:** Control de recepcionista pagador, fecha de liquidación, estado del bono (*PENDIENTE, RECLAMADO, APLICADO*) e historial completo.

---

## 🛡️ Seguridad y Buenas Prácticas

- **Prevención de SQL Injection:** Todas las interacciones con la base de datos se ejecutan mediante sentencias preparadas con PDO (`prepare` y `execute`).
- **Protección XSS:** Todos los datos impresos en pantalla se filtran rigurosamente con `htmlspecialchars($var, ENT_QUOTES, 'UTF-8')`.
- **Almacenamiento de Contraseñas:** Se utiliza el algoritmo `PASSWORD_BCRYPT` mediante la función nativa `password_hash()` de PHP.
- **Manejo de Sesiones:** Destrucción completa de cookies de sesión y variables en `login/logout.php`.
- **Integridad Referencial:** Llaves foráneas con reglas `ON DELETE RESTRICT` y `ON UPDATE CASCADE` en el modelo relacional.
- **Assets Locales:** Todas las librerías CSS y JavaScript están alojadas localmente en el proyecto, garantizando funcionamiento sin conexión a internet.

---

## 👨‍💻 Autor y Proyecto

Desarrollado para la administración y expansión operativa de **Renovation GYM** (Línea *Améliorant*).
