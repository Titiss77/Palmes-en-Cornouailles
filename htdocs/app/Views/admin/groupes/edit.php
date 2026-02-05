<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('admin/groupes') ?>" class="text-decoration-none me-3 text-dark">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h3 class="title-section mb-0">Modifier : <?= esc($item['nom']) ?></h3>
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
        <form action="<?= base_url('admin/groupes/' . $item['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Nom du groupe *</label>
                    <input type="text" name="nom" class="form-input w-100 p-2" value="<?= old('nom', $item['nom']) ?>"
                        required>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Couleur</label>
                    <div class="d-flex gap-2">
                        <input type="color" class="form-control form-control-color" id="colorPicker"
                            value="<?= esc($item['codeCouleur'] ?: '#002d5a') ?>" style="width: 50px; padding: 5px;">
                        <input type="text" name="codeCouleur" id="codeCouleur" class="form-input w-100 p-2"
                            value="<?= old('codeCouleur', $item['codeCouleur']) ?>">
                    </div>
                </div>
            </div>

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Tranche d'âge</label>
                    <input type="text" name="tranche_age" class="form-input w-100 p-2"
                        value="<?= old('tranche_age', $item['tranche_age']) ?>">
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Résumé Horaire</label>
                    <input type="text" name="horaire_resume" class="form-input w-100 p-2"
                        value="<?= old('horaire_resume', $item['horaire_resume']) ?>">
                </div>
            </div>

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Prix (Cotisation) *</label>
                    <input type="text" name="prix" class="form-input w-100 p-2"
                        value="<?= old('prix', $item['prix']) ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Ordre d'affichage</label>
                    <input type="number" name="ordre" class="form-input w-100 p-2"
                        value="<?= old('ordre', $item['ordre']) ?>">
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="fw-bold mb-1">Description</label>
                <textarea name="description" rows="4"
                    class="form-input w-100 p-2"><?= old('description', $item['description']) ?></textarea>
            </div>

            <?php if (!empty($item['image_path'])): ?>
            <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light mb-2 suppr-img">
                <img src="<?= base_url('uploads/' . $item['image_path']) ?>" class="img-groupes">
                <a href="<?= base_url('admin/groupes/' . $item['id'] . '/deleteImage') ?>"
                    class="text-danger small fw-bold" onclick="return confirm('Supprimer l\'image ?');">
                    <i class="bi bi-trash"></i> Supprimer
                </a>
            </div>
            <?php endif; ?>
            <input type="file" name="image" class="form-input w-100 p-2" accept="image/*">

            <div class="text-end mt-4">
                <button type="submit" class="btn-home"><i class="bi bi-check-lg"></i> Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('colorPicker').addEventListener('input', function() {
    document.getElementById('codeCouleur').value = this.value;
});
</script>
<?= $this->endSection() ?>