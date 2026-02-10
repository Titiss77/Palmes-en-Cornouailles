<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>

<div class="card">
    <div class="card-header">
        <h3>Ajouter une performance</h3>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/palmares/create') ?>" method="post" enctype="multipart/form-data">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nageur *</label>
                    <select name="membre_id" class="form-control" required>
                        <option value="">-- Choisir un nageur --</option>
                        <?php foreach($membres as $m): ?>
                        <option value="<?= $m['id'] ?>"><?= esc($m['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Date de l'épreuve *</label>
                    <input type="date" name="date_epreuve" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Nom de la compétition *</label>
                <input type="text" name="competition" class="form-control" placeholder="Ex: Championnats Départementaux"
                    required>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Épreuve *</label>
                    <input type="text" name="epreuve" class="form-control" placeholder="Ex: 50m Papillon" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Classement (Place) *</label>
                    <input type="number" name="classement" class="form-control" placeholder="1, 2, 3..." required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Temps (Optionnel)</label>
                    <input type="text" name="temps" class="form-control" placeholder="Ex: 00:32.45">
                </div>
            </div>

            <div class="mb-3">
                <label>Photo du podium (Optionnel)</label>
                <input type="file" name="image" class="form-control">
                <small class="text-muted">Elle sera renommée automatiquement : Nageur_Competition.jpg</small>
            </div>

            <button type="submit" class="btn btn-success">Enregistrer</button>
            <a href="<?= base_url('admin/palmares') ?>" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>