<?php
include "../USUARIO/CONEXION.php";

if (!isset($_GET['id_personal'])) {
    die("ID de usuario no especificado.");
}

$id_personal = $_GET['id_personal'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');
    $tipo = trim($_POST['tipo'] ?? '');
    $nivel = trim($_POST['nivel'] ?? '');
    $fecha_nac = trim($_POST['fecha_nac'] ?? '');


    $stmt = $conexion->prepare("UPDATE usuario SET nombre = ?, apellido = ?, email = ?, contrasena = ?, tipo = ?, nivel = ?, fecha_nac = ? WHERE id_personal = ?");
    $stmt->bind_param("ssssssss", $nombre, $apellido, $email, $contrasena, $tipo, $nivel, $fecha_nac, $id_personal);

    if ($stmt->execute()) {
        header("Location: insertar.php?actualizado=1");
        exit();
    } else {
        echo "Error al actualizar usuario.";
    }
}

$stmt = $conexion->prepare("SELECT * FROM usuario WHERE id_personal = ?");
$stmt->bind_param("s", $id_personal);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Usuario no encontrado.");
}

$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="/2h_signos_para_todos/css/styleCrudUs.css">
        <link rel="icon" href="/2h_signos_para_todos/imagenes/icon2h.png" type="image/png">
        <title>2H - Actualizacion de datos</title>
</head>
<body>
    <form method="POST" action="" class="actu_form">
        <div class="form-group">
            <h1 class="titulo-actu">Actualizar Usuario <?= htmlspecialchars($usuario['nombre']) ?></h1>

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

            <label>Apellido:</label>
            <input type="text" name="apellido" value="<?= htmlspecialchars($usuario['apellido']) ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

            <label>Contraseña:</label>
            <input type="password" name="contrasena" value="<?= htmlspecialchars($usuario['contrasena']) ?>" required>

            <label>Tipo:</label>
            <select name="tipo" required>
                <option value="estudiante" <?= $usuario['tipo'] === 'estudiante' ? 'selected' : '' ?>>estudiante</option>
                <option value="hablante" <?= $usuario['tipo'] === 'hablante' ? 'selected' : '' ?>>hablante</option>
                <option value="interprete" <?= $usuario['tipo'] === 'interprete' ? 'selected' : '' ?>>interprete</option>
            </select>

            <label>Foto perfil</label>
            <input type="file" class="form-control" name="foto_perfil">

            <label>Nivel:</label>
            <select name="nivel" required>
                <option value="sin conocimientos" <?= $usuario['nivel'] === 'sin conocimientos' ? 'selected' : '' ?>>sin conocimientos</option>
                <option value="basico" <?= $usuario['nivel'] === 'basico' ? 'selected' : '' ?>>básico</option>
                <option value="intermedio" <?= $usuario['nivel'] === 'intermedio' ? 'selected' : '' ?>>intermedio</option>
                <option value="avanzado" <?= $usuario['nivel'] === 'avanzado' ? 'selected' : '' ?>>avanzado</option>
            </select>

            <label>Fecha de nacimiento:</label>
            <input type="date" name="fecha_nac" value="<?= htmlspecialchars($usuario['fecha_nac']) ?>" required>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn">Actualizar</button>
            <a href="insertar.php" class="btn cancel">Cancelar</a>
        </div>
    </form>
</body>
</html>
