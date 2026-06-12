# Resumen de progreso vs épica de inventario

Referencia: `docs/epica-inventario.html` — 1 épica, 6 features, 24 historias de usuario.

---

## Leyenda

| Marca | Significado |
|---|---|
| ✅ | Completado (MVP) |
| ✅⚠️ | Completado pero faltan criterios de aceptación |
| 🔜 | En progreso (siguiente HDU) |
| ❌ | No iniciado |

---

## F-01 — Datos maestros (Alta prioridad)

**Significado de negocio**: Sin estos catálogos base no se puede registrar ningún bien. Son los ladrillos del sistema.

| HU | Descripción | Estado | Brecha técnica |
|---|---|---|---|
| HU-01-01 | Crear categoría | ✅⚠️ | Falta `unique` en name (hoy permite duplicados) |
| HU-01-02 | Listar categorías | ✅⚠️ | Falta ordenar por nombre ASC; falta `cantidad_bienes` (depende de Asset) |
| HU-01-03 | Crear ubicación | ✅⚠️ | Falta `unique` en name (hoy permite duplicados) |
| HU-01-04 | Listar ubicaciones | ✅⚠️ | Falta ordenar por nombre ASC; falta `cantidad_bienes` (depende de Asset) |
| **HU-01-05** | **Crear responsable** | **🔜** | **Contact CRUD — próxima HDU** |
| **HU-01-06** | **Listar responsables** | **🔜** | **Contact CRUD — próxima HDU** |

**A nivel de negocio**: Puedes clasificar bienes (categorías) y saber dónde están (ubicaciones), pero aún **no puedes asignar una persona responsable**. El inventario está mudo sobre quién tiene cada cosa.

---

## F-02 — Registro de bienes (Alta prioridad — core del sistema)

**Significado de negocio**: Es el corazón del sistema. Sin esto, no hay inventario digital — sólo catálogos vacíos.

| HU | Descripción | Estado | Dependencias |
|---|---|---|---|
| HU-02-01 | Crear bien con etiqueta auto-generada | ❌ | Necesita Category + Contact + Asset |
| HU-02-02 | Listar bienes con paginación | ❌ | Necesita Asset existente |
| HU-02-03 | Ver detalle de un bien | ❌ | Necesita Asset existente |
| HU-02-04 | Editar datos de un bien | ❌ | Necesita Asset existente |

**A nivel de negocio**: El sistema **no puede registrar activos físicos**. Sigues usando Excel. No existe el concepto de "Bien" en la base de datos. Ésta es la brecha más crítica del proyecto.

---

## F-03 — Estado y baja (Alta prioridad)

**Significado de negocio**: Controlar si un bien está operativo, en reparación o fue retirado. Evita dar por perdido algo que sólo está en taller.

| HU | Descripción | Estado | Dependencias |
|---|---|---|---|
| HU-03-01 | Cambiar estado del bien | ❌ | Necesita Asset |
| HU-03-02 | Dar de baja (soft delete) | ❌ | Necesita Asset |
| HU-03-03 | Listar bienes dados de baja | ❌ | Necesita Asset |

**A nivel de negocio**: No hay trazabilidad de estado. No puedes saber si un activo está activo, en reparación o fue dado de baja. Una laptop robada vs. una laptop en reparación se ven igual: "no aparece en el listado".

---

## F-04 — Asignación (Alta prioridad)

**Significado de negocio**: Responde las dos preguntas más frecuentes del inventario: ¿quién tiene este bien? y ¿dónde está?

| HU | Descripción | Estado | Dependencias |
|---|---|---|---|
| HU-04-01 | Asignar bien a responsable | ❌ | Necesita Asset + Contact |
| HU-04-02 | Asignar bien a ubicación | ❌ | Necesita Asset |
| HU-04-03 | Reasignar bien | ❌ | Necesita Asset + Contact |

**A nivel de negocio**: Un bien existe físicamente pero el sistema no puede decir quién lo tiene ni dónde está. Es el problema que el sistema completo busca resolver, y está totalmente sin implementar.

---

## F-05 — Búsqueda (Media prioridad)

**Significado de negocio**: Encontrar un bien rápido sin hojear páginas. Escencial cuando hay cientos de activos.

| HU | Descripción | Estado | Dependencias |
|---|---|---|---|
| HU-05-01 | Buscar por etiqueta | ❌ | Necesita Asset con etiqueta |
| HU-05-02 | Filtrar por categoría | ❌ | Necesita Asset |
| HU-05-03 | Filtrar por responsable | ❌ | Necesita Asset + Contact |
| HU-05-04 | Filtrar por ubicación | ❌ | Necesita Asset |

**A nivel de negocio**: Si tuvieras 500 activos, no podrías encontrar nada sin hojear página por página. No hay buscador.

---

## F-06 — Indicadores (Baja prioridad)

**Significado de negocio**: Dashboard básico para que la gerencia vea el estado del inventario de un vistazo.

| HU | Descripción | Estado | Dependencias |
|---|---|---|---|
| HU-06-01 | Conteo de bienes por estado | ❌ | Necesita Asset |
| HU-06-02 | Resumen por categoría | ❌ | Necesita Asset |
| HU-06-03 | Bienes sin responsable | ❌ | Necesita Asset + Contact |
| HU-06-04 | Bienes sin ubicación | ❌ | Necesita Asset |

**A nivel de negocio**: No hay visibilidad gerencial. No puedes responder "¿cuántos activos tenemos?" ni "¿cuántos están perdidos?".

---

## Resumen ejecutivo

Feature | HUs | Hecho | En progreso | No iniciado
---|---|---|---|---
F-01 Datos maestros | 6 | 4 (con gaps) | 2 (Contact) | 0
F-02 Registro de bienes | 4 | 0 | 0 | 4
F-03 Estado y baja | 3 | 0 | 0 | 3
F-04 Asignación | 3 | 0 | 0 | 3
F-05 Búsqueda | 4 | 0 | 0 | 4
F-06 Indicadores | 4 | 0 | 0 | 4
**Total** | **24** | **4** | **2** | **18**

**MVP (15 HU marcadas Alta)**: Completadas 4, en progreso 2, faltan 9. La más crítica es F-02 (Registro de bienes), que es el core del sistema y está 100% sin empezar.

**Dependencia clave**: F-02 (Asset) es requisito de F-03, F-04, F-05 y F-06. Hasta que no exista el modelo `Asset`, las demás features no pueden avanzar.
