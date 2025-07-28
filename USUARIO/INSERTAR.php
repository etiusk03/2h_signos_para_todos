    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/2h_signos_para_todos/css/styleCrudUs.css">
        <link rel="icon" href="/2h_signos_para_todos/imagenes/icon2h.png" type="image/png">
        <title>2H - Administracion de usuarios</title>
    </head>
    <body>
        <?php
            include "../USUARIO/CONEXION.php";
                if (!$conexion) {
                    die("Error de conexión: " . mysqli_connect_error());
                    }
        ?>
        <div class="dashboard">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-header"><h2>Sistema 2H</h2></div>
                <div class="sidebar-menu">
                    <div class="menu-item"><a href="/2h_signos_para_todos/usuario/crudusuario.php">Inicio</a></div>
                    <div class="menu-item"><a href="/2h_signos_para_todos/usuario/insertar.php">Usuarios</a></div>
                    <div class="menu-item"><a href="/2h_signos_para_todos/glosario/insertar.php">Glosario</a></div>
                    <div class="menu-item"><a href="/2h_signos_para_todos/sena/crudsena.php">Seña</a></div>
                    <div class="menu-item"><a href="/2h_signos_para_todos/modulos/crud_modulos.php">Modulos</a></div>
                    <div class="menu-item"><a href="/2h_signos_para_todos/config.php">Configuración</a></div>
                    <div class="sidebar-footer"><a class="logout-btn" href="/2h_signos_para_todos/index.php">Cerrar sesión</a></div>
                </div>
            </div>

            <!-- Contenido Principal -->
            <div class="main-content">
                <div class="header">
                    <h1>Usuarios registrados</h1>
                </div>
                <div class="container-crud">
                    <form class="form-class" method="POST" enctype="multipart/form-data">
                        <h3>Registro de usuario</h3><br>
                        <?php
                        include "../controlador/controlador_insertar_usuario.php";
                        ?>
                        <div class="col-4">
                            <label>Tag Usuario</label>
                            <input type="text" class="form-control" name="id_personal">
                        </div>
                        <div class="col-4">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre">
                        </div>
                        <div class="col-4">
                            <label>Apellido</label>
                            <input type="text" class="form-control" name="apellido">
                        </div>
                        <div class="col-4">
                            <label>Correo electrónico</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="col-4">
                            <label>Contraseña</label>
                            <input type="password" class="form-control" name="contrasena">
                        </div>
                        <div class="col-4">
                            <label>Tipo</label>
                            <select name="tipo" class="form-control">
                                <option value="estudiante">estudiante</option>
                                <option value="hablante">hablante</option>
                                <option value="interprete">interprete</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Foto perfil</label>
                            <input type="file" class="form-control" name="foto_perfil">
                        </div>
                        <div class="col-4">
                            <label>Nivel</label>
                            <select name="nivel" class="form-control">
                                <option value="sin conocimientos">sin conocimientos</option>
                                <option value="basico">básico</option>
                                <option value="intermedio">intermedio</option>
                                <option value="avanzado">avanzado</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Fecha de nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nac">
                        </div>
                        <button type="submit" name="registro" class="btn btn-primary">Registrar</button>

                    </form>

                    <div class="contenedor_tabla">
                        <table class="tabla">
                            <thead>
                                <tr>
                                    <th>Id Personal</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    <th>Tipo</th>
                                    <th>Foto perfil</th>
                                    <th>Nivel</th>
                                    <th>Fecha Nacimiento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = $conexion->query("SELECT * FROM usuario");
                                    while ($datos = $sql->fetch_object()) {
                                        echo "<tr>
                                                <td>$datos->id_personal</td>
                                                <td>$datos->nombre</td>
                                                <td>$datos->apellido</td>
                                                <td>$datos->email</td>
                                                <td>$datos->tipo</td>
                                                <td><img src='$datos->foto_perfil' width='50'></td>
                                                <td>$datos->nivel</td>
                                                <td>$datos->fecha_nac</td>
                                                <td>
                                                    <a href='../USUARIO/UPDATE.php?id_personal=" . urlencode($datos->id_personal) . "'>Actualizar</a>
                                                    <a href='../USUARIO/DELETE.php?id_personal=" . urlencode($datos->id_personal) . "'>Borrar</a>
                                                </td>
                                            </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (isset($_GET['borrado']) && $_GET['borrado'] == 1): ?>
                        <div class="delete_confirm">
                            ✅ Fue borrado correctamente. YEIIIIIIIIIII 🎉
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const alert = document.querySelector('.delete_confirm');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        </script>
    </body>
    </html>
