# AGENTS.md — Primero

Laravel 13 API (learning project). English naming throughout.

## Architecture

`routes/api.php` → `require __DIR__ . '/api/v1/catalogues.php'` → `Route::apiResource()` → **Controller** (injects Service) → **Service** (business logic) → **Model** (Eloquent) → **API Resource** (JSON response) → **FormRequest** (validation).

## Commands

| Action | Command |
|---|---|
| Dev all (server+queue+vite) | `composer dev` |
| Format (PSR-12) | `./vendor/bin/pint` |
| Tests | `composer test` (runs config:clear + artisan test) |
| Single test | `php artisan test tests/Feature/CategoryTest.php` |
| Migrate | `php artisan migrate` |
| Seed | `php artisan db:seed` |
| Routes | `php artisan route:list` |
| Full model+ | `php artisan make:model ModelName -mfsc` |

## Conventions & gotchas

- **`$fillable`** in models (not `$guarded`)
- **Separate FormRequest** per store/update (`app/Http/Requests/{Store,Update}*Request.php`)
- Validation rules use **array syntax**: `['required', 'string', 'max:150']`
- API JSON auto-enabled for all `api/*` routes (`bootstrap/app.php:19`)
- **One Service per entity** (e.g. `CategoryService`, `LocationService`) with CRUD methods
- Tests: SQLite in-memory, `RefreshDatabase` trait, extend `Tests\TestCase`. **Only `CategoryTest` exists** — `LocationTest` missing
- `.npmrc` has `ignore-scripts=true` — npm lifecycle hooks don't run
- `.env`: `QUEUE_CONNECTION=database`, `SESSION_DRIVER=database`, `CACHE_STORE=database`
- **No Sanctum** — API is fully public
- **⚠️ Route casing bug**: `routes/api.php` requires `'api/v1/catalogues.php'` (lowercase) but actual dir is `api/V1/` (uppercase). Works on Windows, fails on Linux
- **README.md is aspirational** — describes "Bienes" (Assets) system in Spanish that doesn't exist yet. Actual code has only `Category` and `Location` in English
- **Business reference**: `docs/epica-inventario.html` — full epic with all 24 user stories. Agents MUST read this file before implementing features
