<?php function insertFancyCheckbox($name, $title)
{ ?>
    <label for="<?= $name ?>" class="fancy-checkbox">
        <input type="checkbox" name="<?= $name ?>" id="<?= $name ?>">
        <?= $title ?>
    </label>
<?php } ?>
