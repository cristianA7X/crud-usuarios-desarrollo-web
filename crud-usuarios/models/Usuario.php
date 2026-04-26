<?php
require_once __DIR__ . '/../includes/db.php';

class Usuario 
{
    private $db;

    public function __construct() 
    {
        $this->db = Database::getConnection();
    }

    /*CREATE: Registra un nuevo usuario en la base de datos*/
    public function crear($datos) 
    {
        try 
        {
            // Preparamos la consulta con marcadores para que sea segura
            $sql = "INSERT INTO usuario (nombre, email, password_hash, dni, rol_id) 
                    VALUES (:nombre, :email, :password, :dni, :rol_id)";
            
            $stmt = $this->db->prepare($sql);

            // Ejecutamos pasando los valores reales
            return $stmt->execute([
                ':nombre'   => $datos['nombre'],
                ':email'    => $datos['email'],
                ':password' => password_hash($datos['password'], PASSWORD_DEFAULT), // Encriptamos la clave
                ':dni'      => $datos['dni'],
                ':rol_id'   => $datos['rol_id']
            ]);
        }catch (PDOException $e) 
        {
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    }

    /*READ: Obtiene todos los usuarios con el nombre de su rol*/
    public function listar() 
    {
        try 
        {
            // Seleccionamos columnas específicas por seguridad y rendimiento
            // Usamos un JOIN para traer el nombre del rol desde la tabla 'rol'
            $sql = "SELECT u.id, u.nombre, u.email, u.dni, u.activo, r.nombre as rol_nombre 
                    FROM usuario u 
                    INNER JOIN rol r ON u.rol_id = r.id 
                    ORDER BY u.fecha_alta DESC";
            
            $stmt = $this->db->query($sql);
            
            // Retornamos todos los registros
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) 
        {
            error_log("Error al listar usuarios: " . $e->getMessage());
            return [];
        }
    }

    public function actualizar($id, $datos) 
    {
        try 
        {
            // SQL con marcadores de posición para seguridad
            $sql = "UPDATE usuario 
                    SET nombre = :nombre, email = :email, dni = :dni, rol_id = :rol_id 
                    WHERE id = :id";
            
            $stmt = $this->db->prepare($sql); // Prepara la sentencia
            
            // Ejecuta pasando el array de valores
            return $stmt->execute([
                ':nombre' => $datos['nombre'],
                ':email'  => $datos['email'],
                ':dni'    => $datos['dni'],
                ':rol_id' => $datos['rol_id'],
                ':id'     => $id
            ]);
        } 
        catch (PDOException $e) 
        {
            error_log("Error al actualizar: " . $e->getMessage()); // Registro privado del error
            return false;
        }
    }

    public function eliminar($id) 
    {
        try 
        {
            // Cambiamos el estado a 0 en lugar de usar DELETE
            $sql = "UPDATE usuario SET activo = 0 WHERE id = :id";
            
            $stmt = $this->db->prepare($sql); // Preparamos por seguridad
            
            // Ejecutamos vinculando el ID de la instancia específica
            return $stmt->execute([':id' => $id]);
        } 
        catch (PDOException $e) 
        {
            error_log("Fallo al eliminar: " . $e->getMessage()); // Registro silencioso del error
            return false;
        }
    }

    public function login($email, $password) 
    {
        $sql = "SELECT * FROM usuario WHERE email = :email AND activo = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        // Verificamos si existe y si la clave coincide con el hash
        if ($usuario && password_verify($password, $usuario['password_hash'])) 
        {
            return $usuario;
        }
        return false;
    }
}