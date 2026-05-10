<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon profil</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Raleway, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        #regForm {
            background: white;
            width: 100%;
            max-width: 650px;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #111827;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
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
            color: #374151;
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
            border-color: #10b981;
            outline: none;
            box-shadow: 0 0 0 4px rgba(16,185,129,0.15);
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
            background: #fee2e2;
            border: 1px solid #ef4444;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 20px;
            color: #991b1b;
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
            background: #d1d5db;
            color: #111827;
        }

        #nextBtn {
            background: #10b981;
            color: white;
        }

        .steps {
            text-align: center;
            margin-top: 35px;
        }

        .step {
            height: 12px;
            width: 12px;
            margin: 0 5px;
            background-color: #d1d5db;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
            transition: 0.3s;
        }

        .step.active {
            opacity: 1;
            background-color: #10b981;
            transform: scale(1.2);
        }

        .step.finish {
            background-color: #10b981;
            opacity: 1;
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
</head>

<body>

<form id="regForm" method="post" action="<?= base_url('utilisateur/updateProfil') ?>">

    <?php if(session()->has('errors')): ?>
        <div class="server-error">
            <ul>
                <?php foreach(session('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(session()->has('success')): ?>
        <div class="server-error" style="background: #d1fae5; border-color: #10b981; color: #065f46;">
            <?= session('success') ?>
        </div>
    <?php endif; ?>

    <div class="tab">
        <h1>Modifier mon profil</h1>
        <p class="subtitle">Informations personnelles</p>

        <div class="grid">
            <div class="form-group">
                <label>Nom *</label>
                <input type="text" name="nom" placeholder="Rakoto" value="<?= old('nom', $user['nom']) ?>">
                <span class="error" data-field="nom"></span>
            </div>

            <div class="form-group">
                <label>Prénom *</label>
                <input type="text" name="prenom" placeholder="Jean" value="<?= old('prenom', $user['prenom']) ?>">
                <span class="error" data-field="prenom"></span>
            </div>
        </div>

        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" placeholder="email@example.com" value="<?= old('email', $user['email']) ?>">
            <span class="error" data-field="email"></span>
        </div>

        <div class="grid">
            <div class="form-group">
                <label>Mot de passe (laisser vide si inchangé)</label>
                <input type="password" name="password" placeholder="******">
                <div class="form-group">

    <span class="error" data-field="password"></span>
</div>

                <span class="error" data-field="password"></span>
                <small style="color: #6b7280;">Minimum 6 caractères</small>
            </div>

            <div class="form-group">
                <label>Genre *</label>
                <select name="genre">
                    <option value="">Choisir</option>
                    <option value="homme" <?= (old('genre', $user['genre']) == 'homme') ? 'selected' : '' ?>>Homme</option>
                    <option value="femme" <?= (old('genre', $user['genre']) == 'femme') ? 'selected' : '' ?>>Femme</option>
                </select>
                <span class="error" data-field="genre"></span>
            </div>
        </div>

        <div class="form-group">
            <label>Date de naissance *</label>
            <input type="date" name="date_naissance" value="<?= old('date_naissance', $user['date_naissance']) ?>">
            <span class="error" data-field="date_naissance"></span>
        </div>
    </div>

    <div class="tab">
        <h1>Profil physique</h1>
        <p class="subtitle">Aidez-nous à personnaliser votre expérience</p>

        <div class="grid">
            <div class="form-group">
                <label>Taille (m) *</label>
                <input type="number" step="0.01" name="taille" placeholder="1.75" value="<?= old('taille', $user['taille']) ?>">
                <span class="error" data-field="taille"></span>
            </div>

            <div class="form-group">
                <label>Poids (kg) *</label>
                <input type="number" step="0.01" name="poids" placeholder="70" value="<?= old('poids', $user['poids']) ?>">
                <span class="error" data-field="poids"></span>
            </div>
        </div>

        <div class="form-group">
            <label>Objectif *</label>
            <select name="objectif">
                <option value="">Choisir un objectif</option>
                <option value="augmenter_poids" <?= (old('objectif', $user['objectif']) == 'augmenter_poids') ? 'selected' : '' ?>>Augmenter le poids</option>
                <option value="reduire_poids" <?= (old('objectif', $user['objectif']) == 'reduire_poids') ? 'selected' : '' ?>>Réduire le poids</option>
                <option value="imc_ideal" <?= (old('objectif', $user['objectif']) == 'imc_ideal') ? 'selected' : '' ?>>IMC idéal</option>
            </select>
            <span class="error" data-field="objectif"></span>
        </div>
    </div>

    <div class="button-row">
        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Précédent</button>
        <button type="button" id="nextBtn" onclick="nextPrev(1)">Suivant</button>
    </div>

    <div class="steps">
        <span class="step"></span>
        <span class="step"></span>
    </div>
</form>

<script>
    let currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        let x = document.getElementsByClassName("tab");
        x[n].style.display = "block";

        if (n === 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }

        if (n === (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Mettre à jour";
        } else {
            document.getElementById("nextBtn").innerHTML = "Suivant";
        }

        fixStepIndicator(n);
    }

    function validateField(field, value) {
        const name = field.getAttribute('name');
        const errorSpan = document.querySelector(`.error[data-field="${name}"]`);
        
        if (!errorSpan) return true;
        
        switch(name) {
            case 'nom':
                if (!value.trim()) {
                    errorSpan.textContent = 'Le nom est obligatoire.';
                    return false;
                }
                if (value.trim().length < 2) {
                    errorSpan.textContent = 'Le nom doit contenir au moins 2 caractères.';
                    return false;
                }
                if (value.trim().length > 100) {
                    errorSpan.textContent = 'Le nom ne doit pas dépasser 100 caractères.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'prenom':
                if (!value.trim()) {
                    errorSpan.textContent = 'Le prénom est obligatoire.';
                    return false;
                }
                if (value.trim().length < 2) {
                    errorSpan.textContent = 'Le prénom doit contenir au moins 2 caractères.';
                    return false;
                }
                if (value.trim().length > 100) {
                    errorSpan.textContent = 'Le prénom ne doit pas dépasser 100 caractères.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!value) {
                    errorSpan.textContent = 'L’email est obligatoire.';
                    return false;
                }
                if (!emailRegex.test(value)) {
                    errorSpan.textContent = 'Email invalide.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'password':
                // Mot de passe optionnel en modification
                if (value && value.length < 6) {
                    errorSpan.textContent = 'Le mot de passe doit contenir au moins 6 caractères.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'genre':
                if (!value) {
                    errorSpan.textContent = 'Le genre est obligatoire.';
                    return false;
                }
                if (!['homme', 'femme'].includes(value)) {
                    errorSpan.textContent = 'Genre invalide.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'date_naissance':
                if (!value) {
                    errorSpan.textContent = 'La date de naissance est obligatoire.';
                    return false;
                }
                const birthDate = new Date(value);
                if (isNaN(birthDate.getTime())) {
                    errorSpan.textContent = 'Date invalide.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'taille':
                if (!value) {
                    errorSpan.textContent = 'La taille est obligatoire.';
                    return false;
                }
                const taille = parseFloat(value);
                if (isNaN(taille)) {
                    errorSpan.textContent = 'La taille doit être un nombre décimal.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'poids':
                if (!value) {
                    errorSpan.textContent = 'Le poids est obligatoire.';
                    return false;
                }
                const poids = parseFloat(value);
                if (isNaN(poids)) {
                    errorSpan.textContent = 'Le poids doit être un nombre décimal.';
                    return false;
                }
                errorSpan.textContent = '';
                return true;
                
            case 'objectif':
                if (!value) {
                    errorSpan.textContent = "L'objectif est obligatoire.";
                    return false;
                }
                if (!['augmenter_poids', 'reduire_poids', 'imc_ideal'].includes(value)) {
                    errorSpan.textContent = "Objectif invalide.";
                    return false;
                }
                errorSpan.textContent = '';
                return true;
        }
        return true;
    }

    function validateForm() {
        let valid = true;
        const currentTabElement = document.getElementsByClassName("tab")[currentTab];
        const inputs = currentTabElement.querySelectorAll('input, select');
        
        inputs.forEach(input => {
            if (input.hasAttribute('name') && input.type !== 'submit') {
                const isValid = validateField(input, input.value);
                if (!isValid) {
                    valid = false;
                    input.classList.add('invalid');
                } else {
                    input.classList.remove('invalid');
                }
            }
        });
        
        if (valid) {
            const steps = document.getElementsByClassName("step");
            if (steps[currentTab]) {
                steps[currentTab].classList.add("finish");
            }
        }
        
        return valid;
    }

    function nextPrev(n) {
        let x = document.getElementsByClassName("tab");
        
        if (n === 1 && !validateForm()) {
            return false;
        }
        
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        
        if (currentTab >= x.length) {
            document.getElementById("regForm").submit();
            return false;
        }
        
        showTab(currentTab);
    }

    function fixStepIndicator(n) {
        let i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        if (x[n]) {
            x[n].className += " active";
        }
    }

    document.querySelectorAll('input, select').forEach(field => {
        if (field.getAttribute('type') !== 'submit' && field.getAttribute('name')) {
            field.addEventListener('blur', function() {
                validateField(this, this.value);
                if (this.value && validateField(this, this.value)) {
                    this.classList.remove('invalid');
                } else if (this.value) {
                    this.classList.add('invalid');
                }
            });
            
            field.addEventListener('input', function() {
                if (this.value && validateField(this, this.value)) {
                    this.classList.remove('invalid');
                    const errorSpan = document.querySelector(`.error[data-field="${this.getAttribute('name')}"]`);
                    if (errorSpan && errorSpan.textContent) {
                        errorSpan.textContent = '';
                    }
                }
            });
        }
    });
</script>



</body>
</html>