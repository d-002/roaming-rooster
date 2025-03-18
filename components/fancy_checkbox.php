<?php function insertFancyCheckbox($name, $title)
{ ?>
    <label for="<?php echo $name; ?>" class="fancy-checkbox">
        <input type="checkbox" name="<?php echo $name; ?>" id="<?php echo $name; ?>">
        <?php echo $title; ?>
    </label>
<?php } ?>
