<?= $this->extend('Public/Layout/l_global') ?>

<?php

/**
 * ============================================================================
 * VUE : BOUTIQUE & PARTENARIATS
 * ============================================================================
 * Cette vue affiche les offres commerciales et les avantages du club.
 * Elle est divisée en deux parties logiques :
 * 1. La Boutique "HelloAsso" (Données dynamiques venant du Contrôleur/BDD).
 * 2. Les Partenariats & Bourse (Données statiques configurées ci-dessous).
 */
?>

<?= $this->section('contenu') ?>

<?php

/**
 * ----------------------------------------------------------------------------
 * 1. CONFIGURATION DES BLOCS "BOURSE & PARTENARIATS" (Pattern Data-Driven)
 * ----------------------------------------------------------------------------
 * Nous définissons ici le contenu des cartes de la seconde section.
 * Cela évite de dupliquer le code HTML et rend l'ajout d'un partenaire trivial.
 */
$partenariats = [
    // --- CARTE 1 : BOURSE AUX MATÉRIELS ---
    [
        'titre' => 'Bourse aux matériels',
        'icon' => 'bi-recycle',  // Icône Bootstrap
        // Note : Le HTML est autorisé ici car défini en dur dans le code (source de confiance).
        'html' => '<p>Plateforme d\'échange de matériel d\'occasion (palmes, tubas...).</p>
                    <p class="txt-small"><em>Réservé aux adhérents.</em></p>',
        'btn' => [
            'text' => 'Consulter le tableau de ventes',
            'url' => base_url('liste'),
            'icon' => 'bi-box-arrow-up-right',  // Icône PDF
            'class' => 'tag-bassin text-decoration-none'  // Style : Bouton gris arrondi (badge)
        ]
    ],
    // --- CARTE 2 : DECATHLON PRO ---
    [
        'titre' => 'Decathlon Pro Club',
        'icon' => 'bi-shop',
        'html' => '<p>Profitez de notre partenariat.</p>
                    <ul class="list-check">
                        <li>Cumul personnel de points fidélité</li>
                        <li>Bonus : le club cumul des points afin de réduire le coût des achats groupés</li>
                    </ul>',
        'btn' => [
            'text' => 'Accéder à la boutique Pro',
            'url' => $liensautres['lienDecatPro'],
            'icon' => 'bi-box-arrow-up-right',  // Icône lien externe
            'class' => 'color-blue fw-bold small'  // Style : Lien texte bleu simple
        ]
    ]
];
?>

<div class="site-container">

    <section class="hero-banner">
        <div class="hero-overlay">
            <h1 class="hero-title">Boutique & Matériel</h1>
        </div>
    </section>

    <h3 class="title-section">Boutiques du club</h3>

    <div class="grid-2">
        <?php if (!empty($boutique)): ?>
        <?php foreach ($boutique as $item): ?>

        <div class="card-item shop-card-clean">

            <div class="shop-card-content">
                <h5><?= esc($item['nom']) ?></h5>

                <p class="txt-small"><?= esc($item['description']) ?></p>

                <div class="price-box">
                    <span class="price-value"><?= esc($item['tranchePrix']) ?></span>
                </div>
            </div>

            <a href="<?= esc($item['url']) ?>" target="_blank" class="btn-shop-link">
                Commander sur HelloAsso <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>Aucuns partenaires pour le moment. Revenez bientôt !</p>
        <?php endif; ?>
    </div>

    <h3 class="title-section">Bourse & Partenariats</h3>

    <div class="grid-2">
        <?php foreach ($partenariats as $p): ?>

        <div class="card-item text-left h-100">

            <h3><i class="bi <?= esc($p['icon']) ?>"></i> <?= esc($p['titre']) ?></h3>

            <div class="mb-3">
                <?= $p['html'] ?>
            </div>

            <div class="mt-auto">
                <a href="<?= $p['btn']['url'] ?>" target="blank" class="<?= esc($p['btn']['class']) ?>">

                    <?php
                    // LOGIQUE D'AFFICHAGE DE L'ICÔNE
                    // Si l'icône n'est pas une flèche "arrow-right", on la met à GAUCHE du texte.
                    if (strpos($p['btn']['icon'], 'arrow-right') === false):
                        ?>
                    <i class="bi <?= esc($p['btn']['icon']) ?>"></i>
                    <?php endif; ?>

                    <?= esc($p['btn']['text']) ?>

                    <?php
                    // Si l'icône est une flèche "arrow-right", on la met à DROITE du texte (style "Lire la suite").
                    if (strpos($p['btn']['icon'], 'arrow-right') !== false):
                        ?>
                    <i class="bi <?= esc($p['btn']['icon']) ?>"></i>
                    <?php endif; ?>
                </a>
            </div>

        </div>
        <?php endforeach; ?>
    </div>

</div>

<?= $this->endSection() ?>