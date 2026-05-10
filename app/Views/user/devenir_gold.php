<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Devenir Gold</title>
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
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px;
    color: #111827;
}

.container {
    width: 100%;
    max-width: 850px;
    background: white;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    overflow: hidden;
}

.header {
    padding: 30px;
    border-bottom: 1px solid #eee;
    text-align: center;
}

.header h1 {
    font-size: 24px;
    font-weight: 700;
}

.header p {
    margin-top: 6px;
    color: #6b7280;
    font-size: 14px;
}

.content {
    padding: 30px;
}

/* messages */
.error-message, .success-message {
    padding: 12px 14px;
    border-radius: 8px;
    font-size: 14px;
    margin-bottom: 20px;
}

.error-message {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.success-message {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

/* price */
.price {
    text-align: center;
    margin: 25px 0 35px;
}

.price .amount {
    font-size: 42px;
    font-weight: 700;
}

.price .period {
    display: block;
    color: #6b7280;
    margin-top: 5px;
}

.badge {
    display: inline-block;
    margin-top: 10px;
    padding: 4px 10px;
    font-size: 12px;
    background: #111827;
    color: white;
    border-radius: 999px;
}

/* grid */
.advantages {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 15px;
    margin-bottom: 25px;
}

.card {
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 18px;
    background: #fff;
}

.card h3 {
    font-size: 15px;
    margin-bottom: 6px;
}

.card p {
    font-size: 13px;
    color: #6b7280;
}

/* highlight card */
.card.highlight {
    border-color: #f59e0b;
    background: #fffbeb;
}

/* warning */
.warning {
    background: #fafafa;
    border: 1px solid #eee;
    padding: 14px;
    border-radius: 10px;
    font-size: 13px;
    color: #374151;
    margin-top: 10px;
}

/* actions */
.actions {
    display: flex;
    gap: 12px;
    margin-top: 25px;
}

.btn {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    text-align: center;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: 0.2s;
}

.btn-secondary {
    background: #f3f4f6;
    color: #111827;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

.btn-primary {
    background: #111827;
    color: white;
}

.btn-primary:hover {
    background: #000;
}

@media (max-width: 600px) {
    .actions {
        flex-direction: column;
    }
}
</style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Devenir membre Gold</h1>
        <p>Accès premium à toutes les fonctionnalités</p>
    </div>

    <div class="content">

        <?php if(session()->has('error')): ?>
            <div class="error-message"><?= session('error') ?></div>
        <?php endif; ?>

        <?php if(session()->has('success')): ?>
            <div class="success-message"><?= session('success') ?></div>
        <?php endif; ?>

        <div class="price">
            <div class="amount">10 000 Ar</div>
            <div class="period">paiement unique</div>
            <div class="badge">-15% sur tout</div>
        </div>

        <div class="advantages">

            <div class="card highlight">
                <h3>Réduction</h3>
                <p>15% sur tous les services</p>
            </div>

            <div class="card">
                <h3>Accès premium</h3>
                <p>Programmes exclusifs</p>
            </div>

            <div class="card">
                <h3>Plans personnalisés</h3>
                <p>Nutrition adaptée à vos objectifs</p>
            </div>

            <div class="card">
                <h3>Avantages exclusifs</h3>
                <p>Codes promo et bonus</p>
            </div>

        </div>

        <div class="warning">
            Solde actuel : <?= number_format($solde, 0, ',', ' ') ?> Ar
        </div>

        <div class="actions">
            <a href="/utilisateur/profil" class="btn btn-secondary">Annuler</a>
            <a href="/utilisateur/payerGold" class="btn btn-primary">Payer 10 000 Ar</a>
        </div>

    </div>

</div>

</body>
</html>