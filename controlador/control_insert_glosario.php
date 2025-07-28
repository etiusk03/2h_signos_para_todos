<?php
include "../GLOSARIO/CONEXION.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        empty($_POST["nombre"]) || 
        empty($_POST["descripcion"])
    ) {
        echo '<div class="alert alert-danger">Uno de los campos está vacío</div>';
    } else {
        $id_personal = $_SESSION["id_personal"];  // ← Toma el usuario en sesión
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $fecha_creacion = date("Y-m-d");  // ← Se fuerza a la fecha actual

        $sql = $conexion->query("INSERT INTO glosario (id_personal, nombre, descripcion, fecha_creacion) 
            VALUES ('$id_personal', '$nombre', '$descripcion', '$fecha_creacion')");

        if ($sql) {
            header("Location: INSERTAR.php?registro=ok");
            exit(); // <-- muy importante para evitar que el script siga ejecutándose
        } else {
            echo '<div class="alert alert-danger">Error al registrar glosario</div>';
        }
    }
}
?>
