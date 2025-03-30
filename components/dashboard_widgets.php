<?php
root_include("/utils/dbutils.php");

function insert_all_widgets($db, $id) {
    $isBusiness = isBusiness($db, $id);
    $isCustomer = isCustomer($db, $id);
    $isAdmin = isAdmin($db, $id);
}
?>
