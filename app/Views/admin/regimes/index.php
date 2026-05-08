<!doctype html>
<html lang="fr"><head><meta charset="utf-8"><title>Régimes</title></head><body>
<h1>Liste des régimes</h1>
<p><a href="<?= site_url('admin/regimes/create') ?>">Créer un régime</a></p>
<table border="1" cellpadding="8"><tr><th>ID</th><th>Nom</th><th>Prix</th><th>Actions</th></tr>
<?php foreach (($regimes ?? []) as $regime): ?>
<tr>
  <td><?= esc($regime['id']) ?></td>
  <td><?= esc($regime['nom']) ?></td>
  <td><?= esc($regime['prix_base']) ?></td>
  <td><a href="<?= site_url('admin/regimes/edit/' . $regime['id']) ?>">Modifier</a></td>
</tr>
<?php endforeach; ?>
</table>
</body></html>
