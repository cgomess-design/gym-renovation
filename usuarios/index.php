<?php
// usuarios/index.php - Vista de Mantenimiento de Usuarios

require_once __DIR__ . '/controlador_usuarios.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento de Usuarios - Renovation GYM</title>
    
    <!-- Bootstrap 5 CSS local -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    <!-- Estilos del Dashboard -->
    <link rel="stylesheet" href="../css/dashboard.css">
    
    <!-- Estilos específicos de Usuarios -->
    <link rel="stylesheet" href="../css/usuarios.css">
</head>
<body>

<div class="dashboard-wrapper">

    <!-- ======================================================= -->
    <!-- 1. BARRA LATERAL DE NAVEGACIÓN (SIDEBAR)                -->
    <!-- ======================================================= -->
    <aside class="sidebar" id="sidebar">
        
        <div class="sidebar-header">
            <div class="sidebar-logo">
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
                <span class="badge bg-secondary text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Línea Améliorant</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-category">Principal</div>
            
            <a href="../menu/dashboard.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Dashboard</span>
            </a>

            <div class="menu-category">Gestión y Operación</div>

            <!-- Opción: Usuarios (Activo) -->
            <a href="index.php" class="sidebar-link active">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Usuarios</span>
            </a>

            <!-- Otras opciones del sistema -->
            <a href="../inscripciones/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                <span>Inscripción</span>
            </a>

            <a href="../ordenes_compra/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span>Orden de Compra</span>
            </a>

            <a href="../inventario/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
                <span>Inventario de Equipos</span>
            </a>

            <a href="../clases/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span>Clases & Aforo</span>
            </a>

            <div class="menu-category">Servicios & Fidelización</div>

            <a href="../suplementos/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                <span>Suplementos (POS)</span>
            </a>

            <a href="../referidos/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    <line x1="19" y1="8" x2="19" y2="14"></line>
                    <line x1="22" y1="11" x2="16" y2="11"></line>
                </svg>
                <span>Referidos & Bonos</span>
            </a>

            <div class="menu-category">Reportes & Desempeño</div>

            <a href="../metricas/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                <span>Métricas & Bonos</span>
            </a>

            <a href="../cierre/index.php" class="sidebar-link">
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
    <!-- 2. ÁREA PRINCIPAL                                       -->
    <!-- ======================================================= -->
    <div class="main-content">
        
        <!-- Topbar -->
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-dark d-lg-none" id="btnToggleSidebar">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <div>
                    <span class="small" style="color: #cbd5e1;">Sucursal activa:</span>
                    <strong class="text-white ms-1">📍 <?= htmlspecialchars($usuario_activo_suc) ?></strong>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-md-block">
                    <div class="fw-semibold text-white small"><?= htmlspecialchars($usuario_activo_nombre) ?></div>
                    <div style="color: #cbd5e1; font-size: 0.78rem;"><?= htmlspecialchars($usuario_activo_rol) ?></div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle text-light d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                        <span class="badge bg-primary"><?= htmlspecialchars($iniciales_activo) ?></span>
                        <span class="d-none d-sm-inline">Mi Cuenta</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                        <li><a class="dropdown-item" href="../menu/dashboard.php">Mi Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="../login/logout.php">Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Contenido Central -->
        <main class="content-body">
            
            <!-- Mensajes de Alerta -->
            <?php if (!empty($mensaje_exito)): ?>
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                    <svg class="me-2" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    <div><?= htmlspecialchars($mensaje_exito) ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($mensaje_error)): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                    <svg class="me-2" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M7.002 11a1 1 0 1 0 2 0 1 1 0 0 0-2 0zm.01-6.938.14 4.995a.86.86 0 0 0 1.696 0l.14-4.995A.87.87 0 0 0 8.118 3h-.236a.87.87 0 0 0-.87.962z"/>
                    </svg>
                    <div><?= htmlspecialchars($mensaje_error) ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <!-- Cabecera con Botón de Creación Arriba de la Tabla -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div>
                    <h2 class="h4 fw-bold text-white mb-1">Mantenimiento de Usuarios</h2>
                    <p class="small mb-0" style="color: #cbd5e1; font-size: 0.95rem;">Listado, registro y control de personal interno, tercerizado y clientes.</p>
                </div>

                <!-- Botón solicitado arriba de la tabla -->
                <div>
                    <button type="button" class="btn btn-gym d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Crear Nuevo Usuario</span>
                    </button>
                </div>
            </div>

            <!-- Tarjeta de la Tabla -->
            <div class="table-responsive-card">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <span style="color: #cbd5e1; font-size: 0.9rem;">
                        Mostrando <strong class="text-white"><?= count($usuarios) ?></strong> usuarios registrados
                    </span>
                    <span class="badge py-2 px-3" style="background-color: #0b111e; border: 1px solid #38bdf8; color: #38bdf8; font-size: 0.82rem; font-weight: 600;">
                        🔒 Identificación biométrica por huella dactilar activa
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-custom align-middle">
                        <thead>
                            <tr>
                                <th># ID</th>
                                <th>Usuario / Correo</th>
                                <th>Nombre Completo</th>
                                <th>Rol & Tipo</th>
                                <th>Sucursal</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($usuarios)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        No se encontraron usuarios registrados en la base de datos.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($usuarios as $u): ?>
                                    <?php
                                        // Clase de badge según rol
                                        $bClass = 'badge-role-admin';
                                        if (stripos($u['nombre_rol'], 'GERENTE') !== false) $bClass = 'badge-role-gerente';
                                        elseif (stripos($u['nombre_rol'], 'RECEPCION') !== false) $bClass = 'badge-role-recepcion';
                                        elseif (stripos($u['nombre_rol'], 'COACH') !== false) $bClass = 'badge-role-coach';
                                        elseif (stripos($u['nombre_rol'], 'PARTNER') !== false) $bClass = 'badge-role-partner';
                                        elseif (stripos($u['nombre_rol'], 'CLIENTE') !== false) $bClass = 'badge-role-cliente';

                                        // Badge estado
                                        $estadoBadge = ($u['estado'] === 'ACTIVO') 
                                            ? 'bg-success text-white' 
                                            : (($u['estado'] === 'SUSPENDIDO') ? 'bg-warning text-dark' : 'bg-danger text-white');

                                        // Datos JSON para JS
                                        $datosJson = htmlspecialchars(json_encode($u), ENT_QUOTES, 'UTF-8');
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold" style="color: #94a3b8; font-size: 0.95rem;">#<?= htmlspecialchars($u['id']) ?></span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-white fs-6 mb-0">@<?= htmlspecialchars($u['usuario']) ?></div>
                                            <div style="color: #94a3b8; font-size: 0.85rem;"><?= htmlspecialchars($u['email']) ?></div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-white fs-6 mb-0"><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido']) ?></div>
                                            <div style="color: #94a3b8; font-size: 0.85rem;"><?= !empty($u['telefono']) ? '📞 ' . htmlspecialchars($u['telefono']) : 'Sin teléfono' ?></div>
                                        </td>
                                        <td>
                                            <span class="badge badge-role <?= $bClass ?> mb-1"><?= htmlspecialchars($u['nombre_rol']) ?></span>
                                            <div class="fw-semibold text-uppercase" style="color: #cbd5e1; font-size: 0.72rem; letter-spacing: 0.5px;">
                                                <?= htmlspecialchars($u['tipo_persona']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-medium text-white">
                                                📍 <?= !empty($u['sucursal_nombre']) ? htmlspecialchars($u['sucursal_nombre']) : '<span style="color: #94a3b8;">Central / Global</span>' ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge <?= $estadoBadge ?> py-1 px-2 fw-bold" style="font-size: 0.78rem; letter-spacing: 0.5px;">
                                                <?= htmlspecialchars($u['estado']) ?>
                                            </span>
                                        </td>
                                        <!-- 3 Botones solicitados a la derecha -->
                                        <td class="text-end text-nowrap">
                                            
                                            <!-- Botón 1: Ver -->
                                            <button 
                                                type="button" 
                                                class="btn btn-sm btn-info text-dark fw-bold me-1 px-2 py-1 shadow-sm" 
                                                title="Ver detalles"
                                                onclick='verUsuario(<?= $datosJson ?>)'
                                            >
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="me-1">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                                Ver
                                            </button>

                                            <!-- Botón 2: Editar -->
                                            <button 
                                                type="button" 
                                                class="btn btn-sm btn-warning text-dark fw-bold me-1 px-2 py-1 shadow-sm" 
                                                title="Editar usuario"
                                                onclick='editarUsuario(<?= $datosJson ?>)'
                                            >
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="me-1">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                </svg>
                                                Editar
                                            </button>

                                            <!-- Botón 3: Eliminar -->
                                            <button 
                                                type="button" 
                                                class="btn btn-sm btn-danger text-white fw-bold px-2 py-1 shadow-sm" 
                                                title="Eliminar usuario"
                                                onclick="eliminarUsuario(<?= $u['id'] ?>, '<?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido'], ENT_QUOTES) ?>', '<?= htmlspecialchars($u['usuario'], ENT_QUOTES) ?>')"
                                            >
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="me-1">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                                Eliminar
                                            </button>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</div>

<!-- =============================================================== -->
<!-- MODAL: CREAR NUEVO USUARIO                                      -->
<!-- =============================================================== -->
<div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="accion" value="crear">
                
                <div class="modal-header">
                    <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-accent)" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                        Crear Nuevo Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Nombre *</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej: Roberto" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Apellido *</label>
                            <input type="text" name="apellido" class="form-control" placeholder="Ej: Morales" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Nombre de Usuario *</label>
                            <input type="text" name="usuario" class="form-control" placeholder="Ej: rmorales" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Correo Electrónico *</label>
                            <input type="email" name="email" class="form-control" placeholder="ejemplo@gym.com" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Contraseña *</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" placeholder="5555-1234">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Rol del Sistema *</label>
                            <select name="rol_id" class="form-select" required>
                                <option value="">Seleccione un rol...</option>
                                <?php foreach ($roles as $r): ?>
                                    <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nombre_rol']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Tipo de Personal *</label>
                            <select name="tipo_persona" class="form-select" required>
                                <option value="INTERNO">INTERNO (Personal Propio)</option>
                                <option value="TERCERIZADO">TERCERIZADO (Partner)</option>
                                <option value="CLIENTE">CLIENTE (Miembro)</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Sucursal Asignada</label>
                            <select name="sucursal_id" class="form-select">
                                <option value="">Todas / Central</option>
                                <?php foreach ($sucursales as $s): ?>
                                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Identificador de Huella Dactilar (Opcional)</label>
                            <input type="text" name="huella_dactilar_hash" class="form-control" placeholder="Dejar en blanco para autogenerar código biométrico">
                            <div class="form-text text-muted">Todos los usuarios deben poseer una identificación única según los requerimientos.</div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-gym">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: VER DETALLES DEL USUARIO                                -->
<!-- =============================================================== -->
<div class="modal fade" id="modalVerUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header">
                <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-blue)" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    Detalles del Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="user-avatar-circle mx-auto mb-2" id="verAvatar" style="width: 70px; height: 70px; font-size: 1.75rem;">
                        U
                    </div>
                    <h4 class="h5 text-white fw-bold mb-1" id="verNombreCompleto">Nombre</h4>
                    <span class="badge badge-role-admin" id="verRol">ROL</span>
                    <span class="badge bg-secondary ms-1" id="verEstado">ESTADO</span>
                </div>

                <div class="list-group list-group-flush bg-transparent">
                    <div class="list-group-item bg-transparent text-light d-flex justify-content-between px-0 py-2 border-secondary">
                        <span class="text-muted">Nombre de Usuario:</span>
                        <strong id="verUsuario">@usuario</strong>
                    </div>
                    <div class="list-group-item bg-transparent text-light d-flex justify-content-between px-0 py-2 border-secondary">
                        <span class="text-muted">Correo Electrónico:</span>
                        <span id="verEmail">correo@gym.com</span>
                    </div>
                    <div class="list-group-item bg-transparent text-light d-flex justify-content-between px-0 py-2 border-secondary">
                        <span class="text-muted">Teléfono:</span>
                        <span id="verTelefono">-</span>
                    </div>
                    <div class="list-group-item bg-transparent text-light d-flex justify-content-between px-0 py-2 border-secondary">
                        <span class="text-muted">Tipo de Personal:</span>
                        <span class="fw-semibold" id="verTipo">INTERNO</span>
                    </div>
                    <div class="list-group-item bg-transparent text-light d-flex justify-content-between px-0 py-2 border-secondary">
                        <span class="text-muted">Sucursal:</span>
                        <span id="verSucursal">Sede Principal</span>
                    </div>
                    <div class="list-group-item bg-transparent text-light d-flex justify-content-between px-0 py-2 border-secondary">
                        <span class="text-muted">Código Biométrico (Huella):</span>
                        <code class="text-warning small" id="verHuella">BIO-XXXX</code>
                    </div>
                    <div class="list-group-item bg-transparent text-light d-flex justify-content-between px-0 py-2 border-secondary">
                        <span class="text-muted">Último Acceso:</span>
                        <span id="verUltimoLogin">-</span>
                    </div>
                    <div class="list-group-item bg-transparent text-light d-flex justify-content-between px-0 py-2 border-secondary">
                        <span class="text-muted">Fecha de Registro:</span>
                        <span id="verCreatedAt">-</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: EDITAR USUARIO                                           -->
<!-- =============================================================== -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="accion" value="editar">
                <input type="hidden" name="id" id="editId">
                
                <div class="modal-header">
                    <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-purple)" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        Editar Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Nombre *</label>
                            <input type="text" name="nombre" id="editNombre" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Apellido *</label>
                            <input type="text" name="apellido" id="editApellido" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Nombre de Usuario *</label>
                            <input type="text" name="usuario" id="editUsuario" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Correo Electrónico *</label>
                            <input type="email" name="email" id="editEmail" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Nueva Contraseña (Opcional)</label>
                            <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para no cambiar">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Teléfono</label>
                            <input type="text" name="telefono" id="editTelefono" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Rol del Sistema *</label>
                            <select name="rol_id" id="editRolId" class="form-select" required>
                                <?php foreach ($roles as $r): ?>
                                    <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nombre_rol']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Tipo de Personal *</label>
                            <select name="tipo_persona" id="editTipoPersona" class="form-select" required>
                                <option value="INTERNO">INTERNO (Personal Propio)</option>
                                <option value="TERCERIZADO">TERCERIZADO (Partner)</option>
                                <option value="CLIENTE">CLIENTE (Miembro)</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Estado de la Cuenta *</label>
                            <select name="estado" id="editEstado" class="form-select" required>
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="INACTIVO">INACTIVO</option>
                                <option value="SUSPENDIDO">SUSPENDIDO</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Sucursal Asignada</label>
                            <select name="sucursal_id" id="editSucursalId" class="form-select">
                                <option value="">Todas / Central</option>
                                <?php foreach ($sucursales as $s): ?>
                                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-semibold">Código Huella Dactilar</label>
                            <input type="text" name="huella_dactilar_hash" id="editHuella" class="form-control">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning fw-semibold">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: CONFIRMAR ELIMINACIÓN                                    -->
<!-- =============================================================== -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="eliminar">
                <input type="hidden" name="id" id="deleteId">
                
                <div class="modal-header border-danger">
                    <h5 class="modal-title text-danger fw-bold d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                        Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-center">
                    <p class="text-light mb-2">¿Estás seguro de que deseas eliminar este usuario?</p>
                    <h5 class="text-white fw-bold mb-1" id="deleteNombre">Usuario</h5>
                    <p class="text-muted small" id="deleteUsuario">@usuario</p>
                    <div class="alert alert-dark border-secondary small text-start mb-0">
                        <strong>Nota:</strong> Si el usuario posee registros históricos vinculados (facturas, clases o asistencias), se marcará como <strong>INACTIVO</strong> para preservar la integridad de los datos.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Sí, Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle JS local -->
<script src="../js/bootstrap.bundle.min.js"></script>

<!-- Scripts específicos de Usuarios -->
<script src="../js/usuarios.js"></script>

</body>
</html>
