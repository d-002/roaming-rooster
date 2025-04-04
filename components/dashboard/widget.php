<?php

function insert_widget($title, $callback): void
{
    ?>
    <div class="widget">
        <div class="widget-header line">
            <div class="circle-inside-accent">
                <img src="/assets/images/down.png" alt="Retract" class="symbol">
            </div>
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
