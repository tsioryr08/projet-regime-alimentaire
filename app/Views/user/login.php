<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Raleway, sans-serif;
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(244, 198, 214, 0.35) 0%, rgba(244, 198, 214, 0) 34%),
                radial-gradient(circle at bottom right, rgba(169, 205, 177, 0.30) 0%, rgba(169, 205, 177, 0) 38%),
                linear-gradient(135deg, #fbfcfb 0%, #fff7fa 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        #loginForm {
            background: linear-gradient(180deg, rgba(255,255,255,0.96) 0%, rgba(255,248,251,0.96) 100%);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 22px;
            box-shadow: 0 20px 50px rgba(119, 96, 111, 0.12);
            border: 1px solid rgba(244, 198, 214, 0.26);
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #2f4f3f;
        }

        .subtitle {
            text-align: center;
            color: #7a6a66;
            margin-bottom: 35px;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #4b5f52;
            font-size: 14px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            transition: 0.2s;
        }

        input:focus {
            border-color: #a9cdb1;
            outline: none;
            box-shadow: 0 0 0 4px rgba(244,198,214,0.18);
        }

        input.invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .error {
            color: #ef4444;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .server-error {
            background: linear-gradient(135deg, rgba(244, 198, 214, 0.26) 0%, rgba(255, 241, 245, 0.95) 100%);
            border: 1px solid rgba(201, 132, 161, 0.24);
            border-radius: 14px;
            padding: 12px;
            margin-bottom: 20px;
            color: #8b4c63;
            font-size: 14px;
        }

        button {
            width: 100%;
            border: none;
            padding: 13px 22px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: 0.2s;
            background: linear-gradient(135deg, #a9cdb1 0%, #89b69e 100%);
            color: #234031;
        }

        button:hover {
            transform: translateY(-1px);
            background: linear-gradient(135deg, #9fc8aa 0%, #7ead95 100%);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #7a6a66;
            font-size: 14px;
        }

        .register-link a {
            color: #7b4e63;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<form id="loginForm" method="post" action="<?= base_url('utilisateur/login') ?>">

    <h1>Connexion</h1>
    <p class="subtitle">Connectez-vous à votre compte</p>

    <?php if(session()->has('error')): ?>
        <div class="server-error">
            <?= session('error') ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label>Email *</label>
        <input type="email" name="email" placeholder="email@example.com" value="<?= old('email') ?>">
        <span class="error" data-field="email"><?= validation_show_error('email') ?></span>
    </div>

    <div class="form-group">
        <label>Mot de passe *</label>
        <input type="password" name="password" placeholder="******">
        <span class="error" data-field="password"><?= validation_show_error('password') ?></span>
    </div>

    <button type="submit">Se connecter</button>

    <div class="register-link">
        Pas encore de compte ? <a href="/utilisateur/register">Créer un compte</a>
    </div>

</form>

 <script src="<?= base_url('js/validation_login.js') ?>"></script>


</body>
</html>
