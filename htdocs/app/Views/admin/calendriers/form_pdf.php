<?= $this->extend('admin/Layout/l_global') ?>

<?= $this->section('contenu') ?>
<div class="card">
    <div class="card-header">
        <h3>Générer le PDF du Calendrier</h3>
    </div>
    <div class="card-body">

        <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <?= implode('<br>', session('errors')) ?>
        </div>
        <?php endif ?>

        <form action="<?= base_url('admin/calendriers/pdf/generate') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="csv_file" class="form-label">Fichier CSV du calendrier</label>
                <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required>
                <div class="form-text">Format attendu : Date ; Lieu ; Bassin ; Niveau ; Nom Compétition</div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-file-pdf"></i> Générer et Télécharger le PDF
            </button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>