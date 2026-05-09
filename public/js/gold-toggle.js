//gestion toggle Gold et recalcul des prix en temps réel
document.addEventListener('DOMContentLoaded', function() {
    const goldToggle = document.getElementById('goldToggle');
    const goldContainer = document.querySelector('.gold-toggle-container');
    
    if (!goldToggle || !goldContainer) return;

    // toggle desactive par défaut
    goldToggle.checked = false;

    // ecouter les changements
    goldToggle.addEventListener('change', function() {
        const newIsGold = this.checked;
        const remiseGold = parseInt(goldContainer.dataset.remiseGold, 10);

        // Recalculer tous les prix
        const priceElements = document.querySelectorAll('[data-price-base]');
        priceElements.forEach(el => {
            const priceBase = parseFloat(el.dataset.priceBase);
            let displayPrice = priceBase;

            if (newIsGold) {
                const remise = (priceBase * remiseGold) / 100;
                displayPrice = priceBase - remise;
            }

            // Formater le prix
            el.textContent = new Intl.NumberFormat('fr-FR', {
                style: 'currency',
                currency: 'MGA',
                minimumFractionDigits: 2
            }).format(displayPrice);
        });

        // Maj de la session via AJAX (async, pas de wait)
        fetch('/regime/toggleGold', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ is_gold: newIsGold ? 1 : 0 })
        })
        .catch(err => console.error('Erreur lors du toggle Gold:', err));
    });
});
