<?php
//session_start();
include "session_page.php";
include "dbconnect.php";


$oldpassword = "";
if (isset($_POST['oldpassword'])) {
    $oldpassword = $_POST['oldpassword'];
}

$check_qry = "SELECT upassword FROM admin_tbl WHERE admin_id = '$session_admin_id' AND upassword = '$oldpassword' AND deleted = '0'";
$check_res = $conn->query($check_qry);

if ($check_res && $check_res->num_rows > 0) {
    echo "valid";
} else {
    echo "invalid";
}
?>
