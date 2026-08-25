<?php echo $this->extend('admin/Layout/l_global'); ?>
<?php echo $this->section('contenu'); ?>

<?php
$isLogged = session()->get('isLoggedIn');
$sections = [];

include __DIR__.'/section.php';

$currentUri = uri_string();

// Détermine la section active
$targetSection = (str_contains($currentUri, 'contact')) ? 'contact' : 'accueil';

// 1. D'abord on filtre correctement
$sections = array_filter($sections, function ($s) use ($targetSection) {
    // On retourne le résultat de la comparaison (Vrai ou Faux)
    return $s['section'] === $targetSection;
});

unset($section);  // Bonnes pratiques : on détruit la référence
?>

<div class="site-container">
    <?php if ($isLogged) { ?>
    <div class="deconnexion-section">
        <a href="<?php echo base_url('logout'); ?>" class="admin-nav-link logout-btn"
            onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')">
            <i class="bi bi-box-arrow-right"></i> <span>Déconnexion</span>
        </a>
    </div>

    <div class="admin-header">
        <h2 class="title-section" style="margin-top: 0;">Tableau de Bord : <?php echo session()->get('nom'); ?></h2>
    </div>
    <?php } ?>

    <?php foreach ($sections as $section) { ?>
    <p class="grey-text">* Vous êtes invités à changer d'onglet afin de trouver les paramètres que vous
        souhaitez modifier</p>
    <h3 class="admin-subtitle">
        <i class="bi <?php echo esc($section['icon']); ?>"></i> <?php echo esc($section['titre']); ?>
    </h3>

    <div class="grid-3 mb-5">

        <?php foreach ($section['cards'] as $card) { ?>
        <div class="card-item admin-nav-card">
            <div class="card-icon">
                <i class="bi <?php echo $card['icon']; ?>"></i>
            </div>

            <div class="card-info">
                <h4>
                    <?php echo isset($card['count']) ? esc($card['count']).' ' : ''; ?>
                    <?php echo esc($card['label']); ?>
                </h4>
                <p><?php echo esc($card['desc']); ?></p>
            </div>

            <a href="<?php echo base_url($card['url']); ?>" class="btn-admin-nav">
                <?php echo esc($card['btn']); ?> <i class="bi bi-chevron-right"></i>
            </a>
        </div>
        <?php } ?>

    </div>
    <?php } ?>

</div>

<?php echo $this->endSection(); ?>