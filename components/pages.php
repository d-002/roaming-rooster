<?php

function insertPageCircle($page)
{
    ?>
    <div class="circle page-circle btn" circle="<?= $page ?>"></div>
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
    <div id="<?= $id ?>" class="btn btn-primary btn-nav">
        <p><?= $txt ?></p>
    </div>
    <?php
}

function insertNavigationMenu($number_of_pages, $start)
{
    ?>
    <div class="pages-nav">
        <?php
        insertNavigationButton("Back", "nav-pred");
        insertCircles($number_of_pages, $start);
        insertNavigationButton("Next", "nav-next");
        ?>
    </div>
    <?php
}

?>