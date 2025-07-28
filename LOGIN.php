<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <link rel="stylesheet" href="CSS/bootstrap.css">
   <link rel="stylesheet" type="text/css" href="CSS/style.css">
   <link rel="stylesheet" type="text/css" href="CSS/loginStyle.css">
   <link rel="icon" href="/2h_signos_para_todos/imagenes/icon2h.png" type="image/png">

   <title>2h - Inicio de sesion</title>
</head>
<body>
   <div class="box_total">
      <div class="container">
            <div class="login-content">
               <form method="post" action="">
                  <img src="IMAGENES/icon2h.png">
                  <h2 class="title">Bienvenido a 2H</h2>

                  
                  <?php
                     include("conexion/conexion_bd.php");
                     include("controlador/controlador_login.php");
                  ?>

                  <div class="input-div one">
                     <div class="i">
                        <i class="fas fa-user"></i>
                     </div>
                     <div class="div">
                        <h5>Correo</h5>
                        <input id="usuario" type="text" class="input" name="email">
                     </div>
                  </div>
                  <div class="input-div pass">
                     <div class="i">
                        <i class="fas fa-lock"></i>
                     </div>
                     <div class="div">
                        <h5>Contraseña</h5>
                        <input type="password" id="input" class="input" name="contrasena">
                     </div>
                  </div>
                  <div class="view">
                     <div class="fas fa-eye verPassword" onclick="vista()" id="verPassword"></div>
                  </div>

                  <div class="text-center">
                     <a class="font-italic isai5" href="#">Olvidé mi contraseña</a>
                     <a class="font-italic isai5" href="registro_usuario.php">Registrarse</a>
                  </div>
                  <input name="btningresar" class="btn" type="submit" value="INICIAR SESION">
                  
                  <div>
                     <a href="index.php">
                        Regresar a la pagina principal
                     </a>
                  </div>
               </form>
            </div>
         </div>
   </div>
   
   <script src="js/fontawesome.js"></script>
   <script src="js/main.js"></script>
   <script src="js/main2.js"></script>
   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.js"></script>
   <script src="js/bootstrap.bundle.js"></script>
</body>
</html>