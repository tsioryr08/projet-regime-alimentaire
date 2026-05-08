<!doctype html>
<html lang="fr"><head><meta charset="utf-8"><title>Créer une activité</title></head><body>
<h1>Créer une activité</h1>
<form method="post" action="<?= site_url('admin/activites/create') ?>">
  <?= csrf_field() ?>
  <input name="nom" placeholder="Nom"><br>
  <textarea name="description" placeholder="Description"></textarea><br>
  <input name="duree_semaines" placeholder="Durée semaines"><br>
  <input name="frequence" placeholder="Fréquence"><br>
  <input name="calories_par_h" placeholder="Calories/h"><br>
  <input name="categorie_imc" placeholder="Categorie IMC"><br>
  <input name="objectif_cible" placeholder="Objectif cible"><br>
  <button type="submit">Enregistrer</button>
</form>
</body></html>
