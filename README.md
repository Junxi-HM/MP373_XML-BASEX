# Sistema de Gestión de Eventos con BaseX

## Descripción General
Este repositorio contiene un sistema de gestión de eventos basado en PHP que utiliza la base de datos XML BaseX para almacenar y gestionar datos de eventos. El sistema permite a los usuarios crear, leer, actualizar y eliminar (CRUD) eventos, así como gestionar una base de datos separada para resultados económicos. La aplicación utiliza la biblioteca PHP BaseXClient para interactuar con el servidor BaseX.

## Funcionalidades
- **Crear Eventos**: Añadir nuevos eventos con un nombre, fecha y descripción.
- **Leer Eventos**: Ver una lista de todos los eventos o filtrar por un ID de evento específico.
- **Actualizar Eventos**: Editar los detalles de un evento existente por ID.
- **Eliminar Eventos**: Eliminar un evento de la base de datos por ID.
- **Gestión de Base de Datos**: Crear o eliminar la base de datos `resultadoseconomicos`.
- **Entrada Basada en Formularios**: Un formulario HTML fácil de usar para añadir nuevos eventos.
- **Manejo de Errores**: Gestión robusta de errores para operaciones de base de datos y entradas inválidas.

## Archivos en el Repositorio
- **`filtrar.php`**: Recupera y muestra un evento específico por ID desde la base de datos `eventos`.
- **`load.php`**: Carga la biblioteca PHP BaseXClient para su uso en la aplicación.
- **`resultadoseconomicos.php`**: Gestiona la creación y eliminación de la base de datos `resultadoseconomicos`.
- **`ver_eventos.php`**: Muestra una tabla con todos los eventos en la base de datos `eventos` con un botón para refrescar.
- **`insertar.php`**: Inserta un nuevo evento en la base de datos `eventos` usando datos de un formulario.
- **`lectura.php`**: Lee y muestra todos los eventos en formato de lista.
- **`eventos.php`**: Recupera y muestra todos los eventos en formato XML sin procesar.
- **`formulario_evento.php`**: Proporciona un formulario HTML para añadir nuevos eventos.
- **`borrar.php`**: Elimina un evento por ID de la base de datos `eventos`.
- **`EditarEvento.php`**: Permite editar un evento existente por ID, con un formulario precargado con los datos actuales.

## Requisitos
- PHP 7.4 o superior
- Servidor BaseX ejecutándose en `localhost:1984` con credenciales de administrador (`admin:admin`)
- Biblioteca PHP BaseXClient (incluida mediante `load.php`)

## Instrucciones de Configuración
1. Asegúrate de que el servidor BaseX esté ejecutándose y sea accesible.
2. Coloca los archivos en la raíz del documento de tu servidor web.
3. Configura los detalles de conexión de BaseX en los archivos PHP si es necesario (host, puerto, credenciales).
4. Accede a la aplicación a través de un navegador web, comenzando con `ver_eventos.php` o `formulario_evento.php`.

## Uso
- Navega a `formulario_evento.php` para añadir un nuevo evento.
- Usa `ver_eventos.php` para ver todos los eventos en una tabla.
- Accede a `filtrar.php?id=X` para ver un evento específico por ID.
- Usa `EditarEvento.php?id=X` para editar un evento.
- Envía una solicitud POST a `borrar.php` con un ID de evento para eliminarlo.
- Usa `resultadoseconomicos.php` para crear o eliminar la base de datos `resultadoseconomicos`.

## Notas
- Asegúrate de sanitizar adecuadamente las entradas para prevenir ataques XSS o de inyección (ya implementado usando `htmlspecialchars`).
- El archivo `eventos.html` referenciado en algunos scripts no está proporcionado en el repositorio y debe crearse si es necesario.
- El archivo `insertar_Evento.php` referenciado en `formulario_evento.php` parece ser un error tipográfico y debería apuntar a `insertar.php`.

## Licencia
Este proyecto está licenciado bajo la Licencia BSD, según la biblioteca BaseXClient.
