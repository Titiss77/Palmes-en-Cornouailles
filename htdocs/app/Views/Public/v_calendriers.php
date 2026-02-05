@ -1,97 +1,116 @@
<?= $this->extend('Public/Layout/l_global') ?>

<?php

/**
 * ============================================================================
 * VUE : CALENDRIERS & HORAIRES
 * ============================================================================
 * Cette vue affiche les documents relatifs à l'organisation temporelle du club.
 * Elle se divise en deux sections distinctes :
 * 1. Les calendriers d'entraînements (images/jpg) : Vacances, Scolaire, etc.
 * 2. Le Calendrier des compétitions (fichier/pdf) : Liste des rencontres à télécharger.
 *
 * Les données ($calendriers, $calendrierCompet) sont injectées par le contrôleur 'Home'.
 */
?>

<?= $this->section('contenu') ?>

<div class="site-container">
    <h2 class="title">Calendriers & Horaires</h2>


    <h3 class="title title-section"><i class="bi bi-calendar3"></i> Planning des Entraînements</h3>
    <p class="txt-muted">Périodes scolaires et vacances.</p>
    <section class="mb-5">
        <?php
        if (!empty($calendriers)):
            // 1. On groupe les calendriers par catégorie dans un nouveau tableau
            $groupedCalendriers = [];
            foreach ($calendriers as $planning) {
                $groupedCalendriers[$planning['categorie']][] = $planning;
            }

            // 2. On boucle sur chaque catégorie
            foreach ($groupedCalendriers as $categorie => $items):
                ?>
        <div class="category-block mb-4">
            <h4 class="text-secondary border-bottom pb-2 mb-3">
                <?= esc(ucfirst($categorie)) ?>
            </h4>

            <div class="calendar-grid">
                <?php foreach ($items as $item): ?>
                <div class="calendar-img-box">
                    <a href="<?= base_url('uploads/' . $item['image']) ?>" target="_blank">
                        <p class="label-cal">
                            <strong><?= esc($item['date']) ?></strong>
                        </p>
                        <img src="<?= base_url('uploads/' . $item['image']) ?>" alt="Planning <?= esc($categorie) ?>"
                            class="img-fluid img-zoom" loading="lazy">
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
            endforeach;
        else:
            ?>

        <div class="alert-info-box">
            <i class="bi bi-info-circle"></i> Aucun planning disponible pour le moment.
        </div>

        <?php endif; ?>
    </section>

    <h3 class="title-section"><i class="bi bi-trophy"></i> Calendrier des compétitions</h3>
    <section class="mb-5">

        <?php
        // VÉRIFICATION : Y a-t-il un calendrier de compétition publié ?
        if (!empty($calendrierCompet)):
            ?>

        <?php foreach ($calendrierCompet as $item): ?>
        <div class="card-item stats-box download-card">

            <div class="d-flex align-items-center gap-3">

                <div class="download-icon">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                </div>

                <div>
                    <h5 class="mb-1 text-primary">Saison <?= esc($item['date']) ?></h5>
                    <p class="txt-small mb-0 text-muted">Consultez les dates et lieux (Format PDF)</p>
                </div>
            </div>

            <a href="<?= base_url('uploads/' . $item['image']) ?>" target="_blank"
                class="btn-home d-inline-flex align-items-center gap-2 text-decoration-none">
                <i class="bi bi-download"></i> Télécharger le calendrier
            </a>

        </div>
        <?php endforeach; ?>

        <?php else: // Si le calendrier compétition n'est pas encore prêt ?>

        <p class="text-muted">Le calendrier des compétitions sera bientôt mis en ligne.</p>

        <?php endif; ?>

    </section>
</div>

<?= $this->endSection() ?>