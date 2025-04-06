<?php
root_include("/utils/dbutils.php");
component("search");
component("dashboard/widget-base");
component("dashboard/buttons");

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


/* WIDGETS */

function widget_business_options($db, $id)
{
    insert_widget("My Seller actions", function () {
        buttons_widget(
            array(
                "Create a service"
            ),
            array(
                "/pages/error/404"
            )
        );
    });
}

function widget_customer_options($db, $id)
{
    insert_widget("My Customer actions", function () {
        buttons_widget(
            array(
                "Browse services"
            ),
            array(
                "/pages/error/404"
            )
        );
    });
}

function widget_admin_options($db, $id)
{
    insert_widget("My Admin actions", function () {
        buttons_widget(
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
