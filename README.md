# Gestión de Bienes (Assets) — API REST

Proyecto de aprendizaje para entender el flujo backend: migraciones, modelos, controladores, servicios, validación, y consumo desde el frontend.

Basado en los patrones del proyecto **apitaxo7** (gestión de activos con Laravel + Sanctum).

---

## Tabla de contenido

- [Modelado de datos](#modelado-de-datos)
- [Arquitectura backend](#arquitectura-backend)
- [API endpoints](#api-endpoints)
- [Plan de desarrollo](#plan-de-desarrollo)
- [Consumo frontend (Angular)](#consumo-frontend-angular)

---

## Modelado de datos

### Diagrama conceptual

```
Categoria ──┐
             ├─── Bien ──── Responsable
Ubicacion ──┘              
```

### Entidades

**Bien** — el activo/bien principal
| Columna | Tipo | Descripción |
|---|---|---|
| id | bigint (PK) | |
| etiqueta | string(20), unique | Código único auto-generado (B00001, B00002...) |
| nombre | string(255) | Nombre del bien |
| descripcion | text, nullable | |
| marca | string(100), nullable | |
| modelo | string(100), nullable | |
| serie | string(100), nullable | |
| estado | enum: activo, en_reparacion, dado_de_baja | |
| categoria_id | bigint (FK → categorias) | |
| ubicacion_id | bigint (FK → ubicaciones) | |
| responsable_id | bigint (FK → responsables) | |
| deleted_at | timestamp (soft delete) | |
| created_at / updated_at | timestamps | |

**Categoria** — clasificación del bien
| Columna | Tipo |
|---|---|
| id | bigint (PK) |
| nombre | string(150) |
| descripcion | text, nullable |
| created_at / updated_at | timestamps |

**Ubicacion** — lugar físico donde está el bien
| Columna | Tipo |
|---|---|
| id | bigint (PK) |
| nombre | string(200) |
| direccion | string(255), nullable |
| created_at / updated_at | timestamps |

**Responsable** — persona a cargo del bien
| Columna | Tipo |
|---|---|
| id | bigint (PK) |
| nombre | string(200) |
| email | string(255), nullable |
| telefono | string(50), nullable |
| created_at / updated_at | timestamps |

### Relaciones Eloquent

```
Bien:
  - belongsTo(Categoria)
  - belongsTo(Ubicacion)
  - belongsTo(Responsable)

Categoria:
  - hasMany(Bien)

Ubicacion:
  - hasMany(Bien)

Responsable:
  - hasMany(Bien)
```

---

## Arquitectura backend

### Estructura de directorios

```
routes/
  api.php                         ← entrypoint, require archivos por dominio
  api/v1/
    bienes.php                    ← rutas de bienes
    catalogos.php                 ← rutas de categorias, ubicaciones, responsables

app/Models/
  Bien.php
  Categoria.php
  Ubicacion.php
  Responsable.php

app/Http/Controllers/Api/V1/
  BienController.php
  CategoriaController.php
  UbicacionController.php
  ResponsableController.php

app/Http/Requests/                ← validación separada del controller
  StoreBienRequest.php
  UpdateBienRequest.php
  StoreCategoriaRequest.php
  UpdateCategoriaRequest.php
  StoreUbicacionRequest.php
  UpdateUbicacionRequest.php
  StoreResponsableRequest.php
  UpdateResponsableRequest.php

app/Http/Resources/               ← transformación de respuestas JSON
  BienResource.php
  CategoriaResource.php
  UbicacionResource.php
  ResponsableResource.php

app/Services/
  BienService.php                 ← lógica de negocio (ej: generar etiqueta)

database/migrations/
  xxxx_create_categorias_table.php
  xxxx_create_ubicaciones_table.php
  xxxx_create_responsables_table.php
  xxxx_create_bienes_table.php

database/factories/
  BienFactory.php
  CategoriaFactory.php
  UbicacionFactory.php
  ResponsableFactory.php

database/seeders/
  DatabaseSeeder.php
  CategoriaSeeder.php
  UbicacionSeeder.php
  ResponsableSeeder.php
  BienSeeder.php

tests/Feature/
  BienTest.php
  CategoriaTest.php
  UbicacionTest.php
  ResponsableTest.php
```

### Flujo de una request

```
POST /api/v1/bienes
       │
       ▼
Laragon/Apache → public/index.php
       │
       ▼
bootstrap/app.php
       │
       ▼
routes/api.php → require api/v1/bienes.php
       │
       ▼
BienController@store
       │
       ▼
StoreBienRequest (validación: nombre requerido, categoria_id existe...)
       │
       ▼
BienService::crear($data)
  ├── Generar etiqueta (B00001, B00002...)
  ├── Bien::create([...])
  └── return $bien
       │
       ▼
BienResource (formatea: incluye categoria, ubicacion, responsable)
       │
       ▼
JSON Response 201
```

### Capas y responsabilidades

| Capa | Archivo | Rol |
|---|---|---|
| Route | `routes/api/v1/*.php` | Define URL + método + controller |
| Controller | `app/Http/Controllers/Api/V1/*.php` | Recibe request, delega al service, retorna response |
| Form Request | `app/Http/Requests/*.php` | Valida datos antes de llegar al controller |
| Service | `app/Services/BienService.php` | Lógica de negocio (crear, actualizar, generar etiqueta, filtros) |
| Model | `app/Models/*.php` | Define tabla, relaciones, casts |
| Resource | `app/Http/Resources/*.php` | Transforma modelo a JSON (qué campos incluir, excluir, formatear) |
| Migration | `database/migrations/*.php` | Define esquema de DB |
| Factory | `database/factories/*.php` | Genera datos de prueba |
| Seeder | `database/seeders/*.php` | Pobla la DB con datos iniciales |
| Test | `tests/Feature/*.php` | Prueba cada endpoint |

---

## API endpoints

### Catálogos

#### Categorias

| Método | URL | Descripción |
|---|---|---|
| GET | `/api/v1/categorias` | Listar todas |
| POST | `/api/v1/categorias` | Crear |
| GET | `/api/v1/categorias/{id}` | Mostrar una |
| PUT | `/api/v1/categorias/{id}` | Actualizar |
| DELETE | `/api/v1/categorias/{id}` | Eliminar |

#### Ubicaciones

| Método | URL | Descripción |
|---|---|---|
| GET | `/api/v1/ubicaciones` | Listar todas |
| POST | `/api/v1/ubicaciones` | Crear |
| GET | `/api/v1/ubicaciones/{id}` | Mostrar una |
| PUT | `/api/v1/ubicaciones/{id}` | Actualizar |
| DELETE | `/api/v1/ubicaciones/{id}` | Eliminar |

#### Responsables

| Método | URL | Descripción |
|---|---|---|
| GET | `/api/v1/responsables` | Listar todas |
| POST | `/api/v1/responsables` | Crear |
| GET | `/api/v1/responsables/{id}` | Mostrar una |
| PUT | `/api/v1/responsables/{id}` | Actualizar |
| DELETE | `/api/v1/responsables/{id}` | Eliminar |

### Bienes (core)

| Método | URL | Descripción |
|---|---|---|
| GET | `/api/v1/bienes` | Listar (paginado, filtros) |
| POST | `/api/v1/bienes` | Crear (genera etiqueta auto) |
| GET | `/api/v1/bienes/{id}` | Mostrar uno con relaciones |
| PUT | `/api/v1/bienes/{id}` | Actualizar |
| DELETE | `/api/v1/bienes/{id}` | Soft delete |

#### Filtros disponibles en GET /api/v1/bienes

| Query param | Ejemplo | Descripción |
|---|---|---|
| `?estado` | `?estado=activo` | Filtrar por estado |
| `?categoria_id` | `?categoria_id=2` | Filtrar por categoría |
| `?ubicacion_id` | `?ubicacion_id=1` | Filtrar por ubicación |
| `?responsable_id` | `?responsable_id=3` | Filtrar por responsable |
| `?search` | `?search=martillo` | Búsqueda por nombre, marca, modelo, serie |
| `?per_page` | `?per_page=20` | Items por página (default 15) |
| `?page` | `?page=2` | Número de página |

### Ejemplos de requests

```bash
# Crear categoría
curl -X POST http://primero.code/api/v1/categorias \
  -H "Content-Type: application/json" \
  -d '{"nombre": "Herramientas", "descripcion": "Herramientas manuales"}'

# Crear bien
curl -X POST http://primero.code/api/v1/bienes \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Martillo de goma",
    "marca": "Stanley",
    "modelo": "MG-100",
    "serie": "ST-001",
    "estado": "activo",
    "categoria_id": 1,
    "ubicacion_id": 2,
    "responsable_id": 1
  }'

# Listar bienes con filtros
curl "http://primero.code/api/v1/bienes?estado=activo&search=martillo&per_page=10"

# Ver bien con relaciones
curl http://primero.code/api/v1/bienes/1
```

### Formato de respuesta

```json
{
  "data": {
    "id": 1,
    "etiqueta": "B00001",
    "nombre": "Martillo de goma",
    "descripcion": null,
    "marca": "Stanley",
    "modelo": "MG-100",
    "serie": "ST-001",
    "estado": "activo",
    "categoria": {
      "id": 1,
      "nombre": "Herramientas"
    },
    "ubicacion": {
      "id": 2,
      "nombre": "Bodega Norte"
    },
    "responsable": {
      "id": 1,
      "nombre": "Juan Pérez"
    },
    "created_at": "2026-06-11T12:00:00Z",
    "updated_at": "2026-06-11T12:00:00Z"
  }
}
```

Listado paginado:

```json
{
  "data": [ ... ],
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 72
  }
}
```

---

## Plan de desarrollo

### Fase 1 — Setup inicial

- [x] Laravel 13 instalado
- [x] Laragon configurado (http://primero.code)
- [x] MySQL corriendo
- [ ] Correr `php artisan migrate` para tablas default (users, cache, jobs, sessions)
- [ ] Crear DB `primero` en MySQL

### Fase 2 — Migraciones y modelos

- [ ] Migración `create_categorias_table`
- [ ] Migración `create_ubicaciones_table`
- [ ] Migración `create_responsables_table`
- [ ] Migración `create_bienes_table` (con FK a las 3 tablas + soft deletes)
- [ ] Modelo `Categoria` con `$fillable`, `$casts`, relación `hasMany(Bien)`
- [ ] Modelo `Ubicacion` con `$fillable`, relación `hasMany(Bien)`
- [ ] Modelo `Responsable` con `$fillable`, relación `hasMany(Bien)`
- [ ] Modelo `Bien` con `$fillable`, `$casts` (estado enum), `SoftDeletes`, relaciones `belongsTo` a las 3 tablas

### Fase 3 — Seeders y factories

- [ ] `CategoriaFactory`, `UbicacionFactory`, `ResponsableFactory`, `BienFactory`
- [ ] `CategoriaSeeder` (5 categorías)
- [ ] `UbicacionSeeder` (5 ubicaciones)
- [ ] `ResponsableSeeder` (5 responsables)
- [ ] `BienSeeder` (20 bienes de prueba)
- [ ] Ejecutar `php artisan db:seed` y verificar datos

### Fase 4 — API de catálogos

- [ ] Routes: `routes/api.php` → `require api/v1/catalogos.php`
- [ ] Crear `CategoriaController` con CRUD completo + `CategoriaResource`
- [ ] Crear `UbicacionController` con CRUD completo + `UbicacionResource`
- [ ] Crear `ResponsableController` con CRUD completo + `ResponsableResource`
- [ ] Form Requests para store/update de cada uno
- [ ] Probar con curl/Postman

### Fase 5 — API de bienes (core)

- [ ] Routes: `routes/api.php` → `require api/v1/bienes.php`
- [ ] Crear `BienService`:
  - Método `crear($data)`: genera etiqueta secuencial (`B00001`), crea bien
  - Método `actualizar($bien, $data)`: actualiza campos
  - Método `listar($filtros)`: query con filtros + paginación + búsqueda
  - Método `obtener($id)`: bien con relaciones
  - Método `eliminar($bien)`: soft delete
- [ ] Crear `BienController` inyectando `BienService`
- [ ] `StoreBienRequest` con reglas de validación
- [ ] `UpdateBienRequest` con reglas
- [ ] `BienResource` que incluye categoria, ubicacion, responsable anidados
- [ ] Probar todos los endpoints

### Fase 6 — Tests de feature

- [ ] `BienTest`: probar CRUD, filtros, validación, soft delete
- [ ] `CategoriaTest`, `UbicacionTest`, `ResponsableTest`: probar CRUD

### Fase 7 — Consumo frontend (Angular)

Ver sección detallada abajo.

---

## Consumo frontend (Angular)

### Setup

```bash
ng new gestion-bienes --standalone
cd gestion-bienes
ng generate service services/bien
ng generate service services/categoria
ng generate service services/ubicacion
ng generate service services/responsable
```

### Servicios Angular

Cada servicio consume la API con `HttpClient`:

```typescript
// services/bien.service.ts
export class BienService {
  private apiUrl = 'http://primero.code/api/v1/bienes';

  constructor(private http: HttpClient) {}

  listar(params?: any): Observable<PaginatedResponse<Bien>> {
    return this.http.get<PaginatedResponse<Bien>>(this.apiUrl, { params });
  }

  crear(data: CreateBienDto): Observable<Bien> {
    return this.http.post<Bien>(this.apiUrl, data);
  }

  obtener(id: number): Observable<Bien> {
    return this.http.get<Bien>(`${this.apiUrl}/${id}`);
  }

  actualizar(id: number, data: UpdateBienDto): Observable<Bien> {
    return this.http.put<Bien>(`${this.apiUrl}/${id}`, data);
  }

  eliminar(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiUrl}/${id}`);
  }
}
```

### Modelos TypeScript

```typescript
// models/bien.model.ts
export interface Bien {
  id: number;
  etiqueta: string;
  nombre: string;
  descripcion?: string;
  marca?: string;
  modelo?: string;
  serie?: string;
  estado: 'activo' | 'en_reparacion' | 'dado_de_baja';
  categoria: { id: number; nombre: string };
  ubicacion: { id: number; nombre: string };
  responsable: { id: number; nombre: string };
  created_at: string;
  updated_at: string;
}

export interface PaginatedResponse<T> {
  data: T[];
  meta: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
}
```

### Componentes sugeridos

```
src/app/
  components/
    layout/            ← header, sidebar, toolbar
    bienes/
      bien-lista/      ← tabla con filtros + paginación
      bien-form/       ← formulario crear/editar (reactive forms)
      bien-detalle/    ← vista de detalle
    catalogos/
      categoria-lista/  ← CRUD categorías
      ubicacion-lista/  ← CRUD ubicaciones
      responsable-lista/ ← CRUD responsables
```

### Flujo del frontend

```
BienLista
  │
  ├── ngOnInit() → BienService.listar(params)
  │     └── GET /api/v1/bienes?page=1&per_page=15
  │
  ├── onFiltrar(filtros) → BienService.listar(filtros)
  │     └── GET /api/v1/bienes?estado=activo&search=martillo
  │
  ├── onCrear() → router.navigate(['/bienes/nuevo'])
  │     └── BienForm → BienService.crear(data)
  │
  ├── onEditar(id) → router.navigate(['/bienes', id, 'editar'])
  │     └── BienForm (carga datos) → BienService.actualizar(id, data)
  │
  └── onEliminar(id) → confirm → BienService.eliminar(id)

CategoriaLista (similar)
  └── CategoriaService.listar() → GET /api/v1/categorias
```

---

## Comandos útiles

### Backend (Laravel)

```bash
# Crear migración
php artisan make:migration create_bienes_table

# Crear modelo con migración, factory, seeder, controller, resource
php artisan make:model Bien -mfsc --resource

# Crear solo un service
# (no hay artisan command, se crea manualmente)

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders
php artisan db:seed

# Rollback última migración
php artisan migrate:rollback

# Ver rutas
php artisan route:list

# Ejecutar tests
php artisan test
# o un archivo específico:
php artisan test tests/Feature/BienTest.php

# Ver datos en Tinker
php artisan tinker
>>> App\Models\Bien::all();
>>> App\Models\Bien::with(['categoria', 'ubicacion', 'responsable'])->first();
```

### Frontend (Angular)

```bash
ng serve                    # dev server en localhost:4200
ng generate component       # crear componente
ng generate service         # crear servicio
ng build                    # build producción
```

---

## Referencias

- [apitaxo7](http://apitaxo7.test) — Proyecto real del cual se extrajeron los patrones
- Laravel 13 docs: https://laravel.com/docs
- Angular docs: https://angular.dev
