<?= $this->extend('admin/Layout/l_global') ?>

<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('admin/actualites') ?>" class="text-decoration-none me-3 text-dark">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h3 class="title-section mb-0">Nouvelle Actualité</h3>
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
        <form action="<?= base_url('admin/actualites') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="form-group mb-3">
                <label class="fw-bold mb-1">Titre de l'article *</label>
                <input type="text" name="titre" class="form-input w-100 p-2" value="<?= old('titre') ?>" required>
            </div>

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Date de l'événement (Optionnel)</label>
                    <input type="date" name="date_evenement" class="form-input w-100 p-2"
                        value="<?= old('date_evenement') ?>">
                    <small class="text-muted">Laisser vide si c'est une info générale.</small>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Statut de publication</label>
                    <select name="statut" class="form-input w-100 p-2">
                        <option value="brouillon" selected>Brouillon (Invisible)</option>
                        <option value="publie">Publié (Visible)</option>
                        <option value="archive">Archivé</option>
                    </select>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="fw-bold mb-1">Contenu *</label>
                <textarea name="description" rows="6" class="form-input w-100 p-2"
                    required><?= old('description') ?></textarea>
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-1">Image d'illustration</label>
                <input type="file" name="image" class="form-input w-100 p-2" accept="image/*">
            </div>

            <div class="text-end">
                <button type="submit" class="btn-home">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>