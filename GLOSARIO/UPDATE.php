<?php
include "../GLOSARIO/CONEXION.php";

if (!isset($_GET['id'])) {
    die("ID del glosario no especificado.");
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $fecha_creacion = trim($_POST['fecha_creacion'] ?? '');

    $stmt = $conexion->prepare("UPDATE glosario SET nombre = ?, descripcion = ?, fecha_creacion = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nombre, $descripcion, $fecha_creacion, $id);

    if ($stmt->execute()) {
        header("Location: insertar.php?actualizado=1");
        exit();
    } else {
        echo "Error al actualizar glosario.";
    }
}

$stmt = $conexion->prepare("SELECT * FROM glosario WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Glosario no encontrado.");
}

$glosario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/2h_signos_para_todos/css/styleCrudUs.css">
    <link rel="icon" href="/2h_signos_para_todos/imagenes/icon2h.png" type="image/png">
    <title>2H - Actualización de Glosario</title>
</head>
<body>
    <form method="POST" action="" class="actu_form">
        <div class="form-group">
            <h1 class="titulo-actu">Actualizar Glosario: <?= htmlspecialchars($glosario['nombre']) ?></h1>

            <label>Nombre del glosario:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($glosario['nombre']) ?>" required>

            <label>Descripción:</label>
            <input type="text" name="descripcion" value="<?= htmlspecialchars($glosario['descripcion']) ?>" required>

            <label>Fecha de creación:</label>
            <input type="date" name="fecha_creacion" value="<?= htmlspecialchars($glosario['fecha_creacion']) ?>" readonly>

            <div class="btn-group">
                <button type="submit" class="btn">Actualizar</button>
                <a href="insertar.php" class="btn cancel">Cancelar</a>
            </div>
        </div>
    </form>
</body>
</html>
