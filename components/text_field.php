<?php function insertTextField($placeholder, $id)
{ ?>
    <label for="<?php echo $id; ?>" class="text-field-label">
        <?php echo $placeholder; ?> <br>
        <input class="text-field" type="text" name="<?php echo $id; ?>" placeholder="<?php echo $placeholder; ?>" id="<?php echo $id; ?>">
    </label>
<?php } ?>
