<?php
include "dbconnect.php";
$username="";
$admin_id="";
if(isset($_POST['user_name']))
{
    $username=$_POST['user_name'];
}
if(isset($_POST['admin_id']))
{
    $admin_id=$_POST['admin_id'];
}
$get_name="SELECT user_name from admin_tbl where user_name='$username' and admin_id != '$admin_id' and deleted='0'";
$get_res=$conn->query($get_name);
if($get_res->num_rows >0)
{
    echo "duplicate_name";
}
else{
    echo"unique_name";
}
?>
