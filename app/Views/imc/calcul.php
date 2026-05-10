
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcul IMC - Régime Alimentaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container-imc {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 500px;
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
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e0e0e0;
        }
        .btn-calculer {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-calculer:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-weight: 700;
        }
        .info-text {
            background-color: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
            color: #555;
        }
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
            <a href="/" class="text-decoration-none">← Retour à l'accueil</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/imc.js"></script>
</body>
</html>
