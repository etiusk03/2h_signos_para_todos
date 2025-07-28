<?php
include "../GLOSARIO/CONEXION.php";

$uploadDir = __DIR__ . "/../sena/videos/";

if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        die("No se pudo crear el directorio de videos");
    }
}

$video_path = ""; 

if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
    $video_tmp = $_FILES['video_file']['tmp_name'];
    $video_name = uniqid() . "_" . $_FILES['video_file']['name'];
    $video_path = "videos/" . $video_name;
    if (!move_uploaded_file($video_tmp, $uploadDir . $video_name)) {
        die("❌ Error: no se pudo mover el archivo de video al directorio.");
    }
} elseif (!empty($_POST['video_base64'])) {
    $videoData = explode(',', $_POST['video_base64'])[1];
    $videoData = base64_decode($videoData);
    $video_name = uniqid() . ".webm";
    $video_path = "videos/" . $video_name;
    if (!file_put_contents($uploadDir . $video_name, $videoData)) {
        die("❌ Error: no se pudo guardar el video grabado.");
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];
    $id_glosario = intval($_POST['id_glosario']);

    $stmt_sena = $conexion->prepare("INSERT INTO sena (nombre, descripcion, video_path, tipo) VALUES (?, ?, ?, ?)");
    if (!$stmt_sena) {
        die("Error al preparar la consulta de sena: " . $conexion->error);
    }
    $stmt_sena->bind_param("ssss", $nombre, $descripcion, $video_path, $tipo);
    if (!$stmt_sena->execute()) {
        die("Error al insertar en sena: " . $stmt_sena->error);
    }

    $id_sena = $conexion->insert_id;

    $stmt_rel = $conexion->prepare("INSERT INTO sen_glosario (id_sena, id_glosario) VALUES (?, ?)");
    if (!$stmt_rel) {
        die("Error al preparar la consulta de relación: " . $conexion->error);
    }
    $stmt_rel->bind_param("ii", $id_sena, $id_glosario);
    if (!$stmt_rel->execute()) {
        die("Error al insertar en sen_glosario: " . $stmt_rel->error);
    }
    header("Location: ../GLOSARIO/ver_senas.php?id_glosario=" . $id_glosario);  
    exit();
}
