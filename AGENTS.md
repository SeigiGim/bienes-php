# AGENTS.md — Primero (Laravel 13 API de aprendizaje)

## Estado: Laravel 13 recién instalado, sin código personalizado

Proyecto de aprendizaje para construir un backend API real desde cero, con base de datos MySQL, endpoints JSON, consumido por app móvil.

## Proyecto de referencia

- **Referencia:** `C:\laragon\www\apitaxo7` — proyecto Laravel con arquitectura real API
- Estructura a replicar: **Controller → Service → Model**, API Resources, FormRequest, rutas modulares por dominio, Sanctum
- Se puede consultar libremente como ejemplo de código

## Comandos exactos

| Acción | Comando |
|---|---|
| Servidor dev | `php artisan serve` (Laragon: `http://primero.code`) |
| Servidor completo | `composer run dev` (server + queue + Vite) |
| Migrar | `php artisan migrate` |
| Sembrar | `php artisan db:seed` |
| Tests | `php artisan test` (SQLite in-memory) |
| Test específico | `php artisan test tests/Feature/ExampleTest.php` |
| Formatear | `./vendor/bin/pint` (PSR-12) |
| Ver rutas | `php artisan route:list` |
| Crear modelo completo | `php artisan make:model Modelo -mfsc --resource` |

## Convenios del proyecto

- `$fillable` en modelos (no `$guarded`)
- Validación en FormRequest separado (`app/Http/Requests/{Store,Update}*Request.php`)
- `bootstrap/app.php` retorna JSON para rutas `api/*`
- `.npmrc` → `ignore-scripts=true` (npm lifecycle scripts no corren)
- `.env` usa `QUEUE_CONNECTION=database`, `SESSION_DRIVER=database`, `CACHE_STORE=database`
- Tests sobrescriben a `sqlite:memory` + `array`/`sync` (configurado en `phpunit.xml`)
- API pública (sin Sanctum aún)
- Sin frontend — solo API JSON

## Testing

- Feature tests extienden `Tests\TestCase` (Laravel booteado)
- Usar `RefreshDatabase` trait cuando se requiera DB limpia
- `phpunit.xml` ya configurado para SQLite in-memory en testing
