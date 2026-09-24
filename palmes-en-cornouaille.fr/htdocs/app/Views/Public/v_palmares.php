<?php echo $this->extend('Public/Layout/l_global'); ?>

<?php echo $this->section('contenu'); ?>

<div class="site-container">
    <a href="<?php echo base_url('/'); ?>" class="text-decoration-none me-3 text-dark">
        <i class="bi bi-arrow-left-circle"></i>
    </a>

    <h3 class="title-section">Derniers podiums & résultats</h3>

    <div class="grid-responsive">
        <?php foreach ($palmares as $p) { ?>
        <div class="card-item hover-effect result-card">
            <?php if (!empty($p['image_path'])) { ?>
            <img src="<?php echo esc(base_url('uploads/'.$p['image_path']), 'attr'); ?>"
                alt="<?php echo esc($p['competition'], 'attr'); ?>" class="img-card"
                style="height: 200px; object-fit: cover;" />
            <?php } ?>

            <div class="badge bg-warning text-dark mt-2 p-2 w-100">
                <?php
                if (1 == $p['classement']) {
                    echo '🥇 1ère Place';
                } elseif (2 == $p['classement']) {
                    echo '🥈 2ème Place';
                } elseif (3 == $p['classement']) {
                    echo '🥉 3ème Place';
                } else {
                    echo esc($p['classement']).'ème Place';
                }
            ?>
            </div>

            <div class="p-3">
                <h5 class="text-primary mb-1">
                    <?php echo esc($p['prenom_nageur']); ?> <?php echo esc($p['nom_nageur']); ?>
                </h5>

                <p class="mb-1">
                    <i class="bi bi-stopwatch"></i> <?php echo esc($p['epreuve']); ?>
                    <?php if (!empty($p['temps'])) { ?>
                    - <strong><?php echo esc($p['temps']); ?></strong>
                    <?php } ?>
                </p>

                <small class="text-muted d-block mt-2 text-end">
                    Le <?php echo date('d/m/Y', strtotime($p['date_epreuve'])); ?>
                    à <?php echo esc($p['competition']); ?>
                </small>
            </div>
        </div>
        <?php } ?>
    </div>



</div>

<?php echo $this->endSection(); ?>