<?= $this->extend('Public/Layout/l_global') ?>

<?= $this->section('contenu') ?>

<div class="site-container">
    <a href="<?= base_url('/') ?>" class="text-decoration-none me-3 text-dark">
        <i class="bi bi-arrow-left-circle"></i>
    </a>

    <h3 class="title-section">Derniers podiums & résultats</h3>

    <div class="grid-responsive">
        <?php foreach ($palmares as $p): ?>
        <div class="card-item hover-effect result-card">
            <?php if (!empty($p['image_path'])): ?>
            <img src="<?= esc(base_url('uploads/' . $p['image_path']), 'attr'); ?>"
                alt="<?= esc($p['competition'], 'attr') ?>" class="img-card"
                style="height: 200px; object-fit: cover;" />
            <?php endif; ?>

            <div class="p-3">
                <h5 class="text-primary mb-1">
                    <?= esc($p['prenom_nageur']) ?> <?= esc($p['nom_nageur']) ?>
                </h5>
                <strong class="d-block mb-2"><?= esc($p['competition']); ?></strong>

                <p class="mb-1">
                    <i class="bi bi-stopwatch"></i> <?= esc($p['epreuve']); ?>
                    <?php if (!empty($p['temps'])): ?>
                    - <strong><?= esc($p['temps']); ?></strong>
                    <?php endif; ?>
                </p>

                <div class="badge bg-warning text-dark mt-2 p-2 w-100">
                    <?php
                    if ($p['classement'] == 1)
                        echo '🥇 1ère Place';
                    elseif ($p['classement'] == 2)
                        echo '🥈 2ème Place';
                    elseif ($p['classement'] == 3)
                        echo '🥉 3ème Place';
                    else
                        echo esc($p['classement']) . 'ème Place';
                    ?>
                </div>

                <small class="text-muted d-block mt-2 text-end">
                    Le <?= date('d/m/Y', strtotime($p['date_epreuve'])); ?>
                </small>
            </div>
        </div>
        <?php endforeach; ?>
    </div>



</div>

<?= $this->endSection() ?>