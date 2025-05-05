<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background: lightblue;
            border-radius: 12px;
            box-shadow: 4px 4px var(--main-color);
            text-align: center;
            border: 2px solid var(--main-color);
        }

        .welcome-text {
            color: var(--font-color);
            font-weight: 900;
            font-size: 24px;
            margin-bottom: 8px;
        }

        .subtext {
            color: var(--font-color-sub);
            font-weight: 600;
            font-size: 17px;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 24px;
            text-align: left;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--font-color);
        }

        .form-control {
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

        .form-control::placeholder {
            color: var(--font-color-sub);
            opacity: 0.8;
        }

        .form-control:focus {
            border-color: var(--input-focus);
        }

        .login-button {
            width: 100%;
            padding: 14px;
            background-color: var(--bg-color);
            color: var(--font-color);
            border: 2px solid var(--main-color);
            border-radius: 8px;
            box-shadow: 4px 4px var(--main-color);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }

        .login-button:hover {
            transform: translateY(-2px);
        }

        .login-button:active {
            box-shadow: 0px 0px var(--main-color);
            transform: translate(3px, 3px);
        }

        .social-login {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }

        .social-btn {
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 100%;
            border: 2px solid var(--main-color);
            background-color: var(--bg-color);
            box-shadow: 4px 4px var(--main-color);
            color: var(--font-color);
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.2s;
        }

        .social-btn:active {
            box-shadow: 0px 0px var(--main-color);
            transform: translate(3px, 3px);
        }

        .icon {
            width: 24px;
            height: 24px;
            fill: var(--main-color);
        }

        .register-text {
            margin-top: 30px;
            font-size: 14px;
            color: var(--font-color);
            font-weight: 500;
        }

        .register-link {
            color: var(--input-focus);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        .arrow-icon {
            transition: transform 0.2s;
        }

        .login-button:hover .arrow-icon {
            transform: translateX(3px);
        }
    </style>
</head>
<body>
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

            <div class="social-login">
                <div class="social-btn"><b>t</b></div>
                <div class="social-btn">
                    <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="24px" viewBox="0 0 56.6934 56.6934" version="1.1" style="enable-background:new 0 0 56.6934 56.6934;" id="Layer_1" height="24px" class="icon"><path d="M51.981,24.4812c-7.7173-0.0038-15.4346-0.0019-23.1518-0.001c0.001,3.2009-0.0038,6.4018,0.0019,9.6017  c4.4693-0.001,8.9386-0.0019,13.407,0c-0.5179,3.0673-2.3408,5.8723-4.9258,7.5991c-1.625,1.0926-3.492,1.8018-5.4168,2.139  c-1.9372,0.3306-3.9389,0.3729-5.8713-0.0183c-1.9651-0.3921-3.8409-1.2108-5.4773-2.3649  c-2.6166-1.8383-4.6135-4.5279-5.6388-7.5549c-1.0484-3.0788-1.0561-6.5046,0.0048-9.5805  c0.7361-2.1679,1.9613-4.1705,3.5708-5.8002c1.9853-2.0324,4.5664-3.4853,7.3473-4.0811c2.3812-0.5083,4.8921-0.4113,7.2234,0.294  c1.9815,0.6016,3.8082,1.6874,5.3044,3.1163c1.5125-1.5039,3.0173-3.0164,4.527-4.5231c0.7918-0.811,1.624-1.5865,2.3908-2.4196  c-2.2928-2.1218-4.9805-3.8274-7.9172-4.9056C32.0723,4.0363,26.1097,3.995,20.7871,5.8372  C14.7889,7.8907,9.6815,12.3763,6.8497,18.0459c-0.9859,1.9536-1.7057,4.0388-2.1381,6.1836  C3.6238,29.5732,4.382,35.2707,6.8468,40.1378c1.6019,3.1768,3.8985,6.001,6.6843,8.215c2.6282,2.0958,5.6916,3.6439,8.9396,4.5078  c4.0984,1.0993,8.461,1.0743,12.5864,0.1355c3.7284-0.8581,7.256-2.6397,10.0725-5.24c2.977-2.7358,5.1006-6.3403,6.2249-10.2138  C52.5807,33.3171,52.7498,28.8064,51.981,24.4812z"></path></svg>
                </div>
                <div class="social-btn">
                    <svg class="icon" height="24px" id="Layer_1" version="1.1" viewBox="0 0 56.693 56.693" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M40.43,21.739h-7.645v-5.014c0-1.883,1.248-2.322,2.127-2.322c0.877,0,5.395,0,5.395,0V6.125l-7.43-0.029  c-8.248,0-10.125,6.174-10.125,10.125v5.518h-4.77v8.53h4.77c0,10.947,0,24.137,0,24.137h10.033c0,0,0-13.32,0-24.137h6.77  L40.43,21.739z"></path></svg>
                </div>
            </div>

            <button type="submit" class="login-button">
                Let's go <span class="arrow-icon">→</span>
            </button>
        </form>

        <div class="register-text">
            Non hai un account? <a href="registrazione.php" class="register-link">Registrati</a>
        </div>
    </div>
</body>
</html>