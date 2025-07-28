<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/2h_signos_para_todos/css/styleCrudMod.css">  
    <link rel="icon" href="/2h_signos_para_todos/imagenes/icon2h.png" type="image/png">
    <title>2H - Usuario Admin - Niveles</title>
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
                <div class="menu-item"><a href="/2h_signos_para_todos/modulos/crud_modulos.php">Niveles</a></div>
                <div class="menu-item"><a href="/2h_signos_para_todos/config.php">Configuración</a></div>
                <div class="sidebar-footer"><a class="logout-btn" href="/2h_signos_para_todos/index.php">Cerrar sesión</a></div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="modulo-container">
            <h1>Selecciona un nivel para comenzar</h1>
            <div class="niveles">
                <a href="nivel/temas_por_nivel.php?nivel=basico" class="nivel-card nivel-basico">
                    <div class="nivel-header">Básico</div>
                    <div class="nivel-body">
                        <p>Aprende el alfabeto, saludos, vocabulario esencial y frases cotidianas en LSV.</p>
                    </div>
                    <div class="nivel-footer">
                        <button class="btn btn-primary">Comenzar</button>
                    </div>
                </a>

                <a href="nivel/temas_por_nivel.php?nivel=intermedio" class="nivel-card nivel-intermedio">
                    <div class="nivel-header">Intermedio</div>
                    <div class="nivel-body">
                        <p>Mejora tu fluidez con nuevos temas, clasificadores y estructuras más completas.</p>
                    </div>
                    <div class="nivel-footer">
                        <button class="btn btn-primary">Comenzar</button>
                    </div>
                </a>

                <a href="nivel/temas_por_nivel.php?nivel=avanzado" class="nivel-card nivel-avanzado">
                    <div class="nivel-header">Avanzado</div>
                    <div class="nivel-body">
                        <p>Domina la expresión en LSV, incluyendo narración, argumentación y cultura sorda.</p>
                    </div>
                    <div class="nivel-footer">
                        <button class="btn btn-primary">Comenzar</button>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
