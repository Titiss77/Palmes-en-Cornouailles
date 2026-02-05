<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('admin/disciplines') ?>" class="text-decoration-none me-3 text-dark">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h3 class="title-section mb-0">Nouvelle Discipline</h3>
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
        <form action="<?= base_url('admin/disciplines') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="form-group mb-3">
                <label class="fw-bold mb-1">Nom de la discipline *</label>
                <input type="text" name="nom" class="form-input w-100 p-2"
                    placeholder="Ex: Natation Course, Water-Polo..." value="<?= old('nom') ?>" required>
            </div>

            <div class="form-group mb-3">
                <label class="fw-bold mb-1">Description</label>
                <textarea name="description" rows="5" class="form-input w-100 p-2"
                    placeholder="Présentation de l'activité..."><?= old('description') ?></textarea>
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-1">Image d'illustration</label>
                <input type="file" name="image" class="form-input w-100 p-2" accept="image/*">
            </div>

            <div class="text-end">
                <button type="submit" class="btn-home"><i class="bi bi-save"></i> Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>