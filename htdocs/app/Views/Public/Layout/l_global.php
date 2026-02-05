<?php
$isLogged = session()->get('isLoggedIn');

$menuItems = [
    '/' => 'Accueil',
    '/groupes' => 'Nos Groupes',
    '/boutique' => 'Boutique',
    '/contact' => 'Contact / inscriptions',
    '/calendriers' => 'Calendriers',
];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Mea+Culpa&family=Montserrat:wght@900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <title><?= $titrePage; ?></title>
    <?php if (!empty($general['image'])): ?>
    <link rel="icon" type="image/png" href="<?= base_url($general['image']); ?>">
    <?php endif; ?>
    <?= view('css/dynamic_root', ['root' => $root]); ?>
    <link rel="stylesheet" href="<?= base_url('Assets/css/Public/global.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('Assets/css/' . $cssPage); ?>">
</head>

<body>
    <nav>
        <div class="nav-brand">
            <img src="<?= base_url('' . $general['image']); ?>" alt="logo du club" />
            <h2><?= $general['nomClub']; ?></h2>
        </div>

        <button class="menu-toggle" id="mobile-menu-btn" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <ul class="nav-menu" id="nav-menu">
            <?php foreach ($menuItems as $url => $label): ?>
            <li>
                <?= anchor($isLogged ? 'logout?return=' . $url : $url, $label); ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <?= $this->renderSection('contenu') ?>

    <footer id="piedBlog">
        <nav class="footer-nav">
            <ul>
                <?php foreach ($menuItems as $url => $label): ?>
                <li>
                    <?= anchor($isLogged ? 'logout?return=' . $url : $url, $label); ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="social-links">
            <a href="<?= $general['lienFacebook']; ?>" target="_blank" aria-label="Facebook">
                <i class="bi bi-facebook"></i>
            </a>
            <a href="<?= $general['lienInstagram']; ?>" target="_blank" aria-label="Instagram">
                <i class="bi bi-instagram"></i>
            </a>
            <a class="fede" href="<?= $general['lienffessm']; ?>" target="_blank" aria-label="FFESSM">
                <img src="<?= base_url('uploads/' . $general['logoffessm']); ?>" alt="FFESSM">
            </a>
        </div>

        <p>&copy; <?= date('Y'); ?> <?= esc($general['nomClub']); ?>. Tous droits réservés.</p>
        <p class="admin-link"><?= anchor('/mentions-legales', 'Mentions légales'); ?></p>
        <p class="admin-link"><?= anchor('/politique-confidentialite', 'Confidentialité'); ?></p>
        <!--<p class="admin-link"><?= anchor('/login', '(Administration)'); ?></p>-->
    </footer>

    <script>
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const navMenu = document.getElementById('nav-menu');

    mobileBtn.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        mobileBtn.classList.toggle('active');
    });

    // Fermer le menu si on clique sur un lien
    document.querySelectorAll('.nav-menu li a').forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            mobileBtn.classList.remove('active');
        });
    });
    </script>
</body>

</html>