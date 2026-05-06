<?php
// 1. IMPORTACIONES
require_once '../../includes/config.php';
require_once '../../models/Usuario.php';

// 2. SEGURIDAD
// Chequeamos que sea admin
if (!isset($_SESSION['user_id']) || $_SESSION['rol_id'] != 1) {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// 3. RECIBIR EL ID
// Chequeamos si vino un parámetro 'id' en la URL (ejemplo: editar.php?id=5)
if (!isset($_GET['id'])) {
    // Si entró sin ID, lo devolvemos al dashboard
    header("Location: dashboard.php");
    exit();
}

$id_usuario = $_GET['id'];

// 4. TRAER LOS DATOS DEL USUARIO
$usuarioModel = new Usuario();
$usuario = $usuarioModel->obtenerPorId($id_usuario);

// Si alguien pone a mano un ID que no existe, lo pateamos
if (!$usuario) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container my-5 d-flex justify-content-center">
        <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
            
            <h3 class="mb-4">Editar Usuario ID: <?php echo $usuario['id']; ?></h3>
            
            <!-- El formulario apunta por POST a tu controlador -->
            <form action="../../controllers/UsuarioController.php" method="POST">
                
                <!-- Acciones ocultas para el controlador -->
                <input type="hidden" name="accion" value="actualizar">
                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <!-- Imprimimos el valor actual en el atributo 'value' -->
                    <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">DNI</label>
                    <input type="number" name="dni" class="form-control" value="<?php echo htmlspecialchars($usuario['dni']); ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Rol</label>
                    <select name="rol_id" class="form-select" required>
                        <!-- Usamos ifs cortos para dejar preseleccionado (selected) el rol que ya tenía -->
                        <option value="1" <?php echo ($usuario['rol_id'] == 1) ? 'selected' : ''; ?>>Administrador</option>
                        <option value="2" <?php echo ($usuario['rol_id'] == 2) ? 'selected' : ''; ?>>Operador</option>
                        <option value="3" <?php echo ($usuario['rol_id'] == 3) ? 'selected' : ''; ?>>Espectador</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>