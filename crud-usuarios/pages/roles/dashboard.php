<?php
// 1. IMPORTACIONES
// Traemos la configuración global (sesiones, constantes de URL) y el modelo
require_once '../../includes/config.php';
require_once '../../models/Usuario.php';

// -------------------------------------------------------------
// 2. BLOQUE DE SEGURIDAD
// -------------------------------------------------------------

// Si no existe la variable de sesión 'user_id' (no pasó por el login)
// O si el 'rol_id' no es 1 (no es Administrador)
if (!isset($_SESSION['user_id']) || $_SESSION['rol_id'] != 1) {
    
    // Lo pateamos de vuelta al Login
    header("Location: " . BASE_URL . "index.php");
    
    // Cortamos la ejecución acá mismo para que no cargue el HTML de abajo
    exit();
}

// -------------------------------------------------------------
// 3. CONSULTA A LA BASE DE DATOS
// -------------------------------------------------------------

// Creamos un nuevo objeto de la clase Usuario
$usuarioModel = new Usuario();

// Usamos tu método listar() que trae a todos los usuarios con su rol
// Guardamos todo el array de resultados en la variable $listaUsuarios
$listaUsuarios = $usuarioModel->listar(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    
    <!-- Cargamos Bootstrap para los estilos y los íconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <!-- 
    =============================================================
    BARRA DE NAVEGACIÓN (NAVBAR)
    ============================================================= 
    -->
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Sistema CRUD</span>
            
            <div class="d-flex align-items-center text-white">
                <!-- Mostramos el nombre del Admin logueado leyendo la sesión -->
                <!-- htmlspecialchars() sanitiza el texto por seguridad -->
                <span class="me-3">Admin: <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                
                <!-- Botón para cerrar sesión -->
                <a href="../../controllers/Logout.php" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <!-- 
    =============================================================
    CONTENIDO PRINCIPAL: LISTA DE USUARIOS
    ============================================================= 
    -->
    <div class="container">
        
        <!-- Encabezado y botón para crear un usuario nuevo -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Gestión de Usuarios</h2>
            
            <a href="../../registro.php" class="btn btn-success">
                <i class="bi bi-person-plus-fill"></i> Nuevo Usuario
            </a>
        </div>

        <!-- Contenedor de la tabla -->
        <div class="card shadow">
            <div class="card-body p-0">
                <div class="table-responsive">
                    
                    <!-- Inicio de la tabla HTML -->
                    <table class="table table-hover table-striped m-0">
                        
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>DNI</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <!-- 
                            =========================================================
                            LÓGICA PHP: DIBUJAR LAS FILAS DE LA TABLA
                            =========================================================
                            -->

                            <!-- Chequeamos si el array de usuarios vino vacío -->
                            <?php if (empty($listaUsuarios)): ?>
                                
                                <!-- Si está vacío, mostramos una fila que ocupe todo el ancho -->
                                <tr>
                                    <td colspan="7" class="text-center py-3">No hay usuarios registrados.</td>
                                </tr>

                            <?php else: ?>
                                
                                <!-- Si hay datos, recorremos el array registro por registro -->
                                <?php foreach ($listaUsuarios as $user): ?>
                                    <tr>
                                        
                                        <!-- Imprimimos el ID directamente porque es un número -->
                                        <td><?php echo $user['id']; ?></td>
                                        
                                        <!-- Usamos htmlspecialchars() en textos ingresados por usuarios por seguridad -->
                                        <td><?php echo htmlspecialchars($user['nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['dni']); ?></td>
                                        
                                        <!-- Columna Rol: Viene del INNER JOIN (alias 'rol_nombre') -->
                                        <td>
                                            <span class="badge bg-primary">
                                                <?php echo htmlspecialchars($user['rol_nombre']); ?>
                                            </span>
                                        </td>
                                        
                                        <!-- Columna Estado: Evaluamos si el campo 'activo' es 1 o 0 en la BD -->
                                        <td>
                                            <?php if ($user['activo'] == 1): ?>
                                                <span class="badge bg-success">Activo</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inactivo</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <!-- Columna Acciones: Botones Editar y Eliminar (aún sin funcionalidad) -->
                                        <td class="text-center">
                                            <a href="editar.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <!-- Botón Eliminar (convertido en formulario POST) -->
                                            <form action="../../controllers/UsuarioController.php" method="POST" class="d-inline">
                                                <input type="hidden" name="accion" value="eliminar">
                                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Dar de baja" onclick="return confirm('¿Seguro que querés dar de baja a este usuario?');">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                <?php endforeach; ?> <!-- Fin del bucle foreach -->

                            <?php endif; ?> <!-- Fin de la validación de array vacío -->
                            
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>