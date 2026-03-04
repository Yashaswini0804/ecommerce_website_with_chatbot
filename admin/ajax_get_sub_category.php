<?php
include "dbconnect.php";
$categoryid="";
if(isset($_POST['categoryid']))
    {
        $categoryid=$_POST['categoryid'];
    }
$subcategory_id="";
$subcategory_name="";
echo "<option value=''>--select--</option>";
$get_subcategory_qry="SELECT subcategory_name,subcategory_id from subcategory_tbl where deleted='0' and category_id ='$categoryid'";
$get_subcategory_res=$conn->query($get_subcategory_qry);
while($row=mysqli_fetch_array($get_subcategory_res))
    {
        $subcategory_id=$row['subcategory_id'];
        $subcategory_name=$row['subcategory_name'];
        ?>
        <option value="<?php echo $subcategory_id; ?>"><?php echo $subcategory_name;?></option>
        <?php
    }
?>