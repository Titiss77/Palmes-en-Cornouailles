<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="title-section mb-0">Gestion des Calendriers</h3>
        <a href="<?= base_url('admin/calendriers/new') ?>" class="btn-home">
            <i class="bi bi-plus-circle"></i> Ajouter un document
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
                        <th width="15%">Aperçu</th>
                        <th width="20%">Catégorie</th>
                        <th width="45%">Nom / Saison</th>
                        <th width="20%" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($calendriers)): ?>
                    <?php foreach ($calendriers as $c): ?>
                    <tr>
                        <td>
                            <?php if (!empty($c['image_path'])): ?>
                            <?php if (str_ends_with($c['image_path'], '.pdf')): ?>
                            <div class="text-danger fs-2 text-center bg-light rounded py-2" style="width: 50px;">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </div>
                            <?php else: ?>
                            <img src="<?= base_url('uploads/' . $c['image_path']) ?>" class="rounded shadow-sm"
                                style="width: 60px; height: 60px; object-fit: cover;">
                            <?php endif; ?>
                            <?php else: ?>
                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-file-earmark-x text-muted"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            $badges = [
                                'scolaire' => 'bg-info text-dark',
                                'vacances' => 'bg-warning text-dark',
                                'competitions' => 'bg-success text-white'
                            ];
                            $badgeClass = $badges[$c['categorie']] ?? 'bg-secondary text-white';
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($c['categorie']) ?></span>
                        </td>
                        <td class="fw-bold">
                            <?= esc($c['date']) ?>
                        </td>
                        <td class="text-end">
                            <a href="<?= base_url('admin/calendriers/' . $c['id'] . '/edit') ?>"
                                class="btn-icon text-primary me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="<?= base_url('admin/calendriers/' . $c['id'] . '/delete') ?>"
                                class="btn-icon text-danger" onclick="return confirm('Supprimer ce document ?');"><i
                                    class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center p-4">Aucun calendrier enregistré.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="<?= base_url('admin/calendriers/pdf/new') ?>" class="btn btn-primary">
        <i class="bi bi-file-pdf"></i> Générer PDF depuis CSV
    </a>
</div>
<?= $this->endSection() ?>