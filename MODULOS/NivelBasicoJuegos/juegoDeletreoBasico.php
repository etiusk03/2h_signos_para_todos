<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="/2h_signos_para_todos/imagenes/icon2h.png" type="image/png">
  <link rel="stylesheet" href="/2h_signos_para_todos/css/styleBasicoJuegos.css">
  <title>Nivel Básico - Deletreo</title>
</head>
<body>

  <div class="modulo-card">
    <h2>Juego de Deletreo</h2>
    <p>Practica deletreando palabra por palabra con ayuda de la cámara.</p>

    <div id="juego">
      <video id="video" autoplay playsinline style="display: none;"></video>
      <canvas id="output_canvas" width="640" height="480"></canvas>
      
      <p><strong>Palabra actual:</strong> <span id="palabra"></span></p>
      <p><strong>Letra esperada:</strong> <span id="letra-esperada"></span></p>
      <p><strong>Letra detectada:</strong> <span id="letra-detectada">-</span></p>
      <p id="mensaje"></p>

      <button id="btnSiguiente" class="btn">Siguiente Letra</button>
      <button id="reiniciar-btn" class="btn btn-secondary">Reiniciar Juego</button>
    </div>

    <!-- Botón para volver a los temas -->
    <div style="margin-top: 20px;">
      <a id="btn-volver" href="#" class="btn btn-volver">← Volver a Temas</a>
    </div>
  </div>

  <!-- MediaPipe y JS del juego -->
  <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js"></script>
  <script type="module" src="../../js/juegoDeletreo.js"></script>

  <!-- Script para establecer enlace de regreso -->
  <script>
    const path = window.location.pathname;
    const nivelCarpeta = path.split('/').filter(Boolean).slice(-2, -1)[0];

    let nivel = '';
    if (nivelCarpeta.toLowerCase().includes('basico')) nivel = 'basico';
    else if (nivelCarpeta.toLowerCase().includes('intermedio')) nivel = 'intermedio';
    else if (nivelCarpeta.toLowerCase().includes('avanzado')) nivel = 'avanzado';

    const btnVolver = document.getElementById('btn-volver');
    btnVolver.href = `/2h_signos_para_todos/MODULOS/nivel/temas_por_nivel.php?nivel=${nivel}`;
  </script>

</body>
</html>
