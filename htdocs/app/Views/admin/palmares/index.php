<?= $this->extend('admin/Layout/l_global') ?>

<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="title-section mb-0">Gestion du Palmarès</h3>
        <a href="<?= base_url('admin/palmares/new') ?>" class="btn-home">
            <i class="bi bi-plus-circle"></i> Ajouter un résultat
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success text-center mb-4 shadow-sm" style="border-radius: var(--radius);">
        <?= session()->getFlashdata('success') ?>
    </div>
    <?php endif; ?>

    <div class="card-item overflow-hidden">
        <div class="table-responsive">
            <table class="table-admin">
                <thead>
                    <tr>
                        <th width="10%">Photo</th>
                        <th width="30%">Nageur</th>
                        <th width="30%">Compétition / Épreuve</th>
                        <th width="15%">Résultat</th>
                        <th width="15%" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($palmares)): ?>
                    <?php foreach ($palmares as $p): ?>
                    <tr>
                        <td>
                            <?php if (!empty($p['image_path'])): ?>
                            <img src="<?= base_url('uploads/' . $p['image_path']) ?>" alt="Podium" class="actu-thumb">
                            <?php else: ?>
                            <div class="actu-placeholder">
                                <i class="bi bi-trophy text-muted"></i>
                            </div>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="actu-info">
                                <strong
                                    class="actu-title"><?= esc($p['nom_nageur'] . ' ' . $p['prenom_nageur']) ?></strong>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex flex-column">
                                <strong class="text-dark"><?= esc($p['competition']) ?></strong>
                                <small class="text-muted">
                                    <?= date('d/m/Y', strtotime($p['date_epreuve'])) ?>
                                    &bull; <?= esc($p['epreuve']) ?>
                                </small>
                            </div>
                        </td>

                        <td>
                            <?php
                            $medal = '';
                            if($p['classement'] == 1) $medal = '🥇';
                            elseif($p['classement'] == 2) $medal = '🥈';
                            elseif($p['classement'] == 3) $medal = '🥉';
                            ?>
                            <span class="badge bg-light text-dark border">
                                <?= $medal ?> <?= esc($p['classement']) ?><sup>e</sup>
                            </span>
                            <?php if(!empty($p['temps'])): ?>
                            <div class="small text-muted mt-1">
                                <i class="bi bi-stopwatch"></i> <?= esc($p['temps']) ?>
                            </div>
                            <?php endif; ?>
                        </td>

                        <td class="text-end">
                            <a href="<?= base_url('admin/palmares/' . $p['id'] . '/edit') ?>"
                                class="btn-icon text-primary me-1" title="Modifier">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= base_url('admin/palmares/' . $p['id'] . '/delete') ?>"
                                class="btn-icon text-danger" onclick="return confirm('Confirmer la suppression ?');"
                                title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center p-5 text-muted">
                            <i class="bi bi-trophy fs-1 d-block mb-3"></i>
                            Aucun résultat pour le moment.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>