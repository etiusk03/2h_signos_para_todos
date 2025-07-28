<?php
include "../GLOSARIO/CONEXION.php";

$id_sena = intval($_GET['id'] ?? 0);
$id_glosario = intval($_GET['gl'] ?? 0);

// Cargar los datos actuales
$stmt = $conexion->prepare("SELECT * FROM sena WHERE id = ?");
$stmt->bind_param("i", $id_sena);
$stmt->execute();
$result = $stmt->get_result();
$sena = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];

    $stmt_upd = $conexion->prepare("UPDATE sena SET nombre=?, descripcion=?, tipo=? WHERE id=?");
    $stmt_upd->bind_param("sssi", $nombre, $descripcion, $tipo, $id_sena);
    $stmt_upd->execute();

    if ($id_glosario === 0) {
        header("Location: ../SENA/CRUDSENA.php");
    } else {
        header("Location: ../GLOSARIO/ver_senas.php?id_glosario=" . $id_glosario);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Seña</title>
    <link rel="stylesheet" type="text/css" href="/2h_signos_para_todos/css/styleCrudGl.css">
</head>
<body>
    <div class="main-content">
        <h2>Editar Seña</h2>
        <form method="POST" enctype="multipart/form-data" action="">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($sena['nombre']) ?>" required>

            <label>Descripción:</label>
            <textarea name="descripcion" required><?= htmlspecialchars($sena['descripcion']) ?></textarea>

            <label>Tipo:</label>
            <input type="text" name="tipo" value="<?= htmlspecialchars($sena['tipo']) ?>" required>

            <button type="submit">Guardar Cambios</button>
            <a class="btn" href="ver_senas.php?id_glosario=<?= $id_glosario ?>">Cancelar</a>
        </form>
    </div>
</body>
</html>
