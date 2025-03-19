<?php function insertTextField($placeholder, $id, $required)
{ ?>
    <label for="<?php echo $id; ?>" class="text-field-label">
        <?php echo $placeholder; ?> <br>
        <input class="text-field" type="text" name="<?php echo $id; ?>" placeholder="<?php echo $placeholder; ?>" id="<?php echo $id; ?>" <?php if ($required) echo "required"; ?>>
    </label>
<?php } ?>
