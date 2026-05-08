<!doctype html>
<html lang="fr">
<head><meta charset="utf-8"><title>Créer paramètre</title></head>
<body>
<h1>Créer un paramètre</h1>
<form method="post" action="<?= site_url('admin/parametres/create') ?>">
  <?= csrf_field() ?>
  <div>
    <label>Clé<br><input name="cle" required></label>
  </div>
  <div>
    <label>Valeur<br><input name="valeur" required></label>
  </div>
  <div>
    <label>Description<br><input name="description"></label>
  </div>
  <button type="submit">Créer</button>
</form>
<p><a href="<?= site_url('admin/parametres') ?>">Retour</a></p>
</body>
</html>
