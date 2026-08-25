<?php echo $this->extend('admin/Layout/l_global'); ?>
<?php echo $this->section('contenu'); ?>
<?php echo $this->include('admin/retour'); ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo base_url('admin/materiel'); ?>" class="text-decoration-none me-3 text-dark">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h3 class="title-section mb-0">Modifier : <?php echo esc($item['nom']); ?></h3>
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
        <form action="<?php echo base_url('admin/materiel/'.$item['id']); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Nom du matériel *</label>
                    <input type="text" name="nom" class="form-input w-100 p-2" value="<?php echo old('nom', $item['nom']); ?>"
                        required>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Catégorie / Disponibilité *</label>
                    <select name="idPret" class="form-input w-100 p-2" required>
                        <option value="">-- Sélectionner --</option>
                        <?php if (!empty($typesPret)) { ?>
                        <?php foreach ($typesPret as $tp) { ?>
                        <option value="<?php echo $tp['id']; ?>"
                            <?php echo (old('idPret', $item['idPret']) == $tp['id']) ? 'selected' : ''; ?>>
                            <?php echo esc($tp['nom']); ?>
                        </option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="fw-bold mb-1">Description</label>
                <textarea name="description" rows="4"
                    class="form-input w-100 p-2"><?php echo old('description', $item['description']); ?></textarea>
            </div>


            <?php if (!empty($item['image_path'])) { ?>
            <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light mb-2 suppr-img">
                <img src="<?php echo base_url('uploads/'.$item['image_path']); ?>" class="img-materiel">
                <a href="<?php echo base_url('admin/materiel/'.$item['id'].'/deleteImage'); ?>"
                    class="text-danger small fw-bold" onclick="return confirm('Supprimer la photo ?');">
                    <i class="bi bi-trash"></i> Supprimer
                </a>
            </div>
            <?php } ?>

            <div class="form-group mb-4">
                <label class="fw-bold mb-1">Remplacer la photo</label>
                <input type="file" name="image" class="form-input w-100 p-2" accept="image/*">
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn-home"><i class="bi bi-check-lg"></i> Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
<?php echo $this->endSection(); ?>