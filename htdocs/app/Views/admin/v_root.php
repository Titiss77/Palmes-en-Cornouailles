<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>
<?= $this->include('admin/retour') ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <h3 class="title-section mb-0">Personnalisation des Couleurs (CSS Root)</h3>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success text-center mb-4"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card-item p-4">
        <form action="<?= base_url('admin/root/update') ?>" method="post">
            <?= csrf_field() ?>

            <div class="grid-2 gap-4">
                <?php foreach ($root as $libelle => $value): ?>
                <div class="form-group mb-4 p-3 border rounded bg-light">
                    <label class="fw-bold mb-2 d-block">
                        <i class="bi bi-palette"></i> <?= esc(ucfirst(str_replace('-', ' ', $libelle))) ?>
                    </label>

                    <div class="d-flex align-items-center gap-3">
                        <input type="color" class="form-control form-control-color" value="<?= esc($value, 'attr') ?>"
                            style="width: 60px; height: 45px; cursor: pointer;"
                            oninput="document.getElementById('input-<?= esc($libelle) ?>').value = this.value">

                        <input type="text" name="root[<?= esc($libelle) ?>]" id="input-<?= esc($libelle) ?>"
                            class="form-input flex-grow-1 p-2" value="<?= esc($value) ?>" placeholder="#000000">
                    </div>
                    <small class="text-muted">Variable CSS : <code>--<?= esc($libelle) ?></code></small>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn-home btn-lg">
                    <i class="bi bi-check-circle"></i> Enregistrer les couleurs
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>