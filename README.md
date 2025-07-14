# Backend Tejelanas Vivi

API backend en PHP nativo para el emprendimiento Tejelanas Vivi, que ofrece insumos para tejido y talleres de crochet. La API soporta operaciones CRUD y está documentada con Swagger para facilitar pruebas y consumo. Proyecto para evaluación de desarrollo backend.

## Descripción

Este proyecto proporciona la lógica backend para gestionar datos del emprendimiento Tejelanas Vivi ubicado en Zapallar, Chile. Incluye una API REST CRUD para productos, talleres y más, documentada con Swagger (OpenAPI) para facilitar su uso y pruebas.

## Estructura del proyecto

```
/api-tejelanas/
│
├── /api/
│   └── /tejelanas/
│       ├── /swagger-ui/        # Interfaz Swagger UI para testeo de endpoints
│       ├── .htaccess           # Configuraciones del servidor (URL rewrite, etc.)
│       ├── index.php           # Punto de entrada y enrutado de la API
│       ├── swagger.yaml        # Archivo de especificación Swagger de la API
│       ├── docs.php            # Redirige a Swagger UI cargando swagger.yaml
│       └── /v1/                # Versión 1 de la API
│           ├── /Config/        # Configuración de base de datos
│           ├── /Models/        # Modelos PHP que representan las entidades
│           ├── /Controller/    # Controladores para las operaciones CRUD
│           └── /Docs/          # Documentación adicional
│               └── ejemplo_db.txt  # Ejemplo básico de llenado de base de datos
```

## Acceso a la documentación

Para acceder a la interfaz Swagger UI y probar la API, abre en tu navegador:

```
http://localhost/api-tejelanas/api/tejelanas/docs.php
```

Desde ahí podrás enviar solicitudes a los endpoints CRUD, ver ejemplos y respuestas.

## Uso

- Este proyecto es solo backend, no incluye vistas ni frontend.
- La API se prueba usando Swagger UI o herramientas como Postman.
- Asegúrate de tener PHP configurado con soporte para `.htaccess` y URL rewriting.
- Ejecuta el servidor en la raíz del proyecto para que el enrutado funcione correctamente.

## Requisitos

- PHP 8.0 o superior
- Servidor web compatible con `.htaccess` (Apache recomendado)
- Navegador para Swagger UI o cliente HTTP como Postman

## Cómo iniciar

1. Clona este repositorio:
   ```bash
   git clone https://github.com/tu_usuario/backend-tejelanas-vivi.git
   ```

2. Configura tu servidor PHP (por ejemplo, XAMPP, WAMP, o PHP built-in server).

3. Accede a la documentación Swagger para probar la API:
   ```
   http://localhost/api-tejelanas/api/tejelanas/docs.php
   ```

4. Utiliza Swagger UI o Postman para probar las operaciones CRUD definidas.

## Arquitectura del Sistema

### Enrutado Principal (index.php)

El archivo `index.php` actúa como el punto de entrada principal de la API y maneja:

- **Configuración CORS**: Permite solicitudes desde cualquier origen y métodos HTTP estándar
- **Autenticación**: Valida el token Bearer 'ipss' en el header Authorization
- **Enrutado**: Procesa las rutas usando `PATH_INFO` para identificar recursos e IDs
- **Delegación**: Redirige las peticiones a los controladores correspondientes

**Estructura de rutas soportadas:**
- `/producto` - Gestión de productos
- `/servicio` - Gestión de servicios/talleres
- `/producto/{id}` - Operaciones sobre producto específico
- `/servicio/{id}` - Operaciones sobre servicio específico

### Controladores

Los controladores actúan como intermediarios entre las rutas y los modelos:

**productosController.php**
- `getallProductos()`: Obtiene todos los productos activos
- `postProducto()`: Crea un nuevo producto
- `putProducto()`: Actualiza completamente un producto
- `patchProducto()`: Actualiza solo el stock
- `deleteProducto()`: Elimina lógicamente un producto

**serviciosController.php**
- `getServicios()`: Obtiene todos los servicios activos
- `postServicio()`: Crea un nuevo servicio/taller
- `putServicio()`: Actualiza completamente un servicio
- `patchServicio()`: Actualiza solo los cupos disponibles
- `deleteServicio()`: Elimina lógicamente un servicio

### Modelos

Los modelos manejan la interacción directa con la base de datos:

**ProductosModel.php**
- Extiende de la clase `Conexion` para acceso a BD
- Implementa operaciones CRUD con consultas preparadas
- Maneja eliminación lógica (campo `estado`)
- Utiliza parámetros bind para prevenir inyección SQL

**ServiciosModel.php**
- Gestiona la tabla `servicios` con campos: título, descripción, fecha, ubicación, cupos
- Implementa el patrón de eliminación lógica
- Utiliza transacciones para garantizar consistencia de datos

### Características Técnicas

- **Eliminación Lógica**: Los registros no se eliminan físicamente, solo se marca `estado = 0`
- **Consultas Preparadas**: Todas las consultas usan parámetros bind para seguridad
- **Gestión de Conexiones**: Cierre automático de conexiones en bloques `finally`
- **Manejo de Errores**: Try-catch en todas las operaciones de BD
- **Códigos HTTP**: Respuestas apropiadas según el resultado de la operación

## Contacto

Para consultas o colaboraciones, puedes contactarme a través de GitHub.
