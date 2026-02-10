<?= $this->extend('admin/Layout/l_global') ?>

<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('admin/palmares') ?>" class="text-decoration-none me-3 text-dark">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h3 class="title-section mb-0">Ajouter une performance</h3>
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
        <form action="<?= base_url('admin/palmares') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Nom du nageur *</label>
                    <input type="text" name="nom_nageur" class="form-input w-100 p-2" value="<?= old('nom_nageur') ?>"
                        required>
                </div>
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Prénom du nageur *</label>
                    <input type="text" name="prenom_nageur" class="form-input w-100 p-2"
                        value="<?= old('prenom_nageur') ?>" required>
                </div>
            </div>

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Lieu de la compétition *</label>
                    <input type="text" name="competition" class="form-input w-100 p-2"
                        placeholder="Ex: Championnats Départementaux" value="<?= old('competition') ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Date de la compétition *</label>
                    <input type="date" name="date_epreuve" class="form-input w-100 p-2"
                        value="<?= old('date_epreuve') ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label class="fw-bold mb-1">Course *</label>
                        <input type="text" name="epreuve" class="form-input w-100 p-2" value="<?= old('epreuve') ?>"
                            required>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label class="fw-bold mb-1">Classement *</label>
                        <input type="number" name="classement" class="form-input w-100 p-2" placeholder="1, 2, 3..."
                            value="<?= old('classement') ?>" required>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label class="fw-bold mb-1">Temps (Optionnel)</label>
                        <input type="text" name="temps" class="form-input w-100 p-2" placeholder="mm:ss.ms"
                            value="<?= old('temps') ?>">
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-1">Photo du podium (Optionnel)</label>
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