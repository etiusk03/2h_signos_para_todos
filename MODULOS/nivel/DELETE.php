<?php
include "../../CONEXION/conexion_bd.php";

// Obtener ID del tema y nivel (para redirigir)
$id_tema = intval($_GET['id'] ?? 0);
$nivel = trim($_GET['nivel'] ?? '');

if ($id_tema > 0) {

    // 1. Obtener la ruta del PDF asociado al tema (usar link_pdf)
    $stmt_pdf = $conexion->prepare("SELECT link_pdf FROM tema WHERE id = ?");
    $stmt_pdf->bind_param("i", $id_tema);
    $stmt_pdf->execute();
    $result_pdf = $stmt_pdf->get_result();

    $pdf_path = '';
    if ($row = $result_pdf->fetch_assoc()) {
        $pdf_path = $row['link_pdf'];  // nombre o ruta del PDF guardada
    }
    $stmt_pdf->close();

    // 2. Eliminar el tema de la base de datos
    $stmt_delete = $conexion->prepare("DELETE FROM tema WHERE id = ?");
    $stmt_delete->bind_param("i", $id_tema);
    $stmt_delete->execute();
    $stmt_delete->close();

    // 3. Eliminar el archivo PDF del servidor (si existe) - debug
    if (!empty($pdf_path)) {
    $ruta_pdf = __DIR__ . "/../../" . basename($pdf_path);
    $ruta_pdf = __DIR__ . "/../../pdfs/" . basename($pdf_path);


    if (file_exists($ruta_pdf)) {
        unlink($ruta_pdf);
    }
}

     // para ver los mensajes sin redirigir

}

// Redirigir a la lista de temas según el nivel
if (!empty($nivel)) {
    header("Location: temas_por_nivel.php?nivel=" . urlencode($nivel));
} else {
    header("Location: temas_por_nivel.php");
}
exit();
?>
