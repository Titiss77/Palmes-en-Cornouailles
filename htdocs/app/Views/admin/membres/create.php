<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('admin/membres') ?>" class="text-decoration-none me-3 text-dark"><i
                class="bi bi-arrow-left-circle"></i></a>
        <h3 class="title-section mb-0">Nouveau Membre</h3>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger mb-4 p-3">
        <?= implode('<br>', session()->getFlashdata('errors')) ?>
    </div>
    <?php endif; ?>

    <div class="card-item p-4">
        <form action="<?= base_url('admin/membres') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2">Nom & Prénom *</label>
                <input type="text" name="nom" class="form-input w-100 p-2" value="<?= old('nom') ?>" required>
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2">Fonctions / Rôles</label>
                <div class="d-flex flex-wrap gap-3 p-3 border rounded bg-light">
                    <?php if (!empty($fonctions)): ?>
                    <?php foreach ($fonctions as $f): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="fonctions[]" value="<?= $f['id'] ?>"
                            id="f_<?= $f['id'] ?>">
                        <label class="form-check-label" for="f_<?= $f['id'] ?>">
                            <?= esc($f['titre']) ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p class="text-muted small mb-0">Aucune fonction paramétrée en base de données.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2">Photo de profil</label>
                <input type="file" name="image" class="form-input w-100 p-2" accept="image/*">
            </div>

            <div class="text-end">
                <button type="submit" class="btn-home"><i class="bi bi-save"></i> Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>