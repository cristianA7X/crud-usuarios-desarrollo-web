<?php
require_once '../includes/config.php'; // Para BASE_URL y sesiones
require_once '../models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioModel = new Usuario();
    
    // 1. LIMPIEZA: Aplicamos trim a todo el array $_POST de una sola vez
    $datos = array_map('trim', $_POST);
    
    $accion = $datos['accion'] ?? '';
    $id = $datos['id'] ?? 0;

    // 2. PROCESAMIENTO
    if ($accion === 'crear') {
        $exito = $usuarioModel->crear($datos); // Usamos el array limpio
        $_SESSION['mensaje'] = $exito ? "Usuario creado correctamente" : "Error al crear";
    }

    if ($accion === 'actualizar') {
        $exito = $usuarioModel->actualizar($id, $datos);
        $_SESSION['mensaje'] = $exito ? "Datos actualizados" : "Error al actualizar";
    }

    if ($accion === 'eliminar') {
        $exito = $usuarioModel->eliminar($id);
        $_SESSION['mensaje'] = $exito ? "Usuario desactivado" : "Error al eliminar";
    }

    if ($accion === 'login') 
    {
        $usuario = $usuarioModel->login($datos['email'], $datos['password']);

        if ($usuario) 
        {
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['nombre']  = $usuario['nombre'];
            header("Location: " . BASE_URL . "views/dashboard.php");
        } 
        else 
        {
            $_SESSION['error'] = "Email o contraseña incorrectos";
            header("Location: " . BASE_URL . "login.php");
        }
        exit();
    }

    // 3. REDIRECCIÓN
    header("Location: " . BASE_URL . "index.php");
    exit();
}