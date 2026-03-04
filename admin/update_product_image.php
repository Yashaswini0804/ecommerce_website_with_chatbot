
<?php 
$page_title = "Update Product Image";
include "admin_header.php"; 
include "admin_navbar.php";
?>

<?php 
include "dbconnect.php";

if(isset($_GET['status']))
{
    if($_GET['status']== "success")
    {
        echo '<div class="alert alert-success">Image updated successfully!!!</div>';
    }
    else
    {
        echo '<div class="alert alert-error">Failed to update image</div>';
    }
}

$id = "";
$name = "";
$priority = "";
$product_id = "";
$image = "";

if(isset($_GET['product_img_id']))
{
    $id = mysqli_real_escape_string($conn, $_GET['product_img_id']);
}

$get_product_image_qry = "SELECT product_img_id, product_img_name, product_id, product_img_priority, product_img 
                          FROM product_img_tbl 
                          WHERE product_img_id='$id' AND deleted='0'";
$get_product_image_res = $conn->query($get_product_image_qry);

if($get_product_image_res->num_rows > 0)
{
    $row = mysqli_fetch_array($get_product_image_res);
    $name = $row['product_img_name'];
    $priority = $row['product_img_priority'];
    $product_id = $row['product_id'];
    $image = $row['product_img'];
}
?>

<div class="admin-content">
    <div class="card">
        <div class="card-header">
            <h3>Update Product Image</h3>
        </div>
        <div class="card-body">
            <form action="update_product_image_process.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="product_img_id" value="<?php echo $id; ?>">
                
                <div class="form-group">
                    <label for="product_id">Select Product</label>
                    <select name="product_id" id="product_id" class="form-control" required>
                        <option value="">-- Select Product --</option>
                        <?php
                        $get_product_qry = "SELECT product_name, product_id FROM product_tbl WHERE deleted='0'";
                        $get_product_res = $conn->query($get_product_qry);
                        if($get_product_res->num_rows > 0)
                        {
                            while($row = mysqli_fetch_array($get_product_res))
                            {
                                $prod_id = $row['product_id'];
                                $prod_name = $row['product_name'];
                                echo '<option value="'.$prod_id.'"'.($prod_id == $product_id ? ' selected' : '').'>'.$prod_name.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="product_img">Upload New Image</label>
                    <input type="file" name="product_img" id="product_img" class="form-control">
                </div>
                
                <?php if($image): ?>
                <div class="form-group">
                    <label>Current Image:</label>
                    <div>
                        <img src="../images/<?php echo htmlspecialchars($image); ?>" width="100" alt="Product Image" style="border-radius: 5px;">
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="product_img_name">Product Image Name</label>
                    <input type="text" name="product_img_name" id="product_img_name" value="<?php echo htmlspecialchars($name); ?>" class="form-control" readonly>
                </div>
                
                <div class="form-group">
                    <label for="product_img_priority">Image Priority</label>
                    <input type="number" name="product_img_priority" id="product_img_priority" value="<?php echo $priority; ?>" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" name="update" id="update" class="btn btn-primary">Update</button>
                    <a href="view_product_image.php" class="btn btn-secondary">View Image List</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById("product_img").addEventListener('change', function(event){
    const file = event.target.files[0];
    if(file)
    {
        const filename = file.name;
        document.getElementById('product_img_name').value = filename;
    }
});
</script>

<?php include "admin_footer.php"; ?>


