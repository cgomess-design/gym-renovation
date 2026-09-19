<?php
// suplementos/index.php - Vista de Punto de Venta (POS) y Tienda de Suplementos

require_once __DIR__ . '/controlador_suplementos.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de Venta & Tienda de Suplementos - Renovation GYM</title>
    
    <!-- Bootstrap 5 CSS local -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    
    <!-- Estilos del Dashboard -->
    <link rel="stylesheet" href="../css/dashboard.css">
    
    <!-- Estilos específicos de Suplementos y POS -->
    <link rel="stylesheet" href="../css/suplementos.css">
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

            <!-- Suplementos (Activo) -->
            <a href="index.php" class="sidebar-link active">
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
                <span class="active">Punto de Venta de Suplementos</span>
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
                    <h2 class="fw-bold text-white mb-1" style="font-size: 1.65rem;">Tienda de Suplementos & POS</h2>
                    <p class="text-secondary mb-0">Facturación de servicios tercerizados, control de inventario y canje directo de bonos por referidos.</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-light d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Nuevo Producto</span>
                    </button>
                </div>
            </div>

            <!-- KPIs de Ventas y Servicios Tercerizados -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="kpi-title">Ventas Hoy (POS)</span>
                            <div class="kpi-icon-wrap" style="color: #4ade80; background: rgba(74, 222, 128, 0.12);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            </div>
                        </div>
                        <div class="kpi-value text-white">Q<?= number_format($kpi_ventas_hoy, 2) ?></div>
                        <div class="kpi-trend text-secondary">Servicios tercerizados Améliorant</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="kpi-title">Facturas Hoy</span>
                            <div class="kpi-icon-wrap" style="color: #38bdf8; background: rgba(56, 189, 248, 0.12);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            </div>
                        </div>
                        <div class="kpi-value text-white"><?= $kpi_facturas_hoy ?></div>
                        <div class="kpi-trend text-secondary">Tickets emitidos</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="kpi-title">Stock Bajo / Alerta</span>
                            <div class="kpi-icon-wrap" style="color: #f59e0b; background: rgba(245, 158, 11, 0.12);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                            </div>
                        </div>
                        <div class="kpi-value text-white"><?= $kpi_stock_bajo ?></div>
                        <div class="kpi-trend text-secondary">Items con ≤ 5 unidades</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="kpi-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="kpi-title">Bonos Canjeados</span>
                            <div class="kpi-icon-wrap" style="color: var(--primary-accent); background: rgba(255, 87, 34, 0.12);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                            </div>
                        </div>
                        <div class="kpi-value text-white">Q<?= number_format($kpi_bonos_canjeados, 2) ?></div>
                        <div class="kpi-trend text-secondary">Fidelización aplicada en compras</div>
                    </div>
                </div>
            </div>

            <!-- Pestañas de Navegación del Módulo -->
            <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold" id="pills-pos-tab" data-bs-toggle="pill" data-bs-target="#pills-pos" type="button" role="tab">
                        Punto de Venta (POS)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="pills-facturas-tab" data-bs-toggle="pill" data-bs-target="#pills-facturas" type="button" role="tab">
                        Historial de Facturas (<?= count($ventas_historial) ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="pills-catalogo-tab" data-bs-toggle="pill" data-bs-target="#pills-catalogo" type="button" role="tab">
                        Catálogo & Inventario (<?= count($catalogo_productos) ?>)
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                
                <!-- =========================================================== -->
                <!-- PESTAÑA 1: PUNTO DE VENTA (POS) Y CARRITO                   -->
                <!-- =========================================================== -->
                <div class="tab-pane fade show active" id="pills-pos" role="tabpanel">
                    <div class="row g-4">
                        
                        <!-- Catálogo interactivo para añadir al carrito (8 columnas) -->
                        <div class="col-12 col-lg-8">
                            <div class="content-table-wrapper p-3 mb-4">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary active">Todos</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Proteínas</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Creatinas</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Pre-Workout</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Aminoácidos</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Bebidas</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Accesorios</button>
                                </div>

                                <div class="row g-3">
                                    <?php if (empty($catalogo_productos)): ?>
                                        <div class="col-12 text-center py-5 text-secondary">
                                            No hay productos disponibles en el catálogo actualmente.
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($catalogo_productos as $prod): ?>
                                            <div class="col-12 col-sm-6 col-xl-4">
                                                <div class="product-card">
                                                    <div>
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <span class="product-stock-badge <?= $prod['stock'] <= 5 ? 'text-warning border-warning' : 'text-success' ?>">
                                                                Stock: <?= $prod['stock'] ?> un.
                                                            </span>
                                                            <span class="badge bg-dark text-info border border-secondary" style="font-size: 0.65rem;">
                                                                <?= htmlspecialchars($prod['categoria']) ?>
                                                            </span>
                                                        </div>
                                                        <h6 class="fw-bold text-white mb-1"><?= htmlspecialchars($prod['nombre']) ?></h6>
                                                        <p class="text-secondary small mb-3" style="min-height: 38px; line-height: 1.3;">
                                                            <?= htmlspecialchars($prod['descripcion'] ?: 'Suplemento de alta calidad.') ?>
                                                        </p>
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-secondary">
                                                        <div class="product-price-tag">
                                                            Q<?= number_format($prod['precio'], 2) ?>
                                                        </div>
                                                        <?php if ($prod['stock'] > 0): ?>
                                                            <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                                                                    onclick="agregarAlCarrito(<?= $prod['id'] ?>, '<?= htmlspecialchars($prod['codigo']) ?>', '<?= htmlspecialchars(addslashes($prod['nombre'])) ?>', <?= $prod['precio'] ?>, <?= $prod['stock'] ?>)">
                                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                                                <span>Añadir</span>
                                                            </button>
                                                        <?php else: ?>
                                                            <button type="button" class="btn btn-sm btn-secondary" disabled>Agotado</button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Panel de Facturación y Carrito de Compras (4 columnas) -->
                        <div class="col-12 col-lg-4">
                            <div class="pos-cart-panel">
                                <h5 class="fw-bold text-white d-flex align-items-center gap-2 mb-3">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                    <span>Ticket de Venta</span>
                                </h5>

                                <form action="index.php" method="POST" id="formVentaPos">
                                    <input type="hidden" name="accion" value="vender_pos">
                                    <input type="hidden" name="productos_json" id="posProductosJSON" value="">
                                    <input type="hidden" name="monto_bono_usado" id="posInputBonoUsado" value="0.00">
                                    <input type="hidden" name="total_venta" id="posInputTotal" value="0.00">

                                    <!-- Sucursal -->
                                    <div class="mb-3">
                                        <label class="form-label text-secondary small fw-semibold">Sucursal de Venta</label>
                                        <select name="sucursal_id" class="form-select form-select-sm" required>
                                            <?php foreach ($sucursales_pos as $suc): ?>
                                                <option value="<?= $suc['id'] ?>"><?= htmlspecialchars($suc['nombre']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Cliente Mostrador o Miembro Registrado -->
                                    <div class="mb-3">
                                        <label class="form-label text-secondary small fw-semibold">Cliente / Miembro</label>
                                        <select name="cliente_id" id="posClienteId" class="form-select form-select-sm">
                                            <option value="" data-bono="0">-- Cliente de Mostrador (Sin Registro) --</option>
                                            <?php foreach ($clientes_pos as $c): ?>
                                                <option value="<?= $c['id'] ?>" data-bono="<?= $c['bono_disponible'] ?>">
                                                    <?= htmlspecialchars($c['nombre'] . ' ' . $c['apellido']) ?>
                                                    <?= $c['bono_disponible'] > 0 ? " (Bono: Q" . number_format($c['bono_disponible'], 2) . ")" : "" ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Alerta de Bono de Referidos Disponible -->
                                    <div id="alertBonoReferidoWrap" class="alert alert-info border-0 p-2 mb-3 d-none" style="background-color: rgba(56, 189, 248, 0.15); border-left: 3px solid #38bdf8 !important;">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="small fw-bold text-info">¡Bono por Referidos Disponible!</span>
                                            <span class="badge bg-info text-dark" id="textBonoMonto">Q0.00</span>
                                        </div>
                                        <div class="form-check form-switch m-0">
                                            <input class="form-check-input" type="checkbox" id="chkUsarBono">
                                            <label class="form-check-label text-white small" for="chkUsarBono">Aplicar saldo a esta compra</label>
                                        </div>
                                    </div>

                                    <!-- Lista de Productos en el Carrito -->
                                    <label class="form-label text-secondary small fw-semibold">Detalle de Productos</label>
                                    <div id="posCartEmptyState" class="text-center py-4 text-secondary small border rounded border-secondary border-opacity-25 mb-3">
                                        El carrito está vacío.<br>Haz clic en "Añadir" en cualquier producto.
                                    </div>
                                    <div id="posCartItemsContainer" class="mb-3" style="max-height: 220px; overflow-y: auto;"></div>

                                    <!-- Método de Pago -->
                                    <div class="mb-3">
                                        <label class="form-label text-secondary small fw-semibold">Método de Pago</label>
                                        <select name="metodo_pago" class="form-select form-select-sm" required>
                                            <option value="EFECTIVO">Efectivo</option>
                                            <option value="TARJETA">Tarjeta de Débito / Crédito</option>
                                            <option value="TRANSFERENCIA">Transferencia Bancaria</option>
                                        </select>
                                    </div>

                                    <!-- Resumen de Totales -->
                                    <div class="cart-total-box">
                                        <div class="d-flex justify-content-between text-secondary small mb-1">
                                            <span>Subtotal:</span>
                                            <span class="text-white fw-bold" id="posSubtotalText">Q0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between text-info small mb-1 d-none" id="posRowBonoDescuento">
                                            <span>Bono Aplicado:</span>
                                            <span class="fw-bold" id="posBonoDescuentoText">- Q0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between text-white fw-bold pt-2 border-top border-secondary">
                                            <span>Total a Pagar:</span>
                                            <span class="text-success fs-5" id="posTotalText">Q0.00</span>
                                        </div>
                                    </div>

                                    <!-- Botón de Confirmación -->
                                    <div class="mt-3">
                                        <button type="submit" id="btnConfirmarCobro" class="btn btn-primary w-100 fw-bold py-2 d-flex align-items-center justify-content-center gap-2" disabled>
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"></path></svg>
                                            <span>Cobrar & Emitir Factura</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- PESTAÑA 2: HISTORIAL DE FACTURAS DE SUPLEMENTOS             -->
                <!-- =========================================================== -->
                <div class="tab-pane fade" id="pills-facturas" role="tabpanel">
                    <div class="content-table-wrapper">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>No. Factura</th>
                                        <th>Fecha & Hora</th>
                                        <th>Cliente</th>
                                        <th>Sucursal</th>
                                        <th>Vendedor</th>
                                        <th>Subtotal</th>
                                        <th>Bono Usado</th>
                                        <th>Total Cobrado</th>
                                        <th>Método</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($ventas_historial)): ?>
                                        <tr>
                                            <td colspan="10" class="text-center py-5 text-secondary">
                                                No hay facturas de suplementos registradas todavía.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($ventas_historial as $fac): ?>
                                            <tr>
                                                <td>
                                                    <span class="fw-bold text-info"><?= htmlspecialchars($fac['numero_factura']) ?></span>
                                                </td>
                                                <td class="small text-secondary">
                                                    <?= date('d/m/Y H:i', strtotime($fac['fecha_venta'])) ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($fac['cliente_nombre'])): ?>
                                                        <span class="text-white fw-semibold"><?= htmlspecialchars($fac['cliente_nombre'] . ' ' . $fac['cliente_apellido']) ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Cliente Mostrador</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="small text-secondary"><?= htmlspecialchars($fac['sucursal_nombre'] ?? 'Central') ?></td>
                                                <td class="small text-secondary"><?= htmlspecialchars(($fac['vendedor_nombre'] ?? '') . ' ' . ($fac['vendedor_apellido'] ?? '')) ?></td>
                                                <td class="text-secondary small">Q<?= number_format($fac['subtotal'], 2) ?></td>
                                                <td>
                                                    <?php if ($fac['monto_bono_usado'] > 0): ?>
                                                        <span class="badge bg-info text-dark">Q<?= number_format($fac['monto_bono_usado'], 2) ?></span>
                                                    <?php else: ?>
                                                        <span class="text-secondary small">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="fw-bold text-success">
                                                    Q<?= number_format($fac['total_venta'], 2) ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-dark border border-secondary"><?= htmlspecialchars($fac['metodo_pago']) ?></span>
                                                </td>
                                                <td class="text-end">
                                                    <button type="button" class="btn btn-sm btn-outline-info" onclick='verFacturaSuplemento(<?= json_encode($fac) ?>)'>
                                                        Ver Factura
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- =========================================================== -->
                <!-- PESTAÑA 3: CATÁLOGO DE PRODUCTOS E INVENTARIO              -->
                <!-- =========================================================== -->
                <div class="tab-pane fade" id="pills-catalogo" role="tabpanel">
                    <div class="content-table-wrapper">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Producto</th>
                                        <th>Categoría</th>
                                        <th>Precio Unitario</th>
                                        <th>Stock Actual</th>
                                        <th>Estado</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($catalogo_productos as $p): ?>
                                        <tr>
                                            <td><code class="text-info"><?= htmlspecialchars($p['codigo']) ?></code></td>
                                            <td>
                                                <div class="fw-bold text-white"><?= htmlspecialchars($p['nombre']) ?></div>
                                                <div class="small text-secondary"><?= htmlspecialchars($p['descripcion']) ?></div>
                                            </td>
                                            <td><span class="badge bg-dark text-white border border-secondary"><?= htmlspecialchars($p['categoria']) ?></span></td>
                                            <td class="fw-bold text-success">Q<?= number_format($p['precio'], 2) ?></td>
                                            <td>
                                                <span class="badge <?= $p['stock'] <= 5 ? 'bg-warning text-dark' : 'bg-success' ?>">
                                                    <?= $p['stock'] ?> unidades
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Activo</span>
                                            </td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                        onclick='editarProducto(<?= json_encode($p) ?>)'>
                                                    Editar / Stock
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>
</div>

<!-- ======================================================= -->
<!-- MODAL: VER FACTURA DE SUPLEMENTOS                       -->
<!-- ======================================================= -->
<div class="modal fade" id="modalVerFacturaSuplemento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                    <span>Comprobante de Venta - Suplementos</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="p-3 mb-3 text-center rounded" style="background-color: #0c121e; border: 1px solid #27374d;">
                    <span class="badge bg-primary text-uppercase mb-1">Renovation GYM - Améliorant</span>
                    <h4 class="text-info fw-bold mb-0" id="verFacNum">FAC-SUP-2026-00000</h4>
                    <span class="small text-secondary" id="verFacFecha">--</span>
                </div>

                <div class="row g-2 mb-3 small">
                    <div class="col-6">
                        <span class="text-secondary d-block">Cliente:</span>
                        <strong class="text-white" id="verFacCliente">--</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-secondary d-block">Sucursal:</span>
                        <strong class="text-white" id="verFacSucursal">--</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-secondary d-block">Vendedor:</span>
                        <strong class="text-white" id="verFacVendedor">--</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-secondary d-block">Método de Pago:</span>
                        <strong class="text-white" id="verFacMetodo">--</strong>
                    </div>
                </div>

                <div class="p-2 mb-3 rounded d-none" id="verFacBoxBono" style="background-color: rgba(56, 189, 248, 0.1); border-left: 3px solid #38bdf8;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-info">Descuento aplicado por Bono de Referidos:</span>
                        <strong class="text-info" id="verFacBonoUsado">- Q0.00</strong>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center p-3 rounded" style="background-color: #0c121e; border: 1px solid #27374d;">
                    <span class="fs-6 fw-bold text-white">Total Facturado:</span>
                    <span class="fs-4 fw-bold text-success" id="verFacTotal">Q0.00</span>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">Imprimir Ticket</button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================= -->
<!-- MODAL: NUEVO PRODUCTO EN CATÁLOGO                      -->
<!-- ======================================================= -->
<div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="crear_producto">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-white fw-bold">Nuevo Producto de Suplementos</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-semibold">Código *</label>
                            <input type="text" name="codigo" class="form-control form-control-sm" placeholder="Ej: PROT-ISO-03" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-semibold">Categoría *</label>
                            <select name="categoria" class="form-select form-select-sm" required>
                                <option value="PROTEINAS">Proteínas</option>
                                <option value="CREATINAS">Creatinas</option>
                                <option value="AMINOACIDOS">Aminoácidos (BCAA)</option>
                                <option value="PRE_WORKOUT">Pre-Workout</option>
                                <option value="BEBIDAS">Bebidas & Hidratación</option>
                                <option value="ACCESORIOS">Accesorios & Shakers</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small fw-semibold">Nombre del Producto *</label>
                            <input type="text" name="nombre" class="form-control form-control-sm" placeholder="Ej: Whey Isolate 5lbs Cookies" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-semibold">Precio de Venta (Q) *</label>
                            <input type="number" step="0.01" name="precio" class="form-control form-control-sm" placeholder="0.00" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-semibold">Stock Inicial *</label>
                            <input type="number" name="stock" class="form-control form-control-sm" value="10" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small fw-semibold">Descripción</label>
                            <textarea name="descripcion" class="form-control form-control-sm" rows="2" placeholder="Detalles de contenido, servicios o sabor..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================= -->
<!-- MODAL: EDITAR PRODUCTO / AJUSTAR STOCK                  -->
<!-- ======================================================= -->
<div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="index.php" method="POST">
                <input type="hidden" name="accion" value="editar_producto">
                <input type="hidden" name="id" id="editProdId" value="">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-white fw-bold">Editar Producto / Stock</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-semibold">Categoría *</label>
                            <select name="categoria" id="editProdCat" class="form-select form-select-sm" required>
                                <option value="PROTEINAS">Proteínas</option>
                                <option value="CREATINAS">Creatinas</option>
                                <option value="AMINOACIDOS">Aminoácidos (BCAA)</option>
                                <option value="PRE_WORKOUT">Pre-Workout</option>
                                <option value="BEBIDAS">Bebidas & Hidratación</option>
                                <option value="ACCESORIOS">Accesorios & Shakers</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-semibold">Estado *</label>
                            <select name="estado" id="editProdEstado" class="form-select form-select-sm">
                                <option value="ACTIVO">Activo</option>
                                <option value="INACTIVO">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small fw-semibold">Nombre del Producto *</label>
                            <input type="text" name="nombre" id="editProdNombre" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-semibold">Precio de Venta (Q) *</label>
                            <input type="number" step="0.01" name="precio" id="editProdPrecio" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-secondary small fw-semibold">Stock Disponible *</label>
                            <input type="number" name="stock" id="editProdStock" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small fw-semibold">Descripción</label>
                            <textarea name="descripcion" id="editProdDesc" class="form-control form-control-sm" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle JS local -->
<script src="../js/bootstrap.bundle.min.js"></script>

<!-- Script de Suplementos y POS -->
<script src="../js/suplementos.js"></script>

<script>
function editarProducto(prod) {
    document.getElementById('editProdId').value = prod.id;
    document.getElementById('editProdNombre').value = prod.nombre;
    document.getElementById('editProdCat').value = prod.categoria;
    document.getElementById('editProdPrecio').value = prod.precio;
    document.getElementById('editProdStock').value = prod.stock;
    document.getElementById('editProdEstado').value = prod.estado;
    document.getElementById('editProdDesc').value = prod.descripcion || '';
    
    const modal = new bootstrap.Modal(document.getElementById('modalEditarProducto'));
    modal.show();
}
</script>

</body>
</html>
