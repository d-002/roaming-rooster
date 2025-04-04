<?php

function insert_header($title, $id): void
{
    ?>
    <header>
        <?php
        component("logo");
        ?>
        <div class="title">
            <h1><?= $title ?></h1>
        </div>
        <aside class="line">
            <?php
            $db = getSecureDB();
            insert_notifications($db, 0);
            insert_profile_button(0);
            ?>
        </aside>
    </header>
    <?php
}

?>
