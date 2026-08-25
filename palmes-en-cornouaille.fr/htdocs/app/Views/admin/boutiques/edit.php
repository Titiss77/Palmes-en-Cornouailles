<?php echo $this->extend('admin/Layout/l_global'); ?>

<?php echo $this->section('contenu'); ?>
<?php echo $this->include('admin/retour'); ?>

<div class="site-container">
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo base_url('admin/boutiques'); ?>" class="text-decoration-none me-3 text-dark">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h3 class="title-section mb-0">Modifier : <?php echo esc($item['nom']); ?></h3>
    </div>

    <?php if (session()->getFlashdata('errors')) { ?>
    <div class="alert alert-danger mb-4 p-3">
        <ul class="mb-0 ps-3">
            <?php foreach (session()->getFlashdata('errors') as $error) { ?>
            <li><?php echo esc($error); ?></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>

    <div class="card-item p-4">
        <form action="<?php echo base_url('admin/boutiques/'.$item['id']); ?>" method="post">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="form-group mb-3">
                <label class="fw-bold mb-1">Nom de l'article</label>
                <input type="text" name="nom" class="form-input w-100 p-2" value="<?php echo old('nom', $item['nom']); ?>"
                    required maxlength="50">
            </div>

            <div class="grid-2 gap-4">
                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Prix / Tranche de prix</label>
                    <input type="text" name="tranchePrix" class="form-input w-100 p-2"
                        value="<?php echo old('tranchePrix', $item['tranchePrix']); ?>" required maxlength="50">
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold mb-1">Lien externe</label>
                    <input type="url" name="url" class="form-input w-100 p-2" value="<?php echo old('url', $item['url']); ?>"
                        maxlength="255">
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="fw-bold mb-1">Description</label>
                <textarea name="description" rows="5" class="form-input w-100 p-2"
                    required><?php echo old('description', $item['description']); ?></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn-home">
                    <i class="bi bi-check-lg"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
<?php echo $this->endSection(); ?>