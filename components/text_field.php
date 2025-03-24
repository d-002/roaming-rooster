<?php function insertTextField($placeholder, $id, $required, $type="text")
{ ?>
    <label for="<?php echo $id; ?>" class="text-field-label">
        <?php echo $placeholder; ?> <br>
        <input class="text-field" type="<?php echo $type; ?>" name="<?php echo $id; ?>" placeholder="<?php echo $placeholder; ?>" id="<?php echo $id; ?>" <?php if ($required) echo "required"; ?>>
    </label>
<?php } ?>
