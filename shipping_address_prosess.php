<?php
include "admin/dbconnect.php";
include "user_session_page.php";
$name="";
$address="";
$city="";
$pincode="";
$district="";
$phonenumber="";
$user_id="";

if(isset($_POST['name']))
    {
        $name=$_POST['name'];

    }
if(isset($_POST['address']))
    {
        $address=$_POST['address'];
    }
if(isset($_POST['pincode']))
    {
        $pincode=$_POST['pincode'];
    }
if(isset($_POST['city']))
    {
        $city=$_POST['city'];
    }
if(isset($_POST['district']))
    {
        $district=$_POST['district'];
    }
if(isset($_POST['phonenumber']))
    {
        $phonenumber=$_POST['phonenumber'];
    }

$insert_address_qry="INSERT into shipping_address_tbl(name,address,city,pincode,district,phonenumber,user_id)
values('$name','$address','$city','$pincode','$district','$phonenumber','$session_user_id')";
$insert_address_res=$conn->query($insert_address_qry);
if($insert_address_res)
    {
        header("location:add_shipping_address.php?status=success");
    }
else{
    header("location:add_shipping_address.php?status=fail");
}
?>