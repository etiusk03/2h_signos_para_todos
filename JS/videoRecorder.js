let mediaRecorder;
let recordedChunks = [];
let isVideoReady = false;

const startBtn = document.getElementById('startRecord');
const stopBtn = document.getElementById('stopRecord');
const preview = document.getElementById('preview');
const videoBase64Input = document.getElementById('video_base64');
const form = document.querySelector("form");

startBtn.onclick = async () => {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        preview.srcObject = stream;

        recordedChunks = [];
        isVideoReady = false;

        mediaRecorder = new MediaRecorder(stream, { mimeType: 'video/webm' });

        mediaRecorder.ondataavailable = (e) => {
            if (e.data.size > 0) recordedChunks.push(e.data);
        };

        mediaRecorder.onstop = () => {
            const blob = new Blob(recordedChunks, { type: 'video/webm' });
            const reader = new FileReader();
            reader.onloadend = () => {
                videoBase64Input.value = reader.result;
                isVideoReady = true;
                console.log("🎥 Video listo y codificado.");
            };
            reader.readAsDataURL(blob);
        };

        mediaRecorder.start();
        startBtn.disabled = true;
        stopBtn.disabled = false;

    } catch (err) {
        alert("❌ Error al acceder a la cámara: " + err.message);
    }
};

stopBtn.onclick = () => {
    if (mediaRecorder && mediaRecorder.state !== "inactive") {
        mediaRecorder.stop();
        startBtn.disabled = false;
        stopBtn.disabled = true;
    }
};

form.addEventListener("submit", function (e) {
    const fileInput = document.querySelector("input[name='video_file']");
    const isFileUploaded = fileInput && fileInput.files.length > 0;

    if (!isFileUploaded && !isVideoReady) {
        e.preventDefault();
        alert("⏳ Por favor espera a que termine la grabación antes de guardar.");
    }
});
