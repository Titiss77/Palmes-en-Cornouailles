<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="title-section mb-0">Gestion du Matériel</h3>
        <a href="<?= base_url('admin/materiel/new') ?>" class="btn-home">
            <i class="bi bi-plus-circle"></i> Ajouter du matériel
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
                        <th width="15%">Image</th>
                        <th width="25%">Nom</th>
                        <th width="35%">Description</th>
                        <th width="10%">Statut / Type</th>
                        <th width="15%" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($materiel)): ?>
                    <?php foreach ($materiel as $m): ?>
                    <tr>
                        <td>
                            <?php if (!empty($m['image_path'])): ?>
                            <img src="<?= base_url('uploads/' . $m['image_path']) ?>" class="rounded shadow-sm"
                                style="width: 60px; height: 60px; object-fit: cover;">
                            <?php else: ?>
                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-tools text-muted"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-bold"><?= esc($m['nom']) ?></td>
                        <td>
                            <small class="text-muted"><?= esc(mb_strimwidth($m['description'], 0, 50, '...')) ?></small>
                        </td>
                        <td>
                            <span class="badge bg-secondary"><?= esc($m['pret_nom'] ?: 'Non défini') ?></span>
                        </td>
                        <td class="text-end">
                            <a href="<?= base_url('admin/materiel/' . $m['id'] . '/edit') ?>"
                                class="btn-icon text-primary me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="<?= base_url('admin/materiel/' . $m['id'] . '/delete') ?>"
                                class="btn-icon text-danger" onclick="return confirm('Supprimer cet élément ?');"><i
                                    class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center p-4">Aucun matériel enregistré.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>