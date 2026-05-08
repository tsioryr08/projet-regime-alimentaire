<!doctype html>
<html lang="fr"><head><meta charset="utf-8"><title>Créer un régime</title></head><body>
<h1>Créer un régime</h1>
<form method="post" action="<?= site_url('admin/regimes/create') ?>">
  <?= csrf_field() ?>
  <input name="nom" placeholder="Nom"><br>
  <textarea name="description" placeholder="Description"></textarea><br>
  <input name="prix_base" placeholder="Prix de base"><br>
  <input name="duree_jours" placeholder="Durée jours"><br>
  <input name="variation_poids" placeholder="Variation poids"><br>
  <input name="sens_variation" placeholder="prise/perte"><br>
  <input name="pct_viande" placeholder="% viande"><br>
  <input name="pct_poisson" placeholder="% poisson"><br>
  <input name="pct_volaille" placeholder="% volaille"><br>
  <input name="categorie_imc" placeholder="categorie imc"><br>
  <button type="submit">Enregistrer</button>
</form>
</body></html>
