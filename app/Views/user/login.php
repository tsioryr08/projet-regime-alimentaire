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
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        #loginForm {
            background: white;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #111827;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 35px;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
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
            border-color: #10b981;
            outline: none;
            box-shadow: 0 0 0 4px rgba(16,185,129,0.15);
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
            background: #fee2e2;
            border: 1px solid #ef4444;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 20px;
            color: #991b1b;
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
            background: #10b981;
            color: white;
        }

        button:hover {
            transform: translateY(-1px);
            background: #059669;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #6b7280;
            font-size: 14px;
        }

        .register-link a {
            color: #10b981;
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