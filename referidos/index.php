<?php
// referidos/index.php - Vista del Programa de Referidos y Entrega de Dinero

require_once __DIR__ . '/controlador_referidos.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programa de Referidos & Bonos - Renovation GYM</title>
    
    <!-- Bootstrap 5 CSS local -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    <!-- Estilos del Dashboard -->
    <link rel="stylesheet" href="../css/dashboard.css">
    
    <!-- Estilos específicos de Referidos -->
    <link rel="stylesheet" href="../css/referidos.css">
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

            <a href="../usuarios/index.php" class="sidebar-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Usuarios</span>
            </a>

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

            <!-- Referidos (Activo) -->
            <a href="index.php" class="sidebar-link active">
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
    <!-- 2. CONTENIDO PRINCIPAL                                  -->
    <!-- ======================================================= -->
    <main class="main-content">
        
        <!-- Header superior -->
        <header class="top-navbar">
            <button class="btn-toggle-sidebar" id="btnToggleSidebar" aria-label="Toggle navigation">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <div class="breadcrumb-nav">
                <span>Renovation GYM</span>
                <span class="separator">/</span>
                <span class="active">Referidos & Entrega de Dinero</span>
            </div>

            <div class="user-profile-menu">
                <div class="user-avatar"><?= htmlspecialchars($iniciales_activo) ?></div>
                <div class="user-info d-none d-sm-block">
                    <span class="user-name"><?= htmlspecialchars($usuario_activo_nombre) ?></span>
                    <span class="user-role"><?= htmlspecialchars($usuario_activo_rol) ?> (<?= htmlspecialchars($usuario_activo_suc) ?>)</span>
                </div>
            </div>
        </header>

        <!-- Cuerpo de la vista -->
        <div class="dashboard-body">

            <!-- Mensajes de Alerta -->
            <?php if (!empty($mensaje_exito)): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 bg-success text-white shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <div><?= $mensaje_exito ?></div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($mensaje_error)): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 bg-danger text-white shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <div><?= htmlspecialchars($mensaje_error) ?></div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Título y Acciones -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                <div>
                    <h2 class="fw-bold text-white mb-1" style="font-size: 1.65rem;">Programa de Referidos & Bonos en Efectivo</h2>
                    <p class="text-secondary mb-0">Recompensa automática a miembros: Q100 por Plan Básico y Q150 por Plan Haute.</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNuevoReferido">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Registrar Referido Manual</span>
                    </button>
                </div>
            </div>

            <!-- KPIs de Bonos -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="kpi-title">Bonos Pagados (Efectivo/Transf)</span>
                            <div class="kpi-icon-wrap" style="color: #4ade80; background: rgba(74, 222, 128, 0.12);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                            </div>
                        </div>
                        <div class="kpi-value text-white">Q<?= number_format($kpi_bonos_entregados, 2) ?></div>
                        <div class="kpi-trend text-secondary">Egresos liquidados con recibo</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="kpi-title">Bonos Pendientes de Cobro</span>
                            <div class="kpi-icon-wrap" style="color: #fbbf24; background: rgba(245, 158, 11, 0.12);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </div>
                        </div>
                        <div class="kpi-value text-white">Q<?= number_format($kpi_bonos_pendientes, 2) ?></div>
                        <div class="kpi-trend text-secondary">Saldo disponible para clientes</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="kpi-title">Afiliaciones por Referido</span>
                            <div class="kpi-icon-wrap" style="color: #38bdf8; background: rgba(56, 189, 248, 0.12);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                        </div>
                        <div class="kpi-value text-white"><?= $kpi_total_afiliados ?></div>
                        <div class="kpi-trend text-secondary">Nuevos clientes atraídos</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="kpi-title">Bonos Descontados en Cuota</span>
                            <div class="kpi-icon-wrap" style="color: var(--primary-accent); background: rgba(255, 87, 34, 0.12);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                        </div>
                        <div class="kpi-value text-white">Q<?= number_format($kpi_bonos_descuento, 2) ?></div>
                        <div class="kpi-trend text-secondary">Aplicados a mensualidades</div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Gestión y Entrega de Dinero -->
            <div class="content-table-wrapper">
                <div class="p-3 border-bottom border-secondary d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-white mb-0">Control de Recompensas y Liquidación de Bonos</h5>
                    <span class="badge bg-secondary">Total: <?= count($lista_referidos) ?> registros</span>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Cliente Referidor (Beneficiario)</th>
                                <th>Nuevo Afiliado (Referido)</th>
                                <th>Plan Adquirido</th>
                                <th>Bono Otorgado</th>
                                <th>Estado</th>
                                <th>Modalidad de Entrega</th>
                                <th>Comprobante</th>
                                <th>Fecha Afiliación</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($lista_referidos)): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-secondary">
                                        No hay registros de referidos por el momento.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($lista_referidos as $ref): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-white"><?= htmlspecialchars($ref['referidor_nombre'] . ' ' . $ref['referidor_apellido']) ?></div>
                                            <div class="small text-secondary"><?= htmlspecialchars($ref['referidor_telefono'] ?: $ref['referidor_email']) ?></div>
                                        </td>
                                        <td>
                                            <div class="text-white"><?= htmlspecialchars($ref['referido_nombre'] . ' ' . $ref['referido_apellido']) ?></div>
                                            <div class="small text-secondary"><?= htmlspecialchars($ref['referido_email']) ?></div>
                                        </td>
                                        <td>
                                            <span class="badge bg-dark border border-secondary text-white"><?= htmlspecialchars($ref['membresia_nombre']) ?></span>
                                        </td>
                                        <td>
                                            <span class="bonus-amount-badge <?= $ref['bono_otorgado'] >= 150 ? 'bonus-haute' : 'bonus-basic' ?>">
                                                Q<?= number_format($ref['bono_otorgado'], 2) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($ref['estado_bono'] === 'PENDIENTE'): ?>
                                                <span class="badge-bono-pendiente">Pendiente de Cobro</span>
                                            <?php elseif ($ref['estado_bono'] === 'RECLAMADO'): ?>
                                                <span class="badge-bono-reclamado">Pagado / Entregado</span>
                                            <?php else: ?>
                                                <span class="badge-bono-aplicado">Aplicado a Cuota</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small">
                                            <?php if (!empty($ref['metodo_entrega'])): ?>
                                                <span class="text-info fw-semibold"><?= htmlspecialchars($ref['metodo_entrega']) ?></span>
                                            <?php else: ?>
                                                <span class="text-secondary">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($ref['comprobante_egreso'])): ?>
                                                <code class="text-warning"><?= htmlspecialchars($ref['comprobante_egreso']) ?></code>
                                            <?php else: ?>
                                                <span class="text-secondary small">Pendiente</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small text-secondary">
                                            <?= date('d/m/Y', strtotime($ref['fecha_referido'])) ?>
                                        </td>
                                        <td class="text-end">
                                            <?php if ($ref['estado_bono'] === 'PENDIENTE'): ?>
                                                <button type="button" class="btn btn-sm btn-success fw-bold d-inline-flex align-items-center gap-1"
                                                        onclick='abrirModalPagarBono(<?= json_encode($ref) ?>)'>
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                                    <span>Entregar Dinero</span>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-outline-info"
                                                        onclick='abrirModalVerComprobante(<?= json_encode($ref) ?>)'>
                                                    Ver Recibo
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<!-- ======================================================= -->
<!-- MODAL: ENTREGAR DINERO / PAGAR BONO                     -->
<!-- ======================================================= -->
<div class="modal fade" id="modalPagarBono" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="pagar_bono">
                <input type="hidden" name="referido_id" id="pagoReferidoId" value="">
                <input type="hidden" name="monto_bono" id="pagoInputMonto" value="">

                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                        <span>Entrega y Liquidación de Bono</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Resumen del bono -->
                    <div class="p-3 mb-3 rounded" style="background-color: #0c121e; border: 1px solid #28374f;">
                        <div class="row g-2 small">
                            <div class="col-6">
                                <span class="text-secondary d-block">Cliente Beneficiario:</span>
                                <strong class="text-white" id="pagoReferidorNombre">--</strong>
                            </div>
                            <div class="col-6">
                                <span class="text-secondary d-block">Amigo / Referido:</span>
                                <strong class="text-white" id="pagoReferidoNombre">--</strong>
                            </div>
                            <div class="col-6">
                                <span class="text-secondary d-block">Plan Afiliado:</span>
                                <span class="text-info fw-semibold" id="pagoMembresiaPlan">--</span>
                            </div>
                            <div class="col-6">
                                <span class="text-secondary d-block">Monto a Entregar:</span>
                                <span class="fs-5 fw-bold text-success" id="pagoMontoBonoText">Q0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Modalidad de Pago -->
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Modalidad de Entrega del Dinero *</label>
                        <select name="metodo_entrega" id="pagoMetodoEntrega" class="form-select" required>
                            <option value="EFECTIVO">Efectivo en Caja / Recepción</option>
                            <option value="TRANSFERENCIA">Transferencia Bancaria Inmediata</option>
                            <option value="DESCUENTO_MEMBRESIA">Aplicar como Descuento a su Próxima Mensualidad</option>
                        </select>
                    </div>

                    <!-- Datos bancarios condicionales -->
                    <div id="boxDetalleTransferencia" class="p-3 mb-3 rounded d-none" style="background-color: #0f172a; border: 1px dashed #334155;">
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label text-secondary small">Banco Destino</label>
                                <input type="text" name="banco_nombre" class="form-control form-control-sm" placeholder="Ej: Banco Industrial, BAM">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-secondary small">No. de Boleta o Ref.</label>
                                <input type="text" name="no_boleta" class="form-control form-control-sm" placeholder="Ej: TR-892401">
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="mb-2">
                        <label class="form-label text-secondary small fw-semibold">Observaciones / Notas de Entrega</label>
                        <textarea name="observaciones" class="form-control form-control-sm" rows="2" placeholder="Ej: Entregado en recepción con firma de recibido."></textarea>
                    </div>
                </div>

                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success fw-bold">Confirmar Entrega y Generar Egreso</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================= -->
<!-- MODAL: VER COMPROBANTE DE EGRESO (RECIBO DE PAGO)       -->
<!-- ======================================================= -->
<div class="modal fade" id="modalVerComprobante" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white fw-bold">Comprobante de Egreso de Caja</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="egreso-receipt-card">
                    <div class="egreso-receipt-header">
                        <span class="badge bg-primary text-uppercase mb-1">Renovation GYM - Améliorant</span>
                        <h4 class="fw-bold text-white mb-1">RECIBO DE PAGO POR REFERIDOS</h4>
                        <div class="text-warning fw-bold font-monospace" id="compNumeroEgreso">EGR-REF-2026-00000</div>
                        <span class="small text-secondary" id="compFechaEntrega">--</span>
                    </div>

                    <div class="egreso-receipt-body">
                        <div class="d-flex justify-content-between py-1 border-bottom border-secondary border-opacity-25">
                            <span class="text-secondary">Beneficiario:</span>
                            <strong class="text-white" id="compBeneficiario">--</strong>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom border-secondary border-opacity-25">
                            <span class="text-secondary">Concepto:</span>
                            <span class="text-white" id="compReferidoDe">Bono por afiliación</span>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom border-secondary border-opacity-25">
                            <span class="text-secondary">Modalidad de Pago:</span>
                            <strong class="text-info" id="compMetodoEntrega">EFECTIVO</strong>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom border-secondary border-opacity-25">
                            <span class="text-secondary">Entregado por:</span>
                            <span class="text-white" id="compRecepcionista">Recepción</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 mt-2 border-top border-secondary">
                            <span class="fs-6 fw-bold text-white">Monto Entregado:</span>
                            <span class="fs-4 fw-bold text-success" id="compMonto">Q0.00</span>
                        </div>
                        <div class="small text-secondary mt-2">
                            <em>Detalle: <span id="compObservaciones">--</span></em>
                        </div>

                        <!-- Línea de Firma -->
                        <div class="egreso-signature-line">
                            <div class="fw-bold text-white" id="compFirmaCliente">Firma del Cliente</div>
                            <span>Recibí conforme (Efectivo / Transferencia)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">Imprimir Recibo</button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================= -->
<!-- MODAL: REGISTRAR REFERIDO MANUALMENTE                   -->
<!-- ======================================================= -->
<div class="modal fade" id="modalNuevoReferido" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="registrar_referido">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-white fw-bold">Registrar Referido y Asignar Bono</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Cliente Referidor (Quién recomienda y recibe el bono) *</label>
                        <select name="cliente_referidor_id" class="form-select form-select-sm" required>
                            <option value="">-- Seleccionar cliente referidor --</option>
                            <?php foreach ($lista_clientes as $cli): ?>
                                <option value="<?= $cli['id'] ?>">
                                    <?= htmlspecialchars($cli['nombre'] . ' ' . $cli['apellido']) ?> (<?= htmlspecialchars($cli['email']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Cliente Referido (El nuevo miembro inscrito) *</label>
                        <select name="cliente_referido_id" class="form-select form-select-sm" required>
                            <option value="">-- Seleccionar cliente nuevo --</option>
                            <?php foreach ($lista_clientes as $cli): ?>
                                <option value="<?= $cli['id'] ?>">
                                    <?= htmlspecialchars($cli['nombre'] . ' ' . $cli['apellido']) ?> (<?= htmlspecialchars($cli['email']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Plan de Membresía Adquirido *</label>
                        <select name="membresia_id" class="form-select form-select-sm" required>
                            <?php foreach ($lista_membresias as $mem): ?>
                                <option value="<?= $mem['id'] ?>">
                                    <?= htmlspecialchars($mem['nombre']) ?> - Precio: Q<?= number_format($mem['precio_mes'], 2) ?> | Bono a otorgar: Q<?= number_format($mem['bono_referido'], 2) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text text-secondary small">
                            Regla Améliorant: Membresía Básica otorga Q100.00; Membresía Haute otorga Q150.00.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar y Acreditar Bono</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle JS local -->
<script src="../js/bootstrap.bundle.min.js"></script>

<!-- Script de Referidos y Bonos -->
<script src="../js/referidos.js"></script>

</body>
</html>
