<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte</title>

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
                radial-gradient(circle at bottom right, rgba(169, 205, 177, 0.28) 0%, rgba(169, 205, 177, 0) 38%),
                linear-gradient(135deg, #fbfcfb 0%, #fff7fa 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        #regForm {
            background: linear-gradient(180deg, rgba(255,255,255,0.96) 0%, rgba(255,248,251,0.96) 100%);
            width: 100%;
            max-width: 650px;
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

        .tab {
            display: none;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #4b5f52;
            font-size: 14px;
            font-weight: 600;
        }

        input,
        select {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            transition: 0.2s;
        }

        input:focus,
        select:focus {
            border-color: #a9cdb1;
            outline: none;
            box-shadow: 0 0 0 4px rgba(244, 198, 214, 0.18);
        }

        input.invalid,
        select.invalid {
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

        .server-error ul {
            margin-left: 20px;
            margin-top: 5px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .button-row {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        button {
            border: none;
            padding: 12px 22px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
            transition: 0.2s;
        }

        button:hover {
            transform: translateY(-1px);
        }

        #prevBtn {
            background: linear-gradient(135deg, #f4c6d6 0%, #efc2d3 100%);
            color: #6e4055;
        }

        #nextBtn {
            background: linear-gradient(135deg, #a9cdb1 0%, #89b69e 100%);
            color: #234031;
        }

        .steps {
            text-align: center;
            margin-top: 35px;
        }

        .step {
            height: 12px;
            width: 12px;
            margin: 0 5px;
            background-color: #f0c9d8;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
            transition: 0.3s;
        }

        .step.active {
            opacity: 1;
            background-color: #89b69e;
            transform: scale(1.2);
        }

        .step.finish {
            background-color: #a9cdb1;
            opacity: 1;
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

        @media(max-width: 600px) {
            .grid {
                grid-template-columns: 1fr;
            }

            #regForm {
                padding: 25px;
            }
        }
    </style>
    <script defer src="<?= base_url('js/mdp.js') ?>"></script>
</head>

<body>

    <form id="regForm" method="post" action="<?= base_url('utilisateur/register') ?>">

        <?php if (session()->has('errors')): ?>
            <div class="server-error">
                <ul>
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="tab">
            <h1>Creer un compte</h1>
            <p class="subtitle">Informations personnelles</p>

            <div class="grid">
                <div class="form-group">
                    <label>Nom *</label>
                    <input type="text" name="nom" placeholder="Rakoto" value="<?= old('nom') ?>">
                    <span class="error" data-field="nom"><?= validation_show_error('nom') ?></span>
                </div>

                <div class="form-group">
                    <label>Prénom *</label>
                    <input type="text" name="prenom" placeholder="Jean" value="<?= old('prenom') ?>">
                    <span class="error" data-field="prenom"><?= validation_show_error('prenom') ?></span>
                </div>
            </div>

            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" placeholder="email@example.com" value="<?= old('email') ?>">
                <span class="error" data-field="email"><?= validation_show_error('email') ?></span>
            </div>

            <div class="grid">
                <div class="form-group" style="position: relative">
                   <label>Mot de passe *</label>
                    <input type="password" name="password" placeholder="******">
                    <span class="error" data-field="password"><?= validation_show_error('password') ?></span>
                    <small style="color: #6b7280;">Minimum 6 caracteres</small>
                </div>

                <div class="form-group">
                    <label>Genre *</label>
                    <select name="genre">
                        <option value="">Choisir</option>
                        <option value="homme" <?= old('genre') == 'homme' ? 'selected' : '' ?>>Homme</option>
                        <option value="femme" <?= old('genre') == 'femme' ? 'selected' : '' ?>>Femme</option>
                    </select>
                    <span class="error" data-field="genre"><?= validation_show_error('genre') ?></span>
                </div>
            </div>

            <div class="form-group">
                <label>Date de naissance *</label>
                <input type="date" name="date_naissance" value="<?= old('date_naissance') ?>">
                <span class="error" data-field="date_naissance"><?= validation_show_error('date_naissance') ?></span>
            </div>
        </div>

        <div class="tab">
            <h1>Profil physique</h1>
            <p class="subtitle">Aidez-nous a personnaliser votre experience</p>

            <div class="grid">
                <div class="form-group">
                    <label>Taille (cm) *</label>
                    <input type="number" step="0.01" name="taille" placeholder="160" value="<?= old('taille') ?>">
                    <span class="error" data-field="taille"><?= validation_show_error('taille') ?></span>
                </div>

                <div class="form-group">
                    <label>Poids (kg) *</label>
                    <input type="number" step="0.01" name="poids" placeholder="70" value="<?= old('poids') ?>">
                    <span class="error" data-field="poids"><?= validation_show_error('poids') ?></span>
                </div>
            </div>

            <div class="form-group">
                <label>Objectif *</label>
                <select name="objectif">
                    <option value="">Choisir un objectif</option>
                    <option value="augmenter_poids" <?= old('objectif') == 'augmenter_poids' ? 'selected' : '' ?>>Augmenter le poids</option>
                    <option value="reduire_poids" <?= old('objectif') == 'reduire_poids' ? 'selected' : '' ?>>Réduire le poids</option>
                    <option value="imc_ideal" <?= old('objectif') == 'imc_ideal' ? 'selected' : '' ?>>IMC idéal</option>
                </select>
                <span class="error" data-field="objectif"><?= validation_show_error('objectif') ?></span>
            </div>
        </div>

        <div class="button-row">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Precedent</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Suivant</button>
        </div>

        <div class="steps">
            <span class="step"></span>
            <span class="step"></span>
        </div>
        <div class="register-link">
            Vous avez deja un compte ? <a href="/utilisateur/login">connecter-vous</a>
        </div>

    </form>
    <script src="<?= base_url('js/validation_register.js') ?>"></script>
    

</body>

</html>
