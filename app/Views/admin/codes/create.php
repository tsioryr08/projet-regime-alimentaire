<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin — Créer un Code</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
  <div class="app">
    <aside class="sidebar">
      <div class="sidebar-brand"><div class="logo-icon"><svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div><div><div class="brand-name">Régime Pro</div><div class="brand-sub">Back Office admin</div></div></div>
      <div class="sidebar-section">Navigation</div>
      <a href="<?= site_url('admin/dashboard') ?>" class="nav-item"><svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>Tableau de bord</a>
      <a href="<?= site_url('admin/regimes') ?>" class="nav-item"><svg viewBox="0 0 24 24"><path d="M12 2v20"/><path d="M17 6H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H7"/></svg>Régimes</a>
      <a href="<?= site_url('admin/activites') ?>" class="nav-item"><svg viewBox="0 0 24 24"><path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z"/></svg>Activités</a>
      <a href="<?= site_url('admin/codes') ?>" class="nav-item active"><svg viewBox="0 0 24 24"><path d="M10 20l4-16"/><path d="M6 8l-4 4 4 4"/><path d="M18 8l4 4-4 4"/></svg>Codes</a>
      <a href="<?= site_url('admin/parametres') ?>" class="nav-item"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>Paramètres</a>
      <div class="sidebar-bottom"><a href="<?= site_url('admin/auth/logout') ?>" class="nav-item" style="margin:0 0 10px;"><svg viewBox="0 0 24 24"><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/><path d="M21 3v18"/></svg>Déconnexion</a></div>
    </aside>

    <main class="main">
      <div class="topbar">
        <div class="topbar-title">Codes - Nouveau</div>
      </div>
      <div class="content">

        <?php if(session()->getFlashdata('error')): ?>
          <div class="alert alert-error" style="padding: 15px; background-color: #f8d7da; color: #721c24; border-radius: 5px; margin-bottom: 20px;">
            <?= session()->getFlashdata('error') ?>
          </div>
        <?php endif; ?>

        <div class="form-card">
          <div class="card-header">
            <div class="card-title">Ajouter un nouveau code</div>
          </div>
          <form action="<?= site_url('admin/codes/create') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group" style="margin-bottom: 15px;">
              <label for="code" style="display: block; font-weight: 500; margin-bottom: 5px;">Nom du code</label>
              <input type="text" name="code" id="code" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" required placeholder="Ex: PROMO-1234">
            </div>
            
            <div class="form-group" style="margin-bottom: 15px;">
              <label for="montant" style="display: block; font-weight: 500; margin-bottom: 5px;">Montant (Ar)</label>
              <input type="number" step="0.01" name="montant" id="montant" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" required placeholder="Ex: 5000">
            </div>

            <div style="margin-top: 20px; display:flex; gap: 10px;">
              <button type="submit" class="btn btn-primary" style="padding: 10px 20px; background-color: #0f172a; color: white; border: none; border-radius: 5px; cursor: pointer; text-decoration: none;">Enregistrer</button>
              <a href="<?= site_url('admin/codes') ?>" class="btn btn-secondary" style="padding: 10px 20px; background-color: #f1f5f9; color: #333; border: none; border-radius: 5px; cursor: pointer; text-decoration: none;">Annuler</a>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>
</html>