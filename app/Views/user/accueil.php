<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regime Pro - Accueil</title>
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
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, .72);
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

        .hero {
            padding: 56px 0 28px;
        }

        .hero-card {
            background: rgba(255, 255, 255, .82);
            border: 1px solid rgba(111, 146, 123, .15);
            border-radius: 28px;
            box-shadow: 0 24px 50px rgba(33, 50, 39, .08);
            overflow: hidden;
        }

        .hero-main {
            padding: 34px;
        }

        .badge-soft {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: 999px;
            font-size: .88rem;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .badge-sage {
            background: rgba(169, 205, 177, .35);
            color: #355642;
        }

        .badge-pink {
            background: rgba(244, 198, 214, .40);
            color: #7b4e63;
        }

        .hero h1 {
            font-size: clamp(2rem, 4vw, 3.5rem);
            line-height: 1.1;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .hero p.lead {
            color: #5f6d64;
            font-size: 1.05rem;
            line-height: 1.8;
            max-width: 680px;
        }

        .cta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-soft {
            border: none;
            border-radius: 14px;
            padding: 12px 18px;
            font-weight: 700;
            text-decoration: none;
        }

        .btn-sage {
            background: linear-gradient(135deg, var(--sage) 0%, #8cb89a 100%);
            color: #234031;
        }

        .btn-sage:hover {
            color: #1e3529;
        }

        .btn-pink {
            background: linear-gradient(135deg, var(--pink) 0%, #f0b7cb 100%);
            color: #713f56;
        }

        .btn-pink:hover {
            color: #603548;
        }

        .section-title {
            font-weight: 800;
            margin: 34px 0 18px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .feature-card {
            background: rgba(255, 255, 255, .9);
            border: 1px solid rgba(111, 146, 123, .14);
            border-radius: 22px;
            padding: 20px;
            min-height: 180px;
            box-shadow: 0 12px 28px rgba(33, 50, 39, .06);
        }

        .feature-card h3 {
            font-size: 1.05rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .feature-card p {
            margin: 0;
            color: #64756d;
            line-height: 1.65;
        }

        .motivations {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-top: 18px;
            margin-bottom: 48px;
        }

        .motivation-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .95));
            border-radius: 22px;
            padding: 22px;
            border: 1px solid rgba(244, 198, 214, .28);
            box-shadow: 0 12px 28px rgba(33, 50, 39, .05);
        }

        .motivation-card strong {
            display: block;
            margin-bottom: 10px;
            color: #6e4055;
        }

        .motivation-card p {
            margin: 0;
            color: #5f6d64;
            line-height: 1.7;
        }

        .welcome-panel {
            background: linear-gradient(135deg, rgba(169, 205, 177, .22) 0%, rgba(244, 198, 214, .22) 100%);
            border: 1px solid rgba(111, 146, 123, .12);
            border-radius: 24px;
            padding: 22px;
        }

        .footer {
            background: rgba(255, 255, 255, .78);
            backdrop-filter: blur(12px);
            border-top: 1px solid rgba(111, 146, 123, .14);
            padding: 40px 0 20px;
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
            color: var(--ink);
        }

        .footer-brand span {
            color: var(--sage-dark);
        }

        .footer-text {
            color: #5f6d64;
            max-width: 420px;
            line-height: 1.7;
            margin: 0;
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

        .welcome-panel h2 {
            font-weight: 800;
            font-size: 1.4rem;
        }

        .welcome-panel p {
            margin: 0;
            color: #5d6b63;
            line-height: 1.7;
        }

        @media (max-width: 992px) {

            .feature-grid,
            .motivations {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .hero-main {
                padding: 24px;
            }

            .feature-grid,
            .motivations {
                grid-template-columns: 1fr;
            }
        }
        .img-logo{
    width: 22px;
    height: 22px;
    object-fit: contain;
    margin-right: 6px;
}
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg topbar">
        <div class="container py-2">
            <a class="navbar-brand brand" href="<?= site_url('utilisateur/accueil') ?>">Regime <span>Pro</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
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
            <a class="nav-link" href="<?= site_url('utilisateur/profil') ?>">
                <img class="img-logo"
                     src="<?= base_url('wallet.png') ?>"
                     alt="wallet">

                <?= esc($user['solde_portefeuille']); ?> Ar
            </a>
        </li>

        <?php if (($user['is_gold'] ?? 0) == 1): ?>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img class="img-logo"
                         src="<?= base_url('crown.png') ?>"
                         alt="gold">

                    Gold
                </a>
            </li>

        <?php else: ?>

            <li class="nav-item">
                <a class="btn btn-warning rounded-pill px-3 fw-semibold"
                   href="<?= site_url('utilisateur/devenirGold') ?>">
                    Devenir membre Gold
                </a>
            </li>

        <?php endif; ?>

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

    <main class="container hero">
        <section class="hero-card">
            <div class="hero-main">
                <span class="badge-soft badge-sage">Bienvenue <?= esc($user['prenom'] ?? 'sur votre espace') ?></span>
                <h1>Votre progression commence ici.</h1>
                <p class="lead">
                    Regime Pro vous accompagne au quotidien avec des outils simples pour suivre votre IMC,
                    découvrir des suggestions adaptées à votre objectif et garder la motivation tout au long de votre régime.
                </p>

                <div class="cta-row">
                    <a href="<?= site_url('imc') ?>" class="btn-soft btn-sage">Calculer mon IMC</a>
                    <a href="<?= site_url('regime/suggestion') ?>" class="btn-soft btn-pink">Voir mes suggestions</a>
                    <a href="<?= site_url('utilisateur/profil') ?>" class="btn-soft" style="background:#edf4ef;color:#355642;">Accéder à mon profil</a>
                </div>
            </div>
        </section>

        <h2 class="section-title">Fonctionnalités principales</h2>
        <section class="feature-grid">
            <article class="feature-card">
                <span class="badge-soft badge-sage">Profil</span>
                <h3>Suivre vos informations</h3>
                <p>Consultez vos données personnelles, vos objectifs et votre niveau Gold en un seul endroit.</p>
            </article>
            <article class="feature-card">
                <span class="badge-soft badge-pink">Créer un compte</span>
                <h3>Partager votre profil santé</h3>
                <p>Inscrivez-vous et personnalisez votre parcours avec votre poids, votre taille et votre objectif.</p>
            </article>
            <article class="feature-card">
                <span class="badge-soft badge-sage">IMC</span>
                <h3>Mesurer votre progression</h3>
                <p>Calculez votre IMC pour savoir où vous en êtes et suivre votre évolution dans le temps.</p>
            </article>
            <article class="feature-card">
                <span class="badge-soft badge-pink">Suggestion</span>
                <h3>Recevoir un plan adapté</h3>
                <p>Découvrez des régimes et activités recommandés selon votre IMC et votre objectif du moment.</p>
            </article>
        </section>

        <h2 class="section-title">Motivation du jour</h2>
        <section class="motivations">
            <article class="motivation-card">
                <strong>Petit pas, grands résultats</strong>
                <p>Un progrès de 1% par jour finit par créer une vraie transformation. L’important, c’est la régularité.</p>
            </article>
            <article class="motivation-card">
                <strong>Ne saute pas les étapes</strong>
                <p>Ton corps change au rythme de tes habitudes. Les routines simples sont souvent les plus puissantes.</p>
            </article>
            <article class="motivation-card">
                <strong>Reste bienveillant avec toi</strong>
                <p>Un régime durable n’est pas une punition. C’est une façon de prendre soin de toi, sans pression inutile.</p>
            </article>
        </section>

        <section class="welcome-panel mb-5">
            <h2>Un espace pensé pour t’accompagner</h2>
            <p>
                Que tu veuilles réduire ton poids, prendre de la masse ou atteindre un IMC idéal,
                Regime Pro te guide avec des outils clairs, un suivi simple et des suggestions ciblées.
            </p>
        </section>
    </main>
    <footer class="footer mt-5">
        <div class="container">
            <div class="footer-content">
                <div>
                    <h5 class="footer-brand">Regime <span>Pro</span></h5>
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
</body>

</html>