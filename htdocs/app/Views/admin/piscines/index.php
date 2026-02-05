<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="title-section mb-0">Gestion des Lieux</h3>
        <a href="<?= base_url('admin/piscines/new') ?>" class="btn-home">
            <i class="bi bi-plus-circle"></i> Ajouter un lieu
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success text-center mb-4"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card-item overflow-hidden">
        <div class="table-responsive">
            <table class="table-admin">
                <thead>
                    <tr>
                        <th width="15%">Photo</th>
                        <th width="25%">Nom</th>
                        <th width="35%">Adresse</th>
                        <th width="10%">Bassin</th>
                        <th width="15%" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($piscines)): ?>
                    <?php foreach ($piscines as $p): ?>
                    <tr>
                        <td>
                            <?php if (!empty($p['image_path'])): ?>
                            <img src="<?= base_url('uploads/' . $p['image_path']) ?>" class="rounded shadow-sm"
                                style="width: 60px; height: 40px; object-fit: cover;">
                            <?php else: ?>
                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 40px;">
                                <i class="bi bi-geo-alt text-muted"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-bold text-primary"><?= esc($p['nom']) ?></td>
                        <td>
                            <small class="text-muted"><i class="bi bi-map"></i> <?= esc($p['adresse']) ?></small>
                        </td>
                        <td>
                            <span class="badge bg-secondary"><?= esc($p['type_bassin']) ?></span>
                        </td>
                        <td class="text-end">
                            <a href="<?= base_url('admin/piscines/' . $p['id'] . '/edit') ?>"
                                class="btn-icon text-primary me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="<?= base_url('admin/piscines/' . $p['id'] . '/delete') ?>"
                                class="btn-icon text-danger" onclick="return confirm('Supprimer ce lieu ?');"><i
                                    class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center p-4">Aucun lieu enregistré.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>