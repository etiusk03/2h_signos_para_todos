<?php
session_start();

if (!empty($_POST["btningresar"])) {
    if (empty($_POST["email"]) || empty($_POST["contrasena"])) {
        echo '<div class="alert alert-danger">LOS CAMPOS ESTÁN SIN RELLENAR</div>';
    } else {
        $email = $_POST["email"];
        $contrasena = $_POST["contrasena"];

        include "../usuario/conexion.php"; // Asegúrate de tener la conexión activa

        $sql = $conexion->query("SELECT * FROM usuario WHERE email='$email' AND contrasena='$contrasena'");
        
        if ($datos = $sql->fetch_object()) {
            $_SESSION["id_personal"] = $datos->id_personal; // ✅ Solo si el login es correcto
            header("Location: /2h_signos_para_todos/usuario/crudusuario.php");
            exit(); // Siempre que hagas redirección
        } else {
            echo '<div class="alert alert-danger">ACCESO DENEGADO</div>';
        }
    }
}
?>
