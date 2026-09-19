<?php
// clases/index.php - Vista de Clases Especializadas (Natación y Boxeo) y Control de Aforo
require_once __DIR__ . '/controlador_clases.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clases & Aforo - Renovation GYM</title>
    
    <!-- Bootstrap 5 CSS local -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    <!-- Estilos generales y del Dashboard -->
    <link rel="stylesheet" href="../css/dashboard.css">
    
    <!-- Estilos base de tablas y modales -->
    <link rel="stylesheet" href="../css/usuarios.css">
    
    <!-- Estilos específicos de Clases -->
    <link rel="stylesheet" href="../css/clases.css">
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

            <!-- Módulo Activo: Clases -->
            <a href="index.php" class="sidebar-link active">
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
                    <h2 class="h4 fw-bold text-white mb-1">Clases & Control de Aforo</h2>
                    <p class="small mb-0" style="color: #cbd5e1;">Horarios de 6:00 AM a 7:00 PM con aforo controlado (Natación máx 10, Boxeo máx 15)</p>
                </div>
                <div>
                    <button type="button" class="btn btn-gym d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevaClase">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Programar Clase</span>
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

            <!-- Tabla de Clases -->
            <div class="table-responsive-card">
                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th>Disciplina</th>
                                <th>Coach</th>
                                <th>Sucursal</th>
                                <th>Fecha</th>
                                <th>Horario (1h)</th>
                                <th>Aforo & Cupos</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($clases)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4" style="color: #94a3b8;">
                                        No hay clases programadas. Haz clic en <strong>"Programar Clase"</strong> para habilitar sesiones.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($clases as $c): ?>
                                    <?php
                                    $badgeDisc = ($c['disciplina'] === 'BOXEO') ? 'badge-disciplina-boxeo' : 'badge-disciplina-natacion';
                                    $iconDisc = ($c['disciplina'] === 'BOXEO') ? '🥊' : '🏊‍♂️';
                                    $cupos = intval($c['cupos_ocupados']);
                                    $aforo = intval($c['aforo_maximo']);
                                    $pct = ($aforo > 0) ? min(100, round(($cupos / $aforo) * 100)) : 0;
                                    $barClass = ($pct >= 90) ? 'aforo-progress-rojo' : (($pct >= 60) ? 'aforo-progress-ambar' : 'aforo-progress-verde');
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="badge <?= $badgeDisc ?> px-2 py-1" style="font-size: 0.8rem;">
                                                <?= $iconDisc ?> <?= htmlspecialchars($c['disciplina']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-white"><?= htmlspecialchars($c['coach_nombre'] . ' ' . $c['coach_apellido']) ?></div>
                                            <div class="small" style="color: #94a3b8;"><?= htmlspecialchars($c['coach_email']) ?></div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background-color: #1e293b; color: #cbd5e1; border: 1px solid #475569;">
                                                📍 <?= htmlspecialchars($c['sucursal_nombre']) ?>
                                            </span>
                                        </td>
                                        <td class="small text-white">
                                            <?= date('d/m/Y', strtotime($c['fecha'])) ?>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-white"><?= substr($c['hora_inicio'], 0, 5) ?> - <?= substr($c['hora_fin'], 0, 5) ?></div>
                                            <div class="small" style="color: #38bdf8;">Duración: 1 hora</div>
                                        </td>
                                        <td style="min-width: 170px;">
                                            <div class="d-flex justify-content-between small mb-1">
                                                <span class="text-white fw-semibold"><?= $cupos ?> / <?= $aforo ?> cupos</span>
                                                <span style="color: #94a3b8;"><?= $pct ?>%</span>
                                            </div>
                                            <div class="aforo-progress-container">
                                                <div class="aforo-progress-bar <?= $barClass ?>" style="width: <?= $pct ?>%;"></div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-1">
                                                <!-- Ver -->
                                                <button type="button" class="btn btn-sm btn-outline-info" title="Ver Detalle y Aforo" onclick='verClase(<?= json_encode($c) ?>)'>
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                </button>
                                                <!-- Editar -->
                                                <button type="button" class="btn btn-sm btn-outline-warning" title="Editar Clase" onclick='editarClase(<?= json_encode($c) ?>)'>
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </button>
                                                <!-- Eliminar -->
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Cancelar Clase" onclick='eliminarClase(<?= $c["id"] ?>, "<?= htmlspecialchars($c["disciplina"]) ?>", "<?= date("d/m/Y", strtotime($c["fecha"])) ?>", "<?= substr($c["hora_inicio"], 0, 5) . " - " . substr($c["hora_fin"], 0, 5) ?>")'>
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
<!-- MODAL: PROGRAMAR CLASE                                          -->
<!-- =============================================================== -->
<div class="modal fade" id="modalNuevaClase" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="crear">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        Programar Clase Especializada
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Disciplina *</label>
                            <select name="disciplina" id="nuevaDisciplina" class="form-select" required>
                                <option value="NATACION" selected>🏊‍♂️ Natación (Máximo 10 usuarios)</option>
                                <option value="BOXEO">🥊 Boxeo (Máximo 15 usuarios)</option>
                            </select>
                            <div id="infoDisciplinaAforo" class="small mt-1" style="color: #38bdf8;">Aforo reglamentario para Natación: máximo 10 participantes.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Coach Instructor *</label>
                            <select name="coach_id" class="form-select" required>
                                <option value="" disabled selected>-- Seleccionar Coach --</option>
                                <?php foreach ($coaches as $co): ?>
                                    <option value="<?= $co['id'] ?>"><?= htmlspecialchars($co['nombre'] . ' ' . $co['apellido']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Sucursal Habilitada *</label>
                            <select name="sucursal_id" class="form-select" required>
                                <?php foreach ($sucursales as $suc): ?>
                                    <option value="<?= $suc['id'] ?>"><?= htmlspecialchars($suc['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha de la Sesión *</label>
                            <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Hora Inicio (Entre 6am y 7pm) *</label>
                            <input type="time" name="hora_inicio" id="nuevaHoraInicio" class="form-control" value="07:00" min="06:00" max="19:00" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Hora Fin (Duración 1 hora) *</label>
                            <input type="time" name="hora_fin" id="nuevaHoraFin" class="form-control" value="08:00" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Aforo Máximo Permitido</label>
                            <input type="number" id="nuevoAforoMax" class="form-control" value="10" readonly>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-gym">Confirmar Programación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: VER DETALLES DE CLASE Y AFORO                            -->
<!-- =============================================================== -->
<div class="modal fade" id="modalVerClase" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    Aforo y Horario de la Clase
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="p-3 rounded mb-3" style="background-color: #0d1320; border: 1px solid #253347;">
                    <span class="badge badge-disciplina-natacion mb-2" id="verDisciplina">NATACION</span>
                    <h5 class="text-white fw-bold mb-1" id="verCoach">-</h5>
                    <div class="small" style="color: #cbd5e1;">Sucursal: <strong class="text-white" id="verSucursalClase">-</strong></div>
                    <div class="small" style="color: #cbd5e1;">Fecha: <strong class="text-white" id="verFechaClase">-</strong></div>
                    <div class="small" style="color: #38bdf8;">Horario: <strong id="verHorarioClase">-</strong></div>
                </div>

                <div class="p-3 rounded mb-3" style="background-color: rgba(56, 189, 248, 0.08); border: 1px solid #0ea5e9;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small text-white fw-bold">Ocupación Actual:</span>
                        <span class="h6 mb-0 fw-bold text-white"><span id="verCuposOcupados">0</span> / <span id="verAforoMaximo">0</span> cupos (<span id="verPorcentajeAforo">0%</span>)</span>
                    </div>
                    <div class="aforo-progress-container mb-2">
                        <div class="aforo-progress-bar" id="verBarraAforo" style="width: 0%;"></div>
                    </div>
                    <div class="small" style="color: #cbd5e1;">Cupos Libres Disponibles: <strong class="text-success" id="verCuposDisponibles">0</strong></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: EDITAR CLASE                                             -->
<!-- =============================================================== -->
<div class="modal fade" id="modalEditarClase" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="editar">
                <input type="hidden" name="id" id="editClaseId">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        Editar Clase Programada
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Disciplina</label>
                            <select name="disciplina" id="editDisciplina" class="form-select" required>
                                <option value="NATACION">Natación (Máximo 10)</option>
                                <option value="BOXEO">Boxeo (Máximo 15)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Coach</label>
                            <select name="coach_id" id="editCoachId" class="form-select" required>
                                <?php foreach ($coaches as $co): ?>
                                    <option value="<?= $co['id'] ?>"><?= htmlspecialchars($co['nombre'] . ' ' . $co['apellido']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sucursal</label>
                            <select name="sucursal_id" id="editSucursalClaseId" class="form-select" required>
                                <?php foreach ($sucursales as $suc): ?>
                                    <option value="<?= $suc['id'] ?>"><?= htmlspecialchars($suc['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" id="editFechaClase" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hora Inicio</label>
                            <input type="time" name="hora_inicio" id="editHoraInicio" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hora Fin</label>
                            <input type="time" name="hora_fin" id="editHoraFin" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cupos Ocupados Actualmente</label>
                            <input type="number" name="cupos_ocupados" id="editCuposOcupados" class="form-control" min="0" required>
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
<!-- MODAL: CANCELAR CLASE                                           -->
<!-- =============================================================== -->
<div class="modal fade" id="modalEliminarClase" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="eliminar">
                <input type="hidden" name="id" id="deleteClaseId">

                <div class="modal-header border-danger">
                    <h5 class="modal-title text-danger fw-bold d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        Cancelar Sesión de Clase
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-center">
                    <p class="text-light mb-2">¿Confirmas que deseas cancelar esta clase programada?</p>
                    <h5 class="text-white fw-bold mb-1" id="deleteDisciplina">Disciplina</h5>
                    <p class="small" style="color: #38bdf8;" id="deleteDetalleClase">Fecha y Hora</p>
                    <div class="alert alert-dark border-secondary small text-start mt-3 mb-0">
                        <strong>Nota:</strong> Se notificará a los usuarios inscritos y se liberarán los cupos asignados.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                    <button type="submit" class="btn btn-danger">Sí, Cancelar Clase</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle JS local -->
<script src="../js/bootstrap.bundle.min.js"></script>

<!-- Scripts específicos de Clases -->
<script src="../js/clases.js"></script>

</body>
</html>
