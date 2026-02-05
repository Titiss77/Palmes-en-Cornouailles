<style>
:root {
    <?php if (isset($root) && is_array($root)): ?> <?php foreach ($root as $name=> $value): ?> --<?=esc($name) ?>: <?=$value ?>;
    <?php endforeach;
    ?><?php endif;
    ?>
}
</style>