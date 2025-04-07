<?php
component("fancy-checkbox");

function insertCheckboxFancyGroup($elements): void
{
    ?> <div class="at-least-one"> <?php
    foreach ($elements as $element) {
        list($name, $title) = $element;
        insertFancyCheckbox($name, $title);
    }
    ?> </div> <?php
}

?>
