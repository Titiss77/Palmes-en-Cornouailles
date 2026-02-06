<?= $this->extend('admin/Layout/l_global') ?>

<?= $this->section('contenu') ?>

<div class="import-actu-container">
    <header class="import-actu-header">
        <h3 class="import-actu-title">Importer des actualités (CSV)</h3>
        <p class="import-actu-description">
            Utilisez cette page pour importer massivement vos articles.
        </p>
    </header>

    <?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <?php foreach (session('errors') as $error): ?>
        <p class="mb-0"><?= $error ?></p>
        <?php endforeach ?>
    </div>
    <?php endif ?>

    <div class="import-actu-step">
        <p class="import-actu-step-text">
            1. Téléchargez le modèle et complétez-le sans modifier l'en-tête.
        </p>
        <a href="<?= base_url('uploads/DossierType.csv') ?>" target="_blank" class="import-actu-btn-download">
            <i class="bi bi-download"></i> Télécharger le fichier modèle
        </a>
    </div>

    <form action="<?= base_url('admin/actualites/processImport') ?>" method="post" enctype="multipart/form-data"
        class="import-actu-form">
        <?= csrf_field() ?>

        <div class="import-actu-group">
            <label for="fichier_csv" class="import-actu-label">2. Choisir le fichier CSV complété</label>
            <input class="import-actu-input" type="file" id="fichier_csv" name="fichier_csv" required accept=".csv">
            <small class="import-actu-hint">Format attendu : Titre ; Statut ; Description ; Date</small>
        </div>

        <div class="import-actu-actions">
            <button type="submit" class="import-actu-btn-submit">
                <i class="bi bi-upload"></i> Importer
            </button>
            <a href="<?= base_url('admin/actualites') ?>" class="import-actu-btn-cancel">Annuler</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>