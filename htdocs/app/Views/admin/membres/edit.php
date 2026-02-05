<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('admin/membres') ?>" class="text-decoration-none me-3 text-dark"><i
                class="bi bi-arrow-left-circle"></i></a>
        <h3 class="title-section mb-0">Modifier : <?= esc($item['nom']) ?></h3>
    </div>

    <div class="card-item p-4">
        <form action="<?= base_url('admin/membres/' . $item['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="form-group mb-4">
                <label class="fw-bold mb-2">Nom & Prénom</label>
                <input type="text" name="nom" class="form-input w-100 p-2" value="<?= old('nom', $item['nom']) ?>"
                    required>
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-2">Fonctions</label>
                <div class="d-flex flex-wrap gap-3 p-3 border rounded bg-light">
                    <?php foreach ($fonctions as $f): ?>
                    <?php
                    // Vérifie si l'ID de la fonction est dans le tableau des rôles actuels du membre
                    $checked = in_array($f['id'], $currentRoles) ? 'checked' : '';
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="fonctions[]" value="<?= $f['id'] ?>"
                            id="f_<?= $f['id'] ?>" <?= $checked ?>>
                        <label class="form-check-label" for="f_<?= $f['id'] ?>">
                            <?= esc($f['titre']) ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if (!empty($item['image_path'])): ?>
            <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light mb-2 suppr-img">
                <img src="<?= base_url('uploads/' . $item['image_path']) ?>" class="img-membres">
                <a href="<?= base_url('admin/membres/' . $item['id'] . '/deleteImage') ?>"
                    class="text-danger small fw-bold" onclick="return confirm('Supprimer la photo ?');">
                    <i class="bi bi-trash"></i> Supprimer
                </a>
            </div>
            <?php endif; ?>
            <input type="file" name="image" class="form-input w-100 p-2" accept="image/*">

            <div class="text-end mt-4">
                <button type="submit" class="btn-home"><i class="bi bi-check-lg"></i> Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>