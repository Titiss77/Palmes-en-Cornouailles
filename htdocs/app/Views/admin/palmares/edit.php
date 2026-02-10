<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>

<div class="card">
    <div class="card-header">
        <h3>Modifier une performance</h3>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/palmares/update/' . $item['id']) ?>" method="post"
            enctype="multipart/form-data">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nageur *</label>
                    <select name="membre_id" class="form-control" required>
                        <option value="">-- Choisir un nageur --</option>
                        <?php foreach($membres as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= ($m['id'] == $item['membre_id']) ? 'selected' : '' ?>>
                            <?= esc($m['nom']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Date de l'épreuve *</label>
                    <input type="date" name="date_epreuve" class="form-control"
                        value="<?= esc($item['date_epreuve']) ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Nom de la compétition *</label>
                <input type="text" name="competition" class="form-control" value="<?= esc($item['competition']) ?>"
                    required>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Épreuve *</label>
                    <input type="text" name="epreuve" class="form-control" value="<?= esc($item['epreuve']) ?>"
                        required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Classement *</label>
                    <input type="text" name="classement" class="form-control" value="<?= esc($item['classement']) ?>"
                        required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Temps (Optionnel)</label>
                    <input type="text" name="temps" class="form-control" value="<?= esc($item['temps']) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label>Photo du podium (Laisser vide pour ne pas changer)</label>
                <input type="file" name="image" class="form-control">

                <?php if (!empty($item['image_path'])): ?>
                <div class="mt-2 p-2 border rounded bg-light">
                    <p class="mb-1">Image actuelle :</p>
                    <img src="<?= base_url('uploads/' . $item['image_path']) ?>" alt="Aperçu"
                        style="max-height: 150px;">
                    <br>
                    <a href="<?= base_url('admin/palmares/' . $item['id'] . '/deleteImage') ?>"
                        class="btn btn-sm btn-outline-danger mt-2"
                        onclick="return confirm('Supprimer définitivement cette image ?')">
                        <i class="bi bi-trash"></i> Supprimer l'image
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="<?= base_url('admin/palmares') ?>" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>