<?php

function insert_widget($title, $callback): void
{
    ?>
    <div class="widget">
        <div class="widget-header">
            <h2><?= $title ?></h2>
        </div>
        <div class="widget-content">
            <?php
            $callback();
            ?>
        </div>
    </div>
    <?php
}
