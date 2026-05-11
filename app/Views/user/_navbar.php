<nav class="navbar navbar-expand-lg topbar">
    <div class="container py-2">
        <a class="navbar-brand brand" href="<?= site_url('utilisateur/accueil') ?>">Regime <span>Pro</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

                <?php if (isset($user)): ?>

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

                            <?= esc($user['solde_portefeuille'] ?? 0); ?> Ar
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

                <li class="nav-item">
                    <a class="btn logout-btn rounded-pill px-3 fw-semibold"
                       href="<?= site_url('utilisateur/logout') ?>">
                        Se déconnecter
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>
