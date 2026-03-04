<?php
include "admin/dbconnect.php";
$username="";
$user_id="";
if(isset($_POST['user_name']))
{
    $username=$_POST['user_name'];
}
if(isset($_POST['user_id']))
{
    $user_id=$_POST['user_id'];
}
$get_name="SELECT user_name ,user_id from user_tbl where user_name='$username' and user_id != '$user_id' and deleted='0'";
$get_res=$conn->query($get_name);
if($get_res->num_rows >0)
{
    echo "duplicate_name";
}
else{
    echo"unique_name";
}
?>
