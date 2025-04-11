<?php
function insert_module($src) {
    ?>
    <script src="/assets/scripts/<?=$src?>.js" type="module"></script>
    <?php
}

function insert_script($src) {
    ?>
    <script src="/assets/scripts/<?=$src?>.js"></script>
    <?php
}
?>
