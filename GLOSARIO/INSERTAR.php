<?php
    session_start();
    include "../GLOSARIO/CONEXION.php";
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/2h_signos_para_todos/css/styleCrudGl.css">
    <link rel="icon" href="/2h_signos_para_todos/imagenes/icon2h.png" type="image/png">
        <title>2H - Administracion de glosarios personales</title>
</head>
<body>
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
                    <h1>Glosarios registrados</h1>
                </div>
                <div class="container-crud">
                    <form class="form-class" method="POST" enctype="multipart/form-data">
                        <h3>Registro de Glosario</h3><br>
                            <?php if (isset($_GET['registro']) && $_GET['registro'] === 'ok'): ?>
                                <div class="alert alert-success">✅ Glosario registrado correctamente</div>
                            <?php endif; ?>
                        <?php
                        include "../controlador/control_insert_glosario.php";
                        include "../usuario/conexion.php";
                        ?>
                        <div class="col-4">
                            <?php
                            if (isset($_SESSION['id_personal'])) {
                                echo '<input type="hidden" name="id_usuario" value="' . $_SESSION['id_personal'] . '">';
                            } else {
                                echo '<div class="alert alert-danger">⚠️ No se ha iniciado sesión correctamente.</div>';
                            }
                            ?>
                        </div>
                        <div class="col-4">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="col-4">
                            <label>Descripcion</label>
                            <input type="text" class="form-control" name="descripcion" required>
                        </div>
                        <div class="col-4">
                            <!-- Fecha actual -->
                            <input type="hidden" name="fecha_creacion" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <button type="submit" name="registro" class="btn btn-primary">Registrar</button>
                    </form>

                    <div class="contenedor_tabla">
                        <table class="tabla">
                            <thead>
                                <tr>
                                    <th>Tag Usuario</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Fecha de creacion</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_SESSION['id_personal'])) {
                                    $id_personal = $_SESSION['id_personal'];
                                    $sql = $conexion->query("SELECT * FROM glosario WHERE id_personal = '$id_personal'");

                                    while ($datos = $sql->fetch_object()) {
                                        echo "<tr>
                                                <td>$datos->id_personal</td>
                                                <td>$datos->nombre</td>
                                                <td>$datos->descripcion</td>
                                                <td>$datos->fecha_creacion</td>
                                                <td>
                                                    <a href='../GLOSARIO/UPDATE.php?id=" . urlencode($datos->id) . "'>Actualizar</a>
                                                    <a href='../GLOSARIO/DELETE.php?id=" . urlencode($datos->id) . "'>Borrar</a>
                                                    <a href='../GLOSARIO/ver_senas.php?id_glosario=" . urlencode($datos->id) . "'>Ver Señas</a>
                                                </td>
                                            </tr>";
                                    }
                                } else {
                                    echo '<tr><td colspan="5"><div class="alert alert-danger">⚠️ No has iniciado sesión correctamente.</div></td></tr>';
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

            setTimeout(() => {
                const alert = document.querySelector('.alert-success');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        </script>
    </body>
    </html>
