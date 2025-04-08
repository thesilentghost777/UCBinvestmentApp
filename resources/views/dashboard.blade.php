<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackathon | Ctrl+Alt+Elite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap');

        body {
            font-family: 'Share Tech Mono', monospace;
            background-color: #0a0a0a;
            color: #00ff41;
        }

        .matrix-text {
            position: absolute;
            color: #00ff41;
            font-size: 1.2em;
            opacity: 0.7;
            user-select: none;
        }

        .glitch {
            animation: glitch 1s linear infinite alternate;
        }

        @keyframes glitch {
            0% {
                text-shadow: 0.05em 0 0 rgba(255, 0, 0, 0.75), -0.05em -0.025em 0 rgba(0, 255, 0, 0.75), 0.025em 0.05em 0 rgba(0, 0, 255, 0.75);
            }
            100% {
                text-shadow: -0.05em 0 0 rgba(255, 0, 0, 0.75), 0.025em -0.05em 0 rgba(0, 255, 0, 0.75), -0.05em 0.025em 0 rgba(0, 0, 255, 0.75);
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center overflow-hidden relative">
    <div id="matrix-background" class="fixed top-0 left-0 w-full h-full z-0"></div>

    <div class="border-2 border-green-500 p-8 rounded bg-black bg-opacity-80 shadow-lg shadow-green-500/50 z-10">
        <div class="mb-6 text-center">
            <div class="flex justify-center mb-2">
                <i class="fas fa-shield-alt text-4xl mr-2 text-green-400"></i>
                <i class="fas fa-code text-4xl mr-2 text-green-400"></i>
                <i class="fas fa-terminal text-4xl text-green-400"></i>
            </div>
            <h1 class="text-4xl font-bold mb-2 text-green-400 glitch">WELCOME TO HACKATHON</h1>
            <div class="border-b-2 border-green-500 w-full mb-6"></div>
            <h2 class="text-3xl font-bold text-green-300">TEAM: <span class="text-green-400">CTRL+ALT+ELITE</span></h2>
            <p class="text-xl mt-4 typing-text">> LET'S HACK</p>
        </div>

        <div class="terminal bg-black text-green-400 p-4 border border-green-500 rounded">
            <p class="mb-2">> initializing terminal...</p>
            <p class="mb-2">> system check: complete</p>
            <p class="mb-2">> loading resources: complete</p>
            <p class="mb-2">> establishing secure connection...</p>
            <p class="mb-2">> access granted</p>
            <p class="mb-2">> welcome admin</p>
            <p class="flex items-center">
                <span class="mr-1">> _</span>
                <span class="w-2 h-5 bg-green-400 animate-pulse"></span>
            </p>
        </div>

        <div class="mt-8 grid grid-cols-3 gap-3">
            <div class="bg-black bg-opacity-60 p-3 border border-green-500 rounded text-center">
                <i class="fas fa-laptop-code text-2xl mb-2"></i>
                <p>CODE</p>
            </div>
            <div class="bg-black bg-opacity-60 p-3 border border-green-500 rounded text-center">
                <i class="fas fa-brain text-2xl mb-2"></i>
                <p>THINK</p>
            </div>
            <div class="bg-black bg-opacity-60 p-3 border border-green-500 rounded text-center">
                <i class="fas fa-rocket text-2xl mb-2"></i>
                <p>DEPLOY</p>
            </div>
        </div>
    </div>

    <footer class="fixed bottom-4 text-green-500 text-sm z-10">
        <div class="flex items-center">
            <i class="fas fa-lock mr-2"></i>
            <span>SECURE CONNECTION ESTABLISHED - {{ date('Y-m-d H:i:s') }}</span>
        </div>
    </footer>

    <script>
        // Matrix background effect
        document.addEventListener('DOMContentLoaded', function() {
            const background = document.getElementById('matrix-background');
            const width = window.innerWidth;
            const height = window.innerHeight;
            const characters = "01アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン";

            for (let i = 0; i < 100; i++) {
                setTimeout(() => {
                    const element = document.createElement('div');
                    element.className = 'matrix-text';
                    element.style.left = Math.random() * width + 'px';
                    element.style.top = Math.random() * height + 'px';
                    element.textContent = characters.charAt(Math.floor(Math.random() * characters.length));
                    background.appendChild(element);

                    let opacity = 1;
                    const interval = setInterval(() => {
                        opacity -= 0.02;
                        element.style.opacity = opacity;

                        if (opacity <= 0) {
                            clearInterval(interval);
                            background.removeChild(element);
                            createNewElement();
                        }
                    }, 100);
                }, i * 100);
            }

            function createNewElement() {
                const element = document.createElement('div');
                element.className = 'matrix-text';
                element.style.left = Math.random() * width + 'px';
                element.style.top = Math.random() * height + 'px';
                element.textContent = characters.charAt(Math.floor(Math.random() * characters.length));
                background.appendChild(element);

                let opacity = 1;
                const interval = setInterval(() => {
                    opacity -= 0.02;
                    element.style.opacity = opacity;

                    if (opacity <= 0) {
                        clearInterval(interval);
                        background.removeChild(element);
                        createNewElement();
                    }
                }, 100);
            }
        });
    </script>
</body>
</html>