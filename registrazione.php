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
        
        /* Container registrazione con sfondo bianco garantito */
        .registration-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 400px;
            max-width: 90%;
            position: relative;
            z-index: 10;
            margin: 20px;
        }
        
        .title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
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
        
        .form-control, .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
            background-color: #fff;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .register-button {
            width: 100%;
            padding: 14px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .register-button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .login-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        
        .login-link {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .login-link:hover {
            color: #1a5276;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Sfondo animato completo -->
    <div class="background-text">
        <!-- 10 righe di testo SCHOOL HOMIES -->
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
        </div>
        <!-- Ripeti per altre 9 righe -->
        <!-- ... (inserisci qui le altre 9 righe identiche) ... -->
    </div>

    <!-- Form di registrazione con sfondo bianco -->
    <div class="registration-container">
        <div class="title">Registrazione nuovo utente</div>
        
        <form action="gestioneUtenti/newUser.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="La tua email">
            </div>

            <div class="form-group">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name" required placeholder="Il tuo nome">
            </div>
            
            <div class="form-group">
                <label for="surname" class="form-label">Cognome</label>
                <input type="text" class="form-control" id="surname" name="surname" required placeholder="Il tuo cognome">
            </div>

            <div class="form-group">
                <label class="form-label" for="user_type">Tipo Utente</label>
                <select class="form-select" name="user_type" id="user_type" required>
                    <option value="" disabled selected>Seleziona...</option>
                    <option value="normale">Studente</option>
                    <option value="amministratore">Insegnante</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Crea una password">
            </div>

            <div class="form-group">
                <label for="confirm_password" class="form-label">Conferma Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="Conferma la password">
            </div>

            <button type="submit" class="register-button">Registrati</button>
        </form>

        <div class="login-text">
            Hai già un account? <a href="login.php" class="login-link">Accedi</a>
        </div>
    </div>

    <script>
        // Aggiunge righe dinamiche per coprire tutto lo schermo
        function addMoreTextRows() {
            const backgroundText = document.querySelector('.background-text');
            const windowHeight = window.innerHeight;
            const rowHeight = 60;
            const rowsNeeded = Math.ceil(windowHeight / rowHeight);
            const currentRows = document.querySelectorAll('.text-row').length;
            
            if (rowsNeeded > currentRows) {
                const rowToClone = document.querySelector('.text-row');
                for (let i = currentRows; i < rowsNeeded; i++) {
                    const newRow = rowToClone.cloneNode(true);
                    backgroundText.appendChild(newRow);
                }
            }
        }
        
        // Validazione password
        function validateForm() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            
            if (password !== confirmPassword) {
                alert("Le password non corrispondono!");
                return false;
            }
            
            if (password.length < 8) {
                alert("La password deve contenere almeno 8 caratteri!");
                return false;
            }
            
            return true;
        }

        // Inizializzazione
        window.addEventListener('load', () => {
            addMoreTextRows();
        });
        
        window.addEventListener('resize', addMoreTextRows);
    </script>
</body>
</html>