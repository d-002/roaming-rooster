<?php

function insert_header($title, $id): void
{
    ?>
    <header>
        <div class="logo-decoration-container">
            <?php
            component("logo");
            ?>
        </div>
        <div class="title">
            <a href="/pages/homepage">
                <h1><?= $title ?></h1>
            </a>
        </div>
        <aside class="line">
            <?php
            $db = getSecureDB();
            insert_notifications($db, $id);
            insert_profile_button($id);
            ?>
        </aside>
    </header>
    <?php
}

?>
