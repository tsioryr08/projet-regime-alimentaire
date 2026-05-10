<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin — Créer une activité</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
  <div class="app">
    <aside class="sidebar">
      <div class="sidebar-brand"><div class="logo-icon"><svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div><div><div class="brand-name">Régime Pro</div><div class="brand-sub">Back Office admin</div></div></div>
      <div class="sidebar-section">Navigation</div>
      <a href="<?= site_url('admin/dashboard') ?>" class="nav-item"><svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>Tableau de bord</a>
      <a href="<?= site_url('admin/regimes') ?>" class="nav-item"><svg viewBox="0 0 24 24"><path d="M12 2v20"/><path d="M17 6H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H7"/></svg>Régimes</a>
      <a href="<?= site_url('admin/activites') ?>" class="nav-item active"><svg viewBox="0 0 24 24"><path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z"/></svg>Activités</a>
      <a href="<?= site_url('admin/codes') ?>" class="nav-item"><svg viewBox="0 0 24 24"><path d="M10 20l4-16"/><path d="M6 8l-4 4 4 4"/><path d="M18 8l4 4-4 4"/></svg>Codes</a>
      <a href="<?= site_url('admin/parametres') ?>" class="nav-item"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>Paramètres</a>
      <div class="sidebar-bottom"><a href="<?= site_url('admin/auth/logout') ?>" class="nav-item" style="margin:0 0 10px;"><svg viewBox="0 0 24 24"><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/><path d="M21 3v18"/></svg>Déconnexion</a></div>
    </aside>

    <main class="main">
      <div class="topbar"><div class="topbar-title">Créer une activité</div><div class="topbar-actions"><a class="btn btn-secondary btn-sm" href="<?= site_url('admin/activites') ?>">Retour</a></div></div>
      <div class="content">
        <div class="form-card">
          <form method="post" action="<?= site_url('admin/activites/create') ?>">
            <?= csrf_field() ?>
            <div class="form-section-title">Informations de l'activité</div>
            <div class="form-grid cols-2">
              <div><label class="field-label" for="nom">Nom<span class="required">*</span></label><input id="nom" name="nom" placeholder="Nom" required></div>
              <div><label class="field-label" for="categorie_imc">Catégorie IMC</label><input id="categorie_imc" name="categorie_imc" placeholder="Categorie IMC"></div>
              <div><label class="field-label" for="duree_semaines">Durée (semaines)</label><input id="duree_semaines" name="duree_semaines" placeholder="Durée semaines"></div>
              <div><label class="field-label" for="frequence">Fréquence</label><input id="frequence" name="frequence" placeholder="Fréquence"></div>
              <div><label class="field-label" for="calories_par_h">Calories / heure</label><input id="calories_par_h" name="calories_par_h" placeholder="Calories/h"></div>
              <div><label class="field-label" for="objectif_cible">Objectif cible</label><input id="objectif_cible" name="objectif_cible" placeholder="Objectif cible"></div>
              <div style="grid-column:1/-1;"><label class="field-label" for="description">Description</label><textarea id="description" name="description" placeholder="Description"></textarea></div>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:12px;"><a class="btn btn-secondary" href="<?= site_url('admin/activites') ?>">Annuler</a><button type="submit" class="btn btn-primary">Enregistrer</button></div>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
