# Guía: proteger la intranet en Apache (Ubuntu Server 24.04)

Bloquea desde la configuración de Apache el acceso web a los archivos que **no deben descargarse**:

| Ruta | Riesgo si está expuesta |
|------|-------------------------|
| `db/` | Descarga de `intranet.sqlite` (usuarios y hashes de contraseña) |
| `.git/` | Reconstrucción del código fuente y de su historial |
| `includes/` | Acceso directo a los archivos internos de PHP |
| `img/uploads/` | Listado del contenido de la carpeta y ejecución de PHP subido |

> **Por qué no `.htaccess`:** en Ubuntu, `/etc/apache2/apache2.conf` define `AllowOverride None` para `/var/www/`, por lo que Apache ignora los `.htaccess`. Por eso la protección va en un archivo de configuración del servidor.

Probado con Apache 2.4.58 (el de Ubuntu 24.04). Requiere `sudo`.

---

## 1. Requisitos

- Ubuntu Server 24.04 con Apache 2.4 y PHP funcionando.
- La intranet en `/var/www/html/intranet`. Si está en otra ruta, cámbiela en el paso 2.

Compruebe la ruta real y que las rutas están hoy expuestas (deben dar `200`):

```bash
RUTA=/var/www/html/intranet
curl -s -o /dev/null -w '%{http_code}\n' http://localhost/intranet/db/intranet.sqlite
curl -s -o /dev/null -w '%{http_code}\n' http://localhost/intranet/.git/HEAD
```

## 2. Crear el archivo de configuración

```bash
sudo nano /etc/apache2/conf-available/intranet-proteger.conf
```

Pegue este contenido (ajuste la ruta si es distinta):

```apache
# Protección de la intranet: bloquea archivos internos y datos sensibles.

# Base de datos y scripts de mantenimiento
<Directory /var/www/html/intranet/db>
    Require all denied
</Directory>

# Código interno (solo debe ser incluido por PHP, nunca pedido por el navegador)
<Directory /var/www/html/intranet/includes>
    Require all denied
</Directory>

# Repositorio git y documentación
<DirectoryMatch "^/var/www/html/intranet/(\.git|docs)">
    Require all denied
</DirectoryMatch>

# Imágenes subidas desde el panel: sin listado y sin ejecutar PHP
<Directory /var/www/html/intranet/img/uploads>
    Options -Indexes
    <FilesMatch "\.(php|phtml|phar)$">
        Require all denied
    </FilesMatch>
</Directory>

# Listado de carpetas desactivado y copias de base de datos o respaldos bloqueadas
<Directory /var/www/html/intranet>
    Options -Indexes
    <FilesMatch "\.(sqlite|sqlite-journal|sqlite-wal|sqlite-shm|sql|bak|log)$">
        Require all denied
    </FilesMatch>
</Directory>
```

Guarde con `Ctrl+O`, `Enter` y salga con `Ctrl+X`.

## 3. Activar y recargar

```bash
sudo a2enconf intranet-proteger
sudo apache2ctl configtest
```

`configtest` debe responder `Syntax OK`. Si da error, **no recargue**: revise el archivo (suele ser una ruta mal escrita).

```bash
sudo systemctl reload apache2
```

## 4. Verificar

Todas estas rutas deben dar **403** (o 404):

```bash
for u in db/intranet.sqlite db/schema.sql db/ includes/db.php includes/ .git/HEAD .git/config img/uploads/; do
  echo -n "$u -> "; curl -s -o /dev/null -w '%{http_code}\n' "http://localhost/intranet/$u"
done
```

Y estas deben seguir funcionando con **200** (si no, la configuración es demasiado estricta):

```bash
for u in index.php salas.php admin/login.php css/estilos.css js/notas-carousel.js img/logoMSP.gif actual.jpeg; do
  echo -n "$u -> "; curl -s -o /dev/null -w '%{http_code}\n' "http://localhost/intranet/$u"
done
```

Pruebe también en el navegador: portada, una tarjeta con ícono, el login de `admin/` y subir una imagen desde el panel (las imágenes de `img/uploads/` deben verse en la portada).

## 5. Después de cerrar el acceso

1. **Cambie la contraseña del administrador.** La base estuvo accesible en la red, así que su hash pudo copiarse:
   ```bash
   php /var/www/html/intranet/db/crear_admin.php <usuario> '<contraseña_nueva_de_12+_caracteres>'
   ```
2. Si la intranet tuvo claves, tokens o direcciones sensibles en el historial de git, considérelas expuestas y cámbielas.

## 6. Mantenimiento y reversión

- **Desactivar la protección** (solo para diagnosticar):
  ```bash
  sudo a2disconf intranet-proteger && sudo systemctl reload apache2
  ```
- **Cambió la ruta de la intranet:** edite el archivo del paso 2, ejecute `configtest` y recargue.
- **Mover la intranet a otro servidor:** repita los pasos 2 a 4; la configuración no viaja con el código.
- Esta guía se publica en `docs/`, pero está bloqueada para la web por la propia configuración.

## Solución de problemas

| Síntoma | Causa probable | Qué hacer |
|---------|----------------|-----------|
| Todo da 403, incluida la portada | Ruta equivocada en un `<Directory>` | Revise `RUTA` en el paso 1 y el archivo |
| Las imágenes subidas no se ven | `Require all denied` se aplicó a `uploads/` entero | Debe bloquearse solo `*.php`, como en el paso 2 |
| Sigue dando 200 tras recargar | La configuración no está activa | `ls /etc/apache2/conf-enabled/` debe mostrar `intranet-proteger.conf` |
| El login del admin falla tras el cambio | La sesión de PHP no se ve afectada; revise permisos | `sudo tail /var/log/apache2/error.log` |

## Recomendación adicional

La protección más sólida es **sacar la base de datos de `/var/www/html`** (por ejemplo a `/var/www/intranet-data/`) y cambiar la ruta en `includes/db.php`. Así no depende de que esta configuración siga activa. Puede aplicarse junto con esta guía.
