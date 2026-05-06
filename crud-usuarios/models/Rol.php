<?php
// Usamos __DIR__ para asegurarnos de que la ruta sea correcta desde cualquier lado
require_once __DIR__ . '/../includes/db.php'; 

class Rol 
{
    private $db;

    public function __construct() 
    {
        // Obtenemos la conexión PDO a través del método estático del Singleton
        $this->db = Database::getConnection(); 
    }

    /**
     * Obtiene todos los roles activos de la base de datos
     */
    public function getRoles() 
    {
        try 
        {
            // Usamos 'rol' que es el nombre en tu SQL
            $sql = "SELECT id, nombre, descripcion FROM rol WHERE activo = 1"; 
            $stmt = $this->db->query($sql);
            
            // Retornamos los datos como array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en getRoles: " . $e->getMessage());
            return [];
        }
    }
}
?>