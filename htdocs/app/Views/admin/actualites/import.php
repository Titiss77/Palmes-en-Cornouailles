<?= $this->extend('admin/Layout/l_global') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3>Importer des actualités (CSV)</h3>
    </div>
    <div class="card-body">

        <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session('errors') as $error): ?>
            <p><?= $error ?></p>
            <?php endforeach ?>
        </div>
        <?php endif ?>

        <form action="<?= base_url('admin/actualites/processImport') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="fichier_csv" class="form-label">Choisir un fichier CSV</label>
                <input class="form-control" type="file" id="fichier_csv" name="fichier_csv" required accept=".csv">
                <div class="form-text">Le format attendu est : Titre ; Description ; Date (AAAA-MM-JJ)</div>
            </div>

            <button type="submit" class="btn btn-primary">Importer</button>
            <a href="<?= base_url('admin/actualites') ?>" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>