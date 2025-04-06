<?php
function widget_notifications($db, $id): void
{
    $nots = get_user_notifications($db, $id);

    if (count($nots) != 0) {
        insert_widget("Latest notifications", function () use ($nots) {
            ?>
            <div>
                <?php
                foreach ($nots as $not) {
                    $not["safe_text"] = htmlspecialchars($not["text"]);
                    $not["date"] = "Received: " . date("D, Y-m-d h:i:sa", $not["time"]);
                    display_notification($not);
                }
                ?>
            </div>
            <?php
        });
    }
}
?>
