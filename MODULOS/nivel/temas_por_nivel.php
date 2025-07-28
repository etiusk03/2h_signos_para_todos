<?php
include "../../CONEXION/conexion_bd.php";

// Obtener y validar el nivel desde la URL
$nivel = isset($_GET['nivel']) ? strtolower(trim($_GET['nivel'])) : '';
$niveles_permitidos = ['basico', 'intermedio', 'avanzado'];

if (empty($nivel) || !in_array($nivel, $niveles_permitidos)) {
    die("❌ Nivel no especificado o inválido. Los niveles permitidos son: básico, intermedio, avanzado");
}

// Consulta preparada para módulos
$stmt = $conexion->prepare("SELECT id, orden, nivel, descripcion FROM modulo WHERE LOWER(nivel) = ? ORDER BY orden ASC");
$stmt->bind_param("s", $nivel);
$stmt->execute();
$resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulos del nivel: <?= ucfirst($nivel) ?></title>
    <link rel="stylesheet" href="/2h_signos_para_todos/css/styleNivTem.css">
    <link rel="icon" href="/2h_signos_para_todos/imagenes/icon2h.png" type="image/png">
</head>
<body>
    <h1>Módulos del nivel: <?= ucfirst($nivel) ?></h1>

    <?php if ($resultado->num_rows > 0): ?>
        <?php while ($modulo = $resultado->fetch_assoc()): ?>
            <div class="modulo-card">
                <h2>Módulo <?= htmlspecialchars($modulo['orden']) ?> (<?= htmlspecialchars($modulo['nivel']) ?>)</h2>
                <p><?= htmlspecialchars($modulo['descripcion']) ?></p>


                <!-- Mostrar temas del módulo -->
                <h3>Temas registrados:</h3>
                <ul>
                    <?php
                    $id_modulo = $modulo['id'];
                    $stmtTemas = $conexion->prepare("SELECT id, nombre, descripcion, link_pdf, link_youtube FROM tema WHERE id_modulo = ? ORDER BY nombre ASC");
                    $stmtTemas->bind_param("i", $id_modulo);
                    $stmtTemas->execute();
                    $temas = $stmtTemas->get_result();

                    if ($temas->num_rows > 0):
                        while ($tema = $temas->fetch_assoc()):
                    ?>
                        <li>
                            <strong><?= htmlspecialchars($tema['nombre']) ?></strong><br>
                            <em><?= htmlspecialchars($tema['descripcion']) ?></em><br>  

                            <?php if (!empty($tema['link_pdf'])): ?>
                                <a href="<?= htmlspecialchars($tema['link_pdf']) ?>" class="btn btn-descargar" download>📄 Descargar PDF</a>
                            <?php else: ?>
                                <span>Sin PDF</span>
                            <?php endif; ?>


                            <?php if (!empty($tema['link_youtube'])): ?>
                                <br><a href="<?= htmlspecialchars($tema['link_youtube']) ?>" target="_blank">▶️ Ver en YouTube</a>
                            <?php endif; ?>

                            <div class="tema-actions" style="flex-shrink: 0; margin-top: 5px;">
                                <a href="UPDATE.php?id=<?= $tema['id'] ?>&nivel=<?= urlencode($nivel) ?>">Editar ✏️</a>
                                <a href="DELETE.php?id=<?= $tema['id'] ?>&nivel=<?= urlencode($nivel) ?>">Borrar 🗑️</a>
                            </div>
                        </li>
                    <?php
                        endwhile;
                    else:
                        echo "<li><em>No hay temas registrados.</em></li>";
                    endif;
                    $stmtTemas->close();
                    ?>
                </ul>

                <!-- Formulario para agregar nuevo tema -->
                <div class="modulo-card">
                    <h4>Agregar nuevo tema:</h4>
                    <form method="POST" action="INSERTAR.php" enctype="multipart/form-data">
                        <input type="hidden" name="id_modulo" value="<?= $modulo['id'] ?>">
                        <input type="hidden" name="nivel" value="<?= htmlspecialchars($nivel) ?>">

                        <div class="form-group">
                            <label for="titulo">Título del tema:</label>
                            <input type="text" id="titulo" name="titulo" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="archivo_pdf">Archivo PDF:</label>
                            <input type="file" name="archivo_pdf" id="archivo_pdf" accept="application/pdf" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="link_youtube">Enlace a YouTube (opcional):</label>
                            <input type="url" id="link_youtube" name="link_youtube" class="form-control" placeholder="https://youtube.com/watch?v=...">
                        </div>

                        <button type="submit">Agregar tema</button>
                    </form>
                </div>
                <hr>

            </div>

            <div class="modulo-card">
                <h3>Área de práctica mediante juegos:</h3>
                <p>En esta sección podrás practicar deletreando palabras letra por letra con la videocámara.</p>
                <a href="../../MODULOS/NivelBasicoJuegos/juegoDeletreoBasico.php" class="btn btn-secondary">Juego de Deletreo</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No se encontraron módulos para este nivel.</p>
    <?php endif; ?>

    <a href="../crud_modulos.php" class="btn btn-secondary">🔙 Volver al inicio de módulos</a>
</body>
</html>
<?php
$stmt->close();
$conexion->close();
?>