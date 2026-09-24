<?php

$menuItems = [
    '/admin' => 'Accueil',
    '/admin/groupes' => 'Nos Groupes',
    '/admin/boutiques' => 'Boutique',
    '/admin/contact' => 'Contact / inscriptions',
    '/admin/calendriers' => 'Calendriers',
];
?>

<head>
    <title><?php echo $titrePage; ?></title>
    <?php if (!empty($general['image'])) { ?>
    <link rel="icon" type="image/png" href="<?php echo base_url('uploads/'.$general['image']); ?>">
    <?php } ?>
    <?php echo view('css/dynamic_root', ['root' => $root]); ?>
    <link rel="stylesheet" href="<?php echo base_url('Assets/css/Public/global.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('Assets/css/'.$cssPage); ?>">
</head>
<nav>
    <div class="nav-brand">
        <img src="<?php echo base_url('uploads/'.$general['image']); ?>" alt="logo du club" />
        <h2><?php echo $general['nomClub']; ?></h2>
    </div>

    <button class="menu-toggle" id="mobile-menu-btn" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <ul class="nav-menu" id="nav-menu">
        <?php foreach ($menuItems as $url => $label) { ?>
        <li>
            <?php echo anchor($url, $label); ?>
        </li>
        <?php } ?>
    </ul>
</nav>

<?php echo $this->renderSection('contenu'); ?>

<footer id="piedBlog">
    <nav class="footer-nav">
        <ul>
            <?php foreach ($menuItems as $url => $label) { ?>
            <li>
                <?php echo anchor($url, $label); ?>
            </li>
            <?php } ?>
        </ul>
    </nav>

    <div class="social-links">
        <a href="<?php echo $general['lienFacebook']; ?>" target="_blank" aria-label="Facebook">
            <i class="bi bi-facebook"></i>
        </a>
        <a href="<?php echo $general['lienInstagram']; ?>" target="_blank" aria-label="Instagram">
            <i class="bi bi-instagram"></i>
        </a>
        <a class="fede" href="<?php echo $general['lienffessm']; ?>" target="_blank" aria-label="FFESSM">
            <img src="<?php echo base_url('uploads/'.$general['logoffessm']); ?>" alt="FFESSM">
        </a>
    </div>

    <p>&copy; <?php echo date('Y'); ?> <?php echo esc($general['nomClub']); ?>. Tous droits réservés.</p>
    <p class="admin-link"><?php echo anchor('/mentions-legales', 'Mentions légales'); ?></p>
    <p class="admin-link"><?php echo anchor('/politique-confidentialite', 'Confidentialité'); ?></p>
    <!--<p class="admin-link"><?php echo anchor('/login', '(administration)'); ?></p>-->
</footer>

<script>
const mobileBtn = document.getElementById('mobile-menu-btn');
const navMenu = document.getElementById('nav-menu');

mobileBtn.addEventListener('click', () => {
    navMenu.classList.toggle('active');
    mobileBtn.classList.toggle('active');
}); // <-- AJOUT : Il manquait la fermeture de l'événement click du bouton

// Fermer le menu si on clique sur un lien
document.querySelectorAll('.nav-menu li a').forEach(link => {
    link.addEventListener('click', () => {
        navMenu.classList.remove('active');
        mobileBtn.classList.remove('active');
    });
}); // <-- AJOUT : Il manquait la fermeture de la boucle forEach
</script>