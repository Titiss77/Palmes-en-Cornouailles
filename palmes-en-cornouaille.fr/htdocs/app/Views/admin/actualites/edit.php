<?php echo $this->extend('admin/Layout/l_global'); ?>

<?php echo $this->section('contenu'); ?>
<?php echo $this->include('admin/retour'); ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo base_url('admin/actualites'); ?>" class="text-decoration-none me-3 text-dark">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h3 class="title-section mb-0">Modifier : <?php echo esc($item['titre']); ?></h3>
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
        <form action="<?php echo base_url('admin/actualites/'.$item['id']); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="form-group mb-3">
                <label class="fw-bold mb-1">Titre</label>
                <input type="text" name="titre" class="form-input w-100 p-2" value="<?php echo old('titre', $item['titre']); ?>"
                    required>
            </div>

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Date événement</label>
                    <input type="date" name="date_evenement" class="form-input w-100 p-2"
                        value="<?php echo old('date_evenement', $item['date_evenement']); ?>">
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Statut</label>
                    <select name="statut" class="form-input w-100 p-2">
                        <option value="brouillon" <?php echo 'brouillon' == $item['statut'] ? 'selected' : ''; ?>>Brouillon
                        </option>
                        <option value="publie" <?php echo 'publie' == $item['statut'] ? 'selected' : ''; ?>>Publié</option>
                        <option value="archive" <?php echo 'archive' == $item['statut'] ? 'selected' : ''; ?>>Archivé</option>
                    </select>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="fw-bold mb-1">Contenu</label>
                <textarea name="description" rows="6" class="form-input w-100 p-2"
                    required><?php echo old('description', $item['description']); ?></textarea>
            </div>

            <?php if (!empty($item['image_path'])) { ?>
            <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light mb-2 suppr-img">

                <div class="d-flex align-items-center gap-3">
                    <img src="<?php echo base_url('uploads/'.$item['image_path']); ?>">
                </div>

                <a href="<?php echo base_url('admin/actualites/'.$item['id'].'/deleteImage'); ?>"
                    class="text-danger text-decoration-none small fw-bold px-2"
                    onclick="return confirm('Voulez-vous vraiment supprimer définitivement cette image ?');">
                    <i class="bi bi-trash"></i> Supprimer
                </a>

            </div>
            <?php } ?>

            <input type="file" name="image" class="form-input w-100 p-2" accept="image/*">

            <div class="text-end">
                <button type="submit" class="btn-home">
                    <i class="bi bi-check-lg"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
<?php echo $this->endSection(); ?>