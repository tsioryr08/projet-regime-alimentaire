<!doctype html>
<html lang="fr"><head><meta charset="utf-8"><title>Activités</title></head><body>
<h1>Liste des activités</h1>
<p><a href="<?= site_url('admin/activites/create') ?>">Créer une activité</a></p>
<table border="1" cellpadding="8"><tr><th>ID</th><th>Nom</th><th>Actions</th></tr>
<?php foreach (($activites ?? []) as $activite): ?>
<tr>
  <td><?= esc($activite['id']) ?></td>
  <td><?= esc($activite['nom']) ?></td>
  <td><a href="<?= site_url('admin/activites/edit/' . $activite['id']) ?>">Modifier</a></td>
</tr>
<?php endforeach; ?>
</table>
</body></html>
