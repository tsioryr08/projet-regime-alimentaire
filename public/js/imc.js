document.addEventListener('DOMContentLoaded', function() {
    const formImc = document.getElementById('formImc');
    const inputPoids = document.getElementById('poids');
    const inputTaille = document.getElementById('taille');
    const resultatDiv = document.getElementById('resultatImc');
    const btnCalculer = document.getElementById('btnCalculer');

    // Calculer en temps reel lors de la saisie
    if (inputPoids) {
        inputPoids.addEventListener('input', calculerImc);
    }
    if (inputTaille) {
        inputTaille.addEventListener('input', calculerImc);
    }

    // Calcul via bouton ca marche tt de meme
    if (btnCalculer) {
        btnCalculer.addEventListener('click', calculerImc);
    }

    // Soumission du formulaire
    if (formImc) {
        formImc.addEventListener('submit', function(e) {
            e.preventDefault();
            calculerImc();
        });
    }

    
    function calculerImc() {
        const poids = parseFloat(inputPoids.value);
        const taille = parseFloat(inputTaille.value);

        // Validation
        if (!poids || !taille || poids <= 0 || taille <= 0) {
            resultatDiv.innerHTML = '<div class="alert alert-warning">Veuillez entrer des valeurs valides (poids > 0, taille > 0)</div>';
            return;
        }

        // Afficher un loader
        resultatDiv.innerHTML = '<div class="spinner-border" role="status"><span class="visually-hidden">Calcul en cours...</span></div>';

        // Effectuer la requete AJAX pour calculer l'IMC
        fetch('/imc/calculer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'poids=' + encodeURIComponent(poids) + '&taille=' + encodeURIComponent(taille)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                afficherResultat(data.data);
            } else {
                resultatDiv.innerHTML = '<div class="alert alert-danger">' + (data.message || 'Erreur lors du calcul') + '</div>';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            resultatDiv.innerHTML = '<div class="alert alert-danger">Erreur lors de la requête. Veuillez vérifier la console.</div>';
        });
    }

    //affichage resultat
    function afficherResultat(data) {
        const couleurMap = {
            'info': 'primary',
            'success': 'success',
            'warning': 'warning',
            'danger': 'danger'
        };

        const couleur = couleurMap[data.couleur] || 'secondary';
        const emoji = getEmojiCategorie(data.code_categorie);

        let html = `
            <div class="card border-${couleur}">
                <div class="card-header bg-${couleur} text-white">
                    <h5 class="mb-0">${emoji} Résultat IMC</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Poids :</strong> ${data.poids} kg</p>
                            <p><strong>Taille :</strong> ${data.taille} cm</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>IMC :</strong> <span class="badge bg-${couleur} fs-6">${data.imc}</span></p>
                            <p><strong>Catégorie :</strong> <span class="badge bg-${couleur}">${data.categorie}</span></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="text-muted">${data.description}</p>
                    </div>
                    <div class="mt-3 d-flex gap-2 flex-wrap">
                        <button class="btn btn-${couleur}" onclick="exporterPDF('${data.imc}', '${data.poids}', '${data.taille}', '${data.categorie}')">
                            Exporter en PDF
                        </button>
                        <button class="btn btn-outline-${couleur}" onclick="window.location.href='/regime/suggestion'">
                            Voir suggestions
                        </button>
                    </div>
                </div>
            </div>
        `;

        resultatDiv.innerHTML = html;

        // Ajouter une barre de progression IMC
        ajouterBarreProgressionImc(data);
    }


    function getEmojiCategorie(code) {
        const emojis = {
            'maigreur': '🤷',
            'normal': '😊',
            'surpoids': '😐',
            'obesite': '😟'
        };
        return emojis[code] || '📊';
    }

    //fonction pour ajouter la barre de progression IMC
    function ajouterBarreProgressionImc(data) {
        const imc = data.imc;
        let position = 0;

        // Calculer la position: 0-18.5 = 0-25%, 18.5-25 = 25-50%, 25-30 = 50-75%, 30+ = 75-100%
        if (imc < 18.5) {
            position = (imc / 18.5) * 25;
        } else if (imc < 25) {
            position = 25 + ((imc - 18.5) / 6.5) * 25;
        } else if (imc < 30) {
            position = 50 + ((imc - 25) / 5) * 25;
        } else {
            position = 75 + (Math.min((imc - 30) / 10, 1)) * 25;
        }

        let progressHtml = `
            <div class="mt-4">
                <label class="form-label fw-bold">Indice IMC</label>
                <div class="progress" style="height: 30px;">
                    <div class="progress-bar bg-info" style="width: 25%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                        Maigreur <br> &lt; 18.5
                    </div>
                    <div class="progress-bar bg-success" style="width: 25%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                        Normal <br> 18.5-25
                    </div>
                    <div class="progress-bar bg-warning" style="width: 25%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                        Surpoids <br> 25-30
                    </div>
                    <div class="progress-bar bg-danger" style="width: 25%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                        Obésité <br> &gt; 30
                    </div>
                </div>
                <div style="position: relative; margin-top: -8px;">
                    <div style="position: absolute; left: ${position}%; transform: translateX(-50%); color: red; font-weight: bold; font-size: 20px;">▼</div>
                </div>
                <small class="form-text text-muted d-block mt-2">Votre IMC: ${data.imc}</small>
            </div>
        `;

        resultatDiv.insertAdjacentHTML('beforeend', progressHtml);
    }
});


function exporterPDF(imc, poids, taille, categorie) {
    const params = new URLSearchParams();

    if (imc !== undefined && imc !== null && imc !== '') params.set('imc', imc);
    if (poids !== undefined && poids !== null && poids !== '') params.set('poids', poids);
    if (taille !== undefined && taille !== null && taille !== '') params.set('taille', taille);
    if (categorie !== undefined && categorie !== null && categorie !== '') params.set('categorie', categorie);

    const queryString = params.toString();
    window.location.href = queryString ? `/imc/export-pdf?${queryString}` : '/imc/export-pdf';
}
