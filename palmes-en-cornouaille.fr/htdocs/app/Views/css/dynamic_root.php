<style>
:root {
    <?php if (isset($root) && is_array($root)) { ?> <?php foreach ($root as $name => $value) { ?> --<?php echo esc($name); ?>: <?php echo $value; ?>;
    <?php }
    ?><?php }
    ?>
}
</style>