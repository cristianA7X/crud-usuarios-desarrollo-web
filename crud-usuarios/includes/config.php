<?php
/**
 * ARCHIVO DE CONFIGURACIÓN GLOBAL
 * Este archivo centraliza la conexión a la base de datos, 
 * la URL base y la seguridad de las sesiones.
 */

// 1. Datos de conexión a la Base de Datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion_usuarios');
define('DB_USER', 'root');
define('DB_PASS', '');

// 2. URL Base del proyecto
define('BASE_URL', 'http://localhost/crud-usuarios-desarrollo-web/crud-usuarios/');

// 3. Configuración de Sesiones Seguras
define('SESSION_NAME', 'admin_session_js');

// Configuraciones de seguridad para proteger la sesión
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Strict');

// Iniciamos la sesión
session_name(SESSION_NAME);
session_start();