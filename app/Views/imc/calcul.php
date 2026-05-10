
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcul IMC - Régime Alimentaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?= $this->include('user/_navbar_styles') ?>
    <style>
        .container-imc {
            background: linear-gradient(180deg, rgba(255,255,255,0.96) 0%, rgba(255,248,251,0.96) 100%);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(119, 96, 111, 0.12);
            border: 1px solid rgba(244, 198, 214, 0.24);
            padding: 40px;
            max-width: 500px;
            margin: 56px auto 48px;
                width: 100%;
            flex: 1;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            font-size: 16px;
        }
        .form-control:focus {
            border-color: #a9cdb1;
            box-shadow: 0 0 0 0.2rem rgba(244, 198, 214, 0.20);
        }
        label {
            font-weight: 600;
            color: #4b5f52;
            margin-bottom: 8px;
            display: block;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e0e0e0;
        }
        .btn-calculer {
            background: linear-gradient(135deg, #a9cdb1 0%, #89b69e 100%);
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
            color: #234031;
        }
        .btn-calculer:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(169, 205, 177, 0.35);
        }
        h1 {
            text-align: center;
            color: #2f4f3f;
            margin-bottom: 30px;
            font-weight: 700;
        }
        .info-text {
            background: linear-gradient(135deg, rgba(244, 198, 214, 0.22) 0%, rgba(255, 241, 245, 0.95) 100%);
            border-left: 4px solid #c984a1;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-size: 14px;
            color: #6f4b5d;
        }

        .imc-result-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.98) 0%, rgba(255,247,250,0.96) 100%);
            border: 1px solid rgba(169,205,177,0.28);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(119,96,111,0.10);
        }

        .imc-result-header {
            background: linear-gradient(135deg, #f6d7e3 0%, #efc2d3 100%);
            color: #6e4055;
            padding: 14px 16px;
        }

        .imc-result-body {
            padding: 16px;
            color: #42534a;
        }

        .imc-badge-main {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 700;
            color: #6e4055;
            background: linear-gradient(135deg, rgba(244,198,214,.78) 0%, rgba(239,194,211,.68) 100%);
        }

        .imc-badge-cat {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            font-weight: 700;
            color: #6e4055;
            background: linear-gradient(135deg, rgba(244,198,214,.72) 0%, rgba(239,194,211,.62) 100%);
        }

        .imc-result-description {
            color: #6f4b5d;
            margin: 0;
        }

        .btn-imc-main {
            background: linear-gradient(135deg, #a9cdb1 0%, #89b69e 100%);
            color: #234031;
            border: none;
            font-weight: 600;
        }

        .btn-imc-main:hover {
            background: linear-gradient(135deg, #9fc8aa 0%, #7ead95 100%);
            color: #1d3528;
        }

        .btn-imc-secondary {
            background: linear-gradient(135deg, #f6d7e3 0%, #efc2d3 100%);
            color: #6e4055;
            border: none;
            font-weight: 600;
        }

        .btn-imc-secondary:hover {
            background: linear-gradient(135deg, #f3cfdc 0%, #ebb7cc 100%);
            color: #5e3648;
        }

        .imc-progress {
            border-radius: 12px;
            overflow: hidden;
        }

        .imc-segment-1 { background: #f4c6d6; color: #6e4055; }
        .imc-segment-2 { background: #a9cdb1; color: #234031; }
        .imc-segment-3 { background: #efd5be; color: #6f5b2f; }
        .imc-segment-4 { background: #e9b0c5; color: #61384b; }
        #resultatImc {
            margin-top: 30px;
            animation: slideIn 0.3s ease-in;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <?= $this->include('user/_navbar') ?>
    <div class="container-imc">
        <h1>Calcul de l'IMC</h1>
        
        <div class="info-text">
            <strong>IMC (Indice de Masse Corporelle)</strong> = Poids (kg) / Taille (m)²
            <br>
            Entrez votre poids et votre taille pour connaître votre indice de masse corporelle.
        </div>

        <form id="formImc" method="POST" action="/imc/resultat">
            <div class="form-group">
                <label for="poids">Poids (en kg)</label>
                <input
                    type="number"
                    class="form-control"
                    id="poids"
                    name="poids"
                    placeholder="Ex: 70"
                    value="<?= esc($poids_prefill ?? '') ?>"
                    min="0"
                    max="300"
                    step="0.1"
                    required
                >
                <small class="form-text text-muted">Entre 0 et 300 kg</small>
            </div>

            <div class="form-group">
                <label for="taille">Taille (en cm)</label>
                <input
                    type="number"
                    class="form-control"
                    id="taille"
                    name="taille"
                    placeholder="Ex: 175"
                    value="<?= esc($taille_prefill ?? '') ?>"
                    min="0"
                    max="300"
                    step="0.1"
                    required
                >
                <small class="form-text text-muted">Entre 0 et 300 cm</small>
            </div>

            <button type="submit" class="btn btn-primary btn-calculer" id="btnCalculer">
                Calculer mon IMC
            </button>
        </form>

        <!-- Zone d'affichage des résultats -->
        <div id="resultatImc"></div>

        <hr class="my-4">
        
        <div style="text-align: center; font-size: 14px; color: #999;">
            <a href="/index.php/utilisateur/accueil" class="text-decoration-none">← Retour à l'accueil</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/imc.js"></script>
    <?= $this->include('user/_footer') ?>
</body>
</html>
