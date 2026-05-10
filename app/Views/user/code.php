<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisir un code</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .header {
            background: #f59e0b;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .header p {
            opacity: 0.9;
        }

        .content {
            padding: 30px;
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
            border-color: #f59e0b;
            outline: none;
            box-shadow: 0 0 0 4px rgba(245,158,11,0.15);
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

        .success {
            background: #d1fae5;
            border: 1px solid #10b981;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 20px;
            color: #065f46;
            font-size: 14px;
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

        .button-row {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            flex: 1;
        }

        .btn-primary {
            background: #f59e0b;
            color: white;
        }

        .btn-primary:hover {
            background: #d97706;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #d1d5db;
            color: #111827;
        }

        .btn-secondary:hover {
            background: #9ca3af;
            transform: translateY(-1px);
        }

        .info {
            background: #fef3c7;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            color: #92400e;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Saisir un code</h1>
            <p>Entrez votre code pour gagner de l'argent</p>
        </div>

        <div class="content">
            <?php if(session()->has('success')): ?>
                <div class="success">
                    🎉 <?= session('success') ?>
                </div>
            <?php endif; ?>

            <?php if(session()->has('error')): ?>
                <div class="server-error">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>

            <div class="info">
                Les codes vous permettent d'ajouter des fonds à votre portefeuille.
                <br>Chaque code est unique et ne peut être utilisé qu'une seule fois.
            </div>

            <form method="post" action="<?= base_url('utilisateur/traiterCode') ?>">
                <div class="form-group">
                    <label>Code promo *</label>
                    <input type="text" name="code" value="<?= old('code') ?>">
                    <span class="error"><?= validation_show_error('code') ?></span>
                </div>

                <div class="button-row">
                    <a href="/utilisateur/profil" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-primary">Valider le code</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>