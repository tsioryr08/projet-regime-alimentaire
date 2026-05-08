<!doctype html>
<html lang="fr"><head><meta charset="utf-8"><title>Modifier une activité</title></head><body>
<h1>Modifier une activité</h1>
<form method="post" action="<?= site_url('admin/activites/edit/' . ($activite['id'] ?? 0)) ?>">
  <?= csrf_field() ?>
  <input name="nom" value="<?= esc($activite['nom'] ?? '') ?>"><br>
  <textarea name="description"><?= esc($activite['description'] ?? '') ?></textarea><br>
  <input name="duree_semaines" value="<?= esc($activite['duree_semaines'] ?? '') ?>"><br>
  <input name="frequence" value="<?= esc($activite['frequence'] ?? '') ?>"><br>
  <input name="calories_par_h" value="<?= esc($activite['calories_par_h'] ?? '') ?>"><br>
  <input name="categorie_imc" value="<?= esc($activite['categorie_imc'] ?? '') ?>"><br>
  <input name="objectif_cible" value="<?= esc($activite['objectif_cible'] ?? '') ?>"><br>
  <button type="submit">Mettre à jour</button>
</form>
</body></html>
