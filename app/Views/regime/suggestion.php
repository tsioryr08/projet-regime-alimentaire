<?php
// Vue : suggestion de régimes et activités selon IMC + objectif
$session = session();
$isGoldActive = !empty($isGoldActive) ? (bool) $isGoldActive : (bool) $session->get('is_gold');
$userDisplayName = $utilisateurNom ?? ($session->get('user_nom') ?? 'Utilisateur');
$userDisplayEmail = $utilisateurEmail ?? ($session->get('user_email') ?? '');
$poidsCibleGlobal = $poidsCibleGlobal ?? null;
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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <?= $this->include('user/_navbar_styles') ?>
  <style>
    :root{
      --bg:#f8faf8; --card:#ffffff; --muted:#6b7280; --accent:#5f8f74; --accent-2:#c78ca7; --success:#10b981; --glass: rgba(255,255,255,0.72);
    }
    html,body{height:100%}
    body{
      font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color:var(--ink); -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale;
    }
    .suggestion-container{max-width:1100px;margin:0 auto;padding:56px 0 48px}
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
    .composition-box{
      margin-top:10px;
      padding:10px 12px;
      border-radius:12px;
      background:linear-gradient(180deg, rgba(247,250,244,.95) 0%, rgba(255,255,255,.96) 100%);
      border:1px solid rgba(169,205,177,.22);
      box-shadow:0 8px 20px rgba(119,96,111,.06);
    }
    .composition-title{font-size:12px;font-weight:800;color:#4f6f5b;letter-spacing:.3px;text-transform:uppercase;margin-bottom:8px}
    .composition-list{display:flex;flex-wrap:wrap;gap:8px}
    .composition-item{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border-radius:999px;background:#fff;border:1px solid rgba(201,132,161,.18);font-size:12px;color:#5b4750;font-weight:600}
    .composition-value{font-weight:800;color:#8a4f67}

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

    .price-stack{display:flex;flex-direction:column;align-items:flex-end;gap:4px}
    .price-original{font-size:13px;color:#94a3b8;text-decoration:line-through}
    .price-current{font-size:18px;font-weight:900;background:linear-gradient(90deg,#7b4e63 0,#c78ca7 45%,#f4c6d6 100%);-webkit-background-clip:text;background-clip:text;color:transparent;letter-spacing:.2px}
    .gold-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 10px;border-radius:999px;background:linear-gradient(135deg,#8a6500 0%,#d4af37 55%,#f8e7a8 100%);color:#5e4200;font-size:12px;font-weight:800;box-shadow:0 4px 15px rgba(212,175,55,0.22)}

    /* Rendu PDF : remplace les textes en dégradé par une couleur pleine lisible */
    .pdf-export-mode .price-main,
    .pdf-export-mode .price-current,
    .pdf-export-mode .price-original,
    .pdf-export-mode .gold-badge{
      background: none !important;
      -webkit-background-clip: initial !important;
      background-clip: initial !important;
      color: #b8860b !important;
      -webkit-text-fill-color: #b8860b !important;
    }

    .pdf-export-mode .price-current{
      font-weight: 800;
    }

    @media (max-width: 900px){
      .suggestion-container{padding:56px 16px 48px}
      .list-group-item{margin-bottom:12px}
      .price-stack{align-items:flex-start}
    }
  </style>
</head>
<body>
<?= $this->include('user/_navbar') ?>
  <?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success">
    <?= esc(session()->getFlashdata('success')) ?>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger">
    <?= esc(session()->getFlashdata('error')) ?>
  </div>
<?php endif; ?>
  <main class="suggestion-container">
    <h2 class="mb-4">Suggestions pour votre IMC</h2>

    <?php if (!empty($error)): ?>
      <div class="alert alert-warning"><?php echo esc($error) ?></div>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-6">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">Contexte</h5>
            <p>IMC détecté : <strong><?php echo esc($imc) ?? '-' ?></strong></p>
            <p>Catégorie : <strong><?php echo esc($categorie ?? '-') ?></strong></p>
            <p>Objectif : <strong><?php echo esc($objectifAffiche ?? $objectif ?? '-') ?></strong></p>
            <?php if (!empty($poidsActuel) && !empty($taille)): ?>
              <?php $tailleEnMetres = $taille > 10 ? $taille / 100 : $taille; ?>
              <p>Poids actuel : <strong><?php echo number_format($poidsActuel, 2, ',', ' ') ?> kg</strong></p>
              <p>Poids cible (IMC = 22) : <strong><?php echo number_format($poidsCibleGlobal ?? (22 * ($tailleEnMetres * $tailleEnMetres)), 2, ',', ' ') ?> kg</strong></p>
            <?php endif; ?>
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
        <?php if (isset($r['pct_viande']) || isset($r['pct_poisson']) || isset($r['pct_volaille'])): ?>
          <div class="composition-box">
            <div class="composition-title">Composition nutritionnelle</div>
            <div class="composition-list">
              <span class="composition-item">Viande <span class="composition-value"><?php echo number_format((float) ($r['pct_viande'] ?? 0), 0, ',', ' ') ?>%</span></span>
              <span class="composition-item">Poisson <span class="composition-value"><?php echo number_format((float) ($r['pct_poisson'] ?? 0), 0, ',', ' ') ?>%</span></span>
              <span class="composition-item">Volaille <span class="composition-value"><?php echo number_format((float) ($r['pct_volaille'] ?? 0), 0, ',', ' ') ?>%</span></span>
            </div>
          </div>
        <?php endif; ?>

        <!-- Bouton Commander -->
        <?php if (isset($r['id'])): ?>
          <form action="<?= site_url('imc/commander') ?>" method="post" class="mt-2">
            <?= csrf_field() ?>
            <input type="hidden" name="regime_id" value="<?= esc($r['id']) ?>">

            <!-- Première activité suggérée est sélectionnée automatiquement -->
            <?php if (!empty($activites)): ?>
              <input type="hidden" name="activite_id" value="<?= esc($activites[0]['id']) ?>">
            <?php else: ?>
              <input type="hidden" name="activite_id" value="1">
            <?php endif; ?>

            <!-- garder le contexte pour revenir sur la même suggestion -->
            <input type="hidden" name="imc" value="<?= esc($imc ?? '') ?>">
            <input type="hidden" name="objectif" value="<?= esc($objectif ?? '') ?>">

            <button type="submit" class="btn btn-sm btn-primary">
              Commander ce régime
            </button>
          </form>
        <?php endif; ?>
      </div>

      <div class="text-end">
        <?php if (isset($r['prix_base'])): ?>
          <?php $prixBase = (float) $r['prix_base']; ?>
          <?php $prixAffiche = $isGoldActive ? $prixBase * (1 - ((float) $remiseGold / 100)) : $prixBase; ?>
          <div class="price-stack">
            <?php if ($isGoldActive): ?>
              <span class="gold-badge">Gold actif - <?php echo esc($remiseGold) ?>% appliqué</span>
              <span class="price-original"><?php echo number_format($prixBase, 2, ',', ' ') ?> Ar</span>
            <?php endif; ?>
            <span class="price-current"><?php echo number_format($prixAffiche, 2, ',', ' ') ?> Ar</span>
          </div>
          <?php if ($isGoldActive): ?>
            <span class="price-note">Le prix Gold est appliqué automatiquement selon votre profil.</span>
          <?php else: ?>
            <span class="price-note">Prix standard du régime.</span>
          <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($r['duree_jours'])): ?>
          <div style="margin-top:8px;">
            <span class="meta-pill duration-pill"><?php echo esc($r['duree_jours']) ?> jours</span>
          </div>
        <?php endif; ?>

        <?php if (!empty($r['variation_par_semaine']) && !empty($r['poids_cible'])): ?>
          <div style="margin-top:12px; padding:10px; background:#f0f4f8; border-radius:8px; font-size:13px; color:#374151;">
            <strong>Évolution estimée:</strong><br>
            <span style="display:block; margin-top:4px;">• Variation/semaine: <?php echo number_format($r['variation_par_semaine'], 2, ',', ' ') ?> kg</span>
            <?php if (!empty($r['poids_actuel'])): ?>
              <span style="display:block; margin-top:4px;">• Poids final estimé: <?php echo number_format($r['poids_cible'], 2, ',', ' ') ?> kg (IMC=22)</span>
            <?php endif; ?>
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
  </main>

  <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
  <script>
    const pdfData = <?= json_encode([
      'user' => [
        'name' => $userDisplayName,
        'email' => $userDisplayEmail,
      ],
      'context' => [
        'imc' => $imc,
        'categorie' => $categorie ?? '-',
        'objectif' => $objectifAffiche ?? $objectif ?? '-',
        'poids_actuel' => $poidsActuel,
        'poids_cible' => $poidsCibleGlobal,
        'taille' => $taille,
        'gold_active' => $isGoldActive,
        'remise_gold' => $remiseGold,
      ],
      'regimes' => $regimes ?? [],
      'activites' => $activites ?? [],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

    const palette = {
      page: [247, 250, 244],
      header: [152, 190, 167],
      headerDark: [111, 149, 128],
      panel: [241, 247, 238],
      panelAlt: [229, 240, 232],
      border: [193, 214, 199],
      text: [38, 64, 52],
      muted: [92, 110, 99],
      badge: [120, 154, 137],
      accent: [96, 129, 112],
      white: [255, 255, 255],
    };

    const formatMoney = (value) => new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(Number(value || 0)) + ' Ar';
    const formatKg = (value) => new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(Number(value || 0)) + ' kg';
    const normalizeTaille = (taille) => {
      const value = Number(taille || 0);
      if (!value) return null;
      return value > 10 ? value / 100 : value;
    };
    const getCurrentPrice = (regime) => {
      const base = Number(regime.prix_base || 0);
      if (pdfData.context.gold_active) {
        return base * (1 - (Number(pdfData.context.remise_gold || 0) / 100));
      }
      return base;
    };
    const getVariationLabel = (regime) => {
      const variation = Number(regime.variation_par_semaine || 0);
      const prefix = regime.sens_variation === 'perte' ? '-' : '+';
      return `${prefix}${variation.toFixed(2).replace('.', ',')} kg/semaine`;
    };
    const getTargetWeightLabel = () => {
      const tailleMetres = normalizeTaille(pdfData.context.taille);
      if (!tailleMetres) return '-';
      return formatKg(22 * (tailleMetres * tailleMetres));
    };
    const addRoundedPanel = (pdf, x, y, w, h, fillColor, strokeColor) => {
      pdf.setFillColor(...fillColor);
      pdf.setDrawColor(...strokeColor);
      pdf.roundedRect(x, y, w, h, 10, 10, 'FD');
    };
    const addSectionTitle = (pdf, title, subtitle, x, y, width) => {
      pdf.setFillColor(...palette.panelAlt);
      pdf.setDrawColor(...palette.border);
      pdf.roundedRect(x, y, width, 42, 10, 10, 'FD');
      pdf.setFont('helvetica', 'bold');
      pdf.setFontSize(14);
      pdf.setTextColor(...palette.text);
      pdf.text(title, x + 14, y + 17);
      if (subtitle) {
        pdf.setFont('helvetica', 'normal');
        pdf.setFontSize(9);
        pdf.setTextColor(...palette.muted);
        pdf.text(subtitle, x + 14, y + 31);
      }
      return y + 54;
    };
    const exportSuggestionPdf = () => {
      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF({ orientation: 'portrait', unit: 'pt', format: 'a4' });
      const pageWidth = pdf.internal.pageSize.getWidth();
      const pageHeight = pdf.internal.pageSize.getHeight();
      const marginX = 34;
      const contentWidth = pageWidth - (marginX * 2);
      const bottomMargin = 40;
      let y = 34;

      const writeWrapped = (text, x, yPos, width, fontSize = 10, color = palette.text, style = 'normal', lineHeight = 1.35) => {
        pdf.setFont('helvetica', style);
        pdf.setFontSize(fontSize);
        pdf.setTextColor(...color);
        const lines = pdf.splitTextToSize(String(text || ''), width);
        pdf.text(lines, x, yPos);
        return lines.length * fontSize * lineHeight;
      };

      const ensureSpace = (neededHeight) => {
        if (y + neededHeight > pageHeight - bottomMargin) {
          pdf.addPage();
          pdf.setFillColor(...palette.page);
          pdf.rect(0, 0, pageWidth, pageHeight, 'F');
          y = 34;
          drawHeader();
        }
      };

      const drawHeader = () => {
        pdf.setFillColor(...palette.header);
        pdf.roundedRect(marginX, y, contentWidth, 88, 16, 16, 'F');
        pdf.setFont('helvetica', 'bold');
        pdf.setFontSize(20);
        pdf.setTextColor(...palette.white);
        pdf.text('Suggestions Régime & Activités', marginX + 18, y + 28);
        pdf.setFont('helvetica', 'normal');
        pdf.setFontSize(10);
        pdf.text('Document de suivi personnalisé', marginX + 18, y + 46);
        pdf.setFont('helvetica', 'bold');
        pdf.text(`Utilisateur : ${pdfData.user.name || 'Utilisateur'}`, marginX + 18, y + 62);
        pdf.setFont('helvetica', 'normal');
        pdf.text(`Généré le : ${new Date().toLocaleDateString('fr-FR')}`, marginX + 18, y + 76);
        y += 106;
      };

      pdf.setFillColor(...palette.page);
      pdf.rect(0, 0, pageWidth, pageHeight, 'F');
      drawHeader();

      y = addSectionTitle(pdf, 'Profil & objectif', 'Résumé des données prises en compte', marginX, y, contentWidth);
      ensureSpace(128);
      const boxWidth = (contentWidth - 12) / 2;
      const infoHeight = 92;
      addRoundedPanel(pdf, marginX, y, boxWidth, infoHeight, palette.panel, palette.border);
      addRoundedPanel(pdf, marginX + boxWidth + 12, y, boxWidth, infoHeight, palette.panel, palette.border);

      pdf.setFont('helvetica', 'bold');
      pdf.setFontSize(10);
      pdf.setTextColor(...palette.badge);
      pdf.text('Utilisateur', marginX + 14, y + 18);
      pdf.text('IMC / Objectif', marginX + boxWidth + 26, y + 18);

      pdf.setFont('helvetica', 'normal');
      pdf.setFontSize(10);
      pdf.setTextColor(...palette.text);
      writeWrapped(pdfData.user.name || 'Utilisateur', marginX + 14, y + 35, boxWidth - 28, 11);
      if (pdfData.user.email) {
        pdf.setTextColor(...palette.muted);
        writeWrapped(pdfData.user.email, marginX + 14, y + 53, boxWidth - 28, 9);
      }

      const contextRight = [
        `IMC : ${Number(pdfData.context.imc || 0).toFixed(2)}`,
        `Catégorie : ${pdfData.context.categorie || '-'}`,
        `Objectif : ${pdfData.context.objectif || '-'}`,
        `Poids actuel : ${formatKg(pdfData.context.poids_actuel || 0)}`,
        `Poids cible (IMC = 22) : ${pdfData.context.poids_cible ? formatKg(pdfData.context.poids_cible) : '-'}`,
      ];
      let contextY = y + 35;
      contextRight.forEach((line) => {
        pdf.setTextColor(...palette.text);
        pdf.text(line, marginX + boxWidth + 26, contextY);
        contextY += 15;
      });
      y += infoHeight + 18;

      y = addSectionTitle(pdf, 'Régimes suggérés', 'Prix normal ou réduit selon votre statut Gold', marginX, y, contentWidth);
      if (!pdfData.regimes.length) {
        ensureSpace(50);
        pdf.setFont('helvetica', 'normal');
        pdf.setFontSize(10);
        pdf.setTextColor(...palette.muted);
        pdf.text('Aucun régime disponible pour ces critères.', marginX + 14, y + 18);
        y += 30;
      } else {
        pdfData.regimes.forEach((regime) => {
          const descLines = pdf.splitTextToSize(String(regime.description || ''), contentWidth - 160);
          const compositionLines = [
            `Viande : ${Number(regime.pct_viande || 0).toFixed(0)}%`,
            `Poisson : ${Number(regime.pct_poisson || 0).toFixed(0)}%`,
            `Volaille : ${Number(regime.pct_volaille || 0).toFixed(0)}%`,
          ];
          const cardHeight = 20 + (descLines.length * 12) + 18 + (compositionLines.length * 14) + (pdfData.context.gold_active ? 34 : 18) + (regime.duree_jours ? 16 : 0) + (regime.poids_cible ? 32 : 0) + 22;
          ensureSpace(cardHeight + 12);
          addRoundedPanel(pdf, marginX, y, contentWidth, cardHeight, palette.panel, palette.border);

          pdf.setFont('helvetica', 'bold');
          pdf.setFontSize(12);
          pdf.setTextColor(...palette.text);
          pdf.text(regime.nom || 'Régime', marginX + 14, y + 18);

          pdf.setFont('helvetica', 'normal');
          pdf.setFontSize(9.5);
          pdf.setTextColor(...palette.muted);
          if (descLines.length) {
            pdf.text(descLines, marginX + 14, y + 33);
          }

          let bodyY = y + 33 + (descLines.length * 12);
          pdf.setFont('helvetica', 'bold');
          pdf.setFontSize(10);
          pdf.setTextColor(...palette.badge);
          pdf.text('Composition nutritionnelle', marginX + 14, bodyY + 12);

          pdf.setFont('helvetica', 'normal');
          pdf.setFontSize(9.5);
          pdf.setTextColor(...palette.text);
          pdf.text(compositionLines, marginX + 20, bodyY + 27);

          bodyY += 50;
          pdf.setFontSize(10);
          pdf.setTextColor(...palette.text);

          if (pdfData.context.gold_active) {
            pdf.setFont('helvetica', 'bold');
            pdf.text(`Prix normal : ${formatMoney(regime.prix_base)}`, marginX + 14, bodyY + 14);
            pdf.setTextColor(...palette.headerDark);
            pdf.text(`Prix Gold : ${formatMoney(getCurrentPrice(regime))}`, marginX + 14, bodyY + 28);
          } else {
            pdf.setFont('helvetica', 'bold');
            pdf.text(`Prix : ${formatMoney(regime.prix_base)}`, marginX + 14, bodyY + 14);
          }

          let metaY = bodyY + (pdfData.context.gold_active ? 42 : 24);
          if (regime.duree_jours) {
            pdf.setFont('helvetica', 'normal');
            pdf.setTextColor(...palette.text);
            pdf.text(`Durée estimée : ${regime.duree_jours} jours`, marginX + 14, metaY);
            metaY += 14;
          }
          if (regime.variation_par_semaine !== undefined && regime.variation_par_semaine !== null) {
            pdf.text(`Variation estimée / semaine : ${getVariationLabel(regime)}`, marginX + 14, metaY);
            metaY += 14;
          }
          if (regime.poids_cible) {
            pdf.text(`Poids cible estimé : ${formatKg(regime.poids_cible)} (IMC = 22)`, marginX + 14, metaY);
          }

          y += cardHeight + 12;
        });
      }

      y = addSectionTitle(pdf, 'Activités suggérées', 'Durée et fréquence recommandées', marginX, y, contentWidth);
      if (!pdfData.activites.length) {
        ensureSpace(50);
        pdf.setFont('helvetica', 'normal');
        pdf.setFontSize(10);
        pdf.setTextColor(...palette.muted);
        pdf.text('Aucune activité disponible pour ces critères.', marginX + 14, y + 18);
        y += 30;
      } else {
        pdfData.activites.forEach((activite) => {
          const descLines = pdf.splitTextToSize(String(activite.description || ''), contentWidth - 140);
          const cardHeight = 20 + (descLines.length * 12) + 34;
          ensureSpace(cardHeight + 12);
          addRoundedPanel(pdf, marginX, y, contentWidth, cardHeight, palette.panelAlt, palette.border);

          pdf.setFont('helvetica', 'bold');
          pdf.setFontSize(12);
          pdf.setTextColor(...palette.text);
          pdf.text(activite.nom || 'Activité', marginX + 14, y + 18);

          pdf.setFont('helvetica', 'normal');
          pdf.setFontSize(9.5);
          pdf.setTextColor(...palette.muted);
          if (descLines.length) {
            pdf.text(descLines, marginX + 14, y + 33);
          }

          let metaY = y + 33 + (descLines.length * 12);
          pdf.setFontSize(10);
          pdf.setTextColor(...palette.text);
          if (activite.duree_semaines) {
            pdf.text(`Durée estimée : ${activite.duree_semaines} semaines`, marginX + 14, metaY);
            metaY += 14;
          }
          if (activite.frequence) {
            pdf.text(`Fréquence : ${activite.frequence}`, marginX + 14, metaY);
          }

          y += cardHeight + 12;
        });
      }

      const totalPages = pdf.getNumberOfPages();
      for (let pageIndex = 1; pageIndex <= totalPages; pageIndex += 1) {
        pdf.setPage(pageIndex);
        const footerY = pageHeight - 24;
        pdf.setDrawColor(...palette.border);
        pdf.line(marginX, footerY - 10, pageWidth - marginX, footerY - 10);
        pdf.setFont('helvetica', 'normal');
        pdf.setFontSize(8.5);
        pdf.setTextColor(...palette.muted);
        pdf.text('Regime Pro', marginX, footerY);
        pdf.text(`Poids cible global : ${getTargetWeightLabel()}`, pageWidth / 2 - 45, footerY);
        pdf.text(`Page ${pageIndex}/${totalPages}`, pageWidth - marginX - 54, footerY);
      }

      pdf.save('suggestions_imc.pdf');
    };

    document.getElementById('exportPdf')?.addEventListener('click', () => {
      try {
        exportSuggestionPdf();
      } catch (err) {
        console.error(err);
        alert('Erreur export PDF');
      }
    });
  </script>
  <?= $this->include('user/_footer') ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
