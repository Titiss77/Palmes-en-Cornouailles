<?= $this->extend('Public/Layout/l_global') ?>

<?= $this->section('contenu') ?>

<div class="site-container">
    <a href="<?= base_url('/') ?>" class="text-decoration-none me-3 text-dark">
        <i class="bi bi-arrow-left-circle"></i>
    </a>

    <h3 class="title-section">Actualités</h3>
    <div class="card-item news-card">
        <?php foreach ($actualites as $item): ?>

        <div class="news-item mb-4 border-bottom pb-3">

            <?php if (!empty($item['image'])): ?>

            <?php if (str_starts_with($item['image'], 'https://')): ?>
            <img src="<?= $item['image']; ?>" alt="<?= esc($item['alt']) ?>" class="img-card mb-3" />

            <?php else: ?>
            <img src="<?= base_url('uploads/' . $item['image']); ?>" alt="<?= esc($item['alt']) ?>"
                class="img-card mb-3" />
            <?php endif; ?>
            <?php endif; ?>

            <div class="news-content">
                <h5><?= esc($item['titre']); ?></h5>

                <?php
                $dateRef = $item['date_evenement'] ?? $item['created_at'];
                $dateLabel = $item['date_evenement'] ? 'Le' : 'Publié le';
                ?>

                <p class="small text-muted">
                    <i class="bi bi-calendar3"></i> <?= $dateLabel ?> <?= date('d/m/Y', strtotime($dateRef)); ?>
                </p>

                <?php if ($item['type'] === 'evenement' && !empty($item['date_evenement'])): ?>
                <p class="event-date text-primary">
                    <strong><i class="bi bi-geo-alt"></i> Événement à venir</strong>
                </p>
                <?php endif; ?>

                <p><?= esc($item['description']); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>




</div>

<?= $this->endSection() ?>