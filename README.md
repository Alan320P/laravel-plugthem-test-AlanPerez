# Laravel Plugthem Test

## Descripción
Proyecto de prueba que implementa encuestas, respuestas, reportes y autenticación usando Laravel, Redis Cache, y Swagger para documentación.

## Recursos necesarios
PHP, Laravel 12, SQLite y Composer

## Instalación
- Pasos:
   ```bash
   Clonar el repositorio: git clone https://github.com/Alan320P/laravel-plugthem-test-AlanPerez.git
   Ubicarse en la carpeta del proyecto: laravel-plugthem-test-AlanPerez
   Instalar dependecias con: composer install
   Migrar y sembrar la base de datos: php artisan migrate --seed
   Ejecutar el servidor: php artisan serve

## EndPoints

- Auth
POST /api/register
POST /api/login
POST /api/logout
GET /api/me

- Surveys
GET /api/surveys
POST /api/surveys
GET /api/surveys/{id}
PUT /api/surveys/{id}
DELETE /api/surveys/{id}
DELETE /api/surveys/{survey}/questions/{question}

- Answers
POST /api/questions/{question_id}/answers
GET /api/questions/{question_id}/answers
GET /api/surveys/{survey_id}/answers
GET /api/reports/survey/{survey_id}

## Comando Artisan
   ```bash
   php artisan survey:deactivate-inactive 
   


