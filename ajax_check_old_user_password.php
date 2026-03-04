<?php
//session_start();
include "user_session_page.php";
include "admin/dbconnect.php";


$oldpassword = "";
if (isset($_POST['oldpassword'])) {
    $oldpassword = $_POST['oldpassword'];
}

$check_qry = "SELECT user_password FROM user_tbl WHERE user_id = '$session_user_id' AND user_password = '$oldpassword' AND deleted = '0'";
$check_res = $conn->query($check_qry);

if ($check_res && $check_res->num_rows > 0) {
    echo "valid";
} else {
    echo "invalid";
}
?>
