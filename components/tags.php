<?php

function insertTag($name)
{
    ?>
    <p class="tag"><?= $name ?></p>
    <?php
}

function insertTags($tags)
{
    ?>
    <div class="tags">
        <?php
        foreach ($tags as $tag) {
            insertTag($tag);
        }
        ?>
    </div>
    <?php
}

?>