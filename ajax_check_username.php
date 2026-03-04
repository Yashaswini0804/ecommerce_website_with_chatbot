<?php
include "admin/dbconnect.php";
$username="";
if(isset($_POST['username']))
{
    $username=$_POST['username'];
}
$get_user_qry="SELECT user_name from user_tbl where user_name ='$username' AND deleted='0'";
$get_user_res=$conn->query($get_user_qry)
if($get_user_res ->num_rows > 0)
{
    echo "duplicatename";
}
else{
    echo "uniquename";
}
?>