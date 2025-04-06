<?php
// widget template for having multiple buttons
// texts and addresses should have the same size
function buttons_widget($texts, $addresses)
{
    ?>

    <div>
        <?php for ($i = 0; $i < count($texts); $i++) { ?>
            <a href="<?= htmlspecialchars($addresses[$i]) ?>" style="display: block">
                <?= htmlspecialchars($texts[$i]) ?>
            </a>
        <?php } ?>
    </div>

    <?php
}
?>
