<?php
include "../GLOSARIO/CONEXION.php";

if (!isset($_GET['id_glosario'])) {
    die("ID de glosario no especificado.");
}

$id_glosario = intval($_GET['id_glosario']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    include "../controlador/controlador_sena.php";
    exit();
}

$sql = "SELECT s.id, s.nombre, s.descripcion, s.video_path, s.tipo 
        FROM sena s
        JOIN sen_glosario sg ON s.id = sg.id_sena
        WHERE sg.id_glosario = ?
        ORDER BY s.nombre";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_glosario);
$stmt->execute();
if (!$stmt) {
    die("Error en la consulta: " . $conexion->error);
}
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/2h_signos_para_todos/css/styleCrudGl.css">
    <link rel="icon" href="/2h_signos_para_todos/imagenes/icon2h.png" type="image/png">
    <title>2H - Glosario - Señas</title>
</head>
<body>
    <div class="main-content">
        <div class="header">
            <h1>Señas del Glosario</h1>
        </div>

        <div class="container_sena_insert">
            <h2>Agregar nueva seña al glosario</h2>
            <form method="POST" enctype="multipart/form-data" action="">
                <input type="hidden" name="id_glosario" value="<?= htmlspecialchars($id_glosario) ?>">

                <label>Nombre:</label>
                <input type="text" name="nombre" required>
                
                <label>Descripción:</label>
                <textarea name="descripcion" required></textarea>
                
                <label>Tipo:</label>
                <input type="text" name="tipo" required>
                
                <label>Video (subir archivo):</label>
                <input type="file" name="video_file" accept="video/*">

                <input type="hidden" name="video_base64" id="video_base64">

                <label>O grabar video:</label>
                <div class="grabacion-contenedor">
                    <video id="preview" width="900" height="240" autoplay muted></video>
                    <div class="botones-grabacion">
                        <button type="button" id="startRecord">Grabar</button>
                        <button type="button" id="stopRecord" disabled>Detener</button>
                        <button type="submit">Guardar Seña</button>
                    </div>
                </div>
            </form>
        </div>


        <div class="contenedor_tabla">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Video</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                            <td><?= htmlspecialchars($row['descripcion']) ?></td>
                            <td>
                                <video width="400" controls>
                                    <source src="/2h_signos_para_todos/sena/<?= htmlspecialchars($row['video_path']) ?>" type="video/mp4">
                                    Tu navegador no puede reproducir este video.
                                </video>
                            </td>
                            <td><?= htmlspecialchars($row['tipo']) ?></td>
                            <td>
                                <a href="/2h_signos_para_todos/SENA/UPDATE.php?id=<?= $row['id'] ?>&gl=<?= $id_glosario ?>">Actualizar</a>
                                <a href="/2h_signos_para_todos/SENA/DELETE.php?id=<?= $row['id'] ?>&gl=<?= $id_glosario ?>" onclick="return confirm('¿Seguro que deseas eliminar esta seña?');">Borrar</a>
                        </td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay señas registradas en este glosario.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div style="text-align:center; margin-top:20px;">
            <a class="btn" href="../GLOSARIO/INSERTAR.php">🔙 Volver</a> 
        </div>
    </div>

    <script src="/2h_signos_para_todos/js/videoRecorder.js"></script>
</body>
</html>