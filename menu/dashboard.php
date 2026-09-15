<?php
// Cargar la lógica y protección de sesión del Dashboard
require_once __DIR__ . '/controlador_dashboard.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Renovation GYM (Améliorant)</title>
    
    <!-- Bootstrap 5 CSS local -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    <!-- Estilos del Dashboard -->
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<div class="dashboard-wrapper">

    <!-- ======================================================= -->
    <!-- 1. BARRA LATERAL DE NAVEGACIÓN (SIDEBAR)                -->
    <!-- ======================================================= -->
    <aside class="sidebar" id="sidebar">
        
        <!-- Logo / Identidad corporativa -->
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <!-- Icono SVG Pesa -->
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 5v14"/>
                    <path d="M18 5v14"/>
                    <path d="M2 9v6"/>
                    <path d="M22 9v6"/>
                    <path d="M6 12h12"/>
                </svg>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-white tracking-wide" style="font-size: 1.05rem;">RENOVATION GYM</h6>
                <span class="badge" style="background-color: rgba(255, 87, 34, 0.2); color: #ff8a50; border: 1px solid rgba(255, 87, 34, 0.4); font-size: 0.68rem; letter-spacing: 0.5px; font-weight: 600;">Línea Améliorant</span>
            </div>
        </div>

        <!-- Menú de navegación con las opciones solicitadas -->
        <nav class="sidebar-menu">
            
            <div class="menu-category">Principal</div>
            <a href="dashboard.php" class="sidebar-link active">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Dashboard</span>
            </a>

            <div class="menu-category">Gestión y Operación</div>

            <!-- Opción: Usuarios -->
            <a href="../usuarios/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Usuarios</span>
            </a>

            <!-- Opción: Inscripción & Membresías -->
            <a href="#modulo-inscripciones" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                <span>Inscripción</span>
            </a>

            <!-- Opción: Órdenes de Compra -->
            <a href="#modulo-ordenes" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span>Orden de Compra</span>
            </a>

            <!-- Opción: Inventario & Equipos -->
            <a href="#modulo-inventario" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
                <span>Inventario de Equipos</span>
            </a>

            <!-- Opción: Clases y Aforo (Natación y Boxeo) -->
            <a href="#modulo-clases" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span>Clases & Aforo</span>
            </a>

            <div class="menu-category">Reportes & Desempeño</div>

            <!-- Opción: Métricas y Bonos -->
            <a href="#modulo-metricas" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                <span>Métricas & Bonos</span>
            </a>

            <!-- Opción: Cierre de Jornada -->
            <a href="#modulo-cierre" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span>Cierre de Jornada</span>
            </a>

        </nav>

        <!-- Botón de Cerrar Sesión en el Sidebar -->
        <div class="sidebar-footer">
            <a href="../login/logout.php" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 py-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Cerrar Sesión</span>
            </a>
        </div>

    </aside>

    <!-- ======================================================= -->
    <!-- 2. ÁREA PRINCIPAL DE CONTENIDO                          -->
    <!-- ======================================================= -->
    <div class="main-content">
        
        <!-- Barra Superior (Topbar) -->
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-dark d-lg-none" id="btnToggleSidebar" title="Menú">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <div class="d-none d-sm-block">
                    <span class="small" style="color: #cbd5e1;">Sucursal asignada:</span>
                    <strong class="text-white ms-1">📍 <?= htmlspecialchars($sucursal) ?></strong>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-md-block">
                    <div class="fw-semibold text-white small"><?= htmlspecialchars($nombre_completo) ?></div>
                    <div style="color: #cbd5e1; font-size: 0.78rem;"><?= htmlspecialchars($rol) ?></div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle text-light d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                        <span class="badge bg-primary"><?= htmlspecialchars($iniciales) ?></span>
                        <span class="d-none d-sm-inline">Mi Cuenta</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                        <li><h6 class="dropdown-header text-white"><?= htmlspecialchars($email) ?></h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger d-flex align-items-center gap-2" href="../login/logout.php">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Cerrar Sesión
                        </a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Cuerpo del Dashboard -->
        <main class="content-body">
            
            <!-- Encabezado de bienvenida -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h2 class="h4 fw-bold text-white mb-1">Panel General</h2>
                    <p class="small mb-0" style="color: #cbd5e1; font-size: 0.95rem;">Sistema de Control Operativo - Expansión a 5 Sucursales</p>
                </div>
                <div>
                    <span class="badge py-2 px-3" style="background-color: #0b111e; border: 1px solid #38bdf8; color: #38bdf8; font-size: 0.85rem; font-weight: 600;">
                        📅 <?= date('d/m/Y') ?> &bull; Horario: 4:00 AM - 10:00 PM
                    </span>
                </div>
            </div>

            <!-- ======================================================= -->
            <!-- 3. EN EL CENTRO: INFORMACIÓN BÁSICA DEL USUARIO LOGUEADO -->
            <!-- ======================================================= -->
            <section class="user-profile-hero mb-4">
                <div class="row align-items-center g-4">
                    
                    <!-- Avatar e Identificación Principal -->
                    <div class="col-lg-4 text-center text-lg-start d-flex flex-column flex-lg-row align-items-center gap-3">
                        <div class="user-avatar-circle">
                            <?= htmlspecialchars($iniciales) ?>
                        </div>
                        <div>
                            <span class="badge <?= $badge_class ?> mb-2"><?= htmlspecialchars($rol) ?></span>
                            <h3 class="h5 fw-bold text-white mb-1"><?= htmlspecialchars($nombre_completo) ?></h3>
                            <p class="small mb-0" style="color: #cbd5e1; font-size: 0.88rem;">@<?= htmlspecialchars($usuario_login) ?> &bull; Personal <?= htmlspecialchars($tipo_persona) ?></p>
                        </div>
                    </div>

                    <!-- Datos Detallados del Perfil -->
                    <div class="col-lg-8">
                        <div class="row g-3">
                            
                            <!-- Caja: Correo Electrónico -->
                            <div class="col-sm-6">
                                <div class="user-info-box">
                                    <div class="info-icon-wrapper">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="info-label">Correo Electrónico</div>
                                        <div class="text-white fw-medium text-truncate" title="<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Caja: Sucursal Asignada -->
                            <div class="col-sm-6">
                                <div class="user-info-box">
                                    <div class="info-icon-wrapper">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="info-label">Sucursal Activa</div>
                                        <div class="text-white fw-medium text-truncate" title="<?= htmlspecialchars($sucursal) ?>"><?= htmlspecialchars($sucursal) ?></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Caja: Tipo de Personal / Vinculación -->
                            <div class="col-sm-6">
                                <div class="user-info-box">
                                    <div class="info-icon-wrapper">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                            <line x1="8" y1="21" x2="16" y2="21"></line>
                                            <line x1="12" y1="17" x2="12" y2="21"></line>
                                        </svg>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="info-label">Tipo de Personal</div>
                                        <div class="text-white fw-medium">
                                            <?= htmlspecialchars($tipo_persona) ?> 
                                            <span style="color: #94a3b8; font-size: 0.8rem; font-weight: normal;">(Huella dactilar activa)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Caja: Último Acceso -->
                            <div class="col-sm-6">
                                <div class="user-info-box">
                                    <div class="info-icon-wrapper">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="info-label">Última Conexión</div>
                                        <div class="text-white fw-medium"><?= htmlspecialchars($ultimo_login) ?></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </section>

            <!-- ======================================================= -->
            <!-- 4. INDICADORES CLAVE DEL GIMNASIO (RENOVATION GYM)      -->
            <!-- ======================================================= -->
            <div class="row g-3 mb-4">
                
                <!-- Indicador: Aforo -->
                <div class="col-xl-3 col-sm-6">
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background-color: rgba(56, 189, 248, 0.15); color: var(--accent-blue);">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div>
                            <div class="kpi-title mb-1">Aforo por Sucursal</div>
                            <h4 class="h5 text-white fw-bold mb-0">75 - 100 usuarios</h4>
                            <span class="small fw-semibold" style="color: #4ade80;">Control biométrico</span>
                        </div>
                    </div>
                </div>

                <!-- Indicador: Membresías -->
                <div class="col-xl-3 col-sm-6">
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background-color: rgba(255, 87, 34, 0.15); color: var(--primary-accent);">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </div>
                        <div>
                            <div class="kpi-title mb-1">Membresías Améliorant</div>
                            <h4 class="h5 text-white fw-bold mb-0">Básica Q250 &bull; Haute Q350</h4>
                            <span class="small fw-semibold" style="color: #fbbf24;">Bonos Q100 / Q150 referidos</span>
                        </div>
                    </div>
                </div>

                <!-- Indicador: Clases -->
                <div class="col-xl-3 col-sm-6">
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background-color: rgba(34, 197, 94, 0.15); color: var(--accent-green);">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="kpi-title mb-1">Aforo en Clases</div>
                            <h4 class="h5 text-white fw-bold mb-0">Natación 10 &bull; Boxeo 15</h4>
                            <span class="small fw-semibold" style="color: #38bdf8;">Duración: 1 hora (6am - 7pm)</span>
                        </div>
                    </div>
                </div>

                <!-- Indicador: Equipos -->
                <div class="col-xl-3 col-sm-6">
                    <div class="kpi-card">
                        <div class="kpi-icon" style="background-color: rgba(168, 85, 247, 0.15); color: var(--accent-purple);">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <div>
                            <div class="kpi-title mb-1">Inventario & Calidad</div>
                            <h4 class="h5 text-white fw-bold mb-0">Certificado 100%</h4>
                            <span class="small fw-semibold" style="color: #c084fc;">Comparativa de proveedores</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Accesos rápidos a los módulos requeridos -->
            <div class="row g-3">
                <div class="col-12">
                    <div class="card p-4" style="background-color: #162032; border: 1px solid #334155; border-radius: 1rem;">
                        <h6 class="text-white fw-bold mb-2" style="font-size: 1.05rem;">Módulos del Sistema</h6>
                        <p class="small mb-3" style="color: #cbd5e1; font-size: 0.9rem;">Selecciona una opción del menú lateral para acceder a la gestión correspondiente:</p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="module-badge">👥 Usuarios y Personal</span>
                            <span class="module-badge">📝 Inscripción y Facturación</span>
                            <span class="module-badge">🛒 Órdenes de Compra y Proveedores</span>
                            <span class="module-badge">🏋️ Inventario de Equipos</span>
                            <span class="module-badge">🏊‍♂️🥊 Natación y Boxeo</span>
                            <span class="module-badge">📊 Bonos (Coaches Q700/Q500, Recepción Q700/Q500)</span>
                            <span class="module-badge">📑 Reporte Diario de Cierre</span>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

</div>

<!-- Bootstrap 5 Bundle JS local -->
<script src="../js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle para menú móvil
    const btnToggleSidebar = document.getElementById('btnToggleSidebar');
    const sidebar = document.getElementById('sidebar');

    if (btnToggleSidebar && sidebar) {
        btnToggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }
</script>

</body>
</html>
