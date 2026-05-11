<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir un accès</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(174, 208, 181, 0.55) 0%, rgba(174, 208, 181, 0) 42%),
                radial-gradient(circle at bottom right, rgba(244, 198, 214, 0.55) 0%, rgba(244, 198, 214, 0) 45%),
                linear-gradient(135deg, #f8faf7 0%, #fff8fb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .choice-shell {
            width: 100%;
            max-width: 920px;
            background: rgba(255, 255, 255, 0.96);
            border-radius: 28px;
            box-shadow: 0 24px 60px rgba(119, 96, 111, 0.18);
            overflow: hidden;
            border: 1px solid rgba(163, 185, 169, 0.24);
        }
        .choice-hero {
            padding: 42px 32px 24px;
            text-align: center;
        }
        .choice-hero h1 {
            font-size: clamp(2rem, 4vw, 3.4rem);
            font-weight: 800;
            margin-bottom: 12px;
            color: #2f4f3f;
        }
        .choice-hero p {
            margin: 0;
            color: #6b7280;
            font-size: 1.05rem;
        }
        .choice-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            padding: 0 32px 36px;
        }
        .choice-card {
            border: 1px solid rgba(163, 185, 169, 0.28);
            border-radius: 22px;
            padding: 28px;
            min-height: 240px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(180deg, rgba(247, 251, 247, 0.98) 0%, rgba(255, 244, 248, 0.98) 100%);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .choice-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px rgba(119, 96, 111, 0.12);
        }
        .choice-title {
            font-size: 1.45rem;
            font-weight: 800;
            margin-bottom: 10px;
            color: #274437;
        }
        .choice-text {
            color: #667085;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .choice-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: .85rem;
            font-weight: 700;
            margin-bottom: 18px;
        }
        .badge-user {
            background: rgba(174, 208, 181, 0.35);
            color: #355a45;
        }
        .badge-admin {
            background: rgba(244, 198, 214, 0.42);
            color: #7b4e63;
        }
        .choice-btn {
            border-radius: 14px;
            padding: 13px 18px;
            font-weight: 700;
        }
        .choice-btn-user {
            background: linear-gradient(135deg, #a9cdb1 0%, #89b69e 100%);
            border: none;
            color: #1f3d2f;
        }
        .choice-btn-user:hover,
        .choice-btn-user:focus {
            background: linear-gradient(135deg, #9fc8aa 0%, #7ead95 100%);
            color: #173225;
        }
        .admin-placeholder {
            background: linear-gradient(135deg, #f6d7e3 0%, #efc2d3 100%);
            color: #6e4055;
            border: none;
            box-shadow: 0 10px 22px rgba(239, 194, 211, 0.35);
        }
        .admin-placeholder:hover,
        .admin-placeholder:focus {
            color: #5e3648;
            background: linear-gradient(135deg, #f3cfdc 0%, #ebb7cc 100%);
        }
        @media (max-width: 768px) {
            .choice-grid {
                grid-template-columns: 1fr;
            }
            .choice-hero,
            .choice-grid {
                padding-left: 20px;
                padding-right: 20px;
            }
        }
    </style>
</head>
<body>
    <main class="choice-shell">
        <section class="choice-hero">
            <h1>Choisissez votre accès</h1>
            <p>Connectez-vous en tant qu'utilisateur ou accédez à l'espace admin.</p>
        </section>

        <section class="choice-grid">
            <article class="choice-card">
                <div>
                    <span class="choice-badge badge-user">Utilisateur</span>
                    <div class="choice-title">Espace utilisateur</div>
                    <div class="choice-text">Créer un compte, se connecter, calculer l'IMC et recevoir les suggestions de régime.</div>
                </div>
                <a href="<?= site_url('utilisateur/register') ?>" class="btn choice-btn choice-btn-user">Créer un compte utilisateur</a>
            </article>

            <article class="choice-card">
                <div>
                    <span class="choice-badge badge-admin">Admin</span>
                    <div class="choice-title">Espace administration</div>
                    <div class="choice-text">Zone réservée au backend admin. </div>
                </div>
                <a href="/admin/auth/login" class="btn admin-placeholder choice-btn">Accéder au backend admin</a>
            </article>
        </section>
    </main>
</body>
</html>
