<?php
header('Content-Type: application/json');
include "../GLOSARIO/CONEXION.php";

$data = json_decode(file_get_contents("php://input"), true);
$id_sena = intval($data['id'] ?? 0);

if (!$id_sena) {
    echo json_encode(["success" => false, "message" => "ID inválido"]);
    exit;
}

// Obtener la ruta del video
$stmt_video = $conexion->prepare("SELECT video_path FROM sena WHERE id = ?");
$stmt_video->bind_param("i", $id_sena);
$stmt_video->execute();
$result = $stmt_video->get_result();

$video_path = "";
if ($row = $result->fetch_assoc()) {
    $video_path = $row['video_path'];
}

// Borrar registros relacionados en sen_glosario
$stmt1 = $conexion->prepare("DELETE FROM sen_glosario WHERE id_sena = ?");
$stmt1->bind_param("i", $id_sena);
$stmt1->execute();

// Borrar registro en sena
$stmt2 = $conexion->prepare("DELETE FROM sena WHERE id = ?");
$stmt2->bind_param("i", $id_sena);
$stmt2->execute();

// Borrar el archivo de video
    if (!empty($video_path)) {
        $ruta_completa = __DIR__ . "/../sena/" . $video_path;
        if (file_exists($ruta_completa)) {
            unlink($ruta_completa);
        }
    }

echo json_encode(["success" => true]);
