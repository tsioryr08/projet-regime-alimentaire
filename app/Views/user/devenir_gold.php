<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devenir Gold</title>
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
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 16px;
        }

        .content {
            padding: 40px;
        }

        .price {
            text-align: center;
            margin-bottom: 40px;
        }

        .price .amount {
            font-size: 48px;
            font-weight: bold;
            color: #f59e0b;
        }

        .price .period {
            color: #6b7280;
        }

        .price .discount {
            background: #ef4444;
            color: white;
            font-size: 14px;
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            margin-left: 15px;
        }

        .advantages {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .advantage-card {
            background: #fef3c7;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            transition: 0.3s;
        }

        .advantage-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .advantage-card .icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .advantage-card h3 {
            color: #92400e;
            margin-bottom: 10px;
        }

        .advantage-card p {
            color: #6b7280;
            font-size: 14px;
        }

        .discount-card {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .discount-card h3, .discount-card p {
            color: white;
        }

        .button-row {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: 0.2s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-gold {
            background: #f59e0b;
            color: white;
        }

        .btn-gold:hover {
            background: #d97706;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #d1d5db;
            color: #111827;
        }

        .btn-secondary:hover {
            background: #9ca3af;
            transform: translateY(-2px);
        }

        .warning {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin-top: 30px;
            border-radius: 10px;
            color: #92400e;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .content {
                padding: 20px;
            }
            .button-row {
                flex-direction: column;
            }
            .btn {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⭐ Devenir Membre Gold</h1>
            <p>Débloquez tous les avantages premium</p>
        </div>

        <div class="content">
            <div class="price">
                <span class="amount">10 000 Ar</span>
                <span class="period">pours toujours</span>
                <span class="discount">-15% sur tout</span>
            </div>

            <div class="advantages">
                <div class="advantage-card discount-card">
                    <div class="icon">💰</div>
                    <h3>15% DE REMISE</h3>
                    <p>Sur tous les programmes et services</p>
                </div>
                <div class="advantage-card">
                    <div class="icon">📋</div>
                    <h3>Programmes exclusifs</h3>
                    <p>Accès à tous les programmes premium</p>
                </div>
                <div class="advantage-card">
                    <div class="icon">🥗</div>
                    <h3>Repas personnalisés</h3>
                    <p>Plans de repas sur mesure</p>
                </div>
        
                <div class="advantage-card">
                    <div class="icon">🎁</div>
                    <h3>Codes promo exclusifs</h3>
                    <p>Des réductions toute l'année</p>
                </div>
                <div class="advantage-card">
                    <div class="icon">👑</div>
                    <h3>Badge Gold</h3>
                    <p>Reconnaissance sur votre profil</p>
                </div>
            </div>

            <div class="warning">
                Le paiement sera déduit de votre portefeuille. Solde actuel : <?= number_format($solde, 0, ',', ' ') ?> Ar<br>
                Une fois Gold, bénéficiez de <strong>15% de réduction</strong> sur tous vos achats !
            </div>

            <div class="button-row">
                <a href="/utilisateur/profil" class="btn btn-secondary">Annuler</a>
                <a href="/utilisateur/payerGold" class="btn btn-gold">Payer</a>
            </div>
        </div>
    </div>
</body>
</html>