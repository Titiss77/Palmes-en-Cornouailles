<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="title-section mb-0">Gestion de l'Équipe</h3>
        <a href="<?= base_url('admin/membres/new') ?>" class="btn-home">
            <i class="bi bi-person-plus-fill"></i> Ajouter un membre
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
                        <th width="10%">Photo</th>
                        <th width="30%">Nom</th>
                        <th width="40%">Fonctions / Rôles</th>
                        <th width="20%" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($membres)): ?>
                    <?php foreach ($membres as $m): ?>
                    <tr>
                        <td>
                            <?php if (!empty($m['image_path'])): ?>
                            <img src="<?= base_url('uploads/' . $m['image_path']) ?>" class="rounded-circle" ">
                            <?php else: ?>
                            <div class=" rounded-circle bg-light d-flex align-items-center justify-content-center"
                                style="width:50px; height:50px;">
                            <i class="bi bi-person text-muted"></i>
        </div>
        <?php endif; ?>
        </td>
        <td class="fw-bold"><?= esc($m['nom']) ?></td>
        <td>
            <?php if (!empty($m['roles_string'])): ?>
            <?php foreach (explode(', ', $m['roles_string']) as $role): ?>
            <span class="badge bg-info text-dark me-1"><?= esc($role) ?></span>
            <?php endforeach; ?>
            <?php else: ?>
            <span class="text-muted small">Aucun rôle</span>
            <?php endif; ?>
        </td>
        <td class="text-end">
            <a href="<?= base_url('admin/membres/' . $m['id'] . '/edit') ?>" class="btn-icon text-primary me-1"><i
                    class="bi bi-pencil-square"></i></a>
            <a href="<?= base_url('admin/membres/' . $m['id'] . '/delete') ?>" class="btn-icon text-danger"
                onclick="return confirm('Supprimer ce membre ?');"><i class="bi bi-trash"></i></a>
        </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="4" class="text-center p-4">Aucun membre enregistré.</td>
        </tr>
        <?php endif; ?>
        </tbody>
        </table>
    </div>
</div>
</div>
<?= $this->endSection() ?>