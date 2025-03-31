<?php
root_include("/utils/dbutils.php");

function insert_all_widgets($db, $id) {
    $isBusiness = isBusiness($db, $id);
    $isCustomer = isCustomer($db, $id);
    $isAdmin = isAdmin($db, $id);

    if ($isBusiness) {
        widget_businessOptions($db, $id);
    }

    if ($isCustomer) {
        widget_customerOptions($db, $id);
    }

    if ($isAdmin) {
        widget_adminOptions($db, $id);
    }

    widget_notifications($db, $id);
}

// widget template for listing debug db results (UNSAFE)
function templace_widget_dblist($title, $contents) {
    echo "<table border=1><th>" . $title . "</th>";
    foreach($contents as $elt)
        echo "<tr><td>" . strval($elt) . "</td></tr>";
    echo "</table>";
}

// widget template for having multiple buttons
// texts and addresses should have the same size
function template_widget_buttons($title, $texts, $addresses) {
    echo "<div>";
    echo "<p><strong>" . htmlspecialchars($title) . "</strong></p>";
    for ($i = 0; $i < count($texts); $i++) {
        echo "<a href='";
        echo htmlspecialchars($addresses[$i]);
        echo "'>";
        echo htmlspecialchars($texts[$i]);
        echo "</a>";
    }
    echo "</div>";
}

/* WIDGETS */

function widget_businessOptions($db, $id) {
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

function widget_customerOptions($db, $id) {
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

function widget_adminOptions($db, $id) {
    template_widget_buttons(
        "My Admin actions",
        array(
            "test"
        ),
        array(
            "/pages/404"
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

    templace_widget_dblist("Latest notifications", $arr);
}
?>
