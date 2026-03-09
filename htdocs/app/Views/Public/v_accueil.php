<?php echo $this->extend('Public/Layout/l_global'); ?>

<?php echo $this->section('contenu'); ?>

<div class="site-container">

    <section class="hero-banner full-bleed">
        <img src="<?php echo esc(base_url('uploads/'.$general['image_groupe']), 'attr'); ?>" alt="Photo du club"
            loading="lazy" />

        <div class="hero-overlay">
            <h1 class="hero-title"><?php echo esc($general['nomClub']); ?></h1>
        </div>
    </section>

    <div class="main-layout-with-sidebar mt-5">

        <div class="main-content">
            <section class="block-club">

                <div class="info">
                    <h2>Bienvenue au <?php echo esc($general['nomClub']); ?></h2>
                    <p class="txt-intro"><?php echo esc($general['description']); ?></p>
                    <p><strong>Philosophie :</strong> <?php echo esc($general['philosophie']); ?></p>
                </div>

                <div class="stats-card mt-3">
                    <div class="stats-box">
                        <h4 class="color-blue"><?php echo esc($general['nombreNageurs']); ?> nageurs</h4>
                        <p>Mixité : <?php echo esc($general['pourcentH']); ?>% H / <?php echo esc($general['pourcentF']); ?>% F</p>
                        <hr>
                        <p class="small">
                            <strong>Projet Sportif :</strong>
                            <?php echo esc($general['projetSportif'] ?? 'Compétition & Loisir'); ?>
                        </p>
                    </div>
                </div>
            </section>
        </div>

        <h3 class="title-section">Nos groupes</h3>
        <div class="grid-responsive">
            <?php foreach ($groupes as $d) { ?>
            <div class="card-item hover-effect" style="background:<?php echo esc($d['codeCouleur'], 'attr'); ?>;">
                <img src="<?php echo esc(base_url('uploads/'.$d['image']), 'attr'); ?>" alt="<?php echo esc($d['nom'], 'attr'); ?>"
                    class="img-card" />
                <div class="p-3">
                    <h5><?php echo esc($d['nom']); ?></h5>
                    <p><?php echo esc($d['tranche_age']); ?></p>
                </div>
                <a href="<?php echo base_url('/groupes'); ?>" class="btn-shop-link">
                    Plus d'infos <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <?php } ?>
        </div>

        <h3 class="title-section">Événements</h3>
        <div class="card-item news-card">
            <?php if (!empty($actualites)) { ?>
            <?php foreach ($actualites as $item) { ?>

            <div class="news-item mb-3 border-bottom pb-3">
                <div class="news-content">
                    <h5 class="mb-1" style="font-size: 1.1rem; color: var(--primary);">
                        <?php echo esc($item['titre']); ?>
                    </h5>

                    <?php
                    // Pas besoin d'esc ici car ce sont des dates générées par PHP, mais bonne pratique de vérifier si null
                    $dateRef = $item['date_evenement'] ?? $item['created_at'];
                $dateLabel = !empty($item['date_evenement']) ? 'Le' : 'Publié le';
                ?>
                    <p class="small text-muted mb-2">
                        <i class="bi bi-calendar3"></i> <?php echo $dateLabel; ?> <?php echo date('d/m/Y', strtotime($dateRef)); ?>
                    </p>

                    <a href="<?php echo base_url('actu/'.esc($item['slug'], 'url')); ?>"
                        class="text-decoration-none small fw-bold" style="color: var(--secondary);">
                        Plus de détails <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php } else { ?>
            <p>Aucune actualité pour le moment. Revenez bientôt !</p>
            <?php } ?>
        </div>

        <h3 class="title-section">Nos disciplines</h3>
        <div class="grid-responsive">
            <?php if (!empty($disciplines)) { ?>
            <?php foreach ($disciplines as $d) { ?>
            <div class="card-item hover-effect">
                <img src="<?php echo esc(base_url('uploads/'.$d['image']), 'attr'); ?>" alt="<?php echo esc($d['nom'], 'attr'); ?>"
                    class="img-card" />
                <div class="p-3">
                    <h5><?php echo esc($d['nom']); ?></h5>
                    <p><?php echo esc($d['description']); ?></p>
                </div>
            </div>
            <?php } ?>
            <?php } else { ?>
            <p>Aucune disciplines pour le moment. Revenez bientôt !</p>
            <?php } ?>
        </div>

        <h3 class="title-section">Nos coachs</h3>
        <div class="grid-responsive">
            <?php if (!empty($coaches)) { ?>
            <?php foreach ($coaches as $c) { ?>
            <div class="coach-item text-center p-3">
                <img src="<?php echo esc(base_url('uploads/'.$c['photo']), 'attr'); ?>" alt="<?php echo esc($c['nom'], 'attr'); ?>"
                    class="img-circle mb-3" />
                <h4><?php echo esc($c['nom']); ?></h4>
            </div>
            <?php } ?>
            <?php } else { ?>
            <p>Aucun coach pour le moment. Revenez bientôt !</p>
            <?php } ?>
        </div>

        <h3 class="title-section">Nos coachs en formation</h3>
        <div class="grid-responsive">
            <?php if (!empty($coachesForm)) { ?>
            <?php foreach ($coachesForm as $c) { ?>
            <div class="coach-item text-center p-3">
                <img src="<?php echo esc(base_url('uploads/'.$c['photo']), 'attr'); ?>" alt="<?php echo esc($c['nom'], 'attr'); ?>"
                    class="img-circle mb-3" />
                <h4><?php echo esc($c['nom']); ?></h4>
            </div>
            <?php } ?>
            <?php } else { ?>
            <p>Aucun coach en formation pour le moment. Revenez bientôt !</p>
            <?php } ?>
        </div>

        <h3 class="title-section">Lieux d'entraînements</h3>
        <div class="grid-responsive">
            <?php if (!empty($piscines)) { ?>
            <?php foreach ($piscines as $p) { ?>
            <div class="piscine-card card-item h-100 d-flex flex-column">
                <img src="<?php echo esc(base_url('uploads/'.($p['photo'] ?? 'piscines/default_piscine.jpg')), 'attr'); ?>"
                    alt="<?php echo esc($p['nom'], 'attr'); ?>" class="img-card" style="height: 200px; object-fit: cover;" />

                <div class="piscine-info p-3 d-flex flex-column flex-grow-1">
                    <h5><?php echo esc($p['nom']); ?></h5>

                    <?php
                // Utilisation de rawurlencode pour être conforme aux standards URL
                // Utilisation du lien HTTPS standard de Google Maps Search
                $adresseEncoded = rawurlencode($p['adresse']);
                $lienMaps = "https://www.google.com/maps/search/?api=1&query={$adresseEncoded}";
                ?>

                    <p class="mb-3">
                        <a href="<?php echo $lienMaps; ?>" target="_blank" rel="noopener noreferrer" class="maps-link"
                            title="Ouvrir dans Google Maps">
                            <i class="bi bi-geo-alt-fill"></i> <?php echo esc($p['adresse']); ?>
                        </a>
                    </p>

                    <div class="mt-auto">
                        <span class="tag-bassin">Bassin <?php echo esc($p['type_bassin'] ?? '25m'); ?></span>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php } else { ?>
            <p>Aucunes piscines pour le moment. Revenez bientôt !</p>
            <?php } ?>
        </div>

    </div>

    <h3 class="title-section">Nos partenaires</h3>
    <div class="grid-responsive-2">
        <?php if (!empty($partenaires)) { ?>
        <?php foreach ($partenaires as $partenaire) { ?>
        <div class="partenaires-item text-center p-3">
            <div class="contenu">
                <img class="img-card-2" src="<?php echo esc(base_url('uploads/'.$partenaire['image_url']), 'attr'); ?>"
                    alt="<?php echo esc($partenaire['description'], 'attr'); ?>">
                <i class="bi bi-arrow-right fleche"></i>
            </div>
            <div class="contenu">
                <p><?php echo esc($partenaire['description']); ?></p>
            </div>
        </div>
        <?php } ?>
        <?php } else { ?>
        <p>Aucuns partenaires pour le moment. Revenez bientôt !</p>
        <?php } ?>
    </div>

</div>

<?php echo $this->endSection(); ?>