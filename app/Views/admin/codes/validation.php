<!doctype html>
<html lang="fr"><head><meta charset="utf-8"><title>Validation code</title></head><body>
<h1>Valider le code</h1>
<p>Code : <?= esc($code['code'] ?? '') ?></p>
<form method="post" action="<?= site_url('admin/codes/validation/' . ($code['id'] ?? 0)) ?>">
  <?= csrf_field() ?>
  <select name="est_valide">
    <option value="1" <?= ((int) ($code['est_valide'] ?? 1) === 1) ? 'selected' : '' ?>>Valide</option>
    <option value="0" <?= ((int) ($code['est_valide'] ?? 1) === 0) ? 'selected' : '' ?>>Invalide</option>
  </select>
  <button type="submit">Enregistrer</button>
</form>
</body></html>
