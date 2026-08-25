<?php echo $this->extend('Public/Layout/l_global'); ?>
<?php echo $this->section('contenu'); ?>

<div class="site-container">
    <h3 class="title-section">Nos groupes</h3>

    <div class="grid-responsive">
        <?php if (!empty($groupes)) { ?>
        <?php foreach ($groupes as $d) { ?>

        <div class="card-item group-card h-100 d-flex flex-column">

            <div class="group-img-header">
                <?php if (!empty($d['image'])) { ?>
                <img src="<?php echo base_url('uploads/'.esc($d['image'])); ?>" alt="<?php echo esc($d['nom']); ?>" loading="lazy" />
                <?php } else { ?>
                <div class="group-img-placeholder">
                    <i class="bi bi-image"></i>
                </div>
                <?php } ?>

                <span class="price-badge"><?php echo esc($d['prix']); ?> €*</span>
            </div>

            <div class="group-body d-flex flex-column flex-grow-1">

                <h5 class="group-title"><?php echo esc($d['nom']); ?></h5>

                <p class="group-desc flex-grow-1">
                    <?php echo esc($d['description']); ?>
                </p>

                <div class="group-meta mt-3">
                    <?php if (!empty($d['tranche_age'])) { ?>
                    <span class="meta-pill" style="background-color:<?php echo esc($d['codeCouleur']); ?>;">
                        <i class="bi bi-person"></i> <?php echo esc($d['tranche_age']); ?>
                    </span>
                    <?php } ?>

                    <?php if (!empty($d['horaire_resume'])) { ?>
                    <span class="meta-pill" style="background-color:<?php echo esc($d['codeCouleur']); ?>;">
                        <i class="bi bi-clock"></i> <?php echo esc($d['horaire_resume']); ?>
                    </span>
                    <?php } ?>
                </div>

            </div>
        </div>
        <?php } ?>
        <?php } else { ?>
        <p>Aucuns groupes pour le moment. Revenez bientôt !</p>
        <?php } ?>
    </div>
    <p>*Via Hello asso, paiement en 3x, passport et chèques vacances</p>
</div>

<?php echo $this->endSection(); ?>