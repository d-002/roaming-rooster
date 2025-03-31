<?php
root_include("/utils/dbutils.php");

function insert_all_widgets($db, $id) {
    $isBusiness = isBusiness($db, $id);
    $isCustomer = isCustomer($db, $id);
    $isAdmin = isAdmin($db, $id);

    if ($isBusiness) {
        widget_business_options($db, $id);
    }

    if ($isCustomer) {
        widget_customer_options($db, $id);
    }

    if ($isAdmin) {
        widget_admin_options($db, $id);
    }

    widget_notifications($db, $id);
}

// widget template for listing debug db results (UNSAFE, DEVELOPMENT ONLY)
function template_widget_dblist($title, $contents) {
?>

<table border=1><th><?php echo $title ?></th>
    <?php foreach($contents as $elt) {?>
        <tr><td><?php echo strval($elt) ?></td></tr>
    <?php } ?>
</table>

<?php
}

// widget template for having multiple buttons
// texts and addresses should have the same size
function template_widget_buttons($title, $texts, $addresses) {
?>

<div>
    <p><strong><?php echo htmlspecialchars($title) ?></strong></p>

    <?php for ($i = 0; $i < count($texts); $i++) { ?>
        <a href="<?php echo htmlspecialchars($addresses[$i]) ?>" style="display: block">
            <?php echo htmlspecialchars($texts[$i]) ?>
        </a>
    <?php } ?>
</div>

<?php
}

/* WIDGETS */

function widget_business_options($db, $id) {
    template_widget_buttons(
        "My Seller actions",
        array(
            "Create a service"
        ),
        array(
            "/pages/404"
        )
    );
}

function widget_customer_options($db, $id) {
    template_widget_buttons(
        "My Customer actions",
        array(
            "Browse services"
        ),
        array(
            "/pages/404"
        )
    );
}

function widget_admin_options($db, $id) {
    template_widget_buttons(
        "My Admin actions",
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
}

function widget_notifications($db, $id) {
    $st = $db->prepare("SELECT * FROM notifications WHERE user_id = (:id)");

    $arr = [];
    if ($st->execute(["id" => $id]))
        while($elt = $st->fetch()) {
            $text = $elt["text"];
            $date = date("l jS \of F Y \at h:i:s A", $elt["time"]);
            array_push($arr, '"' . $text . '" received at ' . $date);
        }

    template_widget_dblist("Latest notifications", $arr);
}
?>
