<?php echo $this->extend('admin/Layout/l_global'); ?>
<?php echo $this->section('contenu'); ?>
<?php echo $this->include('admin/retour'); ?>

<div class="site-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="title-section mb-0">Gestion des Disciplines</h3>
        <a href="<?php echo base_url('admin/disciplines/new'); ?>" class="btn-home">
            <i class="bi bi-plus-circle"></i> Ajouter une discipline
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
                        <th width="15%">Image</th>
                        <th width="30%">Nom</th>
                        <th width="40%">Description</th>
                        <th width="15%" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($disciplines)) { ?>
                    <?php foreach ($disciplines as $d) { ?>
                    <tr>
                        <td>
                            <?php if (!empty($d['image_path'])) { ?>
                            <img src="<?php echo base_url('uploads/'.$d['image_path']); ?>" class="rounded shadow-sm"
                                style="width: 60px; height: 60px; object-fit: cover;">
                            <?php } else { ?>
                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-trophy text-muted"></i>
                            </div>
                            <?php } ?>
                        </td>
                        <td class="fw-bold fs-5 text-primary"><?php echo esc($d['nom']); ?></td>
                        <td>
                            <small class="text-muted"><?php echo esc(mb_strimwidth($d['description'], 0, 80, '...')); ?></small>
                        </td>
                        <td class="text-end">
                            <a href="<?php echo base_url('admin/disciplines/'.$d['id'].'/edit'); ?>"
                                class="btn-icon text-primary me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="<?php echo base_url('admin/disciplines/'.$d['id'].'/delete'); ?>"
                                class="btn-icon text-danger"
                                onclick="return confirm('Supprimer cette discipline ?');"><i
                                    class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td colspan="4" class="text-center p-4">Aucune discipline enregistrée.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>