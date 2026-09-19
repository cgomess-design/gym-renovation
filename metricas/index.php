<?php
// metricas/index.php - Vista de Métricas de Desempeño y Liquidación de Bonos
require_once __DIR__ . '/controlador_metricas.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Métricas & Bonos - Renovation GYM</title>
    
    <!-- Bootstrap 5 CSS local -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    <!-- Estilos generales y del Dashboard -->
    <link rel="stylesheet" href="../css/dashboard.css">
    
    <!-- Estilos base de tablas y modales -->
    <link rel="stylesheet" href="../css/usuarios.css">
    
    <!-- Estilos específicos de Métricas -->
    <link rel="stylesheet" href="../css/metricas.css">
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

            <!-- Módulo Activo: Métricas -->
            <a href="index.php" class="sidebar-link active">
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
                    <h2 class="h4 fw-bold text-white mb-1">Métricas & Bonos de Desempeño</h2>
                    <p class="small mb-0" style="color: #cbd5e1;">Liquidación de bonos de Q700/Q500 para Coaches y Equipo de Recepción</p>
                </div>
                <div>
                    <button type="button" class="btn btn-gym d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevaMetrica">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Registrar Desempeño</span>
                    </button>
                </div>
            </div>

            <!-- Resumen de Metas y Bonos -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="kpi-metric-summary">
                        <div class="small fw-bold text-uppercase" style="color: #94a3b8;">Total Bonos Liquidados</div>
                        <h3 class="fw-bold mb-1" style="color: #4ade80;">Q<?= number_format($total_bonos_pagados, 2) ?></h3>
                        <span class="small" style="color: #cbd5e1;">Acumulado del periodo</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="kpi-metric-summary">
                        <div class="small fw-bold text-uppercase" style="color: #94a3b8;">Meta Coaches / Entrenadores</div>
                        <h5 class="text-white fw-bold mb-1">60 sesiones &bull; CSAT &ge; 92%</h5>
                        <span class="small" style="color: #38bdf8;">Bono Máx: Q700 (1°) + Q500 (2°)</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="kpi-metric-summary">
                        <div class="small fw-bold text-uppercase" style="color: #94a3b8;">Meta Recepción & Ventas</div>
                        <h5 class="text-white fw-bold mb-1">25 ventas &bull; Retención &ge; 95%</h5>
                        <span class="small" style="color: #fbbf24;">Bono Máx: Q700 (1°) + Q500 (2°)</span>
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

            <!-- Tabla de Métricas -->
            <div class="table-responsive-card">
                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th>Empleado</th>
                                <th>Área / Equipo</th>
                                <th>Periodo</th>
                                <th>Sesiones / Ventas</th>
                                <th>Calidad / Retención</th>
                                <th>Cumplimiento</th>
                                <th>Bono Liquidado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($metricas)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4" style="color: #94a3b8;">
                                        No hay registros de desempeño. Presiona <strong>"Registrar Desempeño"</strong> para evaluar al personal.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($metricas as $m): ?>
                                    <?php
                                    $badgeEq = ($m['tipo_equipo'] === 'COACH') ? 'badge-equipo-coach' : 'badge-equipo-recepcion';
                                    $pct = intval($m['porcentaje_bono_aplicado']);
                                    $badgeBono = 'badge-bono-0';
                                    if ($pct >= 100) $badgeBono = 'badge-bono-100';
                                    elseif ($pct >= 75) $badgeBono = 'badge-bono-75';
                                    elseif ($pct >= 50) $badgeBono = 'badge-bono-50';

                                    $metaSes = ($m['tipo_equipo'] === 'COACH') ? 60 : 25;
                                    $metaCsat = ($m['tipo_equipo'] === 'COACH') ? '92%' : '95%';
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-white"><?= htmlspecialchars($m['empleado_nombre'] . ' ' . $m['empleado_apellido']) ?></div>
                                            <div class="small" style="color: #94a3b8;"><?= htmlspecialchars($m['empleado_email']) ?></div>
                                        </td>
                                        <td>
                                            <span class="badge <?= $badgeEq ?> px-2 py-1">
                                                <?= htmlspecialchars($m['tipo_equipo']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background-color: #1e293b; color: #cbd5e1; border: 1px solid #475569;">
                                                📅 <?= htmlspecialchars($m['semana_periodo']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-white"><?= $m['sesiones_o_ventas_realizadas'] ?></div>
                                            <div class="small" style="color: #94a3b8;">Meta: <?= $metaSes ?></div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold" style="color: #fbbf24;"><?= number_format($m['porcentaje_csat_o_retencion'], 1) ?>%</div>
                                            <div class="small" style="color: #94a3b8;">Meta: &ge; <?= $metaCsat ?></div>
                                        </td>
                                        <td>
                                            <span class="badge <?= $badgeBono ?> px-2 py-1">
                                                <?= $pct ?>% Bono
                                            </span>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 fw-bold" style="color: #4ade80;">Q<?= number_format($m['monto_bono_total'], 2) ?></h6>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-1">
                                                <!-- Ver -->
                                                <button type="button" class="btn btn-sm btn-outline-info" title="Ver Desglose de Bono" onclick='verMetrica(<?= json_encode($m) ?>)'>
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                </button>
                                                <!-- Editar -->
                                                <button type="button" class="btn btn-sm btn-outline-warning" title="Editar Registro" onclick='editarMetrica(<?= json_encode($m) ?>)'>
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </button>
                                                <!-- Eliminar -->
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar Registro" onclick='eliminarMetrica(<?= $m["id"] ?>, "<?= htmlspecialchars($m["empleado_nombre"] . " " . $m["empleado_apellido"]) ?>", "<?= htmlspecialchars($m["semana_periodo"]) ?>")'>
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
<!-- MODAL: REGISTRAR EVALUACIÓN Y BONO                              -->
<!-- =============================================================== -->
<div class="modal fade" id="modalNuevaMetrica" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="crear">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        Registrar Evaluación de Desempeño y Bono
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Empleado a Evaluar *</label>
                            <select name="empleado_id" class="form-select" required>
                                <option value="" disabled selected>-- Seleccionar Empleado --</option>
                                <?php foreach ($empleados as $emp): ?>
                                    <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['nombre'] . ' ' . $emp['apellido']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipo de Equipo *</label>
                            <select name="tipo_equipo" id="nuevoTipoEquipo" class="form-select" required>
                                <option value="COACH" selected>COACH (Meta 60 sesiones & CSAT 92%)</option>
                                <option value="RECEPCION">RECEPCIÓN (Meta 25 ventas & Retención 95%)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Semana / Periodo *</label>
                            <input type="text" name="semana_periodo" class="form-control" value="<?= date('Y-\WW') ?>" placeholder="Ej. 2026-W37" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" id="labelMeta1">Sesiones Realizadas (Meta: 60) *</label>
                            <input type="number" name="sesiones_o_ventas_realizadas" id="nuevoSesionesVentas" class="form-control" value="60" min="0" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" id="labelMeta2">Satisfacción CSAT % (Meta: 92%) *</label>
                            <input type="number" step="0.1" name="porcentaje_csat_o_retencion" id="nuevoCsatRetencion" class="form-control" value="95.0" min="0" max="100" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Porcentaje de Bono Aplicado</label>
                            <div class="input-group">
                                <input type="number" name="porcentaje_bono_aplicado" id="nuevoPctBono" class="form-control fw-bold" value="100" readonly>
                                <span class="input-group-text bg-dark border-secondary text-white">%</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Total Bono a Liquidar (Q)</label>
                            <input type="number" step="0.01" name="monto_bono_total" id="nuevoMontoBono" class="form-control fw-bold text-success" value="1200.00" readonly>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-gym">Guardar y Liquidar Bono</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: VER DETALLE DE LIQUIDACIÓN DE BONO                       -->
<!-- =============================================================== -->
<div class="modal fade" id="modalVerMetrica" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    Liquidación de Bono de Desempeño
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="p-3 rounded mb-3" style="background-color: #0d1320; border: 1px solid #253347;">
                    <div class="small fw-bold text-uppercase" style="color: #94a3b8;" id="verTipoEquipoMetrica">COACH</div>
                    <h4 class="text-white fw-bold mb-1" id="verEmpleadoMetrica">-</h4>
                    <div class="small" style="color: #cbd5e1;">Periodo evaluado: <strong class="text-white" id="verPeriodoMetrica">-</strong></div>
                </div>

                <div class="p-3 rounded mb-3" style="background-color: rgba(34, 197, 94, 0.08); border: 1px solid #22c55e;">
                    <div class="d-flex justify-content-between mb-1 small">
                        <span style="color: #cbd5e1;" id="verMetaLabel1">Sesiones Realizadas:</span>
                        <strong class="text-white" id="verMetaVal1">0</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span style="color: #cbd5e1;" id="verMetaLabel2">Calidad CSAT:</span>
                        <strong class="text-white" id="verMetaVal2">0%</strong>
                    </div>
                    <div class="pt-2 border-top border-secondary d-flex justify-content-between align-items-center">
                        <span class="text-white fw-bold">Cumplimiento: <span class="badge bg-success ms-1" id="verPorcentajeBono">100%</span></span>
                        <h5 class="mb-0 fw-bold" style="color: #4ade80;" id="verMontoBonoTotal">Q1,200.00</h5>
                    </div>
                </div>

                <div class="small" style="color: #94a3b8;">
                    Fecha de cálculo: <span id="verFechaCalculo">-</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: EDITAR MÉTRICA                                           -->
<!-- =============================================================== -->
<div class="modal fade" id="modalEditarMetrica" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="editar">
                <input type="hidden" name="id" id="editMetricaId">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        Editar Métrica de Desempeño
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Periodo</label>
                        <input type="text" name="semana_periodo" id="editSemanaPeriodo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sesiones o Ventas Realizadas</label>
                        <input type="number" name="sesiones_o_ventas_realizadas" id="editSesionesVentas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Porcentaje CSAT / Retención (%)</label>
                        <input type="number" step="0.1" name="porcentaje_csat_o_retencion" id="editCsatRetencion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Porcentaje de Bono Aplicado (%)</label>
                        <input type="number" name="porcentaje_bono_aplicado" id="editPctBono" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Monto Total del Bono (Q)</label>
                        <input type="number" step="0.01" name="monto_bono_total" id="editMontoBono" class="form-control" required>
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
<!-- MODAL: ELIMINAR MÉTRICA                                         -->
<!-- =============================================================== -->
<div class="modal fade" id="modalEliminarMetrica" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="eliminar">
                <input type="hidden" name="id" id="deleteMetricaId">

                <div class="modal-header border-danger">
                    <h5 class="modal-title text-danger fw-bold d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        Eliminar Registro de Métrica
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-center">
                    <p class="text-light mb-2">¿Estás seguro de que deseas eliminar este cálculo de desempeño?</p>
                    <h5 class="text-white fw-bold mb-1" id="deleteEmpleadoNombre">Empleado</h5>
                    <p class="small" style="color: #38bdf8;" id="deletePeriodo">Periodo</p>
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

<!-- Scripts específicos de Métricas -->
<script src="../js/metricas.js"></script>

</body>
</html>
