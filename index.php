<?php
session_start();
require 'conexion.php';

$mensaje = $_SESSION['mensaje'] ?? null;
$tipoMensaje = $_SESSION['tipo_mensaje'] ?? 'exito';
unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']);

$resultado = $conexion->query('SELECT id, nombre, apellido, dni, email FROM estudiantes ORDER BY apellido, nombre');
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABM de estudiantes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<main class="contenedor">
    <header>
        <p class="etiqueta">Laboratorio de Software</p>
        <h1>Gestión de estudiantes</h1>
        <p>Alta, modificación, baja y listado de alumnos.</p>
    </header>

    <?php if ($mensaje): ?>
        <div class="mensaje <?= $tipoMensaje === 'error' ? 'mensaje-error' : 'mensaje-exito' ?>" role="alert">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <section class="tarjeta">
        <h2>Alta de estudiante</h2>
        <form action="procesar.php" method="post" class="formulario">
            <input type="hidden" name="accion" value="alta">
            <label>Nombre
                <input type="text" name="nombre" maxlength="50" required autocomplete="given-name">
            </label>
            <label>Apellido
                <input type="text" name="apellido" maxlength="50" required autocomplete="family-name">
            </label>
            <label>DNI
                <input type="text" name="dni" maxlength="10" inputmode="numeric" pattern="[0-9]{7,10}" title="Ingrese entre 7 y 10 dígitos" required>
            </label>
            <label>Correo electrónico
                <input type="email" name="email" maxlength="100" required autocomplete="email">
            </label>
            <button type="submit">Agregar estudiante</button>
        </form>
    </section>

    <section class="tarjeta">
        <h2>Listado de estudiantes</h2>
        <div class="tabla-responsive">
            <table>
                <thead>
                    <tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Email</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= (int) $fila['id'] ?></td>
                            <td><?= htmlspecialchars($fila['nombre']) ?></td>
                            <td><?= htmlspecialchars($fila['apellido']) ?></td>
                            <td><?= htmlspecialchars($fila['dni']) ?></td>
                            <td><?= htmlspecialchars($fila['email']) ?></td>
                            <td class="acciones">
                                <a class="boton boton-secundario" href="editar.php?id=<?= (int) $fila['id'] ?>">Editar</a>
                                <form action="procesar.php" method="post" onsubmit="return confirm('¿Seguro que desea eliminar este estudiante?');">
                                    <input type="hidden" name="accion" value="baja">
                                    <input type="hidden" name="id" value="<?= (int) $fila['id'] ?>">
                                    <button class="boton boton-peligro" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="vacio">No hay estudiantes cargados.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
</body>
</html>
