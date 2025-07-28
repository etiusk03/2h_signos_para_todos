<?php
require_once '../../CONEXION/conexion_bd.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id_tema = intval($_GET['id']);
$mensaje = "";

// Obtener datos actuales del tema
$sql = "SELECT * FROM tema WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_tema);
$stmt->execute();
$resultado = $stmt->get_result();
$tema = $resultado->fetch_assoc();

if (!$tema) {
    $mensaje = "❌ Tema no encontrado.";
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $link_youtube = $_POST['link_youtube'] ?? '';
        $nuevo_pdf_path = $tema['link_pdf']; // por defecto mantiene el actual

        if (!empty($_FILES['pdf']['name'])) {
            // Validar que sea PDF
            $tipo_mime = mime_content_type($_FILES['pdf']['tmp_name']);
            if ($tipo_mime !== 'application/pdf') {
                $mensaje = "❌ El archivo debe ser un PDF válido.";
            } else {
                // Borrar el PDF anterior si existe
                $archivo_anterior = $tema['link_pdf'];
                // Para borrar, quitar el prefijo URL y obtener ruta relativa al FS:
                $ruta_anterior = __DIR__ . "/../../" . ltrim($archivo_anterior, '/'); 
                if (!empty($archivo_anterior) && file_exists($ruta_anterior)) {
                    unlink($ruta_anterior);
                }

                // Guardar el nuevo archivo en la carpeta raíz /pdfs/
                $nombre_archivo = uniqid('tema_', true) . '.pdf';
                $directorio_destino = __DIR__ . "/../../pdfs/";
                if (!is_dir($directorio_destino)) {
                    mkdir($directorio_destino, 0777, true);
                }
                $ruta_destino = $directorio_destino . $nombre_archivo;

                if (move_uploaded_file($_FILES['pdf']['tmp_name'], $ruta_destino)) {
                    // Guardar en la BD la ruta con barra inicial y el prefijo de la app
                    $nuevo_pdf_path = "/2h_signos_para_todos/pdfs/" . $nombre_archivo;
                } else {
                    $mensaje = "❌ Error al subir el nuevo PDF.";
                }
            }
        }

        if (empty($mensaje)) {
            $stmt = $conexion->prepare("UPDATE tema SET nombre = ?, descripcion = ?, link_youtube = ?, link_pdf = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $nombre, $descripcion, $link_youtube, $nuevo_pdf_path, $id_tema);

            if ($stmt->execute()) {
                $nivel = $_GET['nivel'] ?? '';
                if (!empty($nivel)) {
                    header("Location: temas_por_nivel.php?nivel=" . urlencode($nivel) . "&mensaje=tema_actualizado");
                } else {
                    header("Location: index.php?mensaje=tema_actualizado");
                }
                exit;
            } else {
                $mensaje = "❌ Error al actualizar el tema.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Tema</title>
    <link rel="stylesheet" href="/2h_signos_para_todos/css/styleUpextra.css">
    <link rel="icon" href="/2h_signos_para_todos/imagenes/icon2h.png" type="image/png"> 
</head>
<body>
    <div class="box_total">
        <div class="container">
            <h1>Editar Tema</h1>
            
            <?php if (!empty($mensaje)): ?>
                <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
            <?php endif; ?>

            <?php if ($tema): ?>
            <form method="POST" enctype="multipart/form-data">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($tema['nombre']) ?>" required>

                <label>Descripción:</label>
                <textarea name="descripcion" required><?= htmlspecialchars($tema['descripcion']) ?></textarea>

                <label>Link de YouTube:</label>
                <input type="text" name="link_youtube" value="<?= htmlspecialchars($tema['link_youtube']) ?>">

                <label>PDF actual:</label><br>
                <?php if (!empty($tema['link_pdf'])): ?>
                    <a href="<?= htmlspecialchars($tema['link_pdf']) ?>" target="_blank" class="pdf-link">📄 Ver PDF</a>
                <?php else: ?>
                    No hay PDF.<br>
                <?php endif; ?>

                <label>Reemplazar PDF:</label>
                <input type="file" name="pdf" accept=".pdf">

                <button type="submit" class="btn btn-guardar">Guardar Cambios</button>
                <a href="<?= $urlCancelar ?>" class="btn btn-cancelar">Cancelar</a>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
