<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="title-section mb-0">Gestion des Partenaires</h3>
        <a href="<?= base_url('admin/partenaires/new') ?>" class="btn-home">
            <i class="bi bi-plus-circle"></i> Ajouter un partenaire
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
                        <th width="15%">Logo</th>
                        <th width="50%">Nom / Description</th>
                        <th width="15%">Ordre</th>
                        <th width="20%" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($partenaires)): ?>
                    <?php foreach ($partenaires as $p): ?>
                    <tr>
                        <td>
                            <?php if (!empty($p['image_path'])): ?>
                            <img src="<?= base_url('uploads/' . $p['image_path']) ?>"
                                class="rounded shadow-sm bg-white border"
                                style="width: 60px; height: 40px; object-fit: contain;">
                            <?php else: ?>
                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 40px;">
                                <i class="bi bi-building text-muted"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-bold"><?= esc($p['description']) ?></td>
                        <td>
                            <span class="badge bg-light text-dark border"><?= esc($p['ordre']) ?></span>
                        </td>
                        <td class="text-end">
                            <a href="<?= base_url('admin/partenaires/' . $p['id'] . '/edit') ?>"
                                class="btn-icon text-primary me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="<?= base_url('admin/partenaires/' . $p['id'] . '/delete') ?>"
                                class="btn-icon text-danger" onclick="return confirm('Supprimer ce partenaire ?');"><i
                                    class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center p-4">Aucun partenaire enregistré.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>