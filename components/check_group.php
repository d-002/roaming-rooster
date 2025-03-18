<?php

component("fancy_checkbox");

function insertCheckboxFancyGroup($elements) {
    ?> <div class="at-least-one"> <?php
    foreach ($elements as $element) {
        list($name, $title) = $element;
        insertFancyCheckbox($name, $title);
    }
    ?> </div> <?php
}

?>
