<?php
session_start();
require 'conexion.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['mensaje'] = 'El identificador del estudiante no es válido.';
    $_SESSION['tipo_mensaje'] = 'error';
    header('Location: index.php');
    exit;
}

$consulta = $conexion->prepare('SELECT id, nombre, apellido, dni, email FROM estudiantes WHERE id = ?');
$consulta->bind_param('i', $id);
$consulta->execute();
$estudiante = $consulta->get_result()->fetch_assoc();
if (!$estudiante) {
    $_SESSION['mensaje'] = 'No se encontró el estudiante solicitado.';
    $_SESSION['tipo_mensaje'] = 'error';
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar estudiante</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<main class="contenedor contenedor-chico">
    <header><p class="etiqueta">ABM de estudiantes</p><h1>Modificar estudiante</h1></header>
    <section class="tarjeta">
        <form action="procesar.php" method="post" class="formulario">
            <input type="hidden" name="accion" value="modificar">
            <input type="hidden" name="id" value="<?= (int) $estudiante['id'] ?>">
            <label>Nombre<input type="text" name="nombre" maxlength="50" required value="<?= htmlspecialchars($estudiante['nombre']) ?>"></label>
            <label>Apellido<input type="text" name="apellido" maxlength="50" required value="<?= htmlspecialchars($estudiante['apellido']) ?>"></label>
            <label>DNI<input type="text" name="dni" maxlength="10" inputmode="numeric" pattern="[0-9]{7,10}" required value="<?= htmlspecialchars($estudiante['dni']) ?>"></label>
            <label>Correo electrónico<input type="email" name="email" maxlength="100" required value="<?= htmlspecialchars($estudiante['email']) ?>"></label>
            <div class="acciones-formulario"><button type="submit">Guardar cambios</button><a class="boton boton-secundario" href="index.php">Cancelar</a></div>
        </form>
    </section>
</main>
</body>
</html>
