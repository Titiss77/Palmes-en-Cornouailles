<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Palmarès & Podiums</h3>
        <a href="<?= base_url('admin/palmares/new') ?>" class="btn btn-primary">Ajouter un résultat</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Nageur</th>
                    <th>Compétition</th>
                    <th>Épreuve</th>
                    <th>Classement</th>
                    <th>Temps</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($palmares)): ?>
                <?php foreach ($palmares as $p): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($p['date_epreuve'])) ?></td>
                    <td><?= esc($p['prenom_nageur'] . ' ' . $p['nom_nageur']) ?></td>
                    <td><?= esc($p['competition']) ?></td>
                    <td><?= esc($p['epreuve']) ?></td>
                    <td>
                        <?php if($p['classement'] == 1) echo '🥇'; ?>
                        <?php if($p['classement'] == 2) echo '🥈'; ?>
                        <?php if($p['classement'] == 3) echo '🥉'; ?>
                        <?= esc($p['classement']) ?>e
                    </td>
                    <td><?= esc($p['temps']) ?></td>
                    <td>
                        <?php if (!empty($p['image_path'])): ?>
                        <img src="<?= base_url('uploads/' . $p['image_path']) ?>" alt="Podium" width="50">
                        <?php else: ?>
                        -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/palmares/edit/' . $p['id']) ?>"
                            class="btn btn-sm btn-warning">Modif</a>
                        <a href="<?= base_url('admin/palmares/delete/' . $p['id']) ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Confirmer ?')">Suppr</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Aucun résultat enregistré.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>