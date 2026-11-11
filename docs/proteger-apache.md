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

## Alcance: no afecta a otros sitios de `/var/www/html`

Si en `/var/www/html/` hay más sitios (por ejemplo `/var/www/html/otrositio/`), esta configuración **no los toca**:

- Todas las reglas usan **rutas absolutas que empiezan por `/var/www/html/intranet/`**. Apache aplica un `<Directory>` solo a esa carpeta y a lo que hay dentro; no a carpetas hermanas ni a otras con nombre parecido (`intranet2`, `intranet-viejo`).
- **No hay ninguna regla global**: nada sobre `/var/www/html` ni `/var/www`, ni extensiones bloqueadas fuera de la intranet. Otro sitio que tenga su propio `db/`, `includes/` o `.git/` sigue funcionando igual.
- No se cambia `AllowOverride`, ni módulos, ni el VirtualHost, ni `Options` fuera de la intranet.

> **Regla para no romper esto:** si edita el archivo, no quite el prefijo `/var/www/html/intranet` de ninguna ruta, y no añada bloques `<Files>`, `<FilesMatch>` o `<Location>` **fuera** de un `<Directory>` de la intranet: serían globales.

La sección 4 incluye una prueba para comprobarlo en su servidor.

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

# Repositorio git y documentación (solo estas carpetas exactas de la intranet)
<DirectoryMatch "^/var/www/html/intranet/(\.git|docs)(/|$)">
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

### Comprobar que otros sitios no se ven afectados

Antes del paso 3 anote el código HTTP de algunas URL de **otros sitios** (páginas, `db/`, `.git/`, etc. que existan y sean públicas) y repítalas después de recargar: los códigos deben ser idénticos.

```bash
# Sustituya por URL reales de sus otros sitios
URLS="http://localhost/otrositio/ http://localhost/otrositio/index.php http://localhost/otrositio/db/"
for u in $URLS; do echo -n "$u -> "; curl -s -o /dev/null -w '%{http_code}\n' "$u"; done > /tmp/otros-antes.txt   # ANTES del reload
# ... paso 3 (a2enconf + reload) ...
for u in $URLS; do echo -n "$u -> "; curl -s -o /dev/null -w '%{http_code}\n' "$u"; done > /tmp/otros-despues.txt
diff /tmp/otros-antes.txt /tmp/otros-despues.txt && echo "Otros sitios sin cambios"
```

Si `diff` muestra diferencias, desactive la protección (sección 6) y revise que las rutas del archivo empiecen por `/var/www/html/intranet`.

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

La protección más sólida es **sacar la base de datos de `/var/www/html`**, a `/var/www/intranet-data/`. Así no depende de que esta configuración siga activa. `includes/db.php` ya la usa automáticamente en cuanto esa carpeta existe (si no existe, sigue con `db/intranet.sqlite`). Esa carpeta queda fuera de `/var/www/html`, por lo que tampoco afecta a otros sitios:

```bash
sudo mkdir -p /var/www/intranet-data
sudo cp -a /var/www/html/intranet/db/intranet.sqlite /var/www/intranet-data/
sudo chown -R msp:www-data /var/www/intranet-data
sudo chmod 770 /var/www/intranet-data
sudo chmod 660 /var/www/intranet-data/intranet.sqlite
```

Compruebe que la intranet y el panel funcionan y luego borre la copia antigua (`rm /var/www/html/intranet/db/intranet.sqlite`). La carpeta debe ser escribible por el grupo `www-data` porque SQLite crea archivos temporales junto a la base.
