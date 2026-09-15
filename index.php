<?php
// Cargar la lógica de autenticación y control de sesión
require_once __DIR__ . '/login/validar_login.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema - Gym Fitness</title>
    
    <!-- Bootstrap 5 CSS local -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Estilos personalizados del Login -->
    <link rel="stylesheet" href="css/login.css">
</head>
<body class="d-flex align-items-center justify-content-center py-4">

    <main class="container d-flex justify-content-center">
        <div class="login-card p-4 p-sm-5">
            
            <!-- Encabezado del Gimnasio / Branding -->
            <div class="text-center mb-4">
                <div class="gym-logo-badge mb-3">
                    <!-- Icono SVG de Gimnasio / Pesa (100% offline) -->
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 5v14"/>
                        <path d="M18 5v14"/>
                        <path d="M2 9v6"/>
                        <path d="M22 9v6"/>
                        <path d="M6 12h12"/>
                    </svg>
                </div>
                <h1 class="h4 fw-bold text-white mb-1">GYM SYSTEM</h1>
                <p class="brand-subtitle">Bienvenido, ingresa tus credenciales</p>
            </div>

            <!-- Alertas dinámicas con PHP -->
            <?php if (isset($_GET['logout'])): ?>
                <div class="alert alert-info alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                    <div>Has cerrado sesión correctamente.</div>
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

            <?php if (!empty($mensaje_exito)): ?>
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                    <svg class="me-2" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    <div><?= htmlspecialchars($mensaje_exito) ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <!-- Formulario de Login -->
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="needs-validation" novalidate>
                
                <!-- Campo: Usuario / Email -->
                <div class="mb-3">
                    <label for="usuario" class="form-label small text-uppercase fw-semibold" style="color: var(--text-muted); letter-spacing: 0.5px;">
                        Usuario o Correo
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <!-- Icono de usuario -->
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        <input 
                            type="text" 
                            class="form-control input-with-icon" 
                            id="usuario" 
                            name="usuario" 
                            placeholder="ejemplo@gym.com" 
                            value="<?= isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : '' ?>"
                            required 
                            autofocus
                        >
                        <div class="invalid-feedback">
                            Por favor ingresa tu usuario o correo.
                        </div>
                    </div>
                </div>

                <!-- Campo: Contraseña -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label small text-uppercase fw-semibold mb-0" style="color: var(--text-muted); letter-spacing: 0.5px;">
                            Contraseña
                        </label>
                        <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">
                            <!-- Icono de candado -->
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            class="form-control input-with-icon" 
                            id="password" 
                            name="password" 
                            placeholder="••••••••" 
                            required
                        >
                        <button class="btn btn-toggle-password" type="button" id="btnTogglePassword" title="Mostrar/Ocultar contraseña">
                            <!-- Icono ojo -->
                            <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                        <div class="invalid-feedback">
                            Por favor ingresa tu contraseña.
                        </div>
                    </div>
                </div>

                <!-- Recordarme -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="recordar" name="recordar">
                    <label class="form-check-label small" for="recordar" style="color: var(--text-muted);">
                        Recordar mi sesión
                    </label>
                </div>

                <!-- Botón de Ingreso -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-gym py-2">
                        Iniciar Sesión
                    </button>
                </div>

                <!-- Pie de página informativo -->
                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">
                        ¿No tienes una cuenta? <a href="#" class="forgot-link fw-semibold">Contacta al administrador</a>
                    </p>
                </div>

            </form>
        </div>
    </main>

    <!-- Bootstrap 5 Bundle JS local -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Script personalizado del Login -->
    <script src="js/login.js"></script>
</body>
</html>
