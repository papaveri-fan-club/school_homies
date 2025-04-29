<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(rgb(134, 47, 216), rgb(13, 159, 216));
            position: relative;
            overflow: hidden;
        }
        
        /* Stile per lo sfondo con testo a mattoni */
        .background-text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .text-row {
            position: relative;
            height: 50px;
            margin-bottom: 10px;
            display: flex;
            white-space: nowrap;
            color: #333;
        }
        
        .text-row:nth-child(odd) {
            animation-name: scrollLeft;
            animation-duration: 60s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }
        
        .text-row:nth-child(even) {
            animation-name: scrollRight;
            animation-duration: 60s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }
        
        .brick {
            display: inline-block;
            padding: 5px 20px;
            margin: 0 10px;
            background-color: rgba(200, 200, 200, 0.1); /* Sfondo invariato */
            border: 1px solid rgba(200, 200, 200, 0.2); /* Bordo invariato */
            border-radius: 4px;
            color: rgba(100, 100, 100, 0.3); /* Aumentata l'opacità del testo */
            font-weight: 600;
            font-size: 30px;
            text-transform: uppercase;
        }
        
        @keyframes scrollLeft {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        @keyframes scrollRight {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0); }
        }
        
        /* Stile container login */
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 360px;
            max-width: 90%;
            position: relative;
            z-index: 1;
        }
        
        .welcome-text {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }
        
        .subtext {
            font-size: 14px;
            color: #777;
            margin-bottom: 25px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-size: 12px;
            color: #555;
            margin-bottom: 6px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color:rgb(13, 159, 216);
            outline: none;
        }
        
        .social-login {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 25px 0;
        }
        
        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .social-btn:hover {
            background-color: #e8e8e8;
        }
        
        .icon {
            fill: #555;
            width: 18px;
            height: 18px;
        }
        
        .login-button {
            width: 100%;
            padding: 14px;
            background-color:rgb(13, 159, 216);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-button:hover {
            background-color: #2980b9;
        }
        
        .arrow-icon {
            margin-left: 8px;
        }
        
        .register-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        
        .register-link {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link:hover {
            text-decoration: underline;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
        }
    </style>
</head>
<body>
    <!-- Sfondo con testo a mattoni -->
    <div class="background-text">
        <div class="text-row">
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
        </div>
        <div class="text-row">
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
        </div>
        <div class="text-row">
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
        </div>
        <div class="text-row">
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
        </div>
        <div class="text-row">
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
        </div>
        <div class="text-row">
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
        </div>
        <div class="text-row">
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
        </div>
        <div class="text-row">
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
        </div>
        <div class="text-row">
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
        </div>
        <div class="text-row">
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
            <span class="brick">SCHOOL HOMIES</span>
        </div>
    </div>

    <div class="login-container">
        <!-- Riquadro per il logo -->
        <div class="logo-container">
            <img src="path/to/logo.png" alt="Logo" class="logo">
        </div>
        
        <div class="welcome-text">Welcome to School Homies!</div>
        <div class="subtext">sign up to continue</div>
        
        <form action="gestioneUtenti/loginUser.php" method="POST">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="login-button">
                Let's go <span class="arrow-icon">→</span>
            </button>
        </form>

        <div class="register-text">
            Non hai un account? <a href="registrazione.php" class="register-link">Registrati</a>
        </div>
    </div>

    <script>
        // Aggiunge più righe di testo dinamicamente per coprire lo schermo
        function addMoreTextRows() {
            const backgroundText = document.querySelector('.background-text');
            const windowHeight = window.innerHeight;
            const rowHeight = 50; // Altezza di una riga + margine
            const rowsNeeded = Math.ceil(windowHeight / rowHeight) + 2;
            const currentRows = document.querySelectorAll('.text-row').length;
            
            if (rowsNeeded > currentRows) {
                const rowToClone = document.querySelector('.text-row');
                for (let i = currentRows; i < rowsNeeded; i++) {
                    const newRow = rowToClone.cloneNode(true);
                    backgroundText.appendChild(newRow);
                }
            }
        }
        
        // Esegui la funzione al caricamento e al ridimensionamento della finestra
        window.addEventListener('load', addMoreTextRows);
        window.addEventListener('resize', addMoreTextRows);
    </script>
</body>
</html>