<?php
// widget template for having multiple buttons
// texts and addresses should have the same size
function buttons_widget($texts, $addresses): void
{
    ?>

    <div class="dashboard-buttons-list">
        <?php
        for ($i = 0; $i < count($texts); $i++) {
            ?>
            <a href="<?= htmlspecialchars($addresses[$i]) ?>" class="dashboard-line">
                <div class="dashboard-action">
                    <?= htmlspecialchars($texts[$i]) ?>
                </div>
            </a>
            <?php
        }
        ?>
    </div>

    <?php
}

?>
