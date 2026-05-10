<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Devenir Gold</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway:400,600,700" rel="stylesheet">
<?= $this->include('user/_navbar_styles') ?>

<style>
.profile-reset * { box-sizing: border-box; }

.gold-page {
    width: 100%;
    max-width: 920px;
    margin: 0 auto;
    padding: 56px 16px 48px;
}

.header{
    background: rgba(255, 255, 255, .82);
    border: 1px solid rgba(111, 146, 123, .15);
    border-radius: 0;
    box-shadow: 0 24px 50px rgba(33, 50, 39, .08);
    overflow: visible;
}

.header h1{
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 8px 0;
}

.header p{
    margin: 0;
    color: #6b7280;
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
    border: 1px solid rgba(111, 146, 123, .14);
    border-radius: 22px;
    padding: 18px;
    background: linear-gradient(180deg, rgba(255,255,255,0.96) 0%, rgba(250, 252, 250, 0.98) 100%);
    box-shadow: 0 12px 28px rgba(33, 50, 39, .06);
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
    background: linear-gradient(180deg, rgba(255,250,235,1), rgba(255,250,235,.95));
}

/* warning */
.warning {
    background: rgba(255,255,255,.92);
    border: 1px solid rgba(111,146,123,.12);
    padding: 14px;
    border-radius: 12px;
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

.gold-page .btn {
    flex: 1;
    padding: 12px;
    border-radius: 12px;
    text-align: center;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: 0.2s;
}

.gold-page .btn-secondary {
    background: #f3f4f6;
    color: #111827;
}

.gold-page .btn-secondary:hover {
    background: #e5e7eb;
}

.gold-page .btn-primary {
    background: #111827;
    color: white;
}

.gold-page .btn-primary:hover {
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
<?= $this->include('user/_navbar') ?>
<main class="gold-page">

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

</main>
<?= $this->include('user/_footer') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
