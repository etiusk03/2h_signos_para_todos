<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/2h_signos_para_todos/css/styleCrudUs.css">
    <link rel="icon" href="/2h_signos_para_todos/imagenes/icon2h.png" type="image/png">
    <title>2H - Usuario Admin</title>
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
        
        <!-- Contenido Principal -->
        <div class="main-content">
            <div class="header">
                <h1>Bienvenido al Panel</h1>
            </div>
            
            <div class="cards">
                <div class="card">
                    <h3>Actividad Reciente</h3>
                    <p>Revisa las últimas palabras practicadas y las letras detectadas por la cámara.</p>
                </div>
                <div class="card">
                    <h3>Mis Glosarios</h3>
                    <p>Accede rápidamente a tus glosarios personalizados con señas y vocabulario esencial.</p>
                </div>
                <div class="card">
                    <h3>Material Descargable</h3>
                    <p>Descarga archivos PDF de estudio con teoría, señas y actividades complementarias.</p>
                </div>
                <div class="card">
                    <h3>Preferencias</h3>
                    <p>Personaliza la visualización, activa la detección automática y ajusta funciones del juego.</p>
                </div>
            </div>
            
            <div class="card">
                <h3>Última Actividad</h3>
                <p>Visualiza la fecha y el módulo del último juego o tema que exploraste en la plataforma.</p>
            </div>
        </div>

        </div>
    </div>
</body>
</html>