<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School Homies</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link al tuo CSS personalizzato per il login -->
    <link rel="stylesheet" href="styles/login.css"> 
    <!-- Link al CSS dello sfondo animato -->
    <link rel="stylesheet" href="styles/backgroundStyle.css"> 
    <link rel="stylesheet" href="styles/index.css"> 
</head>
<body>
    <!-- Sfondo con testo a mattoni -->
    <div class="background-text" id="background-text">
        <!-- I contenuti delle righe saranno generati dinamicamente tramite JavaScript -->
    </div>

    <div class="login-container">
        <div class="welcome-text">Welcome,</div>
        <div class="subtext">sign up to continue</div>
        
        <form action="../priv/gestioneUtenti/loginUser.php" method="POST">
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

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script per l'animazione dello sfondo -->
    <script src="styles/backgroundStyle.js"></script> <!-- CORRETTO: Percorso a backgroundStyle.js -->
</body>
</html>
