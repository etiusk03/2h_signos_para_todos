// juegoDeletreo.js
import { lsvSeñas } from './lsvAbecedario.js';

let videoElement = document.getElementById("video");
let canvasElement = document.getElementById("output_canvas");
let canvasCtx = canvasElement.getContext("2d");

let palabraSpan = document.getElementById("palabra");
let letraEsperada = document.getElementById("letra-esperada");
let letraDetectadaElement = document.getElementById("letra-detectada");
let mensaje = document.getElementById("mensaje");

const palabras = ["LANA", "ANIME", "BALA", "MIL", "MAL"];
let palabraIndex = 0;
let palabraActual = "";
let letraIndex = 0;
let juegoEnCurso = false;
let tiempoInicio;
let intervaloVerificacion;
let ultimaLetraDetectada = null;

const coloresDedos = ["#FF0000", "#00FF00", "#0000FF", "#FFA500", "#800080"];
const dedosIndices = {
  pulgar: [1, 2, 3, 4],
  indice: [5, 6, 7, 8],
  medio: [9, 10, 11, 12],
  anular: [13, 14, 15, 16],
  menique: [17, 18, 19, 20],
};

function detectarLetra(landmarks) {
  for (const letra in lsvSeñas) {
    if (lsvSeñas[letra](landmarks)) {
      return letra;
    }
  }
  return null;
}

function dibujarDedosConColores(landmarks) {
  Object.values(dedosIndices).forEach((dedo, idx) => {
    canvasCtx.beginPath();
    canvasCtx.strokeStyle = coloresDedos[idx];
    canvasCtx.lineWidth = 3;
    for (let i = 0; i < dedo.length - 1; i++) {
      const start = landmarks[dedo[i]];
      const end = landmarks[dedo[i + 1]];
      canvasCtx.moveTo(start.x * canvasElement.width, start.y * canvasElement.height);
      canvasCtx.lineTo(end.x * canvasElement.width, end.y * canvasElement.height);
    }
    canvasCtx.stroke();
  });

  const palma = [0, 5, 9, 13, 17, 0];
  canvasCtx.beginPath();
  canvasCtx.strokeStyle = "#00FFFF";
  canvasCtx.lineWidth = 2;
  for (let i = 0; i < palma.length - 1; i++) {
    const start = landmarks[palma[i]];
    const end = landmarks[palma[i + 1]];
    canvasCtx.moveTo(start.x * canvasElement.width, start.y * canvasElement.height);
    canvasCtx.lineTo(end.x * canvasElement.width, end.y * canvasElement.height);
  }
  canvasCtx.stroke();

  for (let i = 0; i < landmarks.length; i++) {
    const x = landmarks[i].x * canvasElement.width;
    const y = landmarks[i].y * canvasElement.height;
    canvasCtx.beginPath();
    canvasCtx.arc(x, y, 4, 0, 2 * Math.PI);
    canvasCtx.fillStyle = "#FFFFFF";
    canvasCtx.fill();
    canvasCtx.strokeStyle = "#000000";
    canvasCtx.stroke();
  }
}

function onHandsResults(results) {
  canvasCtx.save();
  canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
  canvasCtx.drawImage(results.image, 0, 0, canvasElement.width, canvasElement.height);

  if (results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
    const landmarks = results.multiHandLandmarks[0];
    dibujarDedosConColores(landmarks);

    const letra = detectarLetra(landmarks);
    letraDetectadaElement.textContent = letra || "No reconocido";

    if (letra && letra !== ultimaLetraDetectada) {
      ultimaLetraDetectada = letra;
      verificarLetra(letra);
    }
  } else {
    letraDetectadaElement.textContent = "No detectado";
  }

  canvasCtx.restore();
}

function verificarLetra(letraDetectada) {
  if (!juegoEnCurso) return;

  const letraCorrecta = palabraActual[letraIndex];
  if (letraDetectada === letraCorrecta) {
    letraIndex++;
    if (letraIndex < palabraActual.length) {
      letraEsperada.textContent = palabraActual[letraIndex];
    } else {
      palabraIndex++;
      if (palabraIndex < palabras.length) {
        mensaje.textContent = `¡Palabra "${palabraActual}" completada!`;
        setTimeout(() => {
          iniciarSiguientePalabra();
        }, 1500);
      } else {
        const tiempoTotal = ((Date.now() - tiempoInicio) / 1000).toFixed(2);
        mensaje.textContent = `🎉 ¡Juego completado! Tiempo: ${tiempoTotal} segundos`;
        juegoEnCurso = false;
        clearInterval(intervaloVerificacion);
      }
    }
  }
}

function iniciarSiguientePalabra() {
  palabraActual = palabras[palabraIndex];
  letraIndex = 0;
  palabraSpan.textContent = palabraActual;
  letraEsperada.textContent = palabraActual[letraIndex];
  mensaje.textContent = "";
  ultimaLetraDetectada = null;
}

function iniciarJuego() {
  palabraIndex = 0;
  juegoEnCurso = true;
  tiempoInicio = Date.now();
  palabras.sort(() => Math.random() - 0.5); // Mezcla aleatoriamente las palabras
  iniciarSiguientePalabra();
}


document.getElementById("reiniciar-btn").addEventListener("click", iniciarJuego);
window.addEventListener("load", iniciarJuego);

// MediaPipe
const hands = new Hands({
  locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`,
});
hands.setOptions({
  maxNumHands: 1,
  modelComplexity: 1,
  minDetectionConfidence: 0.7,
  minTrackingConfidence: 0.5,
});
hands.onResults(onHandsResults);

const camera = new Camera(videoElement, {
  onFrame: async () => {
    await hands.send({ image: videoElement });
  },
  width: 640,
  height: 480,
});
camera.start();
