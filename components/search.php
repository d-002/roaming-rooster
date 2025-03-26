<?php

function insertSearchImage()
{
    ?>
    <div>

    </div>
    <?php
}

function insertSearchWidget($placeholder = "Search a service", $page = true, $content = null): void
{
    ?>
    <div class="text-field">
        <div class="circle-inside-input page-horizontal <?php if ($content !== null) {
            echo "reduce-horizontal";
        } ?>">
            <?php
            if ($page) {
                insertSearchImage();
            } else {
                ?>
                <a href="/pages/search">
                    <?php
                    insertSearchImage();
                    ?>
                </a>
                <?php
            }
            ?>
        </div>
        <label class="circle-inside-input">
            <?php echo $placeholder; ?>
            <input type="search" placeholder="<?php echo $placeholder; ?>" <?php if ($content !== null) {
                echo "value='$content'";
            } ?>>
        </label>
        <div class="circle-inside-input page-horizontal <?php if ($content === null) {
            echo "reduce-horizontal";
        } ?>">

        </div>
    </div>
    <?php
}

?>
