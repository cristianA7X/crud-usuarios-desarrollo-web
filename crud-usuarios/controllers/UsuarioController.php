<?php
require_once '../includes/config.php'; 
require_once '../models/Usuario.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioModel = new Usuario();
    
    // Sanitización de datos de entrada
    $datos = array_map('trim', $_POST);
    $accion = $datos['accion'] ?? '';
    $id = $datos['id'] ?? 0;

    // Procesamiento de registro de nuevo usuario
    if ($accion === 'crear') {
        // Validación de coincidencia de contraseñas
        if ($datos['password'] !== $datos['confirmar_password']) {
            $_SESSION['error'] = "Las contraseñas no coinciden.";
            header("Location: " . BASE_URL . "registro.php");
            exit();
        }

        $exito = $usuarioModel->crear($datos); 
        $_SESSION['mensaje'] = $exito ? "Operación exitosa" : "Error en el registro";
        
        $redireccion = $exito ? "index.php" : "registro.php";
        header("Location: " . BASE_URL . $redireccion);
        exit();
    }

    // Autenticación y derivación por roles
    if ($accion === 'login') {
        $usuario = $usuarioModel->login($datos['email'], $datos['password']);
        
        if ($usuario) {
            // Persistencia de datos de sesión
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['nombre']  = $usuario['nombre'];
            $_SESSION['rol_id']  = $usuario['rol_id'];

            // Redirección basada en el privilegio del usuario (Admin = 1)
            if ($usuario['rol_id'] == 1) {
                header("Location: " . BASE_URL . "pages/roles/dashboard.php");
            } else {
                header("Location: " . BASE_URL . "pages/usuarios/dashboard.php");
            }
        } else {
            $_SESSION['error'] = "Credenciales inválidas";
            header("Location: " . BASE_URL . "index.php"); 
        }
        exit();
    }

    // Gestión de actualización de datos
    if ($accion === 'actualizar') {
        $exito = $usuarioModel->actualizar($id, $datos);
        $_SESSION['mensaje'] = $exito ? "Datos actualizados" : "Error al actualizar";
    }

    // Baja lógica de usuario
    if ($accion === 'eliminar') {
        $exito = $usuarioModel->eliminar($id);
        $_SESSION['mensaje'] = $exito ? "Usuario dado de baja" : "Error al eliminar";
    }

    // Redirección por defecto ante acciones no definidas
    header("Location: " . BASE_URL . "index.php");
    exit();
}