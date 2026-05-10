<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mon profil</title>

<link href="https://fonts.googleapis.com/css?family=Raleway:400,600,700" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Raleway, sans-serif;
}

body {
    background:
        radial-gradient(circle at top left, rgba(169, 205, 177, 0.42) 0%, rgba(169, 205, 177, 0) 38%),
        radial-gradient(circle at bottom right, rgba(244, 198, 214, 0.42) 0%, rgba(244, 198, 214, 0) 40%),
        linear-gradient(135deg, #fbfcfb 0%, #fff7fa 100%);
    min-height: 100vh;
    padding: 30px;
    display: flex;
    justify-content: center;
    color: #203026;
}

.container {
    width: 100%;
    max-width: 820px;
    background: rgba(255, 255, 255, 0.94);
    border-radius: 22px;
    box-shadow: 0 22px 50px rgba(119, 96, 111, 0.14);
    overflow: hidden;
    border: 1px solid rgba(163, 185, 169, 0.22);
}

/* header */
.header {
    padding: 28px 25px;
    border-bottom: 1px solid rgba(163, 185, 169, 0.18);
    text-align: center;
    background: linear-gradient(135deg, rgba(169, 205, 177, 0.18) 0%, rgba(244, 198, 214, 0.18) 100%);
}

.header h1 {
    font-size: 24px;
    font-weight: 800;
    color: #2f4f3f;
}

.header p {
    margin-top: 5px;
    font-size: 14px;
    color: #6b7280;
}

/* content */
.content {
    padding: 25px;
}

/* messages */
.success-message, .error-message {
    padding: 12px;
    border-radius: 14px;
    font-size: 13px;
    margin-bottom: 18px;
}

.success-message {
    background: linear-gradient(135deg, rgba(169, 205, 177, 0.26) 0%, rgba(235, 247, 238, 0.95) 100%);
    border: 1px solid rgba(111, 146, 123, 0.22);
    color: #2f5a43;
}

.error-message {
    background: linear-gradient(135deg, rgba(244, 198, 214, 0.28) 0%, rgba(255, 241, 245, 0.96) 100%);
    border: 1px solid rgba(201, 132, 161, 0.22);
    color: #8b4c63;
}

/* cards */
.card {
    border: 1px solid rgba(163, 185, 169, 0.18);
    border-radius: 18px;
    padding: 18px;
    margin-bottom: 15px;
    background: linear-gradient(180deg, rgba(255,255,255,0.96) 0%, rgba(250, 252, 250, 0.98) 100%);
    box-shadow: 0 10px 28px rgba(33, 50, 39, 0.05);
}

.card h3 {
    font-size: 14px;
    margin-bottom: 12px;
    color: #355a45;
}

/* rows */
.row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 14px;
}

.label {
    color: #5f6d64;
}

.value {
    color: #203026;
    font-weight: 500;
}

/* gold badge */
.gold {
    color: #8d6a00;
    font-weight: 700;
}

/* buttons */
.actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 20px;
}

.btn {
    padding: 10px 14px;
    border-radius: 10px;
    font-size: 13px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.2s;
    text-align: center;
}

.btn-primary {
    background: linear-gradient(135deg, #a9cdb1 0%, #89b69e 100%);
    color: white;
    color: #234031;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #9fc8aa 0%, #7ead95 100%);
}

.btn-secondary {
    background: linear-gradient(135deg, #f6d7e3 0%, #efc2d3 100%);
    color: #6e4055;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #f3cfdc 0%, #ebb7cc 100%);
}

.btn-danger {
    background: linear-gradient(135deg, #f4c6d6 0%, #e9adc2 100%);
    color: white;
    color: #6f3f57;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #f1bfd0 0%, #e49eb7 100%);
}

.btn-gold {
    background: linear-gradient(135deg, #efe0c1 0%, #e3c98f 100%);
    color: #6f5b2f;
}

.btn-gold:hover {
    background: linear-gradient(135deg, #e9d7b2 0%, #dcc079 100%);
}

@media (max-width: 600px) {
    .row {
        flex-direction: column;
        gap: 3px;
    }

    .actions {
        flex-direction: column;
    }
}
</style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Mon profil</h1>
        <p>Bienvenue <?= esc($user['prenom']) ?></p>
    </div>

    <div class="content">

        <?php if(session()->has('success')): ?>
            <div class="success-message"><?= session('success') ?></div>
        <?php endif; ?>

        <?php if(session()->has('error')): ?>
            <div class="error-message"><?= session('error') ?></div>
        <?php endif; ?>

        <div class="card">
            <h3>Informations personnelles</h3>

            <div class="row">
                <span class="label">Nom</span>
                <span class="value"><?= esc($user['nom']) ?></span>
            </div>

            <div class="row">
                <span class="label">Prénom</span>
                <span class="value"><?= esc($user['prenom']) ?></span>
            </div>

            <div class="row">
                <span class="label">Email</span>
                <span class="value"><?= esc($user['email']) ?></span>
            </div>

            <div class="row">
                <span class="label">Genre</span>
                <span class="value"><?= ucfirst(esc($user['genre'])) ?></span>
            </div>

            <div class="row">
                <span class="label">Naissance</span>
                <span class="value"><?= date('d/m/Y', strtotime($user['date_naissance'])) ?></span>
            </div>
        </div>

        <!-- physique -->
        <div class="card">
            <h3>Profil physique</h3>

            <div class="row">
                <span class="label">Taille</span>
                <span class="value"><?= esc($user['taille']) ?> cm</span>
            </div>

            <div class="row">
                <span class="label">Poids</span>
                <span class="value"><?= esc($user['poids']) ?> kg</span>
            </div>

            <div class="row">
                <span class="label">Objectif</span>
                <span class="value"><?= esc($user['objectif']) ?></span>
            </div>
        </div>

        <!-- compte -->
        <div class="card">
            <h3>Compte</h3>

            <div class="row">
                <span class="label">Solde</span>
                <span class="value"><?= number_format($user['solde_portefeuille'], 0, ',', ' ') ?> Ar</span>
            </div>

            <div class="row">
                <span class="label">Statut</span>
                <span class="value">
                    <?php if($user['is_gold']): ?>
                        <span class="gold">⭐ Gold</span>
                    <?php else: ?>
                        Standard
                    <?php endif; ?>
                </span>
            </div>

            <div class="row">
                <span class="label">Inscrit depuis</span>
                <span class="value"><?= date('d/m/Y', strtotime($user['created_at'])) ?></span>
            </div>
        </div>

        <div class="actions">
            <a href="/utilisateur/dashboard" class="btn btn-secondary">Retour</a>
            <a href="/utilisateur/modifProfil" class="btn btn-primary">Modifier</a>
            <a href="/utilisateur/saisirCode" class="btn btn-secondary">Code</a>
            <a href="/utilisateur/devenirGold" class="btn btn-gold">Devenir Gold</a>
            <a href="/utilisateur/logout" class="btn btn-danger">Déconnexion</a>
        </div>

    </div>
</div>

</body>
</html>
