<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="CSS/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link href="https://tresplazas.com/web/img/big_punto_de_venta.png" rel="shortcut icon">
    <link rel="icon" href="IMAGENES/icon2h.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="css/styleRegistro.css">

    <title>2h - Registro de usuario</title>
</head>
<body>


    <div class="box_total">
        <div class="container">
            <form action="" method="POST" class="formulario">
                <h2 class="Titulo">Registrar usuario</h2>
                <?php
                    include("conexion/conexion_bd.php");
                    include("controlador/controlador_registro_usuar.php");
                ?>
                <div>
                    <div>
                        <label for="">tag usuario</label>
                        <input type="text" name="id_personal" size="43" maxlenght="255">
                    </div>
                    <div>
                        <label for="">nombre</label>
                        <input type="text" name="nombre" size="43" maxlenght="50">
                    </div>
                    <div>
                        <label for="">apellido</label>
                        <input type="text" name="apellido" size="43" maxlenght="50">
                    </div>
                    <div>
                        <label for="">correo</label>
                        <input type="email" name="email" size="43" maxlenght="50">
                    </div>
                    <div>
                        <label for="">contraseña</label>
                        <input type="password" name="contrasena" size="43" maxlenght="100">
                    </div>
                    <div>
                        <label for="">Tipo</label>
                        <select name="tipo" id="tipo">
                            <optgroup>
                                <option value="estudiante">estudiante</option>
                                <option value="hablante">hablante</option>
                                <option value="interprete">interprete</option>
                            </optgroup>
                        </select>
                    </div>
                    <div>
                        <label for="">foto de perfil</label>
                        <input type="file" name="foto_perfil">
                        <h6>Insertar archivos de imagen</h6>
                    </div>
                    <div>
                        <label for="">nivel</label>
                        <select name="nivel" id="nivel">
                            <optgroup>
                                <option value="sin conocimientos">sin conocimientos</option>
                                <option value="basico">basico</option>
                                <option value="intermedio">intermedio</option>
                                <option value="avanzado">avanzado</option>
                            </optgroup>
                        </select>
                    </div>
                    <div>
                        <label for="">fecha nacimiento</label>
                        <input type="date" name="fecha_nac">
                    </div>
                    <div>
                        <input name="registro" class="btn" type="submit" value="Registrar">
                        <a class="get_out" href="login.php">Salir</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>