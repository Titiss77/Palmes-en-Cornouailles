<?php echo $this->extend('Public/Layout/l_global'); ?>

<?php echo $this->section('contenu'); ?>

<div class="site-container">
    <a href="<?php echo base_url('/'); ?>" class="text-decoration-none me-3 text-dark">
        <i class="bi bi-arrow-left-circle"></i>
    </a>

    <h3 class="title-section">Événements</h3>
    <div class="card-item news-card">
        <?php foreach ($actualites as $item) { ?>

        <div class="news-item mb-4 border-bottom pb-3">

            <?php if (!empty($item['image'])) { ?>

            <?php if (str_starts_with($item['image'], 'https://')) { ?>
            <img src="<?php echo $item['image']; ?>" alt="<?php echo esc($item['alt']); ?>" class="img-card mb-3" />

            <?php } else { ?>
            <img src="<?php echo base_url('uploads/'.$item['image']); ?>" alt="<?php echo esc($item['alt']); ?>"
                class="img-card mb-3" />
            <?php } ?>
            <?php } ?>

            <div class="news-content">
                <h5><?php echo esc($item['titre']); ?></h5>

                <?php
                $dateRef = $item['date_evenement'] ?? $item['created_at'];
            $dateLabel = $item['date_evenement'] ? 'Le' : 'Publié le';
            ?>

                <p class="small text-muted">
                    <i class="bi bi-calendar3"></i> <?php echo $dateLabel; ?> <?php echo date('d/m/Y', strtotime($dateRef)); ?>
                </p>

                <?php if ('evenement' === $item['type'] && !empty($item['date_evenement'])) { ?>
                <p class="event-date text-primary">
                    <strong><i class="bi bi-geo-alt"></i> Événement à venir</strong>
                </p>
                <?php } ?>

                <p><?php echo esc($item['description']); ?></p>
            </div>
        </div>
        <?php } ?>
    </div>




</div>

<?php echo $this->endSection(); ?>