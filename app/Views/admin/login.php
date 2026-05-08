<?php
helper('form');
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin — Connexion</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root{--c-bg:#f0f2f5;--c-surface:#ffffff;--c-sidebar:#0f1729;--c-primary:#2563eb;--c-primary-h:#1d4ed8;--c-accent:#06b6d4;--c-danger:#ef4444;--c-success:#22c55e;--c-text:#1e293b;--c-muted:#64748b;--c-border:#e2e8f0;--radius:8px;--radius-lg:12px;--shadow-md:0 4px 16px rgba(0,0,0,.10);--font:'Inter',system-ui,sans-serif}
    *{box-sizing:border-box} body{margin:0;min-height:100vh;font-family:var(--font);background:linear-gradient(135deg,#0f1729 0%,#1e3a5f 50%,#0f1729 100%);color:var(--c-text)}
    .login-shell{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
    .login-card{width:100%;max-width:460px;background:var(--c-surface);border-radius:var(--radius-lg);box-shadow:0 20px 60px rgba(0,0,0,.35);padding:40px 36px}
    .login-logo{display:flex;align-items:center;gap:12px;margin-bottom:28px}
    .logo-icon{width:42px;height:42px;border-radius:10px;background:linear-gradient(135deg,var(--c-primary),var(--c-accent));display:grid;place-items:center;flex:none;box-shadow:0 10px 24px rgba(37,99,235,.22)}
    .logo-icon svg{width:20px;height:20px;fill:#fff}
    .login-logo h1{margin:0;font-size:20px;font-weight:800;color:var(--c-text);line-height:1.1}
    .login-logo span{display:block;color:var(--c-muted);font-size:11px;margin-top:3px}
    .login-card h2{margin:0 0 6px;font-size:22px;font-weight:800}
    .subtitle{margin:0 0 26px;color:var(--c-muted);font-size:13px}
    .field-group{margin-bottom:16px}
    .field-group label{display:block;font-size:13px;font-weight:700;margin-bottom:6px;color:var(--c-text)}
    .form-control, select{width:100%;padding:11px 12px;border:1.5px solid var(--c-border);border-radius:var(--radius);background:#f8fafc;font-size:14px;font-family:var(--font);color:var(--c-text);outline:none;transition:border-color .2s,box-shadow .2s}
    .form-control:focus{border-color:var(--c-primary);box-shadow:0 0 0 3px rgba(37,99,235,.12)}
    .remember-row{display:flex;align-items:center;justify-content:space-between;margin:4px 0 20px;font-size:13px;color:var(--c-muted)}
    .remember-row label{display:flex;align-items:center;gap:8px;cursor:pointer}
    input[type="checkbox"]{accent-color:var(--c-primary)}
    .btn-primary{width:100%;border:none;border-radius:var(--radius);padding:12px 16px;background:var(--c-primary);color:#fff;font-weight:700;font-size:14px;cursor:pointer;transition:background .2s,transform .1s}
    .btn-primary:hover{background:var(--c-primary-h)} .btn-primary:active{transform:scale(.99)}
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 14px;border-radius:var(--radius);margin-bottom:18px;font-size:13px;background:rgba(239,68,68,.08);color:#b91c1c}
    .alert:before{content:"";width:10px;height:10px;border-radius:50%;background:var(--c-danger);margin-top:4px;flex:none}
    .login-footer{margin-top:22px;text-align:center;font-size:12px;color:var(--c-muted)}
  </style>
</head>
<body>
  <div class="login-shell">
    <div class="login-card">
      <div class="login-logo">
        <div class="logo-icon">
          <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <div>
          <h1>Régime Pro</h1>
          <span>Back Office administrateur</span>
        </div>
      </div>

      <h2>Connexion administrateur</h2>
      <p class="subtitle">Accédez au tableau de bord, aux statistiques et aux modules de gestion.</p>

      <?php if(session()->getFlashdata('error')): ?>
        <div class="alert"><?= esc(session()->getFlashdata('error')) ?></div>
      <?php endif; ?>

      <form action="<?= site_url('admin/auth/login') ?>" method="post" autocomplete="off">
        <?= csrf_field() ?>

        <div class="field-group">
          <label for="email">Email</label>
          <input id="email" name="email" type="email" class="form-control" required value="<?= set_value('email') ?>" placeholder="admin@regime-app.mg">
        </div>

        <div class="field-group">
          <label for="password">Mot de passe</label>
          <input id="password" name="password" type="password" class="form-control" required placeholder="••••••••">
        </div>

        <div class="remember-row">
          <label><input type="checkbox" name="remember" <?= set_value('remember') ? 'checked' : '' ?>> Se souvenir de moi</label>
          <span>Accès sécurisé</span>
        </div>

        <button type="submit" class="btn-primary">Se connecter</button>
      </form>

      <div class="login-footer">Connexion réservée aux administrateurs autorisés.</div>
    </div>
  </div>
</body>
</html>
