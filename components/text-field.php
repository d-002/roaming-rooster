<?php function insertTextField($placeholder, $id, $required, $type="text")
{ ?>
    <label for="<?= $id ?>" class="text-field-label">
        <?= $placeholder ?> <br>
        <input class="text-field" type="<?= $type ?>" name="<?= $id ?>" placeholder="<?= $placeholder ?>" id="<?= $id ?>" <?php if ($required) echo "required"; ?>>
    </label>
<?php } ?>
