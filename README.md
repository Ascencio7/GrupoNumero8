# Sistema de gestión de clientes y pedidos

Aplicación web desarrollada con Laravel para administrar clientes y sus pedidos. Incluye autenticación, reportes en pantalla y descarga de reportes PDF.

## Funcionalidades

- Registro, consulta, edición y eliminación de clientes.
- Registro, consulta, edición y eliminación de pedidos asociados a clientes.
- Confirmación antes de eliminar registros y cerrar sesión.
- Inicio de sesión y registro de usuarios, con opción para mostrar u ocultar contraseñas.
- Reportes de clientes, pedidos y pedidos por cliente.
- Descarga de reportes en PDF con formato monocromático y horas en formato de 12 horas.

Al eliminar un cliente también se eliminan sus pedidos asociados.

## Requisitos

- PHP 8.3 o superior y Composer.
- Node.js y npm.
- Una base de datos compatible con la configuración de Laravel (SQLite o MySQL, según el archivo `.env`).
- `wkhtmltopdf` para generar PDF.

## Instalación

1. Instala las dependencias de PHP:

   ```bash
   composer install
   ```

2. Crea el archivo de entorno y genera la clave de la aplicación:

   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

   En PowerShell también puedes usar `Copy-Item .env.example .env`.

3. Configura en `.env` la conexión de base de datos y la zona horaria. Por ejemplo:

   ```dotenv
   APP_TIMEZONE=America/El_Salvador
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=parcial3
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Crea previamente la base de datos indicada. Si usas SQLite, configura `DB_CONNECTION=sqlite` y la ruta de la base de datos.

4. Ejecuta las migraciones:

   ```bash
   php artisan migrate
   ```

5. Instala y compila los recursos del frontend:

   ```bash
   npm install
   npm run build
   ```

## Configuración de PDF

Instala `wkhtmltopdf` en el equipo donde se ejecuta Laravel. La configuración está en `config/snappy.php`; en Windows, por defecto, apunta a:

```text
C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe
```

Si el ejecutable está en otra ubicación, define `WKHTML_PDF_BINARY` en `.env` con su ruta completa. La zona horaria utilizada en la fecha de generación de los reportes se define en `APP_TIMEZONE`.

## Iniciar el servidor

```bash
php artisan serve
```

Abre la dirección que indique Artisan, normalmente `http://127.0.0.1:8000`.

## Pruebas

```bash
php artisan test
```
