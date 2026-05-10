<?php
// Vue : suggestion de régimes et activités selon IMC + objectif
$session = session();
$isGoldActive = 0;
// remiseGold passee dynamiquement depuis le controller
if (!isset($remiseGold)) {
    $remiseGold = 15; // Fallback si non defini
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Suggestions — Régime & Activités</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    :root{
      --bg:#f8faf8; --card:#ffffff; --muted:#6b7280; --accent:#5f8f74; --accent-2:#c78ca7; --success:#10b981; --glass: rgba(255,255,255,0.72);
    }
    html,body{height:100%}
    body{
      background:
        radial-gradient(circle at top left, rgba(169, 205, 177, 0.35) 0%, rgba(169, 205, 177, 0) 36%),
        radial-gradient(circle at bottom right, rgba(244, 198, 214, 0.32) 0%, rgba(244, 198, 214, 0) 40%),
        linear-gradient(180deg,#fbfcfb 0,#fff8fb 42%,var(--bg) 100%);
      padding:32px; font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color:#0f172a; -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale;
    }
    .container{max-width:1100px;margin:0 auto}
    h2{font-size:26px;margin-bottom:18px;color:var(--accent)}

    .card{background:linear-gradient(180deg, rgba(255,255,255,.96) 0%, rgba(255,248,251,.94) 100%);border-radius:14px;box-shadow:0 14px 30px rgba(119,96,111,.10);border:1px solid rgba(169,205,177,.22)}
    .card .card-body{padding:20px}

    .contexte-card{margin-bottom:16px}
    .contexte-card p{margin:6px 0}

    .adjustment-card{
      border-radius:20px;
      border:1px solid rgba(196,154,120,.28);
      background:
        linear-gradient(180deg, rgba(255,244,248,.98) 0%, rgba(255,233,241,.96) 100%);
      box-shadow: 0 18px 34px rgba(196,154,120,.14);
      margin-top:28px;
    }

    .adjustment-card .card-body{padding:22px 22px 20px}
    .adjustment-title{font-weight:800;color:#7a4b48;margin-bottom:10px;display:flex;align-items:center;gap:8px;font-size:1.02rem}
    .adjustment-list{margin:0;padding-left:18px;color:#5a5a5a;line-height:1.7}
    .adjustment-list li{margin-bottom:6px}
    .adjustment-note{margin-top:12px;color:#7a6a66;font-size:14px}

    .list-group-item{border-radius:10px;border:1px solid rgba(15,23,42,.04);margin-bottom:10px}
    .list-group-item:hover{transform:translateY(-4px);box-shadow:0 14px 30px rgba(15,23,42,.08)}

    .meta-pill{display:inline-block;padding:8px 12px;border-radius:999px;font-weight:700;color:#fff;font-size:14px}
    .price-main{font-size:18px;font-weight:900;background:linear-gradient(90deg,#7b4e63 0,#c78ca7 45%,#f4c6d6 100%);-webkit-background-clip:text;background-clip:text;color:transparent;letter-spacing:.2px}
    .price-note{display:block;margin-top:8px;font-size:12px;color:#64748b;font-style:italic}
    .duration-pill{background:linear-gradient(90deg,#7ead95,#a9cdb1);box-shadow:0 8px 24px rgba(169,205,177,.22)}
    .freq-text{display:block;font-weight:700;color:var(--muted);font-size:13px;margin-top:6px}

    .card-title{font-weight:800;color:#2f4f3f}
    .text-muted.small{color:var(--muted)}

    .btn-ghost{background:transparent;border:1px solid rgba(169,205,177,.35);padding:10px 14px;border-radius:10px}

    .actions-bar{
      margin-top: 10px;
      background: linear-gradient(180deg, rgba(255,248,251,.92) 0%, rgba(255,255,255,.95) 100%);
      border: 1px solid rgba(244,198,214,.28);
      border-radius: 12px;
      padding: 10px;
    }

    .btn-export-pdf{
      background: linear-gradient(135deg, #f6d7e3 0%, #efc2d3 100%);
      color: #6e4055;
      border: 1px solid rgba(201,132,161,.25);
      font-weight: 700;
    }

    .btn-export-pdf:hover{
      background: linear-gradient(135deg, #f3cfdc 0%, #ebb7cc 100%);
      color: #5e3648;
      border-color: rgba(201,132,161,.35);
    }

    /* === Gold Toggle Switch === */
    .gold-toggle-container{
      background: linear-gradient(135deg, rgba(15,23,42,0.02) 0%, rgba(212,175,55,0.08) 100%);
      border: 1px solid rgba(212,175,55,0.18);
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .gold-toggle-label{
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .gold-toggle-label .label-text{
      font-weight: 700;
      background: linear-gradient(90deg,#7a5a00 0%,#d4af37 42%,#f6e8a8 100%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      font-size: 14px;
      letter-spacing: .2px;
    }

    .gold-toggle-label .label-desc{
      font-size: 12px;
      color: #8a7a45;
    }

    /* Toggle Switch - Style WiFi/Interrupteur */
    .toggle-switch{
      position: relative;
      display: inline-block;
      width: 60px;
      height: 32px;
    }

    .toggle-switch input{
      opacity: 0;
      width: 0;
      height: 0;
    }

    .toggle-switch .slider{
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #cbd5e1;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border-radius: 20px;
    }

    .toggle-switch .slider:before{
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border-radius: 50%;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .toggle-switch input:checked + .slider{
      background: linear-gradient(135deg, #8a6500 0%, #d4af37 55%, #f8e7a8 100%);
      box-shadow: 0 4px 15px rgba(212,175,55,0.35);
    }

    .toggle-switch input:checked + .slider:before{
      transform: translateX(28px);
    }

    .toggle-switch input:hover + .slider{
      box-shadow: 0 2px 12px rgba(0,0,0,0.15);
    }

    /* Rendu PDF : remplace les textes en dégradé par une couleur pleine lisible */
    .pdf-export-mode .price-main,
    .pdf-export-mode .gold-toggle-label .label-text{
      background: none !important;
      -webkit-background-clip: initial !important;
      background-clip: initial !important;
      color: #b8860b !important;
      -webkit-text-fill-color: #b8860b !important;
    }

    .pdf-export-mode .price-main{
      font-weight: 800;
    }

    @media (max-width: 900px){
      .container{padding:0 16px}
      .list-group-item{margin-bottom:12px}
      .gold-toggle-container{flex-direction: column;gap: 12px;align-items: flex-start}
    }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="mb-4">Suggestions pour votre IMC</h2>

    <?php if (!empty($error)): ?>
      <div class="alert alert-warning"><?php echo esc($error) ?></div>
    <?php endif; ?>

    <!-- Gold Toggle Switch -->
    <div class="gold-toggle-container" data-remise-gold="<?php echo $remiseGold ?>">
      <div class="gold-toggle-label">
        <span class="label-text">Devenir Gold maintenant</span>
        <span class="label-desc">Obtenez <?php echo $remiseGold ?>% de remise sur tous les régimes</span>
      </div>
      <label class="toggle-switch">
        <input type="checkbox" id="goldToggle" data-is-gold="<?php echo $isGoldActive ?>" aria-label="Activer ou désactiver l'option Gold">
        <span class="slider" aria-hidden="true"></span>
      </label>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">Contexte</h5>
            <p>IMC détecté : <strong><?php echo esc($imc) ?? '-' ?></strong></p>
            <p>Catégorie : <strong><?php echo esc($categorie ?? '-') ?></strong></p>
            <p>Objectif : <strong><?php echo isset($objectif) && $objectif ? esc($objectif) : '-' ?></strong></p>
          </div>
        </div>

        <?php if (($categorie ?? '') === 'normal' && empty($objectif)): ?>
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title">Choisissez un objectif</h5>
              <p>Votre IMC est dans la zone normale. Choisissez si vous souhaitez augmenter ou réduire votre poids.</p>
              <div class="d-flex gap-2">
                <a href="/regime/suggestion?imc=<?php echo urlencode($imc) ?>&objectif=augmenter_poids" class="btn btn-success">Augmenter le poids</a>
                <a href="/regime/suggestion?imc=<?php echo urlencode($imc) ?>&objectif=reduire_poids" class="btn btn-danger">Réduire le poids</a>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Régimes suggérés</h5>
            <?php if (!empty($regimes)): ?>
              <ul class="list-group">
                <?php foreach ($regimes as $r): ?>
                  <li class="list-group-item">
                    <div class="d-flex justify-content-between">
                      <div>
                        <strong><?php echo esc($r['nom']) ?></strong>
                        <div class="text-muted small"><?php echo esc($r['description'] ?? '') ?></div>
                      </div>
                      <div class="text-end">
                        <?php if (isset($r['prix_base'])): ?>
                          <?php $prixBase = (float) $r['prix_base']; ?>
                          <span class="price-main" data-price-base="<?php echo $prixBase ?>">
                            <?php echo number_format($prixBase, 2, ',', ' ') ?> Ar
                          </span>
                          <span class="price-note">⭐ Bénéficiez d'une remise si vous optez pour l'option Gold</span>
                        <?php endif; ?>
                        <?php if (isset($r['duree_jours'])): ?>
                          <div style="margin-top:8px;">
                            <span class="meta-pill duration-pill"><?php echo esc($r['duree_jours']) ?> jours</span>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p class="text-muted">Aucun régime trouvé pour ces critères.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">Activités suggérées</h5>
            <?php if (!empty($activites)): ?>
              <ul class="list-group">
                <?php foreach ($activites as $a): ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                      <strong><?php echo esc($a['nom']) ?></strong>
                      <div class="text-muted small"><?php echo esc($a['description'] ?? '') ?></div>
                    </div>
                    <div class="text-end small">
                      <?php if (!empty($a['duree_semaines']) || !empty($a['frequence'])): ?>
                        <?php $dur = !empty($a['duree_semaines']) ? esc($a['duree_semaines']) . ' semaines' : ''; ?>
                        <?php $freq = !empty($a['frequence']) ? esc($a['frequence']) : ''; ?>
                        <div class="meta-pill duration-pill"><?php echo trim($dur . ($dur && $freq ? ' — ' : '') . $freq) ?></div>
                      <?php endif; ?>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p class="text-muted">Aucune activité trouvée pour ces critères.</p>
            <?php endif; ?>
          </div>
        </div>

        <div class="d-flex gap-2 actions-bar">
          <a href="/imc" class="btn btn-secondary">← Recalculer IMC</a>
          <button id="exportPdf" class="btn btn-export-pdf">Exporter en PDF</button>
        </div>
      </div>
    </div>

    <?php if (!empty($objectifAjuste)): ?>
      <div class="card adjustment-card">
        <div class="card-body">
          <div class="adjustment-title">⚠️ Votre objectif a été ajusté</div>
          <ul class="adjustment-list">
            <li><strong>Vous avez choisi :</strong> <?php echo esc($objectifInitialLabel ?? 'Non défini') ?></li>
            <li><strong>Votre IMC actuel :</strong> <?php echo esc($imc) ?> (<?php echo esc($categorieLabel ?? ucfirst($categorie ?? '')) ?>)</li>
            <li><strong>Objectif suggéré :</strong> <?php echo esc($objectifFinalLabel ?? 'Non défini') ?></li>
          </ul>
          <p class="adjustment-note"><?php echo esc($ajustementMessage ?? 'Votre objectif a été adapté en fonction de votre IMC actuel.') ?></p>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
  <script src="/js/gold-toggle.js"></script>
  <script>
    document.getElementById('exportPdf')?.addEventListener('click', async () => {
      const container = document.querySelector('.container');
      if (!container) return alert('Rien à exporter');

      document.body.classList.add('pdf-export-mode');
      await new Promise(requestAnimationFrame);

      html2canvas(container, {scale: 1.5}).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF({orientation: 'portrait', unit: 'pt', format: 'a4'});
        const pageWidth = pdf.internal.pageSize.getWidth();
        const imgWidth = pageWidth - 40;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        pdf.addImage(imgData, 'PNG', 20, 20, imgWidth, imgHeight);
        pdf.save('suggestions_imc.pdf');
      }).catch(err => { console.error(err); alert('Erreur export PDF'); })
        .finally(() => document.body.classList.remove('pdf-export-mode'));
    });
  </script>
</body>
</html>
