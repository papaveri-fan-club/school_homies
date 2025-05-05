<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --input-focus: #2d8cf0;
            --font-color: #323232;
            --font-color-sub: #666;
            --bg-color: beige;
            --main-color: black;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            color: #212529;
        }

        .registration-container {
            width: 100%;
            max-width: 500px;
            padding: 40px;
            background: lightblue;
            border-radius: 12px;
            box-shadow: 4px 4px var(--main-color);
            text-align: center;
            border: 2px solid var(--main-color);
        }

        .title {
            color: var(--font-color);
            font-weight: 900;
            font-size: 24px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--font-color);
        }

        .form-control, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--main-color);
            border-radius: 8px;
            background-color: var(--bg-color);
            box-shadow: 4px 4px var(--main-color);
            font-size: 15px;
            font-weight: 600;
            color: var(--font-color);
            transition: all 0.2s;
            box-sizing: border-box;
            outline: none;
        }

        .form-control::placeholder, .form-select::placeholder {
            color: var(--font-color-sub);
            opacity: 0.8;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--input-focus);
        }

        .register-button {
            padding: 14px 28px;
            background-color: var(--bg-color);
            color: var(--font-color);
            border: 2px solid var(--main-color);
            border-radius: 8px;
            box-shadow: 4px 4px var(--main-color);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 10px;
        }

        .register-button:hover {
            transform: translateY(-2px);
        }

        .register-button:active {
            box-shadow: 0px 0px var(--main-color);
            transform: translate(3px, 3px);
        }

        .login-text {
            margin-top: 25px;
            font-size: 14px;
            color: var(--font-color);
            font-weight: 500;
        }

        .login-link {
            color: var(--input-focus);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <div class="title">Registrazione nuovo utente</div>
        
        <form action="../priv/gestioneUtenti/newUser.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="surname" class="form-label">Cognome</label>
                <input type="text" class="form-control" id="surname" name="surname" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="user_type">Tipo Utente</label>
                <select class="form-select" name="user_type" id="user_type" required>
                    <option selected value="normale">Studente</option>
                    <option value="amministratore">Insegnante</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password" class="form-label">Conferma Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="register-button">Registrati</button>
        </form>

        <div class="login-text">
            Hai già un account? <a href="login.php" class="login-link">Accedi</a>
        </div>
    </div>

    <script>
    function validateForm() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        if (password !== confirmPassword) {
            alert("Le password non corrispondono.");
            return false;
        }
        return true;
    }
    </script>
</body>
</html>