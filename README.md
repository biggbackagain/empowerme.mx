# 🚀 EmpowerMe - Plataforma de Eventos y Bienestar

**EmpowerMe** es una aplicación web desarrollada con **Laravel** diseñada para la gestión y promoción de eventos deportivos, de salud y bienestar (Yoga, Running, Nutrición). La plataforma permite a los administradores gestionar la cartelera y a los usuarios inscribirse y llevar un control de sus actividades.




## 📋 Características Principales

### 👤 Para Usuarios (Comunidad)
* **Registro y Autenticación:** Sistema seguro de login y registro.
* **Catálogo de Eventos:** Visualización de eventos disponibles con detalles (fecha, hora, cupo, ubicación).
* **Inscripción en un Clic:** Validación de cupos y registro instantáneo.
* **Dashboard Personal:** Panel "Mis Eventos" para ver próximas actividades inscritas.
* **Alertas Visuales:** Feedback inmediato al inscribirse (éxito/error).

### 🛠️ Para Administradores (Backoffice)
* **Gestión de Eventos (CRUD):** Crear, editar y eliminar eventos.
* **Control de Aforo:** Visualización de cupos llenos/disponibles en tiempo real.
* **Gestión de Imágenes:** Carga de URLs para portadas de eventos.
* **Recomendaciones:** Campo especial para agregar notas a los participantes (ej. "Llevar toalla").

## 💻 Stack Tecnológico

* **Backend:** PHP 8.3, Laravel 11 (Framework).
* **Frontend:** Blade Templates, Tailwind CSS (Estilos modernos y responsivos).
* **Base de Datos:** MySQL.
* **Servidor Local:** Laragon / Artisan.

## ⚙️ Instalación y Configuración

Sigue estos pasos para correr el proyecto en tu entorno local:

1.  **Clonar el repositorio:**
    ```bash
    git clone [https://github.com/TU_USUARIO/empowerme.git](https://github.com/TU_USUARIO/empowerme.git)
    cd empowerme
    ```

2.  **Instalar dependencias de PHP y Node:**
    ```bash
    composer install
    npm install
    ```

3.  **Configurar el entorno:**
    * Duplica el archivo `.env.example` y renómbralo a `.env`.
    * Configura tus credenciales de base de datos en el archivo `.env`:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=empowerme
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generar llave de aplicación y migraciones:**
    ```bash
    php artisan key:generate
    php artisan migrate
    ```

5.  **Crear enlace simbólico (para imágenes):**
    ```bash
    php artisan storage:link
    ```

6.  **Correr el servidor:**
    * En una terminal: `php artisan serve`
    * En otra terminal (para estilos): `npm run dev`

## 🔐 Crear un Administrador

Por defecto, los usuarios nuevos no tienen permisos de administración. Para otorgar permisos de admin a un usuario existente, usa **Laravel Tinker**:

```bash
php artisan tinker
