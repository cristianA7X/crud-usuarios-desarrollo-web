<?php
// Traemos las constantes (DB_HOST, DB_NAME, etc.)
require_once 'config.php';

class Database {
    // Propiedad estática para guardar la única conexión (instancia)
    private static $instance = null;
    private $connection;

    // Constructor PRIVADO: impide crear el objeto con "new" desde fuera
    private function __construct() {
        try {
            // Configuramos la dirección, el usuario y la clave
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            
            // Creamos la conexión PDO
            $this->connection = new PDO($dsn, DB_USER, DB_PASS);
            
            // Forzamos a que PDO lance excepciones si hay errores en el SQL
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Si algo falla, cortamos todo y mostramos el error
            die("Error crítico de conexión: " . $e->getMessage());
        }
    }

    // El método que usaremos siempre: Database::getConnection()
    public static function getConnection() {
        // Si no hay conexión previa, la creamos una sola vez
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        // Retornamos la conexión PDO activa
        return self::$instance->connection;
    }
}