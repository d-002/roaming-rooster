<?php
root_include("/utils/dbutils.php");
component("search");
component("dashboard/widget");

function insert_all_widgets($db, $id): void
{
    ?>
    <div class="widget-list">
        <?php
        $is_business = isBusiness($db, $id);
        $is_customer = isCustomer($db, $id);
        $is_admin = isAdmin($db, $id);

        widget_notifications($db, $id);

        if ($is_business) {
            widget_business_options($db, $id);
        }

        if ($is_customer) {
            insert_search_widget(page: false);
            widget_customer_options($db, $id);
        }

        if ($is_admin) {
            widget_admin_options($db, $id);
        }
        ?>
    </div>
    <?php
}

// widget template for having multiple buttons
// texts and addresses should have the same size
function template_widget_buttons($texts, $addresses)
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

/* WIDGETS */

function widget_business_options($db, $id)
{
    insert_widget("My Seller actions", function () {
        template_widget_buttons(
            array(
                "Create a service"
            ),
            array(
                "/pages/404"
            )
        );
    });
}

function widget_customer_options($db, $id)
{
    insert_widget("My Customer actions", function () {
        template_widget_buttons(
            array(
                "Browse services"
            ),
            array(
                "/pages/404"
            )
        );
    });
}

function widget_admin_options($db, $id)
{
    insert_widget("My Admin actions", function () {
        template_widget_buttons(
            array(
                "query database",
                "format database (SENSITIVE)",
                "fill database (SENSITIVE)"
            ),
            array(
                "/pages/admin/query-database",
                "/pages/admin/format-database",
                "/pages/admin/fill-database"
            )
        );
    });
}

function display_notification($notification): void
{
    ?>
    <div class="notification">
        <p class="notification-text"><?= $notification["text"] ?></p>
        <p class="notification-date"><?= $notification["date"] ?></p>
    </div>
    <?php
}

function widget_notifications($db, $id): void
{
    $st = $db->prepare("SELECT * FROM notifications WHERE user_id = (:id) ORDER BY notifications.time DESC");

    if ($st->execute(["id" => $id])) {
        insert_widget("Latest notifications", function () use ($st) {
            ?>
            <div>
                <?php
                while ($elt = $st->fetch()) {
                    display_notification([
                        "text" => htmlspecialchars($elt["text"]),
                        "date" => "Received: " . date("D, Y-m-d h:i:sa", $elt["time"]),
                    ]);
                }
                ?>
            </div>
            <?php
        });
    }
}

?>
