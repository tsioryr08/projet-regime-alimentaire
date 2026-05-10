<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Mon profil</title>

<link href="https://fonts.googleapis.com/css?family=Raleway:400,600,700" rel="stylesheet">

<style>
/* -------------------- Palette (sage + pink like profile.php) -------------------- */
:root{
  --sage: #a9cdb1;
  --sage-dark: #6f927b;
  --sage-soft: #eef6ef;

  --pink: #f4c6d6;
  --pink-dark: #c984a1;
  --pink-soft: #fff3f7;

  --ink: #203026;
  --muted: #5f6d64;

  --surface: rgba(255,255,255,.88);
  --surface-2: rgba(255,255,255,.72);
  --border: rgba(111, 146, 123, .18);

  --shadow: 0 22px 50px rgba(119, 96, 111, 0.14);
  --radius: 18px;
}

/* -------------------- Base -------------------- */
*{ box-sizing:border-box; margin:0; padding:0; font-family:Raleway, system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }

body{
  min-height:100vh;
  padding:30px 16px;
  display:flex;
  justify-content:center;
  color:var(--ink);
  background:
    radial-gradient(circle at top left, rgba(169, 205, 177, .55), transparent 34%),
    radial-gradient(circle at bottom right, rgba(244, 198, 214, .60), transparent 36%),
    linear-gradient(180deg, #fbfcfb 0%, #fff7fa 100%);
}

.container{
  width:100%;
  max-width:920px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 22px;
  overflow:hidden;
  box-shadow: var(--shadow);
  backdrop-filter: blur(10px);
}

/* -------------------- Header -------------------- */
.header{
  padding:24px 22px;
  border-bottom: 1px solid rgba(163, 185, 169, 0.18);
  background: linear-gradient(135deg, rgba(169, 205, 177, 0.18) 0%, rgba(244, 198, 214, 0.18) 100%);
}

.header-top{
  display:flex;
  align-items:center;
  gap:16px;
}

.avatar{
  width:64px;
  height:64px;
  border-radius:999px;
  border:1px solid rgba(163, 185, 169, 0.35);
  background: linear-gradient(135deg, rgba(169,205,177,.35), rgba(244,198,214,.28));
  display:grid;
  place-items:center;
  overflow:hidden;
  flex: 0 0 auto;
}
.avatar img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
}
.avatar-fallback{
  font-weight:900;
  letter-spacing:.6px;
  color: rgba(47, 90, 67, .85);
}

.header h1{
  font-size:20px;
  font-weight:900;
  color:#2f4f3f;
  margin-bottom:4px;
}
.header p{
  font-size:13px;
  color: var(--muted);
}

/* -------------------- Content -------------------- */
.content{ padding:22px; }

/* Alerts */
.alert{
  padding:12px 14px;
  border-radius:14px;
  font-size:13px;
  margin-bottom:16px;
  border:1px solid rgba(163, 185, 169, 0.22);
}
.alert-success{
  background: linear-gradient(135deg, rgba(169, 205, 177, 0.26), rgba(235, 247, 238, 0.95));
  color:#2f5a43;
}
.alert-error{
  background: linear-gradient(135deg, rgba(244, 198, 214, 0.28), rgba(255, 241, 245, 0.96));
  color:#8b4c63;
  border-color: rgba(201, 132, 161, 0.22);
}

/* -------------------- Cards / Grid -------------------- */
.grid{
  display:grid;
  grid-template-columns: 1fr 1fr;
  gap:14px;
}

.card{
  border: 1px solid rgba(163, 185, 169, 0.18);
  border-radius: 18px;
  padding: 16px;
  background: linear-gradient(180deg, rgba(255,255,255,0.96) 0%, rgba(250, 252, 250, 0.98) 100%);
  box-shadow: 0 10px 28px rgba(33, 50, 39, 0.05);
}

.card h3{
  font-size: 12px;
  letter-spacing: .6px;
  text-transform: uppercase;
  font-weight: 900;
  margin-bottom: 12px;
  color: #355a45;
}

.row{
  display:flex;
  justify-content:space-between;
  gap:16px;
  padding:10px 0;
  border-top:1px solid rgba(32,48,38,.08);
}
.row:first-of-type{ border-top:none; padding-top:0; }

.label{ color: var(--muted); font-size:13px; }
.value{ color: var(--ink); font-size:13.5px; font-weight:700; text-align:right; }

/* Badge */
.badge{
  display:inline-flex;
  align-items:center;
  padding:6px 10px;
  border-radius:999px;
  font-weight:900;
  font-size:12px;
  border:1px solid rgba(163, 185, 169, 0.25);
  background: rgba(255,255,255,.75);
  color: var(--ink);
}
.badge-gold{
  border-color: rgba(181, 144, 26, 0.30);
  background: linear-gradient(135deg, rgba(239,224,193,.95), rgba(227,201,143,.90));
  color:#6f5b2f;
}

/* -------------------- Actions / Buttons -------------------- */
.actions{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  margin-top:18px;
}

.btn{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  padding:10px 14px;
  border-radius:12px;
  font-size:13px;
  font-weight:800;
  text-decoration:none;
  border:1px solid rgba(163, 185, 169, 0.22);
  background: rgba(255,255,255,.70);
  color: var(--ink);
  transition: .2s;
}
.btn:hover{
  transform: translateY(-1px);
  box-shadow: 0 12px 20px rgba(33, 50, 39, .10);
}

.btn-primary{
  background: linear-gradient(135deg, var(--sage) 0%, #89b69e 100%);
  color:#234031;
}
.btn-secondary{
  background: linear-gradient(135deg, var(--pink-soft) 0%, rgba(255,255,255,.65) 100%);
  color:#4b5a51;
}
.btn-gold{
  background: linear-gradient(135deg, #efe0c1 0%, #e3c98f 100%);
  color:#6f5b2f;
}
.btn-danger{
  background: linear-gradient(135deg, var(--pink) 0%, #e9adc2 100%);
  color:#6f3f57;
}

/* -------------------- Responsive -------------------- */
@media (max-width: 820px){
  .grid{ grid-template-columns: 1fr; }
}
@media (max-width: 520px){
  .content{ padding:16px; }
  .header{ padding:18px 16px; }
  .row{ flex-direction:column; align-items:flex-start; }
  .value{ text-align:left; }
  .actions{ flex-direction:column; }
  .btn{ width:100%; }
}
</style>
</head>

<body>
  <div class="container">

    <div class="header">
      <div class="header-top">
        <div class="avatar">
          <?php if(!empty($user['photo_url'])): ?>
            <img src="<?= esc($user['photo_url']) ?>" alt="Photo de profil">
          <?php else: ?>
            <div class="avatar-fallback">
              <?= strtoupper(mb_substr($user['prenom'] ?? 'U', 0, 1)) ?>
              <?= strtoupper(mb_substr($user['nom'] ?? 'S', 0, 1)) ?>
            </div>
          <?php endif; ?>
        </div>

        <div>
          <h1>Mon profil</h1>
          <p>Bienvenue <?= esc($user['prenom']) ?></p>
        </div>
      </div>
    </div>

    <div class="content">

      <?php if(session()->has('success')): ?>
        <div class="alert alert-success"><?= session('success') ?></div>
      <?php endif; ?>

      <?php if(session()->has('error')): ?>
        <div class="alert alert-error"><?= session('error') ?></div>
      <?php endif; ?>

      <div class="grid">
        <div class="card">
          <h3>Informations personnelles</h3>

          <div class="row">
            <span class="label">Nom</span>
            <span class="value"><?= esc($user['nom']) ?></span>
          </div>

          <div class="row">
            <span class="label">Prénom</span>
            <span class="value"><?= esc($user['prenom']) ?></span>
          </div>

          <div class="row">
            <span class="label">Email</span>
            <span class="value"><?= esc($user['email']) ?></span>
          </div>

          <div class="row">
            <span class="label">Genre</span>
            <span class="value"><?= ucfirst(esc($user['genre'])) ?></span>
          </div>

          <div class="row">
            <span class="label">Naissance</span>
            <span class="value"><?= date('d/m/Y', strtotime($user['date_naissance'])) ?></span>
          </div>
        </div>

        <div class="card">
          <h3>Profil physique</h3>

          <div class="row">
            <span class="label">Taille</span>
            <span class="value"><?= esc($user['taille']) ?> cm</span>
          </div>

          <div class="row">
            <span class="label">Poids</span>
            <span class="value"><?= esc($user['poids']) ?> kg</span>
          </div>

          <div class="row">
            <span class="label">Objectif</span>
            <span class="value"><?= esc($user['objectif']) ?></span>
          </div>
        </div>

        <div class="card">
          <h3>Compte</h3>

          <div class="row">
            <span class="label">Solde</span>
            <span class="value"><?= number_format($user['solde_portefeuille'], 0, ',', ' ') ?> Ar</span>
          </div>

          <div class="row">
            <span class="label">Statut</span>
            <span class="value">
              <?php if($user['is_gold']): ?>
                <span class="badge badge-gold">Gold</span>
              <?php else: ?>
                <span class="badge">Standard</span>
              <?php endif; ?>
            </span>
          </div>

          <div class="row">
            <span class="label">Inscrit depuis</span>
            <span class="value"><?= date('d/m/Y', strtotime($user['created_at'])) ?></span>
          </div>
        </div>

        <div class="card">
          <h3>Photo de profil</h3>
          <div class="row">
            <span class="label">Statut</span>
            <span class="value"><?= !empty($user['photo_url']) ? 'Définie' : 'Non définie' ?></span>
          </div>
          <div class="row">
            <span class="label">Action</span>
            <span class="value" style="font-weight:600;color:var(--muted);">
              (Ajout plus tard: bouton “Changer la photo”)
            </span>
          </div>
        </div>
      </div>

      <div class="actions">
        <a href="/utilisateur/accueil" class="btn btn-secondary">Retour</a>
        <a href="/utilisateur/modifProfil" class="btn btn-primary">Modifier</a>
        <a href="/utilisateur/saisirCode" class="btn btn-secondary">Code</a>
        <a href="/utilisateur/devenirGold" class="btn btn-gold">Devenir Gold</a>
        <a href="/utilisateur/logout" class="btn*
        
