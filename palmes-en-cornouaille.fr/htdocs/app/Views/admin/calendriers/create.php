<?php echo $this->extend('admin/Layout/l_global'); ?>
<?php echo $this->section('contenu'); ?>
<?php echo $this->include('admin/retour'); ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo base_url('admin/calendriers'); ?>" class="text-decoration-none me-3 text-dark">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h3 class="title-section mb-0">Nouveau Document</h3>
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
        <form action="<?php echo base_url('admin/calendriers'); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Catégorie *</label>
                    <select name="categorie" class="form-input w-100 p-2">
                        <option value="scolaire">Période Scolaire (Image)</option>
                        <option value="vacances">Vacances (Image)</option>
                        <option value="competitions">Compétitions (PDF)</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Titre / Saison *</label>
                    <input type="text" name="date" class="form-input w-100 p-2"
                        placeholder="Ex: Saison 2024-2025 ou Toussaint" value="<?php echo old('date'); ?>" required>
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-1">Fichier (Image ou PDF)</label>
                <input type="file" name="image" class="form-input w-100 p-2" accept="image/*,.pdf">
                <small class="text-muted">Pour les compétitions, privilégiez le format PDF.</small>
            </div>

            <div class="text-end">
                <button type="submit" class="btn-home"><i class="bi bi-save"></i> Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?php echo $this->endSection(); ?>