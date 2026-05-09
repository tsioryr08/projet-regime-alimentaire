<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin — Tableau de bord</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
  <style>
    :root{
      --bg:#f4f6fb;--sidebar:#111827;--sidebar-2:#0f172a;--panel:#ffffff;--panel-soft:#f8fafc;--text:#0f172a;--muted:#64748b;--border:#e5e7eb;
      --primary:#4f46e5;--primary-soft:rgba(79,70,229,.14);--success:#22c55e;--success-soft:rgba(34,197,94,.14);--warning:#f59e0b;--warning-soft:rgba(245,158,11,.14);--danger:#ef4444;--danger-soft:rgba(239,68,68,.14);--info:#0ea5e9;--info-soft:rgba(14,165,233,.14)
    }
    *{box-sizing:border-box}
    body{margin:0;font-family:Inter,Arial,sans-serif;background:linear-gradient(180deg,#eef2ff 0,#f8fafc 35%,#f4f6fb 100%);color:var(--text)}
    a{color:inherit;text-decoration:none}
    .app{display:flex;min-height:100vh}
    .sidebar{width:290px;background:linear-gradient(180deg,var(--sidebar) 0,var(--sidebar-2) 100%);color:#e5e7eb;padding:22px 18px;position:sticky;top:0;height:100vh;overflow:auto;box-shadow:12px 0 40px rgba(15,23,42,.12)}
    .sidebar-brand{display:flex;align-items:center;gap:12px;margin-bottom:22px;padding:12px 10px;border-radius:16px;background:rgba(255,255,255,.04)}
    .logo-icon{width:42px;height:42px;border-radius:14px;display:grid;place-items:center;background:linear-gradient(135deg,#4f46e5,#38bdf8);color:#fff;box-shadow:0 12px 24px rgba(79,70,229,.35)}
    .brand-name{font-weight:800;font-size:18px;line-height:1.1} .brand-sub{color:#94a3b8;font-size:12px;margin-top:2px}
    .sidebar-section{margin:20px 8px 10px;font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:#94a3b8}
    .nav-item{display:flex;align-items:center;gap:12px;padding:12px 14px;border-radius:14px;color:#cbd5e1;margin-bottom:8px;transition:.2s ease;background:transparent}
    .nav-item svg{width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2;flex:none}
    .nav-item.active,.nav-item:hover{background:rgba(255,255,255,.08);color:#fff}
    .nav-badge{margin-left:auto;background:rgba(255,255,255,.12);color:#fff;font-size:12px;padding:4px 8px;border-radius:999px}
    .sidebar-bottom{margin-top:24px;padding-top:18px;border-top:1px solid rgba(255,255,255,.08)}
    .user-row{display:flex;align-items:center;gap:12px;padding:10px;border-radius:14px;background:rgba(255,255,255,.04)}
    .avatar{width:38px;height:38px;border-radius:50%;display:grid;place-items:center;background:linear-gradient(135deg,#22c55e,#0ea5e9);font-weight:800;color:#fff}
    .name{font-weight:700}.role{font-size:12px;color:#94a3b8}

    .main{flex:1;min-width:0}
    .topbar{display:flex;align-items:center;gap:14px;justify-content:space-between;padding:20px 28px;border-bottom:1px solid rgba(15,23,42,.08);background:rgba(255,255,255,.72);backdrop-filter:blur(14px);position:sticky;top:0;z-index:10}
    .topbar-title{font-size:20px;font-weight:800;color:var(--text)}
    .topbar-search{flex:1;max-width:520px;display:flex;align-items:center;gap:10px;padding:12px 14px;border:1px solid var(--border);border-radius:16px;background:#fff;box-shadow:0 6px 22px rgba(15,23,42,.04)}
    .topbar-search svg{width:18px;height:18px;stroke:var(--muted);fill:none;stroke-width:2}
    .topbar-search input{border:none;outline:none;width:100%;font-size:14px;background:transparent}
    .topbar-actions{display:flex;gap:10px}.icon-btn{width:44px;height:44px;border:none;border-radius:14px;background:#fff;display:grid;place-items:center;position:relative;box-shadow:0 6px 22px rgba(15,23,42,.04);cursor:pointer}
    .icon-btn svg{width:18px;height:18px;stroke:#334155;fill:none;stroke-width:2}.notif-dot{position:absolute;top:11px;right:12px;width:8px;height:8px;border-radius:50%;background:var(--danger)}

    .content{padding:24px 28px 30px;max-width:1700px;margin:0 auto}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px}
    .page-header h2{margin:0;font-size:30px;line-height:1.1}.breadcrumb{margin-top:6px;color:var(--muted);font-size:13px}.breadcrumb span{color:var(--text);font-weight:700}
    .btn{display:inline-flex;align-items:center;gap:8px;border:none;border-radius:14px;padding:12px 16px;font-weight:700;cursor:pointer}.btn svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2}.btn-primary{background:linear-gradient(135deg,#4f46e5,#0ea5e9);color:#fff;box-shadow:0 12px 28px rgba(79,70,229,.25)}

    .kpi-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-bottom:18px}
    .kpi-card{background:#fff;border:1px solid var(--border);border-radius:22px;padding:18px;box-shadow:0 10px 35px rgba(15,23,42,.06)}
    .kpi-header{display:flex;align-items:flex-start;justify-content:space-between;gap:10px}.kpi-label{color:var(--muted);font-size:13px;text-transform:uppercase;letter-spacing:.08em}.kpi-value{font-size:34px;font-weight:900;margin-top:12px;line-height:1}
    .kpi-icon{width:44px;height:44px;border-radius:14px;display:grid;place-items:center}.kpi-icon svg{width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2}.bg-blue{background:var(--primary-soft);color:var(--primary)}.bg-green{background:var(--success-soft);color:var(--success)}.bg-amber{background:var(--warning-soft);color:var(--warning)}
    .kpi-delta{margin-top:10px;font-size:13px;display:flex;align-items:center;gap:6px;color:var(--muted)}.kpi-delta.up{color:var(--success)}.kpi-delta.down{color:var(--danger)}

    .dash-grid{display:grid;grid-template-columns:2fr 1fr;gap:18px;margin-bottom:18px}
    .card{background:#fff;border:1px solid var(--border);border-radius:24px;padding:18px;box-shadow:0 10px 35px rgba(15,23,42,.06)}
    .card-header{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}.card-title{font-size:18px;font-weight:800;color:var(--text)}
    .btn-ghost{background:#eef2ff;color:#3730a3}.btn-sm{padding:9px 12px;border-radius:12px;font-size:13px}

    .chart-area{height:230px;padding:6px 0 10px}
    .activity-list{display:flex;flex-direction:column;gap:14px}.activity-item{display:flex;gap:12px;align-items:flex-start;padding:10px 0;border-bottom:1px solid var(--border)}.activity-item:last-child{border-bottom:none;padding-bottom:0}
    .activity-dot{width:12px;height:12px;border-radius:50%;margin-top:5px;flex:none}.act-title{font-weight:700;color:var(--text)}.act-meta{color:var(--muted);font-size:13px;margin-top:3px}

    .progress-bar-wrap{margin-bottom:16px}.progress-label{display:flex;justify-content:space-between;gap:10px;margin-bottom:8px;font-size:14px;color:var(--text)}.pct{color:var(--muted);font-weight:700}
    .progress-track{height:10px;border-radius:999px;background:#e2e8f0;overflow:hidden}.progress-fill{height:100%;border-radius:999px}

    .charts-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin-bottom:18px}
    .chart-box{background:#fff;border:1px solid var(--border);border-radius:24px;padding:18px;box-shadow:0 10px 35px rgba(15,23,42,.06);min-height:390px}
    .chart-box h3{margin:0 0 12px;font-size:17px}.chart-box canvas{width:100% !important;height:300px !important}

    .tables-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}.table-card{background:#fff;border:1px solid var(--border);border-radius:24px;padding:18px;box-shadow:0 10px 35px rgba(15,23,42,.06)}
    .table-card.full{grid-column:1/-1}.table-card h2{margin:0 0 8px;font-size:20px}.subtitle{margin:0 0 16px;color:var(--muted)}
    table{width:100%;border-collapse:collapse} th,td{padding:12px 10px;border-bottom:1px solid var(--border);text-align:left;font-size:14px} th{color:#475569;font-size:12px;text-transform:uppercase;letter-spacing:.06em} td{color:#0f172a}
    .badge{padding:6px 10px;border-radius:999px;font-size:12px;font-weight:800;display:inline-block}.badge.green{background:var(--success-soft);color:var(--success)}.badge.blue{background:var(--info-soft);color:var(--info)}

    @media (max-width: 1280px){.sidebar{width:250px}.kpi-grid,.charts-grid,.tables-grid,.dash-grid{grid-template-columns:1fr 1fr}}
    @media (max-width: 980px){.app{flex-direction:column}.sidebar{width:100%;height:auto;position:relative}.topbar{flex-wrap:wrap}.topbar-search{order:3;max-width:none;width:100%}.kpi-grid,.charts-grid,.tables-grid,.dash-grid{grid-template-columns:1fr}}
  </style>
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
      <a href="<?= site_url('imc') ?>" class="nav-item">
        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/><path d="M12 11c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1s1-.45 1-1v-4c0-.55-.45-1-1-1z" fill="white"/><circle cx="12" cy="8" r="1" fill="white"/></svg>
        IMC
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

        <div class="dash-grid">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Utilisateurs par objectif</div>
              <button class="btn btn-ghost btn-sm" type="button">Exporter</button>
            </div>
            <div class="chart-area"><canvas id="chartObjectives"></canvas></div>
          </div>

          <div class="card">
            <div class="card-header"><div class="card-title">Activité récente</div><button class="btn btn-ghost btn-sm" type="button">Voir tout</button></div>
            <div class="activity-list">
              <div class="activity-item"><div class="activity-dot" style="background:var(--success)"></div><div class="activity-body"><div class="act-title">Base de données importée</div><div class="act-meta">table.sql synchronisé avec succès</div></div></div>
              <div class="activity-item"><div class="activity-dot" style="background:var(--primary)"></div><div class="activity-body"><div class="act-title">Login administrateur opérationnel</div><div class="act-meta">Accès sécurisé au Back Office</div></div></div>
              <div class="activity-item"><div class="activity-dot" style="background:var(--warning)"></div><div class="activity-body"><div class="act-title">Suggestions seedées</div><div class="act-meta">Données dashboard injectées</div></div></div>
              <div class="activity-item"><div class="activity-dot" style="background:var(--danger)"></div><div class="activity-body"><div class="act-title">Contrôle des rôles actif</div><div class="act-meta">adminAuth protège les routes</div></div></div>
            </div>
          </div>
        </div>

        <div class="charts-grid">
          <div class="chart-box"><h3>Régimes populaires</h3><canvas id="chartRegimes"></canvas></div>
          <div class="chart-box"><h3>Gold vs non-Gold</h3><canvas id="chartGold"></canvas></div>
          <div class="chart-box">
            <h3>Progression des modules</h3>
            <div class="progress-bar-wrap"><div class="progress-label"><span>Module Régimes</span><span class="pct">86%</span></div><div class="progress-track"><div class="progress-fill" style="width:86%;background:var(--primary)"></div></div></div>
            <div class="progress-bar-wrap"><div class="progress-label"><span>Module Activités</span><span class="pct">72%</span></div><div class="progress-track"><div class="progress-fill" style="width:72%;background:var(--success)"></div></div></div>
            <div class="progress-bar-wrap"><div class="progress-label"><span>Module Codes</span><span class="pct">64%</span></div><div class="progress-track"><div class="progress-fill" style="width:64%;background:var(--warning)"></div></div></div>
            <div class="progress-bar-wrap"><div class="progress-label"><span>Module Paramètres</span><span class="pct">48%</span></div><div class="progress-track"><div class="progress-fill" style="width:48%;background:var(--danger)"></div></div></div>
          </div>
        </div>

        <div class="tables-grid">
          <div class="table-card">
            <h2>Tableau croisé : utilisateurs par objectif</h2>
            <p class="subtitle">Répartition des profils enregistrés dans la base.</p>
            <table>
              <thead><tr><th>Objectif</th><th>Total</th></tr></thead>
              <tbody>
                <?php foreach (($utilisateursParObjectif ?? []) as $row): ?>
                  <tr><td><?= esc($row['objectif']) ?></td><td><?= esc($row['total']) ?></td></tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <div class="table-card">
            <h2>Tableau croisé : Gold vs non-Gold</h2>
            <p class="subtitle">Comparaison des utilisateurs premium et standards.</p>
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

          <div class="table-card full">
            <h2>Tableau croisé : régimes populaires</h2>
            <p class="subtitle">Les régimes les plus suggérés aux utilisateurs.</p>
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

  <script>
    window.__dashboardData = <?= json_encode($dashboardData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
  </script>
  <script src="<?= base_url('js/charts.js') ?>"></script>
</body>
</html>
