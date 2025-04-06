<?php
function base_widget($db, $id) {
    insert_widget("Basic options", function() {
        buttons_widget(
            array(
                "Log out",
                "Back to homepage",
                "Profile"
            ),
            array(
                "/pages/signout",
                "/pages/homepage",
                "/pages/profile"
            )
        );
    });
}
?>
