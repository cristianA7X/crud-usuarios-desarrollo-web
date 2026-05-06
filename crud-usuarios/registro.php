<?php require_once 'includes/config.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <div class="container my-5 d-flex justify-content-center align-items-center">
        <div class="card shadow p-4" style="width: 100%; max-width: 500px;">

            <!-- Mensajes de Alerta -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <h3 class="text-center mb-4">Registro de Usuario</h3>
            
            <form action="controllers/UsuarioController.php" method="post">
                <!-- Acción para el controlador -->
                <input type="hidden" name="accion" value="crear">

                <!-- Nombre Completo -->
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Juan Pérez" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="usuario@correo.com" required>
                </div>

                <!-- DNI -->
                <div class="mb-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="number" name="dni" id="dni" class="form-control" placeholder="Solo números" required>
                </div>

                <!-- Contraseña -->
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Repetir Contraseña -->
                <div class="mb-3">
                    <label for="confirmar_password" class="form-label">Repetir Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="confirmar_password" id="confirmar_password" class="form-control" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Selección de Rol -->
                <div class="mb-4">
                    <label for="rol_id" class="form-label">Tipo de Usuario</label>
                    <select name="rol_id" id="rol_id" class="form-select" required>
                        <option value="" selected disabled>Seleccione un rol...</option>
                        <option value="1">Administrador</option>
                        <option value="2">Operador</option>
                        <option value="3">Espectador (Viewer)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Registrar Usuario</button>

                <div class="text-center">
                    <small>¿Ya tenés cuenta? <a href="index.php" class="text-decoration-none">Iniciá sesión acá</a></small>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Lógica de los ojitos -->
    <script>
        function setupPasswordToggle(buttonId, inputId) {
            const button = document.querySelector(buttonId);
            const input = document.querySelector(inputId);

            button.addEventListener('click', function () {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.querySelector('i').classList.toggle('bi-eye');
                this.querySelector('i').classList.toggle('bi-eye-slash');
            });
        }

        // Activamos los dos botones por separado
        setupPasswordToggle('#togglePassword', '#password');
        setupPasswordToggle('#toggleConfirmPassword', '#confirmar_password');
    </script>
</body>
</html>