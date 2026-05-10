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
    background: #f5f6f8;
    min-height: 100vh;
    padding: 30px;
    display: flex;
    justify-content: center;
    color: #111827;
}

.container {
    width: 100%;
    max-width: 820px;
    background: white;
    border-radius: 14px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    overflow: hidden;
}

/* header */
.header {
    padding: 25px;
    border-bottom: 1px solid #eee;
    text-align: center;
}

.header h1 {
    font-size: 22px;
    font-weight: 700;
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
    border-radius: 8px;
    font-size: 13px;
    margin-bottom: 18px;
}

.success-message {
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #065f46;
}

.error-message {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

/* cards */
.card {
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 18px;
    margin-bottom: 15px;
}

.card h3 {
    font-size: 14px;
    margin-bottom: 12px;
    color: #111827;
}

/* rows */
.row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 14px;
}

.label {
    color: #6b7280;
}

.value {
    color: #111827;
    font-weight: 500;
}

/* gold badge */
.gold {
    color: #b45309;
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
    background: #111827;
    color: white;
}

.btn-primary:hover {
    background: #000;
}

.btn-secondary {
    background: #f3f4f6;
    color: #111827;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}

.btn-gold {
    background: #f59e0b;
    color: white;
}

.btn-gold:hover {
    background: #d97706;
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
                <span class="value"><?= esc($user['taille']) ?> m</span>
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