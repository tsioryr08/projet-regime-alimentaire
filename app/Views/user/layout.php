<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Regime Pro' ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <?= $this->include('user/_navbar_styles') ?>

    <?= $this->renderSection('styles') ?>
</head>
<body>

    <?= $this->include('user/_navbar') ?>

    <!-- PAGE CONTENT -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('user/_footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('scripts') ?>

</body>
</html>
