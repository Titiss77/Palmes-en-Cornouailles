<?php
$isLogged = session()->get('isLoggedIn');

$menuItems = [
    '/' => 'Accueil',
    '/groupes' => 'Nos Groupes',
    '/boutique' => 'Boutique',
    '/contact' => 'Contact / inscriptions',
    '/calendriers' => 'Calendriers',
];

/*
 * Informations SEO
 */
$siteUrl = rtrim(base_url(), '/');
$canonicalUrl = current_url();

$siteName = $general['nomClub'] ?? 'Palmes en Cornouaille';

$metaDescription = !empty($general['description'])
    ? $general['description']
    : 'Palmes en Cornouaille, club de nage avec palmes à Quimper. Découvrez nos groupes, nos activités, nos actualités et les informations du club.';

$logoUrl = !empty($general['image'])
    ? base_url('uploads/' . $general['image'])
    : base_url('favicon.png');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ========================================================= -->
    <!-- SEO -->
    <!-- ========================================================= -->

    <title><?php echo esc($titrePage); ?></title>

    <meta name="description" content="<?php echo esc($metaDescription); ?>">

    <link rel="canonical" href="<?php echo esc($canonicalUrl); ?>">

    <!-- ========================================================= -->
    <!-- Open Graph -->
    <!-- ========================================================= -->

    <meta property="og:type" content="website">

    <meta property="og:url" content="<?php echo esc($canonicalUrl); ?>">

    <meta property="og:title" content="<?php echo esc($titrePage); ?>">

    <meta property="og:description" content="<?php echo esc($metaDescription); ?>">

    <!-- LOGO DU CLUB -->
    <meta property="og:image" content="<?php echo esc($logoUrl); ?>">

    <meta property="og:image:alt" content="Logo de Palmes en Cornouaille">

    <meta property="og:site_name" content="<?php echo esc($siteName); ?>">

    <!-- ========================================================= -->
    <!-- Twitter / X -->
    <!-- ========================================================= -->

    <meta name="twitter:card" content="summary">

    <meta name="twitter:url" content="<?php echo esc($canonicalUrl); ?>">

    <meta name="twitter:title" content="<?php echo esc($titrePage); ?>">

    <meta name="twitter:description" content="<?php echo esc($metaDescription); ?>">

    <!-- LOGO DU CLUB -->
    <meta name="twitter:image" content="<?php echo esc($logoUrl); ?>">

    <meta name="twitter:image:alt" content="Logo de Palmes en Cornouaille">

    <!-- ========================================================= -->
    <!-- Google Search Console -->
    <!-- ========================================================= -->

    <meta name="google-site-verification" content="_Pqc_5SFjGzJ_NlCLVTMh730dnVEgzJ9o__o2hl3A3k">

    <!-- ========================================================= -->
    <!-- Données structurées Google -->
    <!-- ========================================================= -->

    <script type="application/ld+json">
    <?php
    echo json_encode(
        [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',

            'name' => $siteName,

            'url' => $siteUrl,

            /*
             * C'est LE logo que nous voulons indiquer à Google.
             */
            'logo' => $logoUrl,

            'description' => $metaDescription,

            'sameAs' => array_values(
                array_filter([
                    $general['lienFacebook'] ?? null,
                    $general['lienInstagram'] ?? null,
                ])
            ),
        ],
        JSON_UNESCAPED_UNICODE
        | JSON_UNESCAPED_SLASHES
        | JSON_HEX_TAG
        | JSON_HEX_AMP
        | JSON_HEX_APOS
        | JSON_HEX_QUOT
    );
    ?>
    </script>

    <!-- ========================================================= -->
    <!-- Fonts / Icônes -->
    <!-- ========================================================= -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Mea+Culpa&family=Montserrat:wght@900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- ========================================================= -->
    <!-- Favicon = LOGO -->
    <!-- ========================================================= -->

    <?php if (!empty($general['image'])) { ?>

    <link rel="icon" type="image/png" href="<?php echo esc($logoUrl); ?>">

    <?php } ?>

    <!-- ========================================================= -->
    <!-- CSS -->
    <!-- ========================================================= -->

    <link rel="stylesheet"
        href="<?php echo base_url('Assets/css/Public/global.css?v=' . filemtime(FCPATH . 'Assets/css/Public/global.css')); ?>">

    <link rel="stylesheet"
        href="<?php echo base_url('Assets/css/' . $cssPage . '?v=' . filemtime(FCPATH . 'Assets/css/' . $cssPage)); ?>">

</head>

<?php echo view('css/dynamic_root', ['root' => $root]); ?>

<body>

    <!-- ========================================================= -->
    <!-- NAVIGATION -->
    <!-- ========================================================= -->

    <nav>

        <div class="nav-brand">

            <img src="<?php echo base_url('uploads/' . $general['image']); ?>"
                alt="Logo de <?php echo esc($general['nomClub']); ?>">

            <h2>
                <?php echo esc($general['nomClub']); ?>
            </h2>

        </div>

        <button class="menu-toggle" id="mobile-menu-btn" aria-label="Menu">

            <span></span>
            <span></span>
            <span></span>

        </button>

        <ul class="nav-menu" id="nav-menu">

            <?php foreach ($menuItems as $url => $label) { ?>

            <li>
                <?php echo anchor(
                    $isLogged ? 'logout?return=' . $url : $url,
                    $label
                ); ?>
            </li>

            <?php } ?>

        </ul>

    </nav>

    <!-- ========================================================= -->
    <!-- CONTENU -->
    <!-- ========================================================= -->

    <?php echo $this->renderSection('contenu'); ?>

    <!-- ========================================================= -->
    <!-- FOOTER -->
    <!-- ========================================================= -->

    <footer id="piedBlog">

        <nav class="footer-nav">

            <ul>

                <?php foreach ($menuItems as $url => $label) { ?>

                <li>
                    <?php echo anchor(
                        $isLogged ? 'logout?return=' . $url : $url,
                        $label
                    ); ?>
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

                <img src="<?php echo base_url('uploads/' . $general['logoffessm']); ?>" alt="FFESSM">

            </a>

        </div>

        <p>
            &copy;
            <?php echo date('Y'); ?>
            <?php echo esc($general['nomClub']); ?>.
            Tous droits réservés.
        </p>

        <p class="admin-link">
            <?php echo anchor(
                '/mentions-legales',
                'Mentions légales'
            ); ?>
        </p>

        <p class="admin-link">
            <?php echo anchor(
                '/politique-confidentialite',
                'Confidentialité'
            ); ?>
        </p>

        <!--<p class="admin-link">
            <?php echo anchor('/login', '(Administration)'); ?>
        </p>-->

    </footer>

    <!-- ========================================================= -->
    <!-- MENU MOBILE -->
    <!-- ========================================================= -->

    <script>
    const mobileBtn =
        document.getElementById('mobile-menu-btn');

    const navMenu =
        document.getElementById('nav-menu');

    mobileBtn.addEventListener('click', () => {

        navMenu.classList.toggle('active');

        mobileBtn.classList.toggle('active');

    });

    document
        .querySelectorAll('.nav-menu li a')
        .forEach(link => {

            link.addEventListener('click', () => {

                navMenu.classList.remove('active');

                mobileBtn.classList.remove('active');

            });

        });
    </script>

</html>