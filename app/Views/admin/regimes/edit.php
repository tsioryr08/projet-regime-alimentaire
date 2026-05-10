<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin — Modifier un régime</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
  <div class="app">
    <aside class="sidebar">
      <div class="sidebar-brand">
        <div class="logo-icon">
          <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <div>
          <div class="brand-name">Régime Pro</div>
          <div class="brand-sub">Back Office admin</div>
        </div>
      </div>

      <div class="sidebar-section">Navigation</div>
      <a href="<?= site_url('admin/dashboard') ?>" class="nav-item">
        <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
        Tableau de bord
      </a>
      <a href="<?= site_url('admin/regimes') ?>" class="nav-item active">
        <svg viewBox="0 0 24 24"><path d="M12 2v20"/><path d="M17 6H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H7"/></svg>
        Régimes
      </a>
      <a href="<?= site_url('admin/activites') ?>" class="nav-item">
        <svg viewBox="0 0 24 24"><path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z"/></svg>
        Activités
      </a>
      <a href="<?= site_url('admin/codes') ?>" class="nav-item">
        <svg viewBox="0 0 24 24"><path d="M10 20l4-16"/><path d="M6 8l-4 4 4 4"/><path d="M18 8l4 4-4 4"/></svg>
        Codes
      </a>
      <a href="<?= site_url('admin/parametres') ?>" class="nav-item">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
        Paramètres
      </a>

      <div class="sidebar-bottom">
        <a href="<?= site_url('admin/auth/logout') ?>" class="nav-item" style="margin:0 0 10px;">
          <svg viewBox="0 0 24 24"><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/><path d="M21 3v18"/></svg>
          Déconnexion
        </a>
      </div>
    </aside>

    <main class="main">
      <div class="topbar">
        <div class="topbar-title">Modifier un régime</div>
        <div class="topbar-actions">
          <a class="btn btn-secondary btn-sm" href="<?= site_url('admin/regimes') ?>">Retour</a>
          <a class="btn btn-ghost btn-sm" href="<?= site_url('admin/regimes/create') ?>">Nouveau régime</a>
        </div>
      </div>

      <div class="content">
        <div class="page-head" style="margin-bottom:18px;">
          <h1 style="font-size:28px; margin:0 0 6px;">Modifier un régime</h1>
          <p style="color:var(--c-muted); margin:0;">Mettez à jour les paramètres du régime et ses critères nutritionnels.</p>
        </div>

        <div class="form-card">
          <form method="post" action="<?= site_url('admin/regimes/edit/' . ($regime['id'] ?? 0)) ?>">
            <?= csrf_field() ?>

            <div class="form-section-title">Informations générales</div>
            <div class="form-grid cols-2">
              <div>
                <label class="field-label" for="nom">Nom<span class="required">*</span></label>
                <input id="nom" name="nom" value="<?= esc($regime['nom'] ?? '') ?>" required>
              </div>
              <div>
                <label class="field-label" for="categorie_imc">Catégorie IMC</label>
                <input id="categorie_imc" name="categorie_imc" value="<?= esc($regime['categorie_imc'] ?? '') ?>" placeholder="Ex. Normal, Surpoids, Obésité">
              </div>
              <div class="section-gap" style="grid-column:1/-1;">
                <label class="field-label" for="description">Description</label>
                <textarea id="description" name="description" placeholder="Décrivez le régime..."><?= esc($regime['description'] ?? '') ?></textarea>
              </div>
            </div>

            <div class="form-section-title">Paramètres du régime</div>
            <div class="form-grid cols-3">
              <div>
                <label class="field-label" for="prix_base">Prix de base</label>
                <input id="prix_base" name="prix_base" type="number" step="0.01" value="<?= esc($regime['prix_base'] ?? '') ?>">
              </div>
              <div>
                <label class="field-label" for="duree_jours">Durée (jours)</label>
                <input id="duree_jours" name="duree_jours" type="number" value="<?= esc($regime['duree_jours'] ?? '') ?>">
              </div>
              <div>
                <label class="field-label" for="variation_poids">Variation de poids</label>
                <input id="variation_poids" name="variation_poids" type="number" step="0.01" value="<?= esc($regime['variation_poids'] ?? '') ?>">
              </div>
              <div>
                <label class="field-label" for="sens_variation">Sens variation</label>
                <input id="sens_variation" name="sens_variation" value="<?= esc($regime['sens_variation'] ?? '') ?>" placeholder="prise ou perte">
              </div>
              <div>
                <label class="field-label" for="pct_viande">% viande</label>
                <input id="pct_viande" name="pct_viande" type="number" step="0.01" value="<?= esc($regime['pct_viande'] ?? '') ?>">
              </div>
              <div>
                <label class="field-label" for="pct_poisson">% poisson</label>
                <input id="pct_poisson" name="pct_poisson" type="number" step="0.01" value="<?= esc($regime['pct_poisson'] ?? '') ?>">
              </div>
              <div>
                <label class="field-label" for="pct_volaille">% volaille</label>
                <input id="pct_volaille" name="pct_volaille" type="number" step="0.01" value="<?= esc($regime['pct_volaille'] ?? '') ?>">
              </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:12px;">
              <a class="btn btn-secondary" href="<?= site_url('admin/regimes') ?>">Annuler</a>
              <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
