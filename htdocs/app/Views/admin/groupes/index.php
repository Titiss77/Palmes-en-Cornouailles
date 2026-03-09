<?php echo $this->extend('admin/Layout/l_global'); ?>
<?php echo $this->section('contenu'); ?>
<?php echo $this->include('admin/retour'); ?>

<div class="site-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="title-section mb-0">Gestion des Groupes</h3>
        <a href="<?php echo base_url('admin/groupes/new'); ?>" class="btn-home">
            <i class="bi bi-plus-circle"></i> Ajouter un groupe
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) { ?>
    <div class="alert alert-success text-center mb-4"><?php echo session()->getFlashdata('success'); ?></div>
    <?php } ?>

    <div class="card-item overflow-hidden">
        <div class="table-responsive">
            <table class="table-admin">
                <thead>
                    <tr>
                        <th width="10%">Image</th>
                        <th width="25%">Nom</th>
                        <th width="30%">Infos (Âge / Horaires)</th>
                        <th width="10%">Prix</th>
                        <th width="10%">Ordre</th>
                        <th width="15%" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($groupes)) { ?>
                    <?php foreach ($groupes as $g) { ?>
                    <tr>
                        <td>
                            <?php if (!empty($g['image_path'])) { ?>
                            <img src="<?php echo base_url('uploads/'.$g['image_path']); ?>" class="rounded shadow-sm"
                                style="width: 60px; height: 40px; object-fit: cover;">
                            <?php } else { ?>
                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 40px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                            <?php } ?>
                        </td>
                        <td>
                            <strong style="color: <?php echo esc($g['codeCouleur'] ?: 'var(--primary)'); ?>;">
                                <?php echo esc($g['nom']); ?>
                            </strong>
                            <br>
                            <?php if ($g['codeCouleur']) { ?>
                            <small class="text-muted"><span
                                    style="display:inline-block;width:10px;height:10px;background:<?php echo esc($g['codeCouleur']); ?>;border-radius:50%;margin-right:5px;"></span>Couleur</small>
                            <?php } ?>
                        </td>
                        <td>
                            <small class="d-block"><i class="bi bi-people"></i>
                                <?php echo esc($g['tranche_age'] ?: '-'); ?></small>
                            <small class="d-block"><i class="bi bi-clock"></i>
                                <?php echo esc($g['horaire_resume'] ?: '-'); ?></small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border"><?php echo esc($g['prix']); ?> €</span>
                        </td>
                        <td><?php echo esc($g['ordre']); ?></td>
                        <td class="text-end">
                            <a href="<?php echo base_url('admin/groupes/'.$g['id'].'/edit'); ?>"
                                class="btn-icon text-primary me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="<?php echo base_url('admin/groupes/'.$g['id'].'/delete'); ?>"
                                class="btn-icon text-danger" onclick="return confirm('Supprimer ce groupe ?');"><i
                                    class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td colspan="6" class="text-center p-4">Aucun groupe enregistré.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>