-- Esquema de la intranet (SQLite)
-- Se ejecuta de forma idempotente en cada conexión (ver includes/db.php)

-- El sitio sirve a una única unidad operativa: esta tabla solo tiene (y solo puede tener) una fila.
CREATE TABLE IF NOT EXISTS unidad_operativa (
    id             INTEGER PRIMARY KEY CHECK (id = 1),
    nombre         TEXT NOT NULL,
    actualizado_en TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS usuarios (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    usuario         TEXT NOT NULL UNIQUE,
    password_hash   TEXT NOT NULL,
    nombre_completo TEXT,
    activo          INTEGER NOT NULL DEFAULT 1,
    creado_en       TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS paginas (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    slug            TEXT NOT NULL UNIQUE,
    titulo          TEXT NOT NULL,
    descripcion     TEXT,
    es_principal    INTEGER NOT NULL DEFAULT 0,
    orden           INTEGER NOT NULL DEFAULT 0,
    activa          INTEGER NOT NULL DEFAULT 1,
    creado_en       TEXT NOT NULL DEFAULT (datetime('now')),
    actualizado_en  TEXT
);

CREATE TABLE IF NOT EXISTS imagenes (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre_original TEXT NOT NULL,
    ruta            TEXT NOT NULL UNIQUE,
    mime            TEXT,
    tamanio_bytes   INTEGER,
    subida_en       TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS categorias (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    pagina_id   INTEGER NOT NULL REFERENCES paginas(id) ON DELETE CASCADE,
    padre_id    INTEGER REFERENCES categorias(id) ON DELETE CASCADE,
    nombre      TEXT NOT NULL,
    imagen_id   INTEGER REFERENCES imagenes(id) ON DELETE SET NULL,
    orden       INTEGER NOT NULL DEFAULT 0,
    activa      INTEGER NOT NULL DEFAULT 1,
    creado_en   TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE INDEX IF NOT EXISTS idx_categorias_pagina ON categorias(pagina_id);
CREATE INDEX IF NOT EXISTS idx_categorias_padre  ON categorias(padre_id);

CREATE TABLE IF NOT EXISTS enlaces (
    id                  INTEGER PRIMARY KEY AUTOINCREMENT,
    pagina_id           INTEGER NOT NULL REFERENCES paginas(id) ON DELETE CASCADE,
    categoria_id        INTEGER REFERENCES categorias(id) ON DELETE SET NULL,
    titulo              TEXT NOT NULL,
    url                 TEXT NOT NULL,
    imagen_id           INTEGER REFERENCES imagenes(id) ON DELETE SET NULL,
    tipo                TEXT NOT NULL DEFAULT 'externo' CHECK (tipo IN ('interno','externo')),
    abrir_nueva_pestana INTEGER NOT NULL DEFAULT 1,
    orden               INTEGER NOT NULL DEFAULT 0,
    activo              INTEGER NOT NULL DEFAULT 1,
    creado_en           TEXT NOT NULL DEFAULT (datetime('now')),
    actualizado_en      TEXT
);

CREATE INDEX IF NOT EXISTS idx_enlaces_pagina    ON enlaces(pagina_id);
CREATE INDEX IF NOT EXISTS idx_enlaces_categoria ON enlaces(categoria_id);

CREATE TABLE IF NOT EXISTS notas_importantes (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo          TEXT NOT NULL,
    contenido       TEXT NOT NULL,
    enlace_url      TEXT,
    enlace_texto    TEXT,
    orden           INTEGER NOT NULL DEFAULT 0,
    activa          INTEGER NOT NULL DEFAULT 1,
    creado_en       TEXT NOT NULL DEFAULT (datetime('now')),
    actualizado_en  TEXT
);

CREATE INDEX IF NOT EXISTS idx_notas_importantes_orden ON notas_importantes(orden);
