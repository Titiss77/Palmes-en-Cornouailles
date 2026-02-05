<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <h3 class="title-section mb-0">Configuration Générale</h3>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success text-center mb-4"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger mb-4 p-3">
        <ul class="mb-0 ps-3">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="card-item p-4">
        <form action="<?= base_url('admin/general/update') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <h5 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-building"></i> Identité & Contact</h5>

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Nom du club *</label>
                    <input type="text" name="nomClub" class="form-input w-100 p-2"
                        value="<?= old('nomClub', $item['nomClub']) ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Email du club</label>
                    <input type="email" name="mailClub" class="form-input w-100 p-2"
                        value="<?= old('mailClub', $item['mailClub']) ?>">
                </div>
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Adresse postale du club</label>
                    <input type="text" name="adresse" class="form-input w-100 p-2"
                        value="<?= old('adresse', $item['adresse']) ?>">
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="fw-bold mb-1">Description générale</label>
                <textarea name="description" rows="3"
                    class="form-input w-100 p-2"><?= old('description', $item['description']) ?></textarea>
            </div>

            <div class="form-group mb-3">
                <label class="fw-bold mb-1">Philosophie du club</label>
                <textarea name="philosophie" rows="3"
                    class="form-input w-100 p-2"><?= old('philosophie', $item['philosophie']) ?></textarea>
            </div>

            <h5 class="text-primary border-bottom pb-2 mb-3 mt-4"><i class="bi bi-graph-up"></i> Chiffres Clés</h5>
            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Nombre total de nageurs</label>
                    <input type="number" name="nombreNageurs" class="form-input w-100 p-2"
                        value="<?= old('nombreNageurs', $item['nombreNageurs']) ?>">
                </div>
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Dont Hommes (calcul auto pour Femmes)</label>
                    <input type="number" name="nombreHommes" class="form-input w-100 p-2"
                        value="<?= old('nombreHommes', $item['nombreHommes']) ?>">
                </div>
            </div>

            <h5 class="text-primary border-bottom pb-2 mb-3 mt-4"><i class="bi bi-link-45deg"></i> Liens & Réseaux</h5>

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1"><i class="bi bi-facebook text-primary"></i> Facebook</label>
                    <input type="url" name="lienFacebook" class="form-input w-100 p-2"
                        value="<?= old('lienFacebook', $item['lienFacebook']) ?>">
                </div>
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1"><i class="bi bi-instagram text-danger"></i> Instagram</label>
                    <input type="url" name="lienInstagram" class="form-input w-100 p-2"
                        value="<?= old('lienInstagram', $item['lienInstagram']) ?>">
                </div>
            </div>

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Lien FFESSM</label>
                    <input type="url" name="lienffessm" class="form-input w-100 p-2"
                        value="<?= old('lienffessm', $item['lienffessm']) ?>">
                </div>
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Lien Google Drive</label>
                    <input type="url" name="lienDrive" class="form-input w-100 p-2"
                        value="<?= old('lienDrive', $item['lienDrive']) ?>">
                </div>
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Lien Decathlon Pro</label>
                    <input type="url" name="lienDecatPro" class="form-input w-100 p-2"
                        value="<?= old('lienDecatPro', $item['lienDecatPro']) ?>">
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="fw-bold mb-1">Projet Sportif (Titre ou Lien)</label>
                <input type="text" name="projetSportif" class="form-input w-100 p-2"
                    value="<?= old('projetSportif', $item['projetSportif']) ?>">
            </div>

            <h5 class="text-primary border-bottom pb-2 mb-3 mt-4"><i class="bi bi-images"></i> Gestion des Images</h5>

            <div class="mb-4 border p-3 rounded bg-light images-gen">
                <div class="d-flex align-items-center mb-2">
                    <img src="<?= base_url('favicon.ico?v=' . time()) ?>"
                        class="me-3 bg-white border rounded p-1 img-favicon">

                    <input type="file" name="image" class="form-input flex-grow-1 p-2" accept="image/*">
                </div>
                <small class="text-muted"><i class="bi bi-info-circle"></i> Le fichier sera renommé
                    <code>favicon.ico</code> et remplacera l'actuel à la racine.</small>
            </div>

            <div class="mb-4 border p-3 rounded bg-light images-gen">
                <div class="d-flex align-items-center mb-2">
                    <?php if (!empty($item['groupe_path'])): ?>
                    <img src="<?= base_url('uploads/' . $item['groupe_path']) ?>"
                        class="me-3 bg-white border rounded p-1 img-groupe">
                    <?php else: ?>
                    <span class="text-muted me-3">Aucune photo</span>
                    <?php endif; ?>
                    <input type="file" name="image_groupe" class="form-input flex-grow-1 p-2" accept="image/*">
                </div>
            </div>

            <div class="mb-4 border p-3 rounded bg-light images-gen">
                <label class="fw-bold mb-2 d-block">Logo FFESSM</label>
                <div class="d-flex align-items-center mb-2">
                    <?php if (!empty($item['ffessm_path'])): ?>
                    <img src="<?= base_url('uploads/' . $item['ffessm_path']) ?>"
                        class="me-3 bg-white border rounded p-1 img-fede">
                    <?php else: ?>
                    <span class="text-muted me-3">Aucun logo</span>
                    <?php endif; ?>
                    <input type="file" name="image_ffessm" class="form-input flex-grow-1 p-2" accept="image/*">
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn-home btn-lg"><i class="bi bi-check-circle"></i> Enregistrer les
                    modifications</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>