<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione - School Homies</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Aggiorna i link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link al CSS per la pagina di registrazione -->
    <link rel="stylesheet" href="styles/registrazione.css">
    <link rel="stylesheet" href="styles/backgroundStyle.css"> 
    <link rel="stylesheet" href="styles/backgroundStyle.js"> 
    <link rel="stylesheet" href="styles/index.css">
</head>
<body>
    <div class="background-text" id="background-text">
        <!-- I contenuti delle righe saranno generati dinamicamente tramite JavaScript -->
    </div>

    <div class="registration-container">
        <div class="title">Registrazione</div>
        
        <form action="../priv/gestioneUtenti/newUser.php" method="POST" onsubmit="return validateForm()">
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

            <button type="submit" class="register-button">
                Registrati <span class="arrow-icon">→</span>
            </button>
        </form>

        <div class="login-text">
            Hai già un account? <a href="login.php" class="login-link">Accedi</a>
        </div>
    </div>

    <script>
        
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
        
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Se vuoi usare lo sfondo animato centralizzato, aggiungi: -->
    <script src="styles/backgroundStyle.js"></script> 
</body>
</html>