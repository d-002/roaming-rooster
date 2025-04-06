<?php
function business_widgets($db, $id)
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
?>
