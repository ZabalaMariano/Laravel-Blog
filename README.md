## Proyecto
Uso de Laravel como Full Stack Framework para la creación de un Blog

## Instalación
PHP version 8.2.1
Composer version 2.5.1
MySQL version 8.0.31

## Ejecución
- crear .env a partir de .env.example:
    - Ejecutar "php artisan key:generate"
    - Completar campos DB, MAIL y PUSHER con datos personales
- php artisan schedule:work
- php artisan queue:work
- npm run dev
- php artisan serve

## Conceptos explorados
- Registro y login de usuario
- Almacenamiento de imágenes
- Blade Template Engine
- Form Validation
- Gates & Policies
- Relationships & Accessors en modelos
- Envío de emails automatizado con Schedule & Jobs/Queues
- Autenticación de usuarios con cookies en web browser environment
- Autenticación de usuarios con tokens en mobile (Laravel Sanctum)
- Broadcast de mensajes con Events y Pusher
- Cache en Cliente y Servidor
- Vite para bundle js y css
- Laravel Scout para búsqueda de texto sobre modelos

## Cambios futuros
- Reemplazar MailTrap con SendGrid
- Reemplazar Pusher con laravel-websockets
