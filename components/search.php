<?php

function insertSearchImage()
{
    ?>
    <div class="symbol">
        <img src="/assets/images/symbols/search.svg" alt="Search" class="symbol">
    </div>
    <?php
}

function insertSearchWidget($placeholder = "Search a service", $page = true, $content = null): void
{
    ?>
    <label class="text-field-label">
        <?php echo $placeholder; ?> <br>
        <form class="text-field line-form" action="/pages/search-results">
            <div id="search-symbol" class="circle-inside-input page-horizontal minimize <?php if ($content !== null) {
                echo "reduce-horizontal";
            } ?>">
                <?php
                if ($page) {
                    insertSearchImage();
                } else {
                    ?>
                    <a href="/pages/search-results">
                        <?php
                        insertSearchImage();
                        ?>
                    </a>
                    <?php
                }
                ?>
            </div>
            <input id="s" name="s" class="circle-inside-input" type="search" placeholder="<?php echo $placeholder; ?>" <?php if ($content !== null) {
                echo "value='$content'";
            } ?>>
            <div id="cancel-search" class="circle-inside-input page-horizontal minimize <?php if ($content === null) {
                echo "reduce-horizontal";
            } ?>">
                <img src="/assets/images/symbols/cancel.svg" alt="cancel search" class="symbol">
            </div>
        </form>
    </label>
    <?php
}

?>
