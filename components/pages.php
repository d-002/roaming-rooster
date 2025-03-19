<?php

function insertPageCircle($page)
{
    ?>
    <div class="circle page-circle" id="page-circle-<?php echo $page; ?>"></div>
    <?php
}

function insertCircles($number_of_pages, $start)
{
    ?>
    <div class="circles">
        <?php
        for ($i = $start; $i < $number_of_pages + $start; $i++) {
            insertPageCircle($i);
        }
        ?>
    </div>
    <?php
}

function insertNavigationButton($txt, $id)
{
    ?>
    <button id="<?php echo $id; ?>" class="btn btn-primary btn-nav">
        <?php echo $txt; ?>
    </button>
    <?php
}

function insertNavigationMenu($number_of_pages, $start)
{
    insertNavigationButton("&larr;", "nav-pred");
    insertCircles($number_of_pages, $start);
    insertNavigationButton("&rarr;", "nav-next");
}

?>