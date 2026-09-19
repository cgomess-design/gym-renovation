<?php
// cierre/index.php - Vista de Cierre Diario de Jornada y Balance de Operaciones
require_once __DIR__ . '/controlador_cierre.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre de Jornada - Renovation GYM</title>
    
    <!-- Bootstrap 5 CSS local -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    <!-- Estilos generales y del Dashboard -->
    <link rel="stylesheet" href="../css/dashboard.css">
    
    <!-- Estilos base de tablas y modales -->
    <link rel="stylesheet" href="../css/usuarios.css">
    
    <!-- Estilos específicos de Cierre -->
    <link rel="stylesheet" href="../css/cierre.css">
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

            <a href="../inventario/index.php" class="sidebar-link">
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

            <!-- Módulo Activo: Cierre -->
            <a href="index.php" class="sidebar-link active">
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
                    <h2 class="h4 fw-bold text-white mb-1">Cierre Diario de Jornada</h2>
                    <p class="small mb-0" style="color: #cbd5e1;">Consolidación operativa: conteo de aforo, tiempo promedio e ingresos diarios</p>
                </div>
                <div>
                    <button type="button" class="btn btn-gym d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoCierre">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Generar Cierre del Día</span>
                    </button>
                </div>
            </div>

            <!-- Resumen de KPIs de Cierre -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="report-stat-box">
                        <div class="report-stat-label">Aforo Promedio Diario</div>
                        <div class="report-stat-val" style="color: #38bdf8;"><?= round($promedio_aforo) ?> usuarios</div>
                        <div class="small" style="color: #94a3b8;">Por sucursal (Capacidad 75-100)</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="report-stat-box">
                        <div class="report-stat-label">Tiempo Promedio de Permanencia</div>
                        <div class="report-stat-val" style="color: #fbbf24;"><?= round($promedio_permanencia, 1) ?> minutos</div>
                        <div class="small" style="color: #94a3b8;">Control biométrico de salida</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="report-stat-box">
                        <div class="report-stat-label">Ingresos Consolidados en Cierres</div>
                        <div class="report-stat-val" style="color: #4ade80;">Q<?= number_format($total_ingresos_historico, 2) ?></div>
                        <div class="small" style="color: #94a3b8;">Membresías + Tercerizados</div>
                    </div>
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

            <!-- Tabla de Cierres -->
            <div class="table-responsive-card">
                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Sucursal</th>
                                <th>Usuarios Día</th>
                                <th>Tiempo Promedio</th>
                                <th>Ventas Membresías</th>
                                <th>Tercerizados</th>
                                <th>Total Día</th>
                                <th>Clases</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($reportes)): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4" style="color: #94a3b8;">
                                        No hay reportes de cierre registrados. Haz clic en <strong>"Generar Cierre del Día"</strong>.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($reportes as $rep): ?>
                                    <?php
                                    $vMem = floatval($rep['ventas_membresias_total']);
                                    $vTerc = floatval($rep['ventas_servicios_tercerizados']);
                                    $totalDia = $vMem + $vTerc;
                                    ?>
                                    <tr>
                                        <td class="fw-bold text-white">
                                            <?= date('d/m/Y', strtotime($rep['fecha'])) ?>
                                        </td>
                                        <td>
                                            <span class="badge" style="background-color: #1e293b; color: #cbd5e1; border: 1px solid #475569;">
                                                📍 <?= htmlspecialchars($rep['sucursal_nombre']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-white"><?= $rep['cantidad_usuarios_dia'] ?> usuarios</div>
                                            <div class="small" style="color: #4ade80;">Aforo biométrico</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold" style="color: #fbbf24;"><?= number_format($rep['tiempo_promedio_minutos'], 1) ?> min</div>
                                            <div class="small" style="color: #94a3b8;">Por usuario</div>
                                        </td>
                                        <td class="text-white">
                                            Q<?= number_format($vMem, 2) ?>
                                        </td>
                                        <td class="text-white">
                                            Q<?= number_format($vTerc, 2) ?>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 fw-bold" style="color: #4ade80;">Q<?= number_format($totalDia, 2) ?></h6>
                                        </td>
                                        <td class="small" style="color: #38bdf8;">
                                            🏊‍♂️ <?= $rep['usuarios_clases_natacion'] ?> &bull; 🥊 <?= $rep['usuarios_clases_boxeo'] ?>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-1">
                                                <!-- Ver -->
                                                <button type="button" class="btn btn-sm btn-outline-info" title="Ver Balance Ejecutivo" onclick='verCierre(<?= json_encode($rep) ?>)'>
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                </button>
                                                <!-- Editar -->
                                                <button type="button" class="btn btn-sm btn-outline-warning" title="Editar Cierre" onclick='editarCierre(<?= json_encode($rep) ?>)'>
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </button>
                                                <!-- Eliminar -->
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar Cierre" onclick='eliminarCierre(<?= $rep["id"] ?>, "<?= htmlspecialchars($rep["sucursal_nombre"]) ?>", "<?= date("d/m/Y", strtotime($rep["fecha"])) ?>")'>
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
<!-- MODAL: GENERAR CIERRE DIARIO                                    -->
<!-- =============================================================== -->
<div class="modal fade" id="modalNuevoCierre" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="crear">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Generar Reporte de Cierre de Jornada
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Sucursal a Consolidar *</label>
                            <select name="sucursal_id" class="form-select" required>
                                <?php foreach ($sucursales as $suc): ?>
                                    <option value="<?= $suc['id'] ?>"><?= htmlspecialchars($suc['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha del Cierre *</label>
                            <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Total de Usuarios que Asistieron *</label>
                            <input type="number" name="cantidad_usuarios_dia" class="form-control" value="85" min="0" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tiempo Promedio de Permanencia (Minutos) *</label>
                            <input type="number" step="0.1" name="tiempo_promedio_minutos" class="form-control" value="75.0" min="0" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ventas Totales de Membresías (Q) *</label>
                            <input type="number" step="0.01" name="ventas_membresias_total" class="form-control" value="6500.00" min="0" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ventas de Servicios Tercerizados (Q) *</label>
                            <input type="number" step="0.01" name="ventas_servicios_tercerizados" class="form-control" value="<?= isset($ventas_suplementos_hoy) && $ventas_suplementos_hoy > 0 ? number_format($ventas_suplementos_hoy, 2, '.', '') : '1500.00' ?>" min="0" required>
                            <div class="form-text small" style="color: #94a3b8;">Incluye suplementos, bebidas y nutrición Améliorant.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Usuarios en Clases de Natación</label>
                            <input type="number" name="usuarios_clases_natacion" class="form-control" value="15" min="0">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Usuarios en Clases de Boxeo</label>
                            <input type="number" name="usuarios_clases_boxeo" class="form-control" value="22" min="0">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-gym">Consolidar y Guardar Cierre</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: VER BALANCE DIARIO EJECUTIVO                             -->
<!-- =============================================================== -->
<div class="modal fade" id="modalVerCierre" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Comprobante Ejecutivo de Cierre Diario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="report-receipt-card">
                    <div class="d-flex justify-content-between align-items-center border-bottom border-secondary pb-3 mb-3">
                        <div>
                            <h5 class="text-white fw-bold mb-0">RENOVATION GYM</h5>
                            <div class="small" style="color: #ff8a50;">Línea Améliorant - Balance Operativo</div>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-primary" id="verCierreSucursal">Central</div>
                            <div class="small" style="color: #cbd5e1;" id="verCierreFecha">-</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <div class="p-3 rounded" style="background-color: #111a28;">
                                <div class="small fw-bold text-uppercase" style="color: #94a3b8;">Aforo Consolidado</div>
                                <h4 class="text-white fw-bold mb-0"><span id="verCierreUsuarios">0</span> usuarios</h4>
                                <div class="small" style="color: #38bdf8;">Permanencia prom: <strong id="verCierreTiempo">-</strong></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 rounded" style="background-color: #111a28;">
                                <div class="small fw-bold text-uppercase" style="color: #94a3b8;">Ingresos Totales del Día</div>
                                <h4 class="fw-bold mb-0" style="color: #4ade80;" id="verCierreTotalIngresos">Q0.00</h4>
                                <div class="small" style="color: #cbd5e1;">Membresías: <span id="verCierreVentasMem">Q0</span> &bull; Tercerizados: <span id="verCierreVentasTerc">Q0</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded mb-3" style="background-color: #111a28;">
                        <div class="small fw-bold text-uppercase mb-1" style="color: #94a3b8;">Participación en Clases</div>
                        <div class="d-flex justify-content-between text-white small">
                            <span>🏊‍♂️ Natación Olímpica: <strong id="verCierreNatacion">-</strong></span>
                            <span>🥊 Boxeo Deportivo: <strong id="verCierreBoxeo">-</strong></span>
                        </div>
                    </div>

                    <div class="small text-end" style="color: #64748b;">
                        Generado el: <span id="verCierreGenerado">-</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: EDITAR CIERRE                                            -->
<!-- =============================================================== -->
<div class="modal fade" id="modalEditarCierre" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="editar">
                <input type="hidden" name="id" id="editCierreId">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        Editar Reporte de Cierre
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Sucursal</label>
                            <select name="sucursal_id" id="editSucursalCierreId" class="form-select" required>
                                <?php foreach ($sucursales as $suc): ?>
                                    <option value="<?= $suc['id'] ?>"><?= htmlspecialchars($suc['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" id="editFechaCierre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cantidad de Usuarios</label>
                            <input type="number" name="cantidad_usuarios_dia" id="editUsuariosDia" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tiempo Promedio (min)</label>
                            <input type="number" step="0.1" name="tiempo_promedio_minutos" id="editTiempoProm" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ventas Membresías (Q)</label>
                            <input type="number" step="0.01" name="ventas_membresias_total" id="editVentasMem" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ventas Tercerizados (Q)</label>
                            <input type="number" step="0.01" name="ventas_servicios_tercerizados" id="editVentasTerc" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alumnos Natación</label>
                            <input type="number" name="usuarios_clases_natacion" id="editClasesNat" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alumnos Boxeo</label>
                            <input type="number" name="usuarios_clases_boxeo" id="editClasesBox" class="form-control">
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
<!-- MODAL: ELIMINAR CIERRE                                          -->
<!-- =============================================================== -->
<div class="modal fade" id="modalEliminarCierre" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="eliminar">
                <input type="hidden" name="id" id="deleteCierreId">

                <div class="modal-header border-danger">
                    <h5 class="modal-title text-danger fw-bold d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        Eliminar Reporte de Cierre
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-center">
                    <p class="text-light mb-2">¿Estás seguro de que deseas eliminar este reporte de cierre?</p>
                    <h5 class="text-white fw-bold mb-1" id="deleteSucursalCierre">Sucursal</h5>
                    <p class="small" style="color: #38bdf8;" id="deleteFechaCierre">Fecha</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                    <button type="submit" class="btn btn-danger">Sí, Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle JS local -->
<script src="../js/bootstrap.bundle.min.js"></script>

<!-- Scripts específicos de Cierre -->
<script src="../js/cierre.js"></script>

</body>
</html>
