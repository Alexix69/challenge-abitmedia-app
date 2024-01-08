# challenge_abitmedia_app

Full Stack Developer Challenge

## Requisitos del Sistema

-   **PHP:** Versión 7.4 o superior.
-   **Composer:** Herramienta de gestión de dependencias para PHP. [Instalación de Composer](https://getcomposer.org/download/).
-   **Base de Datos:** MySQL.
-   **Node.js y NPM**.
-   **Servidor Web:** Apache, Nginx u otro servidor compatible con PHP.

## Configuración del Entorno

1. Clona el repositorio: `git clone https://github.com/Alexix69/challenge-abitmedia-app.git`.
2. Navega al directorio del proyecto.
3. Copia el archivo `.env.example` a `.env`.
4. Configura las variables de entorno en el archivo `.env`, especialmente la conexión a la base de datos **challenge_abitmedia_app** y el usuario **root**.
5. Ejecuta `composer install` para instalar las dependencias de PHP.
6. Ejecuta `php artisan key:generate` para generar la clave de la aplicación.
7. Ejecuta `php artisan migrate` para migrar la base de datos.
8. Ejecuta `php artisan db:seed` para insertar valores por defecto (solo actua en tabla `operating_systems`).

## Ejecutar el Proyecto

Ejecuta el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

## Documentación de la API

Para realizar pruebas del API, puedes importar el archivo de **Postman** proporcionado en la carpeta `postman` dentro del proyecto.
