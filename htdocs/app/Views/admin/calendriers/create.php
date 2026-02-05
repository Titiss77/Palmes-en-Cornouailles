<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('admin/calendriers') ?>" class="text-decoration-none me-3 text-dark">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h3 class="title-section mb-0">Nouveau Document</h3>
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
        <form action="<?= base_url('admin/calendriers') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

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
                        placeholder="Ex: Saison 2024-2025 ou Toussaint" value="<?= old('date') ?>" required>
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
<?= $this->endSection() ?>