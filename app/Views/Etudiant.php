<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
    <link rel="stylesheet" href="">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:hover { background-color: #f5f5f5; }
    </style>
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <h1>Liste des Étudiants</h1>
    
    <?php if (!empty($etudiants)) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $etudiant) : ?>
                    <tr>
                        <td><?= $etudiant['id'] ?></td>
                        <td><?= $etudiant['nom'] ?></td>
                        <td><?= $etudiant['email'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucun étudiant trouvé.</p>
    <?php endif; ?>
</body>
</html>
