<style>
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
</style>

<footer class="footer">
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
