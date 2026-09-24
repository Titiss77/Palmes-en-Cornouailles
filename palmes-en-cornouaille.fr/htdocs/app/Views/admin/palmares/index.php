<?php echo $this->extend('admin/Layout/l_global'); ?>

<?php echo $this->section('contenu'); ?>
<?php echo $this->include('admin/retour'); ?>

<div class="site-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="title-section mb-0">Gestion du Palmarès</h3>
        <a href="<?php echo base_url('admin/palmares/new'); ?>" class="btn-home">
            <i class="bi bi-plus-circle"></i> Ajouter un résultat
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) { ?>
    <div class="alert alert-success text-center mb-4 shadow-sm" style="border-radius: var(--radius);">
        <?php echo session()->getFlashdata('success'); ?>
    </div>
    <?php } ?>

    <div class="card-item overflow-hidden">
        <div class="table-responsive">
            <table class="table-admin">
                <thead>
                    <tr>
                        <th width="10%">Photo</th>
                        <th width="30%">Nageur</th>
                        <th width="30%">Compétition / Épreuve</th>
                        <th width="15%">Résultat</th>
                        <th width="15%">Statut</th>
                        <th width="15%" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($palmares)) { ?>
                    <?php foreach ($palmares as $p) { ?>
                    <tr>
                        <td>
                            <?php if (!empty($p['image_path'])) { ?>
                            <img src="<?php echo base_url('uploads/'.$p['image_path']); ?>" alt="Podium" class="actu-thumb">
                            <?php } else { ?>
                            <div class="actu-placeholder">
                                <i class="bi bi-trophy text-muted"></i>
                            </div>
                            <?php } ?>
                        </td>

                        <td>
                            <div class="actu-info">
                                <strong
                                    class="actu-title"><?php echo esc($p['nom_nageur'].' '.$p['prenom_nageur']); ?></strong>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex flex-column">
                                <strong class="text-dark"><?php echo esc($p['competition']); ?></strong>
                                <small class="text-muted">
                                    <?php echo date('d/m/Y', strtotime($p['date_epreuve'])); ?>
                                    &bull; <?php echo esc($p['epreuve']); ?>
                                </small>
                            </div>
                        </td>

                        <td>
                            <?php
                            $medal = '';
                        if (1 == $p['classement']) {
                            $medal = '🥇';
                        } elseif (2 == $p['classement']) {
                            $medal = '🥈';
                        } elseif (3 == $p['classement']) {
                            $medal = '🥉';
                        }
                        ?>
                            <span class="badge bg-light text-dark border">
                                <?php echo $medal; ?> <?php echo esc($p['classement']); ?><sup>e</sup>
                            </span>
                            <?php if (!empty($p['temps'])) { ?>
                            <div class="small text-muted mt-1">
                                <i class="bi bi-stopwatch"></i> <?php echo esc($p['temps']); ?>
                            </div>
                            <?php } ?>
                        </td>

                        <td>
                            <?php
                        // Définition des couleurs spécifiques au statut
                        $colors = [
                            'publie' => '#28a745',
                            'brouillon' => '#ffc107',
                            'archive' => '#6c757d',
                        ];
                        // Fallback sur la variable secondary du seed si statut inconnu, ou gris
                        $bgStatus = $colors[$p['statut']] ?? '#ccc';
                        ?>
                            <span class="status-badge" style="background-color: <?php echo $bgStatus; ?>;">
                                <?php echo ucfirst($p['statut']); ?>
                            </span>
                        </td>

                        <td class="text-end">
                            <a href="<?php echo base_url('admin/palmares/'.$p['id'].'/edit'); ?>"
                                class="btn-icon text-primary me-1" title="Modifier">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?php echo base_url('admin/palmares/'.$p['id'].'/delete'); ?>"
                                class="btn-icon text-danger" onclick="return confirm('Confirmer la suppression ?');"
                                title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td colspan="5" class="text-center p-5 text-muted">
                            <i class="bi bi-trophy fs-1 d-block mb-3"></i>
                            Aucun résultat pour le moment.
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>