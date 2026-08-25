<?php echo $this->extend('admin/Layout/l_global'); ?>
<?php echo $this->section('contenu'); ?>
<?php echo $this->include('admin/retour'); ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo base_url('admin/calendriers'); ?>" class="text-decoration-none me-3 text-dark">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h3 class="title-section mb-0">Modifier : <?php echo esc($item['date']); ?></h3>
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
        <form action="<?php echo base_url('admin/calendriers/'.$item['id']); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Catégorie *</label>
                    <select name="categorie" class="form-input w-100 p-2">
                        <option value="scolaire" <?php echo 'scolaire' == $item['categorie'] ? 'selected' : ''; ?>>Période
                            Scolaire</option>
                        <option value="vacances" <?php echo 'vacances' == $item['categorie'] ? 'selected' : ''; ?>>Vacances
                        </option>
                        <option value="competitions" <?php echo 'competitions' == $item['categorie'] ? 'selected' : ''; ?>>
                            Compétitions</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Titre / Saison *</label>
                    <input type="text" name="date" class="form-input w-100 p-2"
                        value="<?php echo old('date', $item['date']); ?>" required>
                </div>
            </div>


            <?php if (!empty($item['image_path'])) { ?>
            <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light mb-2 suppr-img">
                <div>
                    <?php if (str_ends_with($item['image_path'], '.pdf')) { ?>
                    <span class="text-danger fw-bold"><i class="bi bi-file-earmark-pdf"></i> Document PDF</span>
                    <a href="<?php echo base_url('uploads/'.$item['image_path']); ?>" target="_blank"
                        class="ms-2 small">Voir</a>
                    <?php } else { ?>
                    <img src="<?php echo base_url('uploads/'.$item['image_path']); ?>" class="img-calendriers">
                    <?php } ?>
                </div>

                <a href="<?php echo base_url('admin/calendriers/'.$item['id'].'/deleteImage'); ?>"
                    class="text-danger small fw-bold" onclick="return confirm('Supprimer ce fichier ?');">
                    <i class="bi bi-trash"></i> Supprimer
                </a>
            </div>
            <?php } ?>

            <div class="form-group mb-4">
                <label class="fw-bold mb-1">Remplacer le fichier</label>
                <input type="file" name="image" class="form-input w-100 p-2" accept="image/*,.pdf">
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn-home"><i class="bi bi-check-lg"></i> Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
<?php echo $this->endSection(); ?>