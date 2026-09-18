<?php
session_start();
require 'conexion.php';

function redirigir(string $mensaje, string $tipo = 'exito', string $destino = 'index.php'): never
{
    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo_mensaje'] = $tipo;
    header('Location: ' . $destino);
    exit;
}

function datosEstudiante(): array
{
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nombre === '' || $apellido === '' || $dni === '' || $email === '') {
        redirigir('Todos los campos son obligatorios.', 'error');
    }
    if (mb_strlen($nombre) > 50 || mb_strlen($apellido) > 50 || strlen($dni) > 10 || strlen($email) > 100) {
        redirigir('Uno o más campos superan la longitud permitida.', 'error');
    }
    if (!preg_match('/^[0-9]{7,10}$/', $dni)) {
        redirigir('El DNI debe contener entre 7 y 10 dígitos.', 'error');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirigir('Ingrese un correo electrónico válido.', 'error');
    }
    return [$nombre, $apellido, $dni, $email];
}

$accion = $_POST['accion'] ?? '';

if ($accion === 'alta') {
    [$nombre, $apellido, $dni, $email] = datosEstudiante();
    $consulta = $conexion->prepare('INSERT INTO estudiantes (nombre, apellido, dni, email) VALUES (?, ?, ?, ?)');
    $consulta->bind_param('ssss', $nombre, $apellido, $dni, $email);
    if ($consulta->execute()) {
        redirigir('Estudiante agregado correctamente.');
    }
    if ($conexion->errno === 1062) {
        redirigir('Ya existe un estudiante con ese DNI.', 'error');
    }
    redirigir('No se pudo agregar el estudiante.', 'error');
}

if ($accion === 'modificar') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        redirigir('El identificador del estudiante no es válido.', 'error');
    }
    [$nombre, $apellido, $dni, $email] = datosEstudiante();
    $consulta = $conexion->prepare('UPDATE estudiantes SET nombre = ?, apellido = ?, dni = ?, email = ? WHERE id = ?');
    $consulta->bind_param('ssssi', $nombre, $apellido, $dni, $email, $id);
    if ($consulta->execute()) {
        redirigir('Datos del estudiante actualizados correctamente.');
    }
    if ($conexion->errno === 1062) {
        redirigir('Ya existe otro estudiante con ese DNI.', 'error');
    }
    redirigir('No se pudo modificar el estudiante.', 'error');
}

if ($accion === 'baja') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        redirigir('El identificador del estudiante no es válido.', 'error');
    }
    $consulta = $conexion->prepare('DELETE FROM estudiantes WHERE id = ?');
    $consulta->bind_param('i', $id);
    if ($consulta->execute() && $consulta->affected_rows > 0) {
        redirigir('Estudiante eliminado correctamente.');
    }
    redirigir('No se encontró el estudiante a eliminar.', 'error');
}

redirigir('Acción no válida.', 'error');
?>
