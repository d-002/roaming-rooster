<?php

root_include("/utils/time.php");

const BROADCAST_ID = 0;
const SYSTEM_ID = 0;

function insert_notifications(PDO $db, $id)
{
    ?>
    <div class="circle-inside-accent logo">
        <img src="/assets/images/symbols/notification.svg" alt="notifications">
    </div>
    <?php
}

function display_notification($notification): void
{
    ?>
    <div class="notification line" not="<?= $notification["id"] ?>">
        <?php
        if ($notification["user_id"] != BROADCAST_ID) {
            ?>
            <div class="circle-inside-accent">
                <img src="/assets/images/symbols/cancel.svg" alt="remove notification" class="symbol">
            </div>
            <?php
        }
        ?>
        <div class="notification-content">
            <p class="notification-text"><?= $notification["text"] ?></p>
            <p class="notification-date"><?= $notification["date"] ?></p>
        </div>
        <?php
        if ($notification["conversation_id"] != SYSTEM_ID) {
            ?>
            <div class="circle-inside-accent">
                <p class="symbol">&rarr;</p>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

function get_user_notifications(PDO $db, $id): array
{
    $st = $db->prepare("
    SELECT *
    FROM notifications
    -- Support for broadcasts
    WHERE user_id = (:id) OR user_id = 0
    ORDER BY notifications.time DESC
    ");
    return $st->execute(["id" => $id]) ? $st->fetchAll() : [];
}

function read_notification(PDO $db, $user_id, $notification_id): void
{
    $prepared = $db->prepare("DELETE FROM notifications WHERE user_id = :user_id AND id = :id");
    $prepared->execute([
        "user_id" => $user_id,
        "id" => $notification_id
    ]);
}

function send_notification(PDO $db, $content, $user = BROADCAST_ID, $conversation = SYSTEM_ID): void
{
    $prepared = $db->prepare("INSERT INTO notifications (text, time, user_id, conversation_id) VALUES (:txt, :time, :uid, :cid)");
    $prepared->execute([
        "txt" => $content,
        "time" => now(),
        "uid" => $user,
        "cid" => $conversation
    ]);
}

?>