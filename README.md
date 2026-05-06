# CRUD de Usuarios y Roles

Sistema de gestión de usuarios, roles y autenticación armado en PHP puro.

## Estructura del Proyecto

El proyecto separa la lógica del backend (MVC) de las vistas del frontend[cite: 2]:

### Backend
*   `/controllers`: Lógica de la aplicación y peticiones (`UsuarioController.php`, `Logout.php`)[cite: 2].
*   `/models`: Entidades y acceso a datos (`Usuario.php`, `Rol.php`)[cite: 2].
*   `/includes`: Configuración y conexión a la base de datos (`config.php`, `db.php`)[cite: 2].

### Frontend (Vistas)
*   **Archivos en la raíz:**
    *   `index.php`: Pantalla de inicio / Login[cite: 2].
    *   `registro.php`: Formulario para alta de usuarios[cite: 2].
*   **Carpeta `/pages/roles/`:** Vistas del sistema una vez autenticado.
    *   `dashboard.php`: Panel principal de gestión[cite: 2].
    *   `editar.php`: Interfaz para modificar la información[cite: 2].

## Instalación y Uso
1. Clonar el repositorio en el directorio de tu servidor web local.
2. Importar el archivo `gestion_usuarios.sql` en tu motor de base de datos para crear las tablas[cite: 2].
3. Actualizar las credenciales de conexión en `/includes/db.php`[cite: 2].
