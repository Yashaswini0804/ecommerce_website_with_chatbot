
<?php 
$page_title = "Add Product Image";
include "admin_header.php"; 
include "admin_navbar.php";
?>

<?php 
include "dbconnect.php";
?>

<div class="admin-content">
    <?php
    if(isset($_GET['status']))
    {
        if($_GET['status']== "success")
        {
            echo '<div class="alert alert-success">Image added successfully!!!</div>';
        }
        else
        {
            echo '<div class="alert alert-error">Failed to add image</div>';
        }
    }
    ?>

    <div class="card">
        <div class="card-header">
            <h3>Add Product Image</h3>
        </div>
        <div class="card-body">
            <form action="add_product_image_process.php" method="post" enctype="multipart/form-data">
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
                                $product_name = $row['product_name'];
                                $product_id = $row['product_id'];
                                echo '<option value="'.$product_id.'">'.$product_name.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="product_img">Upload Image</label>
                    <input type="file" name="product_img" id="product_img" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="product_img_name">Product Image Name</label>
                    <input type="text" name="product_img_name" id="product_img_name" class="form-control" readonly required>
                </div>
                
                <div class="form-group">
                    <label for="product_img_priority">Image Priority</label>
                    <input type="number" name="product_img_priority" id="product_img_priority" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
                    <a href="admin_menu.php" class="btn btn-secondary">Menu Page</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('product_img').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const fileName = file.name;
        document.getElementById('product_img_name').value = fileName;
    }
});
</script>

<?php include "admin_footer.php"; ?>


