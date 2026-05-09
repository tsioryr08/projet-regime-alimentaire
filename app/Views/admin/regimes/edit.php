<!doctype html>
<html lang="fr"><head><meta charset="utf-8"><title>Modifier un régime</title></head><body>
<h1>Modifier un régime</h1>
<form method="post" action="<?= site_url('admin/regimes/edit/' . ($regime['id'] ?? 0)) ?>">
  <?= csrf_field() ?>
  <input name="nom" value="<?= esc($regime['nom'] ?? '') ?>"><br>
  <textarea name="description"><?= esc($regime['description'] ?? '') ?></textarea><br>
  <input name="prix_base" value="<?= esc($regime['prix_base'] ?? '') ?>"><br>
  <input name="duree_jours" value="<?= esc($regime['duree_jours'] ?? '') ?>"><br>
  <input name="variation_poids" value="<?= esc($regime['variation_poids'] ?? '') ?>"><br>
  <input name="sens_variation" value="<?= esc($regime['sens_variation'] ?? '') ?>"><br>
  <input name="pct_viande" value="<?= esc($regime['pct_viande'] ?? '') ?>"><br>
  <input name="pct_poisson" value="<?= esc($regime['pct_poisson'] ?? '') ?>"><br>
  <input name="pct_volaille" value="<?= esc($regime['pct_volaille'] ?? '') ?>"><br>
  <input name="categorie_imc" value="<?= esc($regime['categorie_imc'] ?? '') ?>"><br>
  <button type="submit">Mettre à jour</button>
</form>
</body></html>
