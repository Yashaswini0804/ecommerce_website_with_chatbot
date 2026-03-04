<?php
include "dbconnect.php";
$name="";
$discription="";
$priority="";
$image="";
$category="";
if(isset($_POST['subcategory_name']))
    {
        $name=$_POST['subcategory_name'];
    }
if(isset($_POST['subcategory_discription']))
    {
        $discription=$_POST['subcategory_discription'];
    }
if(isset($_POST['subcategory_priority']))
    {
        $priority=$_POST['subcategory_priority'];
    }
if(isset($_POST['category_id']))
    {
        $category=$_POST['category_id'];
    }
if(!empty($_FILES['subcategory_img']['name']))
    {
        $folder="../images/";
        $image=$_FILES['subcategory_img']['name'];
        $temp_img=$_FILES['subcategory_img']['tmp_name'];

        move_uploaded_file($temp_img ,$folder.$image);
    }
if(empty($name) || empty($discription) || empty($priority) || empty($category)) {
    header("location:add_subcategory.php?status=fail");
    exit;
}
$add_subcategory_qry="INSERT INTO subcategory_tbl(subcategory_name,subcategory_discription,subcategory_priority,subcategory_img,category_id,deleted)
values ('$name','$discription','$priority','$image','$category','0')";
$add_subcategory_res=$conn->query($add_subcategory_qry);
if($add_subcategory_res)
    {
        header("location:add_subcategory.php?status=success");
    }
else
    {
        
        header("location:add_subcategory.php?status=fail");
    }
?>