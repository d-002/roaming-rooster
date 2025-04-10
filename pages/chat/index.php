<?php
require $_SERVER["DOCUMENT_ROOT"] . "/utils/base.php";
root_include("/utils/dbutils.php");
?>

<!DOCTYPE html>
<html lang="en">
<?php
component("header");
insert_head("Home", array("chat"));
?>
<body>
    <div><div id="main">
        <div class="mine"><p>This is my message</p></div>
        <div class="other"><p>This is another's message</p></div>
        <div class="mine"><p>This is my message</p></div>
        <div class="other"><p>This is another's message</p></div>
        <div class="mine"><p>This is my message</p><p>with a newline</p></div>
        <div class="other"><p>This is another's message</p><p>with a newline</p></div>
        <div class="mine"><p>This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message </p></div>
        <div class="other"><p>This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message This is my very long message </p></div>
    </div></div>

    <div id="bottom">
        <form method="POST">
            <input type="text" />
            <input type="submit" value="Send" />
        </form>
        <a id="refresh" href=""></a>
    </div>
</body>
</html>
