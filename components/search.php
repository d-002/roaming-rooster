<?php

function insert_search_image()
{
    ?>
    <div class="symbol">
        <img src="/assets/images/symbols/search.svg" alt="Search" class="symbol">
    </div>
    <?php
}

function insert_search_widget($placeholder = "Search a service", $page = true, $content = null): void
{
    ?>
    <div class="text-field-label">
        <label for="s">
            <?= $placeholder ?>
        </label> <br>
        <form class="text-field line-form" action="/pages/search-results">
            <div id="search-symbol" class="circle-inside-input page-horizontal minimize <?php if ($content !== null) {
                echo "reduce-horizontal";
            } ?>">
                <?php
                if ($page) {
                    insert_search_image();
                } else {
                    ?>
                    <a href="/pages/search-results">
                        <?php
                        insert_search_image();
                        ?>
                    </a>
                    <?php
                }
                ?>
            </div>
            <input id="s" name="s" class="circle-inside-input" type="search"
                   placeholder="<?= $placeholder ?>" <?php if ($content !== null) {
                echo "value='$content'";
            } ?>>
            <div id="cancel-search" class="circle-inside-input page-horizontal minimize <?php if ($content === null) {
                echo "reduce-horizontal";
            } ?>">
                <img src="/assets/images/symbols/cancel.svg" alt="cancel search" class="symbol">
            </div>
        </form>
    </div>
    <?php
}

?>
