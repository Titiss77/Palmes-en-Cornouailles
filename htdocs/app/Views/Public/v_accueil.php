<?= $this->extend('Public/Layout/l_global') ?>

<?= $this->section('contenu') ?>

<div class="site-container">

    <section class="hero-banner full-bleed">
        <img src="<?= esc(base_url('uploads/' . $general['image_groupe']), 'attr') ?>" alt="Photo du club"
            loading="lazy" />

        <div class="hero-overlay">
            <h1 class="hero-title"><?= esc($general['nomClub']); ?></h1>
        </div>
    </section>

    <div class="main-layout-with-sidebar mt-5">

        <div class="main-content">
            <section class="block-club">

                <div class="info">
                    <h2>Bienvenue au <?= esc($general['nomClub']); ?></h2>
                    <p class="txt-intro"><?= esc($general['description']); ?></p>
                    <p><strong>Philosophie :</strong> <?= esc($general['philosophie']); ?></p>
                </div>

                <div class="stats-card mt-3">
                    <div class="stats-box">
                        <h4 class="color-blue"><?= esc($general['nombreNageurs']); ?> nageurs</h4>
                        <p>Mixité : <?= esc($general['pourcentH']); ?>% H / <?= esc($general['pourcentF']); ?>% F</p>
                        <hr>
                        <p class="small">
                            <strong>Projet Sportif :</strong>
                            <?= esc($general['projetSportif'] ?? 'Compétition & Loisir'); ?>
                        </p>
                    </div>
                </div>
            </section>
        </div>

        <h3 class="title-section">Nos groupes</h3>
        <div class="grid-responsive">
            <?php foreach ($groupes as $d): ?>
            <div class="card-item hover-effect" style="background:<?= esc($d['codeCouleur'], 'attr') ?>;">
                <img src="<?= esc(base_url('uploads/' . $d['image']), 'attr'); ?>" alt="<?= esc($d['nom'], 'attr') ?>"
                    class="img-card" />
                <div class="p-3">
                    <h5><?= esc($d['nom']); ?></h5>
                    <p><?= esc($d['tranche_age']); ?></p>
                </div>
                <a href="<?= base_url('/groupes'); ?>" class="btn-shop-link">
                    Plus d'infos <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <h3 class="title-section">Derniers Podiums & Résultats 🏆</h3>
        <?php if (!empty($palmares)): ?>
        <div class="grid-responsive">
            <?php foreach ($palmares as $p): ?>
            <div class="card-item hover-effect result-card">
                <?php if (!empty($p['image_path'])): ?>
                <img src="<?= esc(base_url('uploads/' . $p['image_path']), 'attr'); ?>"
                    alt="<?= esc($p['competition'], 'attr') ?>" class="img-card"
                    style="height: 200px; object-fit: cover;" />
                <?php else: ?>
                <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                    <i class="bi bi-trophy" style="font-size: 3rem; color: #ccc;"></i>
                </div>
                <?php endif; ?>

                <div class="p-3">
                    <h5 class="text-primary mb-1"><?= esc($p['nom_nageur']); ?></h5>
                    <strong class="d-block mb-2"><?= esc($p['competition']); ?></strong>

                    <p class="mb-1">
                        <i class="bi bi-stopwatch"></i> <?= esc($p['epreuve']); ?>
                        <?php if(!empty($p['temps'])): ?>
                        - <strong><?= esc($p['temps']); ?></strong>
                        <?php endif; ?>
                    </p>

                    <div class="badge bg-warning text-dark mt-2 p-2 w-100">
                        <?php 
                                    if($p['classement'] == 1) echo '🥇 1ère Place';
                                    elseif($p['classement'] == 2) echo '🥈 2ème Place';
                                    elseif($p['classement'] == 3) echo '🥉 3ème Place';
                                    else echo esc($p['classement']) . 'ème Place';
                                ?>
                    </div>

                    <small class="text-muted d-block mt-2 text-end">
                        Le <?= date('d/m/Y', strtotime($p['date_epreuve'])); ?>
                    </small>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-center text-muted">Aucun résultat récent à afficher.</p>
        <?php endif; ?>

        <h3 class="title-section">Événements</h3>
        <div class="card-item news-card">
            <?php if (!empty($actualites)): ?>
            <?php foreach ($actualites as $item): ?>

            <div class="news-item mb-3 border-bottom pb-3">
                <div class="news-content">
                    <h5 class="mb-1" style="font-size: 1.1rem; color: var(--primary);">
                        <?= esc($item['titre']); ?>
                    </h5>

                    <?php
                    // Pas besoin d'esc ici car ce sont des dates générées par PHP, mais bonne pratique de vérifier si null
                    $dateRef = $item['date_evenement'] ?? $item['created_at'];
                    $dateLabel = !empty($item['date_evenement']) ? 'Le' : 'Publié le';
                    ?>
                    <p class="small text-muted mb-2">
                        <i class="bi bi-calendar3"></i> <?= $dateLabel ?> <?= date('d/m/Y', strtotime($dateRef)); ?>
                    </p>

                    <a href="<?= base_url('actu/' . esc($item['slug'], 'url')) ?>"
                        class="text-decoration-none small fw-bold" style="color: var(--secondary);">
                        Plus de détails <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>Aucune actualité pour le moment. Revenez bientôt !</p>
            <?php endif; ?>
        </div>

        <h3 class="title-section">Nos disciplines</h3>
        <div class="grid-responsive">
            <?php if (!empty($disciplines)): ?>
            <?php foreach ($disciplines as $d): ?>
            <div class="card-item hover-effect">
                <img src="<?= esc(base_url('uploads/' . $d['image']), 'attr'); ?>" alt="<?= esc($d['nom'], 'attr') ?>"
                    class="img-card" />
                <div class="p-3">
                    <h5><?= esc($d['nom']); ?></h5>
                    <p><?= esc($d['description']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>Aucune disciplines pour le moment. Revenez bientôt !</p>
            <?php endif; ?>
        </div>

        <h3 class="title-section">Nos coachs</h3>
        <div class="grid-responsive">
            <?php if (!empty($coaches)): ?>
            <?php foreach ($coaches as $c): ?>
            <div class="coach-item text-center p-3">
                <img src="<?= esc(base_url('uploads/' . $c['photo']), 'attr'); ?>" alt="<?= esc($c['nom'], 'attr'); ?>"
                    class="img-circle mb-3" />
                <h4><?= esc($c['nom']); ?></h4>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>Aucun coach pour le moment. Revenez bientôt !</p>
            <?php endif; ?>
        </div>

        <h3 class="title-section">Nos coachs en formation</h3>
        <div class="grid-responsive">
            <?php if (!empty($coachesForm)): ?>
            <?php foreach ($coachesForm as $c): ?>
            <div class="coach-item text-center p-3">
                <img src="<?= esc(base_url('uploads/' . $c['photo']), 'attr'); ?>" alt="<?= esc($c['nom'], 'attr'); ?>"
                    class="img-circle mb-3" />
                <h4><?= esc($c['nom']); ?></h4>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>Aucun coach en formation pour le moment. Revenez bientôt !</p>
            <?php endif; ?>
        </div>

        <h3 class="title-section">Lieux d'entraînements</h3>
        <div class="grid-responsive">
            <?php if (!empty($piscines)): ?>
            <?php foreach ($piscines as $p): ?>
            <div class="piscine-card card-item h-100 d-flex flex-column">
                <img src="<?= esc(base_url('uploads/' . ($p['photo'] ?? 'piscines/default_piscine.jpg')), 'attr') ?>"
                    alt="<?= esc($p['nom'], 'attr') ?>" class="img-card" style="height: 200px; object-fit: cover;" />

                <div class="piscine-info p-3 d-flex flex-column flex-grow-1">
                    <h5><?= esc($p['nom']); ?></h5>

                    <?php
                    // Utilisation de rawurlencode pour être conforme aux standards URL
                    // Utilisation du lien HTTPS standard de Google Maps Search
                    $adresseEncoded = rawurlencode($p['adresse']);
                    $lienMaps = "https://www.google.com/maps/search/?api=1&query={$adresseEncoded}";
                    ?>

                    <p class="mb-3">
                        <a href="<?= $lienMaps ?>" target="_blank" rel="noopener noreferrer" class="maps-link"
                            title="Ouvrir dans Google Maps">
                            <i class="bi bi-geo-alt-fill"></i> <?= esc($p['adresse']); ?>
                        </a>
                    </p>

                    <div class="mt-auto">
                        <span class="tag-bassin">Bassin <?= esc($p['type_bassin'] ?? '25m'); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>Aucunes piscines pour le moment. Revenez bientôt !</p>
            <?php endif; ?>
        </div>

    </div>

    <h3 class="title-section">Nos partenaires</h3>
    <div class="grid-responsive-2">
        <?php if (!empty($partenaires)): ?>
        <?php foreach ($partenaires as $partenaire): ?>
        <div class="partenaires-item text-center p-3">
            <div class="contenu">
                <img class="img-card-2" src="<?= esc(base_url('uploads/' . $partenaire['image_url']), 'attr'); ?>"
                    alt="<?= esc($partenaire['description'], 'attr') ?>">
                <i class="bi bi-arrow-right fleche"></i>
            </div>
            <div class="contenu">
                <p><?= esc($partenaire['description']) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>Aucuns partenaires pour le moment. Revenez bientôt !</p>
        <?php endif; ?>
    </div>

</div>

<?= $this->endSection() ?>