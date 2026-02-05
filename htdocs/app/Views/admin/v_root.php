<?= $this->extend('admin/Layout/l_global') ?>
<?= $this->section('contenu') ?>

<?php foreach ($root as $item): ?>
<?php if (is_array($item)): ?>
<p><?= esc($item['libelle']) ?></p>
<div style="width:100px; height:100px; background-color:<?= esc($item['value'], 'attr') ?>;"></div>
<?php endif; ?>
<?php endforeach; ?>

<?= $this->endSection() ?>