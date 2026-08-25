<?php echo $this->extend('admin/Layout/l_global'); ?>
<?php echo $this->section('contenu'); ?>
<?php echo $this->include('admin/retour'); ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo base_url('admin/partenaires'); ?>" class="text-decoration-none me-3 text-dark">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h3 class="title-section mb-0">Nouveau Partenaire</h3>
    </div>

    <?php if (session()->getFlashdata('errors')) { ?>
    <div class="alert alert-danger mb-4 p-3">
        <ul class="mb-0 ps-3">
            <?php foreach (session()->getFlashdata('errors') as $error) { ?>
            <li><?php echo esc($error); ?></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>

    <div class="card-item p-4">
        <form action="<?php echo base_url('admin/partenaires'); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Nom du partenaire (Description) *</label>
                    <input type="text" name="description" class="form-input w-100 p-2" value="<?php echo old('description'); ?>"
                        required>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Ordre d'affichage</label>
                    <input type="number" name="ordre" class="form-input w-100 p-2" value="<?php echo old('ordre', 1); ?>">
                    <small class="text-muted">Plus le chiffre est petit, plus il apparaît en premier.</small>
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-1">Logo</label>
                <input type="file" name="image" class="form-input w-100 p-2" accept="image/*">
            </div>

            <div class="text-end">
                <button type="submit" class="btn-home"><i class="bi bi-save"></i> Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?php echo $this->endSection(); ?>