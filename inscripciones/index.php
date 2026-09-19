<?php
// inscripciones/index.php - Vista de Gestión de Inscripciones y Membresías
require_once __DIR__ . '/controlador_inscripciones.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción & Membresías - Renovation GYM</title>
    
    <!-- Bootstrap 5 CSS local -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    <!-- Estilos generales y del Dashboard -->
    <link rel="stylesheet" href="../css/dashboard.css">
    
    <!-- Estilos base de tablas y modales -->
    <link rel="stylesheet" href="../css/usuarios.css">
    
    <!-- Estilos específicos de Inscripciones -->
    <link rel="stylesheet" href="../css/inscripciones.css">
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

            <!-- Módulo Activo: Inscripción -->
            <a href="index.php" class="sidebar-link active">
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
            
            <!-- Encabezado y Botón Principal -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h2 class="h4 fw-bold text-white mb-1">Inscripción & Membresías</h2>
                    <p class="small mb-0" style="color: #cbd5e1;">Gestión de afiliaciones, emisión de facturas y beneficios de la Línea Améliorant</p>
                </div>
                <div>
                    <button type="button" class="btn btn-gym d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevaInscripcion">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Nueva Inscripción</span>
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

            <!-- Tabla de Inscripciones -->
            <div class="table-responsive-card">
                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Membresía</th>
                                <th>Sucursal</th>
                                <th>Periodo</th>
                                <th>Estado</th>
                                <th>Factura</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($inscripciones)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4" style="color: #94a3b8;">
                                        No hay membresías registradas actualmente. Presiona <strong>"Nueva Inscripción"</strong> para afiliar a un cliente.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($inscripciones as $ins): ?>
                                    <?php
                                    $badgePlanClass = ($ins['membresia_id'] == 2) ? 'badge-plan-haute' : 'badge-plan-basica';
                                    $badgeEstClass = 'badge-status-vigente';
                                    if ($ins['estado'] === 'VENCIDA') $badgeEstClass = 'badge-status-vencida';
                                    elseif ($ins['estado'] === 'CANCELADA') $badgeEstClass = 'badge-status-cancelada';
                                    ?>
                                    <tr>
                                        <td class="fw-bold" style="color: #94a3b8;">#<?= htmlspecialchars($ins['id']) ?></td>
                                        <td>
                                            <div class="fw-bold text-white"><?= htmlspecialchars($ins['cliente_nombre'] . ' ' . $ins['cliente_apellido']) ?></div>
                                            <div class="small" style="color: #94a3b8;"><?= htmlspecialchars($ins['cliente_email']) ?></div>
                                        </td>
                                        <td>
                                            <span class="badge <?= $badgePlanClass ?> px-2 py-1">
                                                <?= htmlspecialchars($ins['plan_nombre']) ?>
                                            </span>
                                            <div class="small fw-semibold mt-1" style="color: #38bdf8;">Q<?= number_format($ins['precio_mes'], 2) ?>/mes</div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background-color: #1e293b; color: #cbd5e1; border: 1px solid #475569;">
                                                📍 <?= htmlspecialchars($ins['sucursal_nombre']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small text-white"><?= date('d/m/Y', strtotime($ins['fecha_inicio'])) ?> &bull; <?= date('d/m/Y', strtotime($ins['fecha_fin'])) ?></div>
                                            <div class="small" style="color: #94a3b8;">
                                                Renovación: <?= ($ins['renovacion_automatica'] == 1) ? '<span style="color: #4ade80;">Auto</span>' : 'Manual' ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge <?= $badgeEstClass ?> px-2 py-1 text-uppercase" style="font-size: 0.75rem;">
                                                <?= htmlspecialchars($ins['estado']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!empty($ins['numero_factura'])): ?>
                                                <div class="fw-bold" style="color: #fbbf24; font-size: 0.85rem;"><?= htmlspecialchars($ins['numero_factura']) ?></div>
                                                <div class="small" style="color: #94a3b8;">Q<?= number_format($ins['monto_pagado'], 2) ?> (<?= htmlspecialchars($ins['metodo_pago']) ?>)</div>
                                            <?php else: ?>
                                                <span class="small" style="color: #94a3b8;">Sin factura</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-1">
                                                <!-- Botón Ver -->
                                                <button type="button" class="btn btn-sm btn-outline-info" title="Ver Detalles y Beneficios" onclick='verInscripcion(<?= json_encode($ins) ?>)'>
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                </button>
                                                <!-- Botón Editar -->
                                                <button type="button" class="btn btn-sm btn-outline-warning" title="Editar Suscripción" onclick='editarInscripcion(<?= json_encode($ins) ?>)'>
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </button>
                                                <!-- Botón Eliminar / Cancelar -->
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Cancelar Membresía" onclick='eliminarInscripcion(<?= $ins["id"] ?>, "<?= htmlspecialchars($ins["cliente_nombre"] . " " . $ins["cliente_apellido"]) ?>", "<?= htmlspecialchars($ins["plan_nombre"]) ?>")'>
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
<!-- MODAL: NUEVA INSCRIPCIÓN                                        -->
<!-- =============================================================== -->
<div class="modal fade" id="modalNuevaInscripcion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="crear">
                
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                        Nueva Inscripción & Membresía
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        
                        <div class="col-md-6">
                            <label class="form-label">Cliente Afiliado *</label>
                            <select name="cliente_id" class="form-select" required>
                                <option value="" disabled selected>-- Seleccionar Cliente --</option>
                                <?php foreach ($clientes_disponibles as $cli): ?>
                                    <option value="<?= $cli['id'] ?>">
                                        <?= htmlspecialchars($cli['nombre'] . ' ' . $cli['apellido']) ?> (@<?= htmlspecialchars($cli['usuario']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Plan de Membresía *</label>
                            <select name="membresia_id" id="nuevaMembresiaId" class="form-select" required>
                                <?php foreach ($membresias_catalogo as $mem): ?>
                                    <option value="<?= $mem['id'] ?>" data-precio="<?= $mem['precio_mes'] ?>">
                                        <?= htmlspecialchars($mem['nombre']) ?> - Q<?= number_format($mem['precio_mes'], 2) ?>/mes
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Sucursal de Asignación *</label>
                            <select name="sucursal_id" class="form-select" required>
                                <?php foreach ($sucursales_lista as $suc): ?>
                                    <option value="<?= $suc['id'] ?>"><?= htmlspecialchars($suc['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Método de Pago *</label>
                            <select name="metodo_pago" class="form-select" required>
                                <option value="TARJETA" selected>Tarjeta de Débito / Crédito</option>
                                <option value="EFECTIVO">Efectivo en Caja</option>
                                <option value="TRANSFERENCIA">Transferencia Bancaria</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Monto a Cobrar (Q)</label>
                            <input type="number" step="0.01" name="monto" id="nuevoMonto" class="form-control" value="250.00" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha de Inicio *</label>
                            <input type="date" name="fecha_inicio" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha de Vencimiento *</label>
                            <input type="date" name="fecha_fin" class="form-control" value="<?= date('Y-m-d', strtotime('+1 month')) ?>" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label" style="color: #38bdf8;">¿Recomendado por un Miembro? (Opcional - Acredita Bono de Referidos)</label>
                            <select name="referidor_id" class="form-select">
                                <option value="">-- Sin Referidor (Inscripción directa) --</option>
                                <?php foreach ($clientes_disponibles as $refCli): ?>
                                    <option value="<?= $refCli['id'] ?>">
                                        <?= htmlspecialchars($refCli['nombre'] . ' ' . $refCli['apellido']) ?> (@<?= htmlspecialchars($refCli['usuario']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text small" style="color: #94a3b8;">
                                Al afiliar con recomendación, el socio referidor recibe automáticamente su bono (Q100 Básica / Q150 Haute).
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="renovacion_automatica" value="1" id="switchRenovacion" checked>
                                <label class="form-check-label text-light" for="switchRenovacion">Habilitar renovación automática mensual</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-gym">Confirmar Inscripción y Facturar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =============================================================== -->
<!-- MODAL: VER DETALLES Y BENEFICIOS                                -->
<!-- =============================================================== -->
<div class="modal fade" id="modalVerInscripcion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    Ficha de Inscripción y Beneficios Améliorant
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background-color: #0d1320; border: 1px solid #253347;">
                            <div class="small fw-bold text-uppercase" style="color: #94a3b8;">Cliente</div>
                            <h5 class="text-white fw-bold mb-1" id="verClienteNombre">-</h5>
                            <div class="small" style="color: #cbd5e1;" id="verClienteEmail">-</div>
                            <div class="small" style="color: #94a3b8;" id="verClienteTel">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background-color: #0d1320; border: 1px solid #253347;">
                            <div class="small fw-bold text-uppercase" style="color: #94a3b8;">Plan & Facturación</div>
                            <h5 class="text-white fw-bold mb-1" id="verPlanNombre">-</h5>
                            <div class="small text-warning fw-semibold" id="verFacturaNum">-</div>
                            <div class="small" style="color: #38bdf8;"><span id="verMontoPagado">-</span> por <span id="verMetodoPago">-</span></div>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <h6 class="fw-bold text-white mb-2">Detalle de Beneficios Exclusivos del Plan:</h6>
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <div class="benefit-item">
                                    🚗 Descuento Parqueo: <strong id="verBenParqueo">-</strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="benefit-item">
                                    🏋️‍♂️ Sesiones de Coaching: <strong id="verBenCoaching">-</strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="benefit-item">
                                    🎟️ Pases de Prueba para Terceros: <strong id="verBenPrueba">-</strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="benefit-item">
                                    💰 Bono por Referir Amigos: <strong id="verBenReferido">-</strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="benefit-item">
                                    🏊‍♂️🥊 Piscinas y Área de Boxeo: <strong id="verBenPiscina">-</strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="benefit-item">
                                    💆‍♂️ Sillones de Masaje: <strong id="verBenSillones">-</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="small" style="color: #94a3b8;">
                            Sucursal: <strong class="text-light" id="verSucursal">-</strong> &bull; 
                            Inicio: <strong class="text-light" id="verFechaInicio">-</strong> &bull; 
                            Vence: <strong class="text-light" id="verFechaFin">-</strong> &bull; 
                            Estado: <strong class="text-light" id="verEstado">-</strong> &bull; 
                            Renovación: <strong class="text-light" id="verRenovacion">-</strong>
                        </div>
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
<!-- MODAL: EDITAR INSCRIPCIÓN                                       -->
<!-- =============================================================== -->
<div class="modal fade" id="modalEditarInscripcion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="editar">
                <input type="hidden" name="id" id="editInscripcionId">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        Editar Suscripción de <span id="editClienteNombre" class="text-warning"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Plan de Membresía</label>
                            <select name="membresia_id" id="editMembresiaId" class="form-select" required>
                                <?php foreach ($membresias_catalogo as $mem): ?>
                                    <option value="<?= $mem['id'] ?>"><?= htmlspecialchars($mem['nombre']) ?> (Q<?= number_format($mem['precio_mes'], 2) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sucursal</label>
                            <select name="sucursal_id" id="editSucursalId" class="form-select" required>
                                <?php foreach ($sucursales_lista as $suc): ?>
                                    <option value="<?= $suc['id'] ?>"><?= htmlspecialchars($suc['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" id="editFechaInicio" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha de Vencimiento</label>
                            <input type="date" name="fecha_fin" id="editFechaFin" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado</label>
                            <select name="estado" id="editEstado" class="form-select" required>
                                <option value="VIGENTE">VIGENTE</option>
                                <option value="VENCIDA">VENCIDA</option>
                                <option value="CANCELADA">CANCELADA</option>
                            </select>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="renovacion_automatica" value="1" id="editRenovacion">
                                <label class="form-check-label text-light" for="editRenovacion">Renovación automática habilitada</label>
                            </div>
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
<!-- MODAL: CONFIRMAR CANCELACIÓN                                    -->
<!-- =============================================================== -->
<div class="modal fade" id="modalEliminarInscripcion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="eliminar">
                <input type="hidden" name="id" id="deleteInscripcionId">

                <div class="modal-header border-danger">
                    <h5 class="modal-title text-danger fw-bold d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        Cancelar Membresía
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-center">
                    <p class="text-light mb-2">¿Confirmas la cancelación de la siguiente membresía?</p>
                    <h5 class="text-white fw-bold mb-1" id="deleteClienteNombre">Cliente</h5>
                    <p class="small" style="color: #38bdf8;" id="deletePlanNombre">Plan</p>
                    <div class="alert alert-dark border-secondary small text-start mb-0">
                        <strong>Nota:</strong> Al cancelar, la membresía pasará a estado <strong>CANCELADA</strong> y no se renovará automáticamente, preservando el registro de facturas previas.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                    <button type="submit" class="btn btn-danger">Sí, Cancelar Membresía</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle JS local -->
<script src="../js/bootstrap.bundle.min.js"></script>

<!-- Scripts específicos de Inscripciones -->
<script src="../js/inscripciones.js"></script>

</body>
</html>
