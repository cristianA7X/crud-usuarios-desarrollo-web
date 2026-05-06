# 📘 Documentación Técnica de Integración - Backend de Usuarios

Esta guía detalla la arquitectura del backend, los puntos de acceso (endpoints) y los procedimientos necesarios para conectar la interfaz de usuario con la lógica de negocio y la base de datos.

---

## 1. Estructura de Archivos del Sistema
El backend se organiza bajo una arquitectura de separación de responsabilidades:

- **`/includes`**: Configuraciones globales y conexión a base de datos.
- **`/models`**: Clases de acceso a datos (Queries SQL).
- **`/controllers`**: Procesadores de peticiones y lógica de control.

---

## 2. Configuración Global
El archivo `includes/config.php` centraliza las constantes del sistema. 
- **`BASE_URL`**: Se debe utilizar para todas las rutas absolutas en enlaces y redirecciones.
- **Sesiones**: La sesión se inicia automáticamente. Se han configurado cookies seguras (`HttpOnly`, `SameSite=Strict`) para proteger la identidad del usuario.

---

## 3. Integración de Formularios (POST)
Todas las solicitudes de envío de datos deben dirigirse a `controllers/UsuarioController.php` utilizando el método **POST**.

### Requisito: Campo de Acción
Cada formulario debe incluir un campo oculto que indique la operación a realizar:
`<input type="hidden" name="accion" value="NOMBRE_ACCION">`.

### Acciones Disponibles y Parámetros:

| Acción (`accion`) | Campos Requeridos (`name`) | Resultado |
| :--- | :--- | :--- |
| **`crear`** | `nombre`, `email`, `password`, `dni`, `rol_id` | Registra un usuario y genera hash de contraseña. |
| **`actualizar`** | `id`, `nombre`, `email`, `dni`, `rol_id` | Modifica los datos de la instancia seleccionada. |
| **`eliminar`** | `id` | Borrado lógico (establece `activo = 0`). |
| **`login`** | `email`, `password` | Valida credenciales y genera variables de sesión. |

---

## 4. Visualización de Datos (Lectura)
Para mostrar información en las tablas y selectores, el frontend debe instanciar los modelos correspondientes:

### Listado de Usuarios (Tablas)
Se debe utilizar el método `listar()` de la clase `Usuario`. Este método realiza un `INNER JOIN` con la tabla `rol` para obtener el nombre del rol asociado.
- **Retorno**: Array asociativo con `id`, `nombre`, `email`, `dni`, `activo` y `rol_nombre`.

### Selección de Roles (Selects)
Se debe utilizar el método `getRoles()` de la clase `Rol` para obtener los roles activos en el sistema.
- **Campos disponibles**: `id`, `nombre`, `descripcion`.

---

## 5. Gestión de Notificaciones y Feedback
El controlador utiliza la sesión para enviar mensajes de éxito o error tras las operaciones.

- **`$_SESSION['mensaje']`**: Texto con la confirmación de la operación (ej: "Usuario creado correctamente").
- **`$_SESSION['error']`**: Texto descriptivo cuando el login falla (ej: "Email o contraseña incorrectos").

---

## 6. Seguridad y Procesamiento
- **Sanitización**: El controlador aplica automáticamente `trim()` a todas las entradas para eliminar espacios accidentales.
- **Inyección SQL**: El backend utiliza sentencias preparadas (PDO) en todas las consultas para garantizar la seguridad de los datos.
- **Hasheo**: Las contraseñas se almacenan mediante el algoritmo `PASSWORD_DEFAULT` y se validan con `password_verify`.
- **Cierre de Sesión**: Para desconectar al usuario, se debe redirigir la aplicación al archivo `controllers/Logout.php`.
