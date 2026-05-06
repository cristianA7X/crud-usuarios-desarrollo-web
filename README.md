# CRUD de Usuarios y Roles

Sistema de gestión de usuarios, roles y autenticación armado en PHP puro.

## Estructura del Proyecto

El proyecto separa la lógica del backend (MVC) de las vistas del frontend:

### Backend
*   `/controllers`: Lógica de la aplicación y peticiones (`UsuarioController.php`, `Logout.php`).
*   `/models`: Entidades y acceso a datos (`Usuario.php`, `Rol.php`).
*   `/includes`: Configuración y conexión a la base de datos (`config.php`, `db.php`).

### Frontend (Vistas)
*   **Archivos en la raíz:**
    *   `index.php`: Pantalla de inicio / Login.
    *   `registro.php`: Formulario para alta de usuarios.
*   **Carpeta `/pages/roles/`:** Vistas del sistema una vez autenticado.
    *   `dashboard.php`: Panel principal de gestión.
    *   `editar.php`: Interfaz para modificar la información.

## Instalación y Uso
1. Clonar el repositorio en el directorio de tu servidor web local.
2. Importar el archivo `gestion_usuarios.sql` en tu motor de base de datos para crear las tablas.
3. Actualizar las credenciales de conexión en `/includes/db.php`.
