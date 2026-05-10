<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil</title>
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
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .header {
            background: #10b981;
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

        .info-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-section h3 {
            color: #10b981;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .info-row {
            display: flex;
            margin-bottom: 12px;
        }

        .info-label {
            width: 140px;
            font-weight: 600;
            color: #374151;
        }

        .info-value {
            flex: 1;
            color: #111827;
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
        }

        .btn-primary {
            background: #10b981;
            color: white;
        }

        .btn-primary:hover {
            background: #059669;
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

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        @media (max-width: 600px) {
            .content {
                padding: 20px;
            }
            .info-row {
                flex-direction: column;
            }
            .info-label {
                margin-bottom: 5px;
            }
            .button-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Mon profil</h1>
            <p>Bienvenue <?= esc($user['prenom']) ?> !</p>
        </div>

        <div class="content">
            <div class="info-section">
                <h3>Informations personnelles</h3>
                <div class="info-row">
                    <div class="info-label">Nom :</div>
                    <div class="info-value"><?= esc($user['nom']) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Prénom :</div>
                    <div class="info-value"><?= esc($user['prenom']) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email :</div>
                    <div class="info-value"><?= esc($user['email']) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Genre :</div>
                    <div class="info-value"><?= ucfirst(esc($user['genre'])) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Date de naissance :</div>
                    <div class="info-value"><?= date('d/m/Y', strtotime($user['date_naissance'])) ?></div>
                </div>
            </div>

            <div class="info-section">
                <h3>Profil physique</h3>
                <div class="info-row">
                    <div class="info-label">Taille :</div>
                    <div class="info-value"><?= esc($user['taille']) ?> m</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Poids :</div>
                    <div class="info-value"><?= esc($user['poids']) ?> kg</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Objectif :</div>
                    <div class="info-value">
                        <?php 
                        $objectifs = [
                            'augmenter_poids' => 'Augmenter le poids',
                            'reduire_poids' => 'Réduire le poids',
                            'imc_ideal' => 'IMC idéal'
                        ];
                        echo isset($objectifs[$user['objectif']]) ? $objectifs[$user['objectif']] : esc($user['objectif']);
                        ?>
                    </div>
                </div>
            </div>

            <div class="info-section">
                <h3>Informations compte</h3>
                <div class="info-row">
                    <div class="info-label">Solde :</div>
                    <div class="info-value"><?= number_format($user['solde_portefeuille'], 0, ',', ' ') ?> €</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Statut :</div>
                    <div class="info-value">
                        <?php if($user['is_gold']): ?>
                            <span style="color: #f59e0b; font-weight: bold;">⭐ Membre Gold</span>
                        <?php else: ?>
                            Membre Standard
                        <?php endif; ?>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Membre depuis :</div>
                    <div class="info-value"><?= date('d/m/Y', strtotime($user['created_at'])) ?></div>
                </div>
            </div>

            <div class="button-row">
                <a href="/utilisateur/dashboard" class="btn btn-secondary">Retour</a>
                <a href="/utilisateur/modifProfil" class="btn btn-primary">Modifier mon profil</a>
                <a href="/utilisateur/logout" class="btn btn-danger">Déconnexion</a>
            </div>
        </div>
    </div>
</body>
</html>