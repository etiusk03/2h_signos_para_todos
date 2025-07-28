// lsvAbecedario.js

// Detecta si un dedo está extendido (comparando punta con articulación intermedia)
function dedoExtendido(landmarks, indices) {
  // Para dedos índice a meñique (verticales): la punta (índice 3) debe estar "más arriba" (menor y) que la articulación intermedia (índice 2)
  return landmarks[indices[3]].y < landmarks[indices[2]].y;
}

// Pulgar es horizontal, así que comparamos en x (asumiendo mano derecha)
function pulgarExtendido(landmarks) {
  if (!landmarks[4] || !landmarks[3]) return false;
  return landmarks[4].x < landmarks[3].x; // Esto es para mano derecha
}

// Pulgar doblado (no extendido)
function pulgarDoblado(landmarks) {
  return !pulgarExtendido(landmarks);
}

// Dedos doblados
function dedoDoblado(landmarks, indices) {
  return !dedoExtendido(landmarks, indices);
}

function distancia(p1, p2) {
  return Math.sqrt(
    Math.pow(p1.x - p2.x, 2) +
    Math.pow(p1.y - p2.y, 2) +
    Math.pow(p1.z - p2.z, 2)
  );
}

function dedoTocaPalma(landmarks, puntaDedo, centroPalma) {
  if (!landmarks[puntaDedo] || !landmarks[centroPalma]) return false;
  return distancia(landmarks[puntaDedo], landmarks[centroPalma]) < 0.07;
}


// Letra A (funciona esta logica)
function señaA(landmarks) {
  if (!landmarks) return false;

  const distancia = (a, b) => {
    return Math.sqrt(
      Math.pow(landmarks[a].x - landmarks[b].x, 2) +
      Math.pow(landmarks[a].y - landmarks[b].y, 2)
    );
  };

  // Verificar que índice toque su base (8 cerca de 1)
  const indiceDoblado = distancia(8, 1) < 0.10;

  // Verificar que medio, anular y meñique toquen palma (12, 16, 20 cerca de 0)
  const medioEnPalma = distancia(12, 0) < 0.10;
  const anularEnPalma = distancia(16, 0) < 0.10;
  const meniqueEnPalma = distancia(20, 0) < 0.10;

  // Pulgar extendido (punto 4 lejos del punto 0)
  const pulgarExtendido = distancia(4, 0) > 0.15;


  return (
    indiceDoblado &&
    medioEnPalma &&
    anularEnPalma &&
    meniqueEnPalma &&
    pulgarExtendido
  );
}

// Letra B (Funciona su logica)
function señaB(landmarks) {
  // Mano abierta, dedos juntos y estirados, pulgar cruzado sobre la palma
  const dedosExtendidos = 
    dedoExtendido(landmarks, [5,6,7,8]) &&
    dedoExtendido(landmarks, [9,10,11,12]) &&
    dedoExtendido(landmarks, [13,14,15,16]) &&
    dedoExtendido(landmarks, [17,18,19,20]);
  
  // Pulgar cruzado: la punta del pulgar (4) está a la derecha del punto 0 (palma)
  const pulgarCruzado = landmarks[4].x > landmarks[0].x;
  
  return dedosExtendidos && pulgarCruzado;
}

// Letra C (Funciona su logica)
function señaC(landmarks) {
  // Mano en forma de "C": dedos y pulgar curvados, separados formando "C"
  // Simplificación: Distancia entre punta pulgar y punta índice relativamente cerca
  const distanciaPulgarIndice = Math.hypot(
    (landmarks[4].x - landmarks[8].x),
    (landmarks[4].y - landmarks[8].y)
  );
  // Distancia entre punta índice y medio
  const distanciaIndiceMedio = Math.hypot(
    (landmarks[8].x - landmarks[12].x),
    (landmarks[8].y - landmarks[12].y)
  );
  
  // Para la C, distancia pulgar-índice debe ser menor que índice-medio
  // Y dedos no totalmente extendidos (menos que en B)
  const dedosNoMuyExtendidos = 
    !dedoExtendido(landmarks, [5,6,7,8]) &&
    !dedoExtendido(landmarks, [9,10,11,12]) &&
    !dedoExtendido(landmarks, [13,14,15,16]) &&
    !dedoExtendido(landmarks, [17,18,19,20]);

  return distanciaPulgarIndice < distanciaIndiceMedio && dedosNoMuyExtendidos;
}

// Letra D (Funciona su logica)
function señaD(landmarks) {
  // Dedo índice extendido, medio doblado tocando pulgar, anular y meñique doblados, pulgar tocando punta dedo medio
  const indiceExt = dedoExtendido(landmarks, [5,6,7,8]);
  const medioDob = dedoDoblado(landmarks, [9,10,11,12]);
  const anularDob = dedoDoblado(landmarks, [13,14,15,16]);
  const meniqueDob = dedoDoblado(landmarks, [17,18,19,20]);
  
  // Pulgar tocando punta dedo medio: distancia pulgar punta (4) y medio punta (12) pequeña
  const distanciaPulgarMedio = Math.hypot(
    (landmarks[4].x - landmarks[12].x),
    (landmarks[4].y - landmarks[12].y)
  );
  
  return indiceExt && medioDob && anularDob && meniqueDob && distanciaPulgarMedio < 0.05;
}

// Letra E (Funciona con sus pequeños detalles)
function señaE(landmarks, umbral = 0.05) {
  if (!landmarks || landmarks.length < 21) return false;

  // Calcula distancia 2D
  const distancia2D = (i, j) =>
    Math.hypot(landmarks[i].x - landmarks[j].x, landmarks[i].y - landmarks[j].y);

  const cerca = (i, j, tol = umbral) => distancia2D(i, j) < tol;

  // Dedo índice curvado: punta 8 cerca de base 5
  const indiceCurvado = cerca(8, 5, umbral * 1.2);
  const medioCurvado = cerca(12, 9, umbral * 1.2);
  const anularCurvado = cerca(16, 13, umbral * 1.2);
  const meniqueCurvado = cerca(20, 17, umbral * 1.2);
  const pulgarTocaIndice = cerca(4, 8, umbral * 0.8);

  return (
    indiceCurvado &&
    medioCurvado &&
    anularCurvado &&
    meniqueCurvado &&
    pulgarTocaIndice
  );
}

// Letra F (Funciona bien, se deja)
function señaF(landmarks) {
  // Pulgar e índice formando círculo (como "OK"), otros tres dedos extendidos y separados
  // Verificar distancia entre punta pulgar (4) y punta índice (8) pequeña
  const distanciaPulgarIndice = Math.hypot(
    (landmarks[4].x - landmarks[8].x),
    (landmarks[4].y - landmarks[8].y)
  );
  
  // Dedos medio, anular y meñique extendidos
  const medioExt = dedoExtendido(landmarks, [9,10,11,12]);
  const anularExt = dedoExtendido(landmarks, [13,14,15,16]);
  const meniqueExt = dedoExtendido(landmarks, [17,18,19,20]);
  
  // Distancia pequeña para círculo
  const circuloFormado = distanciaPulgarIndice < 0.05;
  
  return circuloFormado && medioExt && anularExt && meniqueExt;
}

// Letra G (Funciona bien, se deja)
function señaG(landmarks) {
  if (!landmarks || landmarks.length < 21) return false;

  const umbral = 0.09; // Puedes ajustar este valor si detecta de más o de menos

  const cerca = (p1, p2) => {
    return distancia(landmarks[p1], landmarks[p2]) < umbral;
  };

  const medioDob = cerca(6, 10); // base del índice cerca de la falange media del medio
  const pulgarIndiceParalelo = cerca(3, 11); // base del pulgar cerca del dedo medio

  return medioDob && pulgarIndiceParalelo;
}

//NO DETECTA H

/*
function señaH(landmarks) {
  const umbral = 0.05;

  const indiceExt = dedoExtendido(landmarks, [5,6,7,8]);
  const medioExt = dedoExtendido(landmarks, [9,10,11,12]);
  const juntos = distancia(landmarks[8], landmarks[12]) < umbral;

  const anularDob = dedoDoblado(landmarks, [13,14,15,16]);
  const meniqueDob = dedoDoblado(landmarks, [17,18,19,20]);
  const pulgarDob = distancia(landmarks[4], landmarks[0]) < 0.06;

  return indiceExt && medioExt && juntos && anularDob && meniqueDob && pulgarDob;
}
*/

//Ya la detecta bien
function señaI(landmarks) {
  // Meñique extendido
  const meniqueExt = dedoExtendido(landmarks, [17, 18, 19, 20]);

  // Índice, medio y anular doblados
  const indiceDob = dedoDoblado(landmarks, [5, 6, 7, 8]);
  const medioDob = dedoDoblado(landmarks, [9, 10, 11, 12]);
  const anularDob = dedoDoblado(landmarks, [13, 14, 15, 16]);

  // Pulgar doblado (punta cerca de la palma/base)
  const distanciaPulgarPalma = distancia(landmarks[4], landmarks[0]);

  const pulgarDob = distanciaPulgarPalma < 0.30;

  return meniqueExt && indiceDob && medioDob && anularDob && pulgarDob;
}


function señaL(landmarks) {
  if (!landmarks || landmarks.length < 21) return false;

  const umbralDistancia = 0.12;
  const umbralDob = 0.04;

  const indiceExt = dedoExtendido(landmarks, [5,6,7,8]);
  const pulgarExt = pulgarExtendido(landmarks);

  // Pulgar e índice deben estar bien separados, formando ángulo de L
  const distanciaPulgarIndice = distancia(landmarks[4], landmarks[8]);
  const anguloL = distanciaPulgarIndice > umbralDistancia;

  // Resto de dedos bien doblados
  const medioDob = distancia(landmarks[12], landmarks[9]) < umbralDob;
  const anularDob = distancia(landmarks[16], landmarks[13]) < umbralDob;
  const meniqueDob = distancia(landmarks[20], landmarks[17]) < umbralDob;

  return indiceExt && pulgarExt && anguloL && medioDob && anularDob && meniqueDob;
}



//Funciona pero es algo conflictiva con N
function señaM(landmarks) {
  const umbral = 0.13;

  const indiceDob = dedoDoblado(landmarks, [5,6,7,8]);
  const medioDob = dedoDoblado(landmarks, [9,10,11,12]);
  const anularDob = dedoDoblado(landmarks, [13,14,15,16]);
  const meniqueDob = dedoDoblado(landmarks, [17,18,19,20]);

  const pulgarBajoMedios = (
    distancia(landmarks[4], landmarks[6]) < umbral &&
    distancia(landmarks[4], landmarks[10]) < umbral &&
    distancia(landmarks[4], landmarks[14]) < umbral
  );

  // El meñique no debe estar completamente doblado hacia la palma como en la N
  const meniqueNoTanDob = distancia(landmarks[20], landmarks[17]) > 0.02;

  return indiceDob && medioDob && anularDob && meniqueDob && pulgarBajoMedios && meniqueNoTanDob;
}



//Letra N (funciona)
function señaN(landmarks) {
  const umbral = 0.16;

  const indiceDob = dedoDoblado(landmarks, [5,6,7,8]);
  const medioDob = dedoDoblado(landmarks, [9,10,11,12]);
  const anularDob = dedoDoblado(landmarks, [13,14,15,16]);
  const meniqueDob = dedoDoblado(landmarks, [17,18,19,20]);

  const pulgarBajoDos = (
    distancia(landmarks[4], landmarks[6]) < umbral &&
    distancia(landmarks[4], landmarks[10]) < umbral &&
    distancia(landmarks[4], landmarks[14]) > umbral // ← el anular no está encima del pulgar
  );

  return indiceDob && medioDob && anularDob && meniqueDob && pulgarBajoDos;
}



// Exportar todas las letras
export const lsvSeñas = {
  A: señaA,
  B: señaB,
  C: señaC,
  D: señaD,
  E: señaE,
  F: señaF,
  G: señaG,
  //H: señaH,
  I: señaI,
  L: señaL,
  M: señaM,
  N: señaN,
};
