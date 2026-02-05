<?= $this->extend('admin/Layout/l_global') ?>

<?= $this->section('contenu') ?>

<?= $this->include('admin/retour') ?>


<div class="site-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="title-section mb-0">Gestion des Actualités</h3>
        <a href="<?= base_url('admin/actualites/new') ?>" class="btn-home">
            <i class="bi bi-plus-circle"></i> Créer une actualité
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
                        <th width="10%">Aperçu</th>
                        <th width="45%">Infos</th>
                        <th width="20%">Statut</th>
                        <th width="25%" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($actualites)): ?>
                    <?php foreach ($actualites as $actu): ?>
                    <tr>
                        <td>
                            <?php if (!empty($actu['image_path'])): ?>
                            <img src="<?= base_url('uploads/' . $actu['image_path']) ?>" alt="<?= $actu['alt'] ?>"
                                class="actu-thumb">
                            <?php else: ?>
                            <div class="actu-placeholder">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="actu-info">
                                <strong class="actu-title"><?= esc($actu['titre']) ?></strong>
                                <small class="actu-meta">
                                    <?php if ($actu['date_evenement']): ?>
                                    <i class="bi bi-calendar-event"></i>
                                    Événement : <?= date('d/m/Y', strtotime($actu['date_evenement'])) ?>
                                    <?php else: ?>
                                    <i class="bi bi-clock"></i>
                                    Créé le <?= date('d/m/Y', strtotime($actu['created_at'])) ?>
                                    <?php endif; ?>
                                </small>
                            </div>
                        </td>

                        <td>
                            <?php
                            // Définition des couleurs spécifiques au statut
                            $colors = [
                                'publie' => '#28a745',
                                'brouillon' => '#ffc107',
                                'archive' => '#6c757d'
                            ];
                            // Fallback sur la variable secondary du seed si statut inconnu, ou gris
                            $bgStatus = $colors[$actu['statut']] ?? '#ccc';
                            ?>
                            <span class="status-badge" style="background-color: <?= $bgStatus ?>;">
                                <?= ucfirst($actu['statut']) ?>
                            </span>
                        </td>

                        <td class="text-end">
                            <a href="<?= base_url('admin/actualites/' . $actu['id'] . '/edit') ?>"
                                class="btn-icon text-primary me-1" title="Modifier">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= base_url('admin/actualites/' . $actu['id'] . '/delete') ?>"
                                class="btn-icon text-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');"
                                title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center p-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            Aucune actualité pour le moment.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="<?= base_url('admin/actualites/import') ?>" class="btn-home">
        <i class="bi bi-plus-circle"></i> Importer des actualités
    </a>
</div>
<?= $this->endSection() ?>