<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>

<?php
$isLogged = session()->get('isLoggedIn');
$sections = [];
include __DIR__ . '/section.php';

$currentUri = uri_string();

// Détermine la section active
$targetSection = (strpos($currentUri, 'contact') !== false) ? 'contact' : 'accueil';

// 1. D'abord on filtre correctement
$sections = array_filter($sections, function ($s) use ($targetSection) {
    // On retourne le résultat de la comparaison (Vrai ou Faux)
    return $s['section'] === $targetSection;
});

// 2. Ensuite on modifie les données si besoin (via une boucle par référence &$section)
foreach ($sections as &$section) {
    if ($targetSection == 'contact') {
        // CORRECTION SYNTAXE : On utilise la concaténation pour base_url()
        $section['plus'] = "* Les tarifs sont modifiables dans la section nos groupes et pour les membres du bureau, c'est
        <a href='" . base_url('admin/membres') . "' style='color:red; font-weight:bold; font-size:14px;'>ici</a>.";
    }
}
unset($section);  // Bonnes pratiques : on détruit la référence
?>

<div class="site-container">
    <?php if ($isLogged): ?>
    <div class="deconnexion-section">
        <a href="<?= base_url('logout') ?>" class="admin-nav-link logout-btn"
            onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')">
            <i class="bi bi-box-arrow-right"></i> <span>Déconnexion</span>
        </a>
    </div>

    <div class="admin-header">
        <h2 class="title-section" style="margin-top: 0;">Tableau de Bord : <?= session()->get('nom') ?></h2>
    </div>
    <?php endif; ?>

    <?php foreach ($sections as $section): ?>
    <p class="grey-text">* Vous êtes invités à changer d'onglet afin de trouver les paramètres que vous
        souhaitez modifier</p>
    <h3 class="admin-subtitle">
        <i class="bi <?= esc($section['icon']) ?>"></i> <?= esc($section['titre']) ?>
    </h3>

    <div class="grid-3 mb-5">

        <?php foreach ($section['cards'] as $card): ?>
        <div class="card-item admin-nav-card">
            <div class="card-icon">
                <i class="bi <?= $card['icon'] ?>"></i>
            </div>

            <div class="card-info">
                <h4>
                    <?= isset($card['count']) ? esc($card['count']) . ' ' : '' ?>
                    <?= esc($card['label']) ?>
                </h4>
                <p><?= esc($card['desc']) ?></p>
            </div>

            <a href="<?= base_url($card['url']) ?>" class="btn-admin-nav">
                <?= esc($card['btn']) ?> <i class="bi bi-chevron-right"></i>
            </a>
        </div>
        <?php endforeach; ?>

        <?php if (isset($section['plus'])): ?>
        <p><?= $section['plus'] ?></p>
        <?php endif; ?>

    </div>
    <?php endforeach; ?>

</div>

<?= $this->endSection() ?>