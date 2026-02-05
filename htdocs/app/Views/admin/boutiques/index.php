<?= $this->extend('admin/Layout/l_global') ?>

<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="title-section mb-0">Gestion de la Boutique</h3>
        <a href="<?= base_url('admin/boutiques/new') ?>" class="btn-home">
            <i class="bi bi-plus-circle"></i> Ajouter un article
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
                        <th width="40%">Article</th>
                        <th width="30%">Description</th>
                        <th width="15%">Prix</th>
                        <th width="15%" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($boutiques)): ?>
                    <?php foreach ($boutiques as $item): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-bag-fill text-secondary"></i>
                                </div>
                                <div>
                                    <strong class="d-block text-dark"><?= esc($item['nom']) ?></strong>
                                    <?php if (!empty($item['url'])): ?>
                                    <a href="<?= esc($item['url']) ?>" target="_blank"
                                        class="small text-primary text-decoration-none">
                                        <i class="bi bi-link-45deg"></i> Voir le lien
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>

                        <td>
                            <small class="text-muted">
                                <?= strip_tags($item['description']) ?>
                            </small>
                        </td>

                        <td>
                            <span class="badge bg-secondary"><?= esc($item['tranchePrix']) ?></span>
                        </td>

                        <td class="text-end">
                            <a href="<?= base_url('admin/boutiques/' . $item['id'] . '/edit') ?>"
                                class="btn-icon text-primary me-1" title="Modifier">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="<?= base_url('admin/boutiques/' . $item['id'] . '/delete') ?>"
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
                            <i class="bi bi-shop fs-1 d-block mb-3"></i>
                            La boutique est vide pour le moment.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
    <p>* Les liens du Decathlon Pro et du listing de materiel sont administrables
        <a href="<?= base_url('admin/general') ?>" style="color:red; font-weight:bold; font-size:14px;">ici</a>.
    </p>
</div>
<?= $this->endSection() ?>