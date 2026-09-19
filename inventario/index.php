<?php
// inventario/index.php - Vista de Inventario de Equipos y Certificados de Calidad
require_once __DIR__ . '/controlador_inventario.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Equipos - Renovation GYM</title>
    
    <!-- Bootstrap 5 CSS local -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    <!-- Estilos generales y del Dashboard -->
    <link rel="stylesheet" href="../css/dashboard.css">
    
    <!-- Estilos base de tablas y modales -->
    <link rel="stylesheet" href="../css/usuarios.css">
    
    <!-- Estilos específicos de Inventario -->
    <link rel="stylesheet" href="../css/inventario.css">
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
                <span class="badge" style="background-color: rgba(255, 87, 34, 0.2); color: #ff8a50; border: 1px solid rgba(255, 87, 34, 0.4); font-size: 0.68rem; letter-spacing: 0.5px; font-weight: 600;">Línea Améliorant</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-category">Principal</div>
            <a href="../menu/dashboard.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Dashboard</span>
            </a>

            <div class="menu-category">Gestión y Operación</div>

            <a href="../usuarios/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Usuarios</span>
            </a>

            <a href="../inscripciones/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                <span>Inscripción</span>
            </a>

            <a href="../ordenes_compra/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span>Orden de Compra</span>
            </a>

            <!-- Módulo Activo: Inventario -->
            <a href="index.php" class="sidebar-link active">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
                <span>Inventario de Equipos</span>
            </a>

            <a href="../clases/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span>Clases & Aforo</span>
            </a>

            <div class="menu-category">Servicios & Fidelización</div>

            <a href="../suplementos/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                <span>Suplementos (POS)</span>
            </a>

            <a href="../referidos/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                <span>Métricas & Bonos</span>
            </a>

            <a href="../cierre/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Cerrar Sesión</span>
            </a>
        </div>
    </aside>

    <!-- ======================================================= -->
    <!-- 2. CONTENIDO PRINCIPAL                                  -->
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
                        <li><a class="dropdown-item text-danger d-flex align-items-center gap-2" href="../login/logout.php">Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Cuerpo del Módulo -->
        <main class="content-body">
            
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h2 class="h4 fw-bold text-white mb-1">Inventario de Equipos</h2>
                    <p class="small mb-0" style="color: #cbd5e1;">Control de maquinaria de alto rendimiento, certificados de calidad 100% y mantenimiento</p>
                </div>
                <div>
                    <button type="button" class="btn btn-gym d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoEquipo">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Nuevo Equipo</span>
                    </button>
                </div>
            </div>

            <!-- Notificaciones -->
            <?php if (!empty($mensaje_exito)): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background-color: #064e3b; color: #a7f3d0; border-color: #059669;">
                    <div class="d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <div><?= $mensaje_exito ?></div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($mensaje_error)): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="background-color: #7f1d1d; color: #fecaca; border-color: #dc2626;">
                    <div class="d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <div><?= htmlspecialchars($mensaje_error) ?></div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Tabla de Inventario -->
            <div class="table-responsive-card">
                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Equipo</th>
                                <th>Categoría</th>
                                <th>Sucursal</th>
                                <th>Certificado</th>
                                <th>Estado</th>
                                <th>Fecha Adq.</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($equipos)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4" style="color: #94a3b8;">
                                        No hay equipos registrados en el inventario. Presiona <strong>"Nuevo Equipo"</strong> para añadir maquinaria.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($equipos as $eq): ?>
                                    <?php
                                    $badgeOpClass = 'badge-operativo-activo';
                                    if ($eq['estado_operativo'] === 'EN_MANTENIMIENTO') $badgeOpClass = 'badge-operativo-mantenimiento';
                                    elseif ($eq['estado_operativo'] === 'DE_BAJA') $badgeOpClass = 'badge-operativo-baja';
                                    ?>
                                    <tr>
                                        <td class="fw-bold" style="color: #38bdf8;"><?= htmlspecialchars($eq['codigo_inventario']) ?></td>
                                        <td>
                                            <div class="fw-bold text-white"><?= htmlspecialchars($eq['nombre_equipo']) ?></div>
                                            <?php if (!empty($eq['numero_orden'])): ?>
                                                <div class="small" style="color: #94a3b8;">OC: <?= htmlspecialchars($eq['numero_orden']) ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-categoria px-2 py-1">
                                                <?= htmlspecialchars($eq['categoria']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background-color: #1e293b; color: #cbd5e1; border: 1px solid #475569;">
                                                📍 <?= htmlspecialchars($eq['sucursal_nombre']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-cert-100 px-2 py-1">
                                                🛡️ Certificado 100%
                                            </span>
                                            <div class="small text-truncate mt-1" style="color: #94a3b8; max-width: 140px;" title="<?= htmlspecialchars($eq['numero_certificado']) ?>">
                                                <?= htmlspecialchars($eq['numero_certificado']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge <?= $badgeOpClass ?> px-2 py-1 text-uppercase" style="font-size: 0.75rem;">
                                                <?= htmlspecialchars(str_replace('_', ' ', $eq['estado_operativo'])) ?>
                                            </span>
                                        </td>
                                        <td class="small" style="color: #cbd5e1;">
                                            <?= date('d/m/Y', strtotime($eq['fecha_adquisicion'])) ?>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-1">
                                                <!-- Ver -->
                                                <button type="button" class="btn btn-sm btn-outline-info" title="Ficha Técnica y Certificado" onclick='verEquipo(<?= json_encode($eq) ?>)'>
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                </button>
                                                <!-- Editar -->
                                                <button type="button" class="btn btn-sm btn-outline-warning" title="Editar Equipo" onclick='editarEquipo(<?= json_encode($eq) ?>)'>
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </button>
                                                <!-- Dar de Baja -->
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Dar de Baja" onclick='eliminarEquipo(<?= $eq["id"] ?>, "<?= htmlspecialchars($eq["codigo_inventario"]) ?>", "<?= htmlspecialchars($eq["nombre_equipo"]) ?>")'>
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                </button>
                                            </div>
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
<!-- MODAL: NUEVO EQUIPO                                             -->
<!-- =============================================================== -->
<div class="modal fade" id="modalNuevoEquipo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="crear">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        Registrar Nuevo Equipo de Gimnasio
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label">Nombre del Equipo *</label>
                            <input type="text" name="nombre_equipo" class="form-control" placeholder="Ej. Caminadora Matrix T70 Cardio" required>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Categoría *</label>
                            <select name="categoria" id="nuevoCategoria" class="form-select" required>
                                <option value="PESAS">PESAS & MANCUERNAS</option>
                                <option value="CARDIO">CARDIO & RUNNING</option>
                                <option value="ESTATICO">MÁQUINAS ESTÁTICAS</option>
                                <option value="SILLON_MASAJE">SILLONES DE MASAJE</option>
                                <option value="BOXEO">EQUIPAMIENTO DE BOXEO</option>
                                <option value="PISCINA">EQUIPOS DE PISCINA</option>
                                <option value="BANDAS">BANDAS ELÁSTICAS</option>
                                <option value="CUERDAS">CUERDAS DE SALTO</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Código de Inventario *</label>
                            <input type="text" name="codigo_inventario" id="nuevoCodigo" class="form-control" value="EQ-PESA-<?= mt_rand(100, 999) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Sucursal Asignada *</label>
                            <select name="sucursal_id" class="form-select" required>
                                <?php foreach ($sucursales as $suc): ?>
                                    <option value="<?= $suc['id'] ?>"><?= htmlspecialchars($suc['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Número de Certificado de Calidad *</label>
                            <input type="text" name="numero_certificado" class="form-control" value="CERT-ISO-9001-Q100-<?= mt_rand(100, 999) ?>" required>
                            <div class="form-text">Garantiza el 100% de cumplimiento en calidad y seguridad.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha de Adquisición</label>
                            <input type="date" name="fecha_adquisicion" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Estado Operativo</label>
                            <select name="estado_operativo" class="form-select" required>
                                <option value="OPERATIVO" selected>OPERATIVO</option>
                                <option value="EN_MANTENIMIENTO">EN MANTENIMIENTO</option>
                                <option value="DE_BAJA">DE BAJA</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Orden de Compra Vinculada (Opcional)</label>
                            <select name="orden_compra_id" class="form-select">
                                <option value="">-- Sin Orden Directa --</option>
                                <?php foreach ($ordenes_lista as $ord): ?>
                                    <option value="<?= $ord['id'] ?>"><?= htmlspecialchars($ord['numero_orden']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-gym">Guardar en Inventario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: VER FICHA TÉCNICA                                        -->
<!-- =============================================================== -->
<div class="modal fade" id="modalVerEquipo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    Ficha Técnica del Equipo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="p-3 rounded mb-3" style="background-color: #0d1320; border: 1px solid #253347;">
                    <div class="small fw-bold" style="color: #38bdf8;" id="verCodigoEq">-</div>
                    <h5 class="text-white fw-bold mb-1" id="verNombreEq">-</h5>
                    <div class="small" style="color: #cbd5e1;">Categoría: <strong class="text-white" id="verCategoriaEq">-</strong></div>
                    <div class="small" style="color: #cbd5e1;">Ubicación: <strong class="text-white" id="verSucursalEq">-</strong></div>
                </div>

                <div class="p-3 rounded mb-3" style="background-color: rgba(56, 189, 248, 0.08); border: 1px solid #0ea5e9;">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge badge-cert-100">🛡️ Certificado 100% Calidad</span>
                    </div>
                    <div class="small" style="color: #cbd5e1;">Acreditación: <strong class="text-white" id="verCertificadoNum">-</strong></div>
                </div>

                <div class="small" style="color: #94a3b8;">
                    Estado: <strong class="text-white" id="verEstadoEq">-</strong> &bull; 
                    Adquisición: <strong class="text-white" id="verFechaAdq">-</strong> &bull; 
                    Orden: <strong class="text-white" id="verOrdenCompra">-</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: EDITAR EQUIPO                                            -->
<!-- =============================================================== -->
<div class="modal fade" id="modalEditarEquipo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="editar">
                <input type="hidden" name="id" id="editEquipoId">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        Editar Equipo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Nombre del Equipo</label>
                            <input type="text" name="nombre_equipo" id="editNombreEq" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Código de Inventario</label>
                            <input type="text" name="codigo_inventario" id="editCodigoEq" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Categoría</label>
                            <select name="categoria" id="editCategoriaEq" class="form-select" required>
                                <option value="PESAS">PESAS & MANCUERNAS</option>
                                <option value="CARDIO">CARDIO & RUNNING</option>
                                <option value="ESTATICO">MÁQUINAS ESTÁTICAS</option>
                                <option value="SILLON_MASAJE">SILLONES DE MASAJE</option>
                                <option value="BOXEO">EQUIPAMIENTO DE BOXEO</option>
                                <option value="PISCINA">EQUIPOS DE PISCINA</option>
                                <option value="BANDAS">BANDAS ELÁSTICAS</option>
                                <option value="CUERDAS">CUERDAS DE SALTO</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sucursal</label>
                            <select name="sucursal_id" id="editSucursalEq" class="form-select" required>
                                <?php foreach ($sucursales as $suc): ?>
                                    <option value="<?= $suc['id'] ?>"><?= htmlspecialchars($suc['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado Operativo</label>
                            <select name="estado_operativo" id="editEstadoEq" class="form-select" required>
                                <option value="OPERATIVO">OPERATIVO</option>
                                <option value="EN_MANTENIMIENTO">EN MANTENIMIENTO</option>
                                <option value="DE_BAJA">DE BAJA</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Número de Certificado de Calidad</label>
                            <input type="text" name="numero_certificado" id="editCertificadoNum" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-gym">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: DAR DE BAJA EQUIPO                                       -->
<!-- =============================================================== -->
<div class="modal fade" id="modalEliminarEquipo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="eliminar">
                <input type="hidden" name="id" id="deleteEquipoId">

                <div class="modal-header border-danger">
                    <h5 class="modal-title text-danger fw-bold d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        Dar de Baja Equipo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-center">
                    <p class="text-light mb-2">¿Confirmas que deseas dar de baja este equipo?</p>
                    <h5 class="text-white fw-bold mb-1" id="deleteNombreEq">Equipo</h5>
                    <p class="small" style="color: #38bdf8;" id="deleteCodigoEq">EQ-000</p>
                    <div class="alert alert-dark border-secondary small text-start mt-3 mb-0">
                        <strong>Nota:</strong> El equipo pasará a estado <strong>DE BAJA</strong> para preservar el historial de inventario y compras.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                    <button type="submit" class="btn btn-danger">Sí, Dar de Baja</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle JS local -->
<script src="../js/bootstrap.bundle.min.js"></script>

<!-- Scripts específicos de Inventario -->
<script src="../js/inventario.js"></script>

</body>
</html>
