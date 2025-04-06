<?php
function admin_widgets($db, $id)
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
?>
