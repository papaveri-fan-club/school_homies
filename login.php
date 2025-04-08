<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
        <body>
            <div class="container">
                <div class="logo-container"></div>
                <h4>Login</h4>
                <form action="gestioneUtenti/loginUser.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>


                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>


                    <button type="submit" class="btn btn-primary">Accedi</button>
                </form>


                <p>Non hai un account? <a href="registrazione.php">Registrati</a></p>
            </div>


        </body>
</html>


    <style>

        .logo-container {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 2px solid black;
            background-image: url('./Media/galileo-5bf2ecef46e0fb005117b4e3.png');
            background-size: cover;
            background-position: center;
            margin: 0 auto 20px auto;
            position: relative;
            z-index: 10;
            box-sizing: border-box;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, rgb(0, 155, 244),rgb(242, 0, 0));
        }


        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            width: 350px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }


        h4 {
            color: #333;
            font-size: 22px;
            margin-bottom: 20px;
        }


        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }


        button {
            width: 100%;
            padding: 10px;
            background: #6a00f4;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }


        button:hover {
            background: #5a00e4;
        }


        .alert-danger {
            color: #f00;
            background: #ffcccc;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }


        p a {
            margin-bottom: 10px;
            padding: 10px;
            text-decoration: none;
            color: #6a00f4;
            font-weight: bold;
        }


        p a:hover {
            text-decoration: underline;
        }
    </style>


<?php include "./include/end.inc"; ?>

