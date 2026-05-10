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

    <style>
        :root {
            --sage: #a9cdb1;
            --sage-dark: #6f927b;
            --sage-soft: #eef6ef;
            --pink: #f4c6d6;
            --pink-dark: #c984a1;
            --pink-soft: #fff3f7;
            --ink: #203026;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(169, 205, 177, .55), transparent 34%),
                radial-gradient(circle at bottom right, rgba(244, 198, 214, .60), transparent 36%),
                linear-gradient(180deg, #fbfcfb 0%, #fff7fa 100%);
            color: var(--ink);

            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(16px);
            background: rgba(255,255,255,.72);
            border-bottom: 1px solid rgba(111, 146, 123, .14);
        }

        .brand {
            font-weight: 800;
            letter-spacing: .3px;
            color: var(--ink) !important;
        }

        .brand span {
            color: var(--sage-dark);
        }

        .nav-link {
            color: #4b5a51 !important;
            font-weight: 600;
        }

        .nav-link:hover {
            color: var(--sage-dark) !important;
        }

        .footer {
            background: rgba(255,255,255,.78);
            backdrop-filter: blur(12px);
            border-top: 1px solid rgba(111, 146, 123, .14);
            padding: 40px 0 20px;
            margin-top: 50px;
        }

        .footer-line {
            width: 100%;
            height: 4px;
            background: linear-gradient(
                90deg,
                var(--sage),
                var(--pink),
                var(--sage)
            );
            border-radius: 999px;
            margin-bottom: 28px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .footer-brand {
            font-weight: 800;
            margin-bottom: 10px;
        }

        .footer-brand span {
            color: var(--sage-dark);
        }

        .footer-text {
            color: #5f6d64;
            max-width: 420px;
            line-height: 1.7;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-links a {
            text-decoration: none;
            color: #4b5a51;
            font-weight: 600;
            transition: .2s ease;
        }

        .footer-links a:hover {
            color: var(--sage-dark);
            transform: translateX(3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(111, 146, 123, .12);
            padding-top: 18px;
            text-align: center;
            color: #6b7a72;
            font-size: .95rem;
        }

        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
            }
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>
<body>

    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg topbar">
        <div class="container py-2">
            <a class="navbar-brand brand" href="<?= site_url('utilisateur/accueil') ?>">
                Regime <span>Pro</span>
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('utilisateur/profil') ?>">
                            Profil
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('wallet') ?>">
                            Porte-feuille
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('imc') ?>">
                            IMC
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('regime/suggestion') ?>">
                            Suggestion
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">

            <div class="footer-line"></div>

            <div class="footer-content">
                <div>
                    <h5 class="footer-brand">
                        Regime <span>Pro</span>
                    </h5>

                    <p class="footer-text">
                        Votre compagnon bien-être pour suivre votre progression,
                        améliorer vos habitudes et atteindre vos objectifs santé.
                    </p>
                </div>

                <div class="footer-links">
                    <a href="<?= site_url('utilisateur/profil') ?>">Profil</a>
                    <a href="<?= site_url('imc') ?>">IMC</a>
                    <a href="<?= site_url('regime/suggestion') ?>">Suggestions</a>
                </div>
            </div>

            <div class="footer-bottom">
                © <?= date('Y') ?> Regime Pro — Tous droits réservés.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('scripts') ?>

</body>
</html>