## 📚 Reportes App Back
Este es el backend de la aplicación ReportesTk, desarrollado en Laravel 10 con Sanctum para autenticación y Laravel WebSockets para actualizaciones en tiempo real.

## 🚀 Tecnologías utilizadas
- Laravel: Framework PHP para backend.
- PHP: Lenguaje de programación utilizado (versión recomendada: 8.2 o superior).
- MySQL: Gestor de bases de datos.
- Composer: Administrador de dependencias para PHP.

## 🛠️ Instalación
-- Clonar el repositorio
```sh
git clone https://github.com/hazielace/ReportsTkBack.git
cd ReportesTkBack
```
## 🚦 Ejecución del proyecto

Configurar el entorno, editar el archivo:
```sh
.env
```
Instalar dependencias
```sh
composer install
```
Migrar la base de datos y ejecutar seeder (antes crear la bd)
```sh
php artisan migrate
php artisan db:seed --class=UserSeeder
```
Iniciar servidor laravel
```sh
php artisan serve
```
Iniciar laravel webSockets
```sh
php artisan websockets:serve
```
Iniciar jobs en segundo plano
```sh
php artisan queue:work
```
