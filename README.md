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
│   ├── dashboard.php              # Vista principal del Dashboard
│   └── controlador_dashboard.php  # Lógica del dashboard y validación de acceso
│
├── usuarios/
│   ├── index.php                  # Vista del Mantenimiento de Usuarios (Tabla + Modales)
│   └── controlador_usuarios.php   # Lógica CRUD de usuarios (Crear, Editar, Eliminar)
│
├── css/
│   ├── bootstrap.min.css          # Framework Bootstrap 5.3 (local)
│   ├── login.css                  # Estilos visuales del Login
│   ├── dashboard.css              # Estilos del Dashboard, Sidebar y KPIs
│   └── usuarios.css               # Estilos del Mantenimiento de Usuarios y Tablas
│
├── js/
│   ├── bootstrap.bundle.min.js    # Bootstrap 5 JS Bundle (local)
│   ├── login.js                   # Interactividad y validaciones del Login
│   └── usuarios.js                # Control de modales (Ver, Editar, Eliminar)
│
├── index.php                      # Página de inicio / Login del sistema
├── database.sql                   # Script DDL/DML con 14 tablas relacionales y seeds
└── README.md                      # Documentación general del proyecto
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
