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
        const emoji = getEmojiCategorie(data.code_categorie);

        let html = `
            <div class="imc-result-card">
                <div class="imc-result-header">
                    <h5 class="mb-0">${emoji} Résultat IMC</h5>
                </div>
                <div class="imc-result-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Poids :</strong> ${data.poids} kg</p>
                            <p><strong>Taille :</strong> ${data.taille} cm</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>IMC :</strong> <span class="imc-badge-main">${data.imc}</span></p>
                            <p><strong>Catégorie :</strong> <span class="imc-badge-cat">${data.categorie}</span></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="imc-result-description">${data.description}</p>
                    </div>
                    <div class="mt-3 d-flex gap-2 flex-wrap result-actions">
                        <button class="btn btn-imc-main" onclick="exporterPDF('${data.imc}', '${data.poids}', '${data.taille}', '${data.categorie}')">
                            Exporter en PDF
                        </button>
                        <button class="btn btn-imc-secondary" onclick="window.location.href='/regime/suggestion'">
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

        // fomba ficalculena anle barre
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
            <div class="mt-4 imc-progress-wrap">
                <label class="form-label fw-bold">Indice IMC</label>
                <div class="progress imc-progress" style="height: 30px;">
                    <div class="progress-bar imc-segment-1" style="width: 25%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                        Maigreur <br> &lt; 18.5
                    </div>
                    <div class="progress-bar imc-segment-2" style="width: 25%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                        Normal <br> 18.5-25
                    </div>
                    <div class="progress-bar imc-segment-3" style="width: 25%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                        Surpoids <br> 25-30
                    </div>
                    <div class="progress-bar imc-segment-4" style="width: 25%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                        Obésité <br> &gt; 30
                    </div>
                </div>
                <div style="position: relative; margin-top: -8px;">
                    <div style="position: absolute; left: ${position}%; transform: translateX(-50%); color: #7b4e63; font-weight: bold; font-size: 20px;">▼</div>
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
