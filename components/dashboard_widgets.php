<?php
root_include("/utils/dbutils.php");
component("search");
component("dashboard/widget");

function insert_all_widgets($db, $id)
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

// widget template for listing debug db results (UNSAFE, DEVELOPMENT ONLY)
function template_widget_dblist($title, $contents)
{
    ?>

    <table border=1>
        <th><?php echo $title ?></th>
        <?php foreach ($contents as $elt) { ?>
            <tr>
                <td><?php echo strval($elt) ?></td>
            </tr>
        <?php } ?>
    </table>

    <?php
}

// widget template for having multiple buttons
// texts and addresses should have the same size
function template_widget_buttons($texts, $addresses)
{
    ?>

    <div>
        <?php for ($i = 0; $i < count($texts); $i++) { ?>
            <a href="<?php echo htmlspecialchars($addresses[$i]) ?>" style="display: block">
                <?php echo htmlspecialchars($texts[$i]) ?>
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

function widget_notifications($db, $id)
{
    $st = $db->prepare("SELECT * FROM notifications WHERE user_id = (:id)");

    $arr = [];
    if ($st->execute(["id" => $id]))
        while ($elt = $st->fetch()) {
            $text = $elt["text"];
            $date = date("l jS \of F Y \at h:i:s A", $elt["time"]);
            $arr[] = '"' . $text . '" received at ' . $date;
        }

    template_widget_dblist("Latest notifications", $arr);
}

?>
