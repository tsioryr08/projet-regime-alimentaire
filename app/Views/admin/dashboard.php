<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin — Tableau de bord</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
  <?php
    $dashboardData = [
      'utilisateursParObjectif' => $utilisateursParObjectif ?? [],
      'regimesPopulaires' => $regimesPopulaires ?? [],
      'repartitionGold' => $repartitionGold ?? [],
    ];
  ?>
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
      <a href="<?= site_url('admin/dashboard') ?>" class="nav-item active">
        <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
        Tableau de bord
      </a>

      <a href="<?= site_url('admin/regimes') ?>" class="nav-item">
        <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
        Régimes
        <span class="nav-badge"><?= esc($resume['totalRegimes'] ?? 0) ?></span>
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
        <a href="#" class="user-row">
          <div class="avatar">AD</div>
          <div class="user-info">
            <div class="name"><?= esc(session()->get('admin_email') ?? 'Administrateur') ?></div>
            <div class="role">Super administrateur</div>
          </div>
        </a>
      </div>
    </aside>

    <div class="main">
      <div class="topbar">
        <div class="topbar-title">Tableau de bord</div>
        <div class="topbar-search">
          <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" placeholder="Rechercher…" />
        </div>
        <div class="topbar-actions">
          <button class="icon-btn" type="button"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg><span class="notif-dot"></span></button>
          <button class="icon-btn" type="button"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg></button>
        </div>
      </div>

      <div class="content">
        <div class="page-header">
          <div>
            <h2>Tableau de bord</h2>
            <div class="breadcrumb">Accueil / <span>Statistiques du back office</span></div>
          </div>
          <a class="btn btn-primary btn-sm" href="<?= site_url('admin/auth/logout') ?>">
            <svg viewBox="0 0 24 24"><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/><path d="M21 3v18"/></svg>
            Déconnexion
          </a>
        </div>

        <div class="kpi-grid">
          <div class="kpi-card">
            <div class="kpi-header"><div class="kpi-label">Utilisateurs</div><div class="kpi-icon bg-blue"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div></div>
            <div class="kpi-value"><?= esc($resume['totalUtilisateurs'] ?? 0) ?></div>
            <div class="kpi-delta up">Base utilisateurs chargée</div>
          </div>
          <div class="kpi-card">
            <div class="kpi-header"><div class="kpi-label">Régimes</div><div class="kpi-icon bg-green"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div></div>
            <div class="kpi-value"><?= esc($resume['totalRegimes'] ?? 0) ?></div>
            <div class="kpi-delta up">Régimes disponibles</div>
          </div>
          <div class="kpi-card">
            <div class="kpi-header"><div class="kpi-label">Activités</div><div class="kpi-icon bg-amber"><svg viewBox="0 0 24 24"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg></div></div>
            <div class="kpi-value"><?= esc($resume['totalActivites'] ?? 0) ?></div>
            <div class="kpi-delta up">Activités sportives</div>
          </div>
          <div class="kpi-card">
            <div class="kpi-header"><div class="kpi-label">Codes</div><div class="kpi-icon bg-blue"><svg viewBox="0 0 24 24"><path d="M10 20l4-16"/><path d="M6 8l-4 4 4 4"/><path d="M18 8l4 4-4 4"/></svg></div></div>
            <div class="kpi-value"><?= esc($resume['totalCodes'] ?? 0) ?></div>
            <div class="kpi-delta up">Codes porte-monnaie</div>
          </div>
        </div>

        <div class="charts-grid">
          <div class="chart-box">
            <h3>Utilisateurs par objectif</h3>
            <canvas id="chartObjectives"></canvas>
            <div class="chart-table">
              <h4>Tableau croisé</h4>
              <table>
                <thead><tr><th>Objectif</th><th>Total</th></tr></thead>
                <tbody>
                  <?php foreach (($utilisateursParObjectif ?? []) as $row): ?>
                    <tr><td><?= esc($row['objectif']) ?></td><td><?= esc($row['total']) ?></td></tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="chart-box">
            <h3>Gold vs non-Gold</h3>
            <canvas id="chartGold"></canvas>
            <div class="chart-table">
              <h4>Tableau croisé</h4>
              <table>
                <thead><tr><th>Statut</th><th>Total</th></tr></thead>
                <tbody>
                  <?php foreach (($repartitionGold ?? []) as $row): ?>
                    <tr>
                      <td><?= ((int) $row['is_gold'] === 1) ? '<span class="badge green">Gold</span>' : '<span class="badge blue">Non-Gold</span>' ?></td>
                      <td><?= esc($row['total']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="chart-box">
            <h3>Régimes populaires</h3>
            <canvas id="chartRegimes"></canvas>
            <div class="chart-table">
              <h4>Tableau croisé</h4>
              <table>
                <thead><tr><th>Régime</th><th>Occurrences</th></tr></thead>
                <tbody>
                  <?php foreach (($regimesPopulaires ?? []) as $row): ?>
                    <tr><td><?= esc($row['nom'] ?? 'Sans nom') ?></td><td><?= esc($row['total']) ?></td></tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  <script>
    window.__dashboardData = <?= json_encode($dashboardData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
  </script>
  <script src="<?= base_url('js/charts.js?v=' . filemtime(FCPATH . 'js/charts.js')) ?>"></script>
</body>
</html>
