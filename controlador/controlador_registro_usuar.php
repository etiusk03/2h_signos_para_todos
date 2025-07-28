<?php
if (!empty($_POST["registro"])) {
    if (
        empty($_POST["id_personal"]) || empty($_POST["nombre"]) ||
        empty($_POST["apellido"]) || empty($_POST["email"]) ||
        empty($_POST["contrasena"]) || empty($_POST["tipo"]) ||
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
        $foto_perfil = ""; // Se ignora la imagen

        $sql = $conexion->query("INSERT INTO usuario (
            id_personal, nombre, apellido, email, contrasena, tipo, foto_perfil, nivel, fecha_nac
        ) VALUES (
            '$id_personal', '$nombre', '$apellido', '$email', '$contrasena',
            '$tipo', '$foto_perfil', '$nivel', '$fecha_nac'
        )");

        if ($sql == 1) {
            echo '<div class="alert alert-success">Usuario registrado correctamente</div>';
        } else {
            echo '<div class="alert alert-danger">Error, usuario no registrado</div>';
        }
    }
}
?>
