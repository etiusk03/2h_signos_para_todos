<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar campos vacíos, excepto la imagen
    if (
        empty($_POST["id_personal"]) || empty($_POST["nombre"]) || empty($_POST["apellido"]) ||
        empty($_POST["email"]) || empty($_POST["contrasena"]) || empty($_POST["tipo"]) ||
        empty($_POST["nivel"]) || empty($_POST["fecha_nac"])
    ) {
        echo '<div class="alert alert-danger">Uno de los campos está vacío</div>';
    } else {
        $id_personal = $_POST["id_personal"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $contrasena = $_POST["contrasena"];
        $tipo = $_POST["tipo"];
        $nivel = $_POST["nivel"];
        $fecha_nac = $_POST["fecha_nac"];

        // Manejo de la imagen
        $rutaDestino = "";
        if (!empty($_FILES["foto_perfil"]["name"])) {
            $carpetaDestino = "../imagenes/usuarios/";
            if (!file_exists($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }

            $nombreImagen = basename($_FILES["foto_perfil"]["name"]);
            $rutaDestino = $carpetaDestino . $nombreImagen;

            if (!move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $rutaDestino)) {
                echo '<div class="alert alert-warning">No se pudo subir la imagen, se dejará en blanco</div>';
                $rutaDestino = "";
            }
        }

        // Insertar usuario
        $sql = $conexion->query("INSERT INTO usuario (id_personal, nombre, apellido, email, contrasena, tipo, foto_perfil, nivel, fecha_nac) 
            VALUES ('$id_personal', '$nombre', '$apellido', '$email', '$contrasena', '$tipo', '$rutaDestino', '$nivel', '$fecha_nac')");

        if ($sql) {
            echo '<div class="alert alert-success">Usuario registrado correctamente</div>';
        } else {
            echo '<div class="alert alert-danger">Error al registrar usuario</div>';
        }
    }
}
?>
