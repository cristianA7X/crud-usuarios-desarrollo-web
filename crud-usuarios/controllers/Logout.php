<?php
require_once 'includes/config.php'; // Para obtener BASE_URL

// 1. Limpiamos las variables de sesión
session_unset();

// 2. Destruimos la sesión en el servidor
session_destroy();

// 3. Redirigimos al login o inicio
header("Location: " . BASE_URL . "login.php");
exit();