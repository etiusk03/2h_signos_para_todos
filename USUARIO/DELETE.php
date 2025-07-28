<?php
include "../USUARIO/CONEXION.php";

if (isset($_GET["id_personal"])) {
    $id_personal = trim($_GET["id_personal"]);

    $stmt = $conexion->prepare("DELETE FROM usuario WHERE id_personal = ?");
    $stmt->bind_param("s", $id_personal);

    
    if ($stmt->execute()) {
        header("Location: insertar.php?borrado=1");
        exit();
        } else {
            echo "❌ No se pudo eliminar la persona";
        }
        } else {
            echo "❌ Parámetro id_personal no recibido";
    }
?>
