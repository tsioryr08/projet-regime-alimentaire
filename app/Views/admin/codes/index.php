<!doctype html>
<html lang="fr"><head><meta charset="utf-8"><title>Codes</title></head><body>
<h1>Liste des codes</h1>
<table border="1" cellpadding="8"><tr><th>ID</th><th>Code</th><th>Montant</th><th>Validité</th><th>Actions</th></tr>
<?php foreach (($codes ?? []) as $code): ?>
<tr>
  <td><?= esc($code['id']) ?></td>
  <td><?= esc($code['code']) ?></td>
  <td><?= esc($code['montant']) ?></td>
  <td><?= ((int) $code['est_valide'] === 1) ? 'Valide' : 'Invalide' ?></td>
  <td>
    <form method="post" action="<?= site_url('admin/codes/validation/' . $code['id']) ?>" style="display:inline">
      <?= csrf_field() ?>
      <input type="hidden" name="est_valide" value="<?= ((int) $code['est_valide'] === 1) ? '0' : '1' ?>">
      <button type="submit"><?= ((int) $code['est_valide'] === 1) ? 'Désactiver' : 'Activer' ?></button>
    </form>
    &nbsp;|&nbsp;
    <a href="<?= site_url('admin/codes/validation/' . $code['id']) ?>">Modifier</a>
  </td>
</tr>
<?php endforeach; ?>
</table>
</body></html>
