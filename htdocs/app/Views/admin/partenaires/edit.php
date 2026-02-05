<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('admin/partenaires') ?>" class="text-decoration-none me-3 text-dark">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h3 class="title-section mb-0">Modifier : <?= esc($item['description']) ?></h3>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger mb-4 p-3">
        <ul class="mb-0 ps-3">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="card-item p-4">
        <form action="<?= base_url('admin/partenaires/' . $item['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Nom du partenaire (Description) *</label>
                    <input type="text" name="description" class="form-input w-100 p-2"
                        value="<?= old('description', $item['description']) ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Ordre d'affichage</label>
                    <input type="number" name="ordre" class="form-input w-100 p-2"
                        value="<?= old('ordre', $item['ordre']) ?>">
                </div>
            </div>

            <?php if (!empty($item['image_path'])): ?>
            <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light mb-2 suppr-img">
                <img src="<?= base_url('uploads/' . $item['image_path']) ?>" class="img-partenaires">
                <a href="<?= base_url('admin/partenaires/' . $item['id'] . '/deleteImage') ?>"
                    class="text-danger small fw-bold" onclick="return confirm('Supprimer le logo ?');">
                    <i class="bi bi-trash"></i> Supprimer
                </a>
            </div>
            <?php endif; ?>

            <div class="form-group mb-4">
                <label class="fw-bold mb-1">Remplacer le logo</label>
                <input type="file" name="image" class="form-input w-100 p-2" accept="image/*">
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn-home"><i class="bi bi-check-lg"></i> Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>