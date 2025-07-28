<?php
include "../GLOSARIO/CONEXION.php"; 

if (isset($_GET["id"])) {
    $id = trim($_GET["id"]);

    $stmt = $conexion->prepare("DELETE FROM glosario WHERE id = ?");
    $stmt->bind_param("i", $id); 

    if ($stmt->execute()) {
        header("Location: insertar.php?borrado=1");
        exit();
    } else {
        echo "❌ No se pudo eliminar el glosario";
    }
} else {
    echo "❌ Parámetro id no recibido";
}
?>
