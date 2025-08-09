<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Camera Input</title>
</head>
<body>
    <video id="video" width="640" height="480" autoplay></video>
    <button id="snap">Snap Photo</button>
    <canvas id="canvas" width="640" height="480"></canvas>
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const constraints = {
            audio: false,
            video: {
                facingMode: { exact: "environment" }
            }
        };
        async function init() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                handleSuccess(stream);
            } catch (e) {
                console.error(e);
            }
        }
        function handleSuccess(stream) {
            window.stream = stream;
            video.srcObject = stream;
        }
        snap.addEventListener('click', function() {
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL();
            const link = document.createElement('a');
            link.download = 'photo.png';
            link.href = dataURL;
            link.click();
        });
        init();
    </script>
</body>
</html>

