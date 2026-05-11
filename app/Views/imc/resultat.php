<?php
function getEmojiCategorie(string $code): string {
    $emojis = [
        'maigreur'  => '🤷',
        'normal'    => '😊',
        'surpoids'  => '😐',
        'obesite'   => '😟',
    ];
    return $emojis[$code] ?? '📊';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat IMC - Régime Alimentaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?= $this->include('user/_navbar_styles') ?>    <style>
        .container-resultat {
            max-width: 800px;
            padding-top: 56px;
            padding-bottom: 48px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .card-header {
            padding: 25px;
            font-size: 24px;
            font-weight: 700;
        }
        .card-body {
            padding: 30px;
        }
        .imc-value {
            font-size: 48px;
            font-weight: 700;
            text-align: center;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-around;
            margin: 25px 0;
            flex-wrap: wrap;
        }
        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            flex: 1;
            min-width: 150px;
            margin: 10px;
        }
        .info-box strong {
            display: block;
            font-size: 12px;
            color: #999;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .info-box .value {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .btn-back {
            flex: 1;
            min-width: 150px;
        }
        .categorie-description {
            background: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<?= $this->include('user/_navbar') ?>
    <div class="container container-resultat">
        
        <?php if (!empty($resultat)): ?>
            <div class="card border-0">
                <div class="card-header bg-<?php echo $resultat['couleur'] === 'info' ? 'primary' : $resultat['couleur']; ?> text-white">
                    <?php echo getEmojiCategorie($resultat['code_categorie'] ?? ''); ?> Votre Résultat IMC
                </div>
                <div class="card-body">
                    <div class="imc-value">
                        <span class="badge bg-<?php echo $resultat['couleur'] === 'info' ? 'primary' : $resultat['couleur']; ?>" style="font-size: 32px; padding: 15px;">
                            <?php echo $resultat['imc']; ?>
                        </span>
                    </div>

                    <div class="info-row">
                        <div class="info-box">
                            <strong>Poids</strong>
                            <div class="value"><?php echo $resultat['poids']; ?> <span style="font-size: 24px;">kg</span></div>
                        </div>
                        <div class="info-box">
                            <strong>Taille</strong>
                            <div class="value"><?php echo $resultat['taille']; ?> <span style="font-size: 24px;">cm</span></div>
                        </div>
                        <div class="info-box">
                            <strong>Catégorie</strong>
                            <div class="value" style="font-size: 20px;">
                                <span class="badge bg-<?php echo $resultat['couleur'] === 'info' ? 'primary' : $resultat['couleur']; ?>">
                                    <?php echo $resultat['categorie']; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="categorie-description">
                        <?php echo $resultat['description']; ?>
                    </div>

                    <!-- Barre de progression IMC -->
                    <div style="margin: 30px 0;">
                        <div class="form-label fw-bold">Indice de Santé</div>
                        <div class="progress" style="height: 40px;">
                            <div class="progress-bar bg-info" style="width: 25%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600;">
                                Maigreur<br>&lt; 18.5
                            </div>
                            <div class="progress-bar bg-success" style="width: 25%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600;">
                                Normal<br>18.5-25
                            </div>
                            <div class="progress-bar bg-warning" style="width: 25%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600;">
                                Surpoids<br>25-30
                            </div>
                            <div class="progress-bar bg-danger" style="width: 25%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600;">
                                Obésité<br>&gt; 30
                            </div>
                        </div>
                    </div>

                    <div class="btn-group">
                        <a href="/imc" class="btn btn-secondary btn-back">← Calculer un autre IMC</a>
                        <button class="btn btn-primary btn-back" onclick="exporterPDF('<?php echo esc($resultat['imc'] ?? '') ?>', '<?php echo esc($resultat['poids'] ?? '') ?>', '<?php echo esc($resultat['taille'] ?? '') ?>', '<?php echo esc($resultat['code_categorie'] ?? '') ?>')">
                             Exporter en PDF
                        </button>
                        <a href="/regime/suggestion" class="btn btn-outline-primary btn-back">
                            Voir suggestions
                        </a>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Aucun résultat</h4>
                <p>Veuillez accéder à la page de calcul IMC pour obtenir vos résultats.</p>
                <a href="/imc" class="btn btn-warning btn-sm">Aller au formulaire</a>
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function exporterPDF(imc, poids, taille, categorie) {
            const params = new URLSearchParams();

            if (imc) params.set('imc', imc);
            if (poids) params.set('poids', poids);
            if (taille) params.set('taille', taille);
            if (categorie) params.set('categorie', categorie);

            const queryString = params.toString();
            window.location.href = queryString ? `/imc/export-pdf?${queryString}` : '/imc/export-pdf';
        }
    </script>
    <?= $this->include('user/_footer') ?>
</body>
</html>
