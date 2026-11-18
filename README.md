<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## 🚀 Instalación y Puesta en Marcha

Sigue estos pasos para clonar y configurar el proyecto localmente.

### 1. Variables de entorno

Copia el archivo de ejemplo y configura tus credenciales:

```bash
cp .env.example .env
```
---

### 2. Instalar dependencias de PHP (Composer)

**En Windows:** 
```bash
composer update --ignore-platform-reqs
```

**En Linux / macOS:**
```bash
composer update
```

---

### 3. Generar la clave de la aplicación

```bash
php artisan key:generate
```

---

### 4. Instalar y compilar dependencias de Frontend

```bash
npm install
npm run build
# o para desarrollo continuo:
npm run dev
```

---

### 5. Base de datos y datos de prueba

Ejecuta las migraciones y llena la base de datos con los datos iniciales y usuarios de prueba:

```bash
php artisan migrate --seed
# o individualmente:
php artisan migrate
php artisan db:seed --class=DatabaseSeeder
```

---

### 6. Procesamiento de Colas (Queues)

Para procesar conversiones de divisas y tareas en segundo plano:

**En Windows:**
```bash
php artisan queue:work
```

**En Linux / macOS:**
```bash
php artisan horizon
# o: php artisan queue:work
```

---

### 7. Tareas Programadas (Scheduler / Cron)

Para la actualización automática de precios en dólares según Banxico:

- **En desarrollo local:**
  ```bash
  php artisan schedule:work
  ```

- **En servidor de producción (Linux Crontab):**
  Agrega esta línea con `crontab -e`:
  ```bash
  * cd/* * * *var/www/oscar-conde-hernandez && php artisan schedule:run >> /dev/null 2>&1
  ```

---

## 👤 Credenciales de Acceso

| Rol | Correo Electrónico | Contraseña |
| :--- | :--- | :--- |
| **Administrador** | `admin@ecommerce.test` | `demo2089` |



