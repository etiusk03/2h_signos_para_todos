<?php
include "../GLOSARIO/CONEXION.php";

$id_sena = intval($_GET['id'] ?? 0);
$id_glosario = intval($_GET['gl'] ?? 0);

if ($id_sena && $id_glosario) {

    $stmt_video = $conexion->prepare("SELECT video_path FROM sena WHERE id = ?");
    $stmt_video->bind_param("i", $id_sena);
    $stmt_video->execute();
    $result = $stmt_video->get_result();

    $video_path = "";
    if ($row = $result->fetch_assoc()) {
        $video_path = $row['video_path'];
    }

    $stmt1 = $conexion->prepare("DELETE FROM sen_glosario WHERE id_sena = ? AND id_glosario = ?");
    $stmt1->bind_param("ii", $id_sena, $id_glosario);
    $stmt1->execute();

    $stmt2 = $conexion->prepare("DELETE FROM sena WHERE id = ?");
    $stmt2->bind_param("i", $id_sena);
    $stmt2->execute();


    if (!empty($video_path)) {
        $ruta_completa = __DIR__ . "/../sena/" . $video_path;
        if (file_exists($ruta_completa)) {
            unlink($ruta_completa);
        }
    }
}

if ($id_glosario === 0) {
    header("Location: ../SENA/CRUDSENA.php");
} else {
    header("Location: ../GLOSARIO/ver_senas.php?id_glosario=" . $id_glosario);
}
exit();
