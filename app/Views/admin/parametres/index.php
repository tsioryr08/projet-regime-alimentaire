<!doctype html>
<html lang="fr"><head><meta charset="utf-8"><title>Paramètres</title></head><body>
<h1>Paramètres système</h1>
<p><a href="<?= site_url('admin/parametres/create') ?>">Créer un nouveau paramètre</a></p>
<form method="post" action="<?= site_url('admin/parametres') ?>">
  <?= csrf_field() ?>
  <table border="1" cellpadding="8">
    <tr><th>Clé</th><th>Valeur</th><th>Description</th></tr>
    <?php foreach (($parametres ?? []) as $parametre): ?>
      <tr>
        <td><?= esc($parametre['cle']) ?></td>
        <td><input name="parametres[<?= esc($parametre['id']) ?>][valeur]" value="<?= esc($parametre['valeur']) ?>"></td>
        <td><input name="parametres[<?= esc($parametre['id']) ?>][description]" value="<?= esc($parametre['description']) ?>"></td>
        <td><a href="<?= site_url('admin/parametres/delete/' . $parametre['id']) ?>" onclick="return confirm('Supprimer ce paramètre ?')">Supprimer</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
  <button type="submit">Enregistrer</button>
</form>
</body></html>
