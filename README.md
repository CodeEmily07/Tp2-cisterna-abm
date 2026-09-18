# Informe — ABM de estudiantes

## Instalación y configuración

1. Copiar esta carpeta dentro del directorio público del servidor local (por ejemplo, `htdocs` de XAMPP).
2. Iniciar los servicios Apache y MySQL desde XAMPP (o el entorno local elegido).
3. Abrir phpMyAdmin, seleccionar **Importar** y cargar el archivo `escuela.sql`. Esto crea la base `escuela`, la tabla `estudiantes` y tres registros de prueba.
4. Revisar `conexion.php`. La configuración predeterminada es host `localhost`, usuario `root`, contraseña vacía y base de datos `escuela`; modificarla si la instalación local usa otros datos.
5. Acceder desde el navegador a `http://localhost/TP_N°2_PHP/index.php` (adaptando la ruta al nombre elegido para la carpeta).

## Validaciones implementadas

Los cuatro campos son obligatorios. Nombre y apellido admiten hasta 50 caracteres, DNI hasta 10 y correo hasta 100. El DNI debe contener entre 7 y 10 dígitos y el email se valida con el filtro de PHP.

La tabla define el DNI como único. Además de esa restricción, la aplicación detecta el error de DNI duplicado y muestra un mensaje claro. Los IDs recibidos se validan como enteros y las operaciones de inserción, actualización, consulta y eliminación usan sentencias preparadas para evitar inyección SQL. Los datos que se muestran en HTML se escapan para prevenir la inserción de contenido no deseado.
# Tp2-cisterna-abm
