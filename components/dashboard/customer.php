<?php
function customer_widgets($db, $id)
{
    insert_widget("My Customer actions", function () {
        buttons_widget(
            array(
                "Browse services"
            ),
            array(
                "/pages/services"
            )
        );
    });
}
?>
