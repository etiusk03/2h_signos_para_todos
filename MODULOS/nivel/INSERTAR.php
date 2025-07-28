<?php
include "../../CONEXION/conexion_bd.php";

// Habilitar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verificar método POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("❌ Método no permitido");
}

// Validar datos
$id_modulo = filter_input(INPUT_POST, 'id_modulo', FILTER_VALIDATE_INT);
$titulo = trim($_POST['titulo'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$link_youtube = trim($_POST['link_youtube'] ?? '');
$nivel = strtolower(trim($_POST['nivel'] ?? ''));

// Verificaciones básicas
if ($id_modulo === false || $id_modulo <= 0) {
    die("❌ ID de módulo inválido");
}

if (empty($titulo)) {
    die("❌ El título del tema es requerido");
}

// Verificar que el módulo exista
$stmt_check = $conexion->prepare("SELECT id FROM modulo WHERE id = ? AND LOWER(nivel) = ?");
$stmt_check->bind_param("is", $id_modulo, $nivel);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows === 0) {
    die("❌ El módulo no existe o no coincide con el nivel");
}
$stmt_check->close();

// Manejo del archivo PDF
$pdf_path = null;

if (isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['error'] === UPLOAD_ERR_OK) {
    $archivo_tmp = $_FILES['archivo_pdf']['tmp_name'];
    $nombre_original = basename($_FILES['archivo_pdf']['name']);
    $ext = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));

    if ($ext !== 'pdf') {
        die("❌ Solo se permiten archivos PDF.");
    }

    $nombre_guardado = uniqid("tema_", true) . ".pdf";
    $ruta_destino = "../../pdfs/" . $nombre_guardado;

    if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
        $pdf_path = "/2h_signos_para_todos/pdfs/" . $nombre_guardado;
    } else {
        die("❌ Error al guardar el archivo PDF.");
    }
}

// Insertar tema
$stmt = $conexion->prepare("
    INSERT INTO tema (id_modulo, nombre, descripcion, link_pdf, link_youtube)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param("issss", $id_modulo, $titulo, $descripcion, $pdf_path, $link_youtube);

if ($stmt->execute()) {
    header("Location: temas_por_nivel.php?nivel=" . urlencode($nivel));
    exit();
} else {
    die("❌ Error al insertar el tema: " . $stmt->error);
}
?>
