<?php
include "../GLOSARIO/CONEXION.php";

$sql = "SELECT * FROM sena ORDER BY nombre";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Señas Globales</title>
    <link rel="icon" href="/2h_signos_para_todos/imagenes/icon2h.png" type="image/png">
    <link rel="stylesheet" href="/2h_signos_para_todos/css/styleCrudSena.css">
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Sistema 2H</h2>
            </div>
            <div class="sidebar-menu">
                <div class="menu-item"><a href="/2h_signos_para_todos/usuario/crudusuario.php">Inicio</a></div>
                <div class="menu-item"><a href="/2h_signos_para_todos/usuario/insertar.php">Usuarios</a></div>
                <div class="menu-item"><a href="/2h_signos_para_todos/glosario/insertar.php">Glosario</a></div>
                <div class="menu-item"><a href="/2h_signos_para_todos/sena/crudsena.php">Seña</a></div>
                <div class="menu-item"><a href="/2h_signos_para_todos/modulos/crud_modulos.php">Modulos</a></div>
                <div class="menu-item"><a href="/2h_signos_para_todos/config.php">Configuración</a></div>

                <div class="sidebar-footer"><a class="logout-btn" href="/2h_signos_para_todos/index.php">Cerrar sesion</a></div>
            </div>
        </div>
    <div>

    <h1 style="text-align:center;">Todas las Señas Registradas</h1>

    <div class="buscador-container">
        <input type="text" id="buscador" class="buscador-input" placeholder="🔍 Buscar seña por nombre...">
    </div>


    <div class="contenedor-tarjetas">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="tarjeta-sena">
                <h3><?= htmlspecialchars($row['nombre']) ?></h3>
                <video controls>
                    <source src="/2h_signos_para_todos/sena/<?= htmlspecialchars($row['video_path']) ?>" type="video/mp4">
                    Tu navegador no puede reproducir este video.
                </video>
                <p><strong>Descripción:</strong> <?= htmlspecialchars($row['descripcion']) ?></p>
                <p><strong>Tipo:</strong> <?= htmlspecialchars($row['tipo']) ?></p>
                
                <div class="acciones-tarjeta">
                    <a href="/2h_signos_para_todos/SENA/UPDATE.php?id=<?= $row['id'] ?>&gl=0" class="btn-accion actualizar">✏️ Actualizar</a>
                    <button class="btn-accion eliminar" data-id="<?= $row['id'] ?>" onclick="eliminarSena(this)">🗑️ Eliminar</button>
                </div>
            </div>
        <?php endwhile; ?>
    </div>


    <script>
        const buscador = document.getElementById('buscador');

        buscador.addEventListener('input', () => {
            const texto = buscador.value.toLowerCase();
            const tarjetas = document.querySelectorAll('.tarjeta-sena');

            tarjetas.forEach(tarjeta => {
                const contenido = tarjeta.textContent.toLowerCase();
                tarjeta.style.display = contenido.includes(texto) ? "block" : "none";
            });
        });

        function eliminarSena(boton) {
            if (!confirm('¿Estás seguro de eliminar esta seña?')) return;

            const id = boton.dataset.id;
            console.log("Intentando eliminar seña con ID:", id);

            fetch(`/2h_signos_para_todos/SENA/DELETE_AJAX.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id })
            })
            .then(res => res.json())
            .then(data => {
                console.log("Respuesta del servidor:", data);

                if (data.success) {
                    const tarjeta = boton.closest('.tarjeta-sena');
                    tarjeta.remove();
                } else {
                    alert('❌ Error al eliminar: ' + data.message);
                }
            })
            .catch(err => {
                alert('❌ Error en la solicitud AJAX');
                console.error(err);
            });
        }
    </script>
</body>
</html>