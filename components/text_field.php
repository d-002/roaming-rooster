<?php function insertTextField($placeholder, $id)
{ ?>
    <label for="<?php echo $id; ?>">
        <?php echo $placeholder; ?>
        <input class="text-field" type="text" name="<?php echo $id; ?>" placeholder="<?php echo $placeholder; ?>">
    </label>
<?php } ?>
