<?php
root_include("/utils/dbutils.php");
component("search");

component("dashboard/widget-base");
component("dashboard/base");
component("dashboard/buttons");
component("dashboard/business");
component("dashboard/customer");
component("dashboard/admin");
component("dashboard/notifications");

function insert_all_widgets($db, $id): void
{
    $is_business = isBusiness($db, $id);
    $is_customer = isCustomer($db, $id);
    $is_admin = isAdmin($db, $id);

    // search bar at the start, in a separate div, if needed
    if ($is_customer) { ?>
        <div id="search-container">
        <?php insert_search_widget(page: false); ?>
        </div>
    <?php } ?>

    <div class="widget-list">
        <?php
        widget_notifications($db, $id);
        base_widget($db, $id);

        if ($is_business) {
            business_widgets($db, $id);
        }

        if ($is_customer) {
            customer_widgets($db, $id);
        }

        if ($is_admin) {
            admin_widgets($db, $id);
        }
    ?>
    </div>
    <?php
}
?>
