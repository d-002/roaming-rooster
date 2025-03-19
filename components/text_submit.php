<?php function insertTextSubmit($name, $remove_on_submit, $reload)
{ ?>
    <input class="text-submit <?php if ($remove_on_submit) echo "remove-on-submit"; ?>"
           value="<?php echo $name; ?>" type='submit'>
<?php } ?>
