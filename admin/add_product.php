
<?php 
$page_title = "Add Product";
include "admin_header.php"; 
include "admin_navbar.php";
?>

<?php
include "dbconnect.php";
?>

<div class="admin-content">
    <?php
    if(isset($_GET["status"]))
    {
        if($_GET["status"]== "success")
        {
            echo '<div class="alert alert-success">Product added successfully!!!</div>';
        }
        else
        {
            echo '<div class="alert alert-error">Failed to add product</div>';
        }
    }
    ?>

    <div class="card">
        <div class="card-header">
            <h3>Add New Product</h3>
        </div>
        <div class="card-body">
            <form action="add_product_process.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control" required onchange="get_sub_category()">
                        <option value="">-- Select Category --</option>
                        <?php
                        $get_category_name_qry = "SELECT category_name, category_id FROM category_tbl WHERE deleted='0'";
                        $get_category_name_res = $conn->query($get_category_name_qry);
                        while($row = mysqli_fetch_array($get_category_name_res))
                        {
                            $id = $row['category_id'];
                            $name = $row['category_name'];
                            echo '<option value="'.$id.'">'.$name.'</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="subcategory_id">Subcategory</label>
                    <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                        <option value="">-- Select Subcategory --</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="product_discription">Product Description</label>
                    <textarea name="product_discription" id="product_discription" class="form-control" rows="4" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="selling_price">Selling Price</label>
                    <input type="number" name="selling_price" id="selling_price" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <a href="admin_menu.php" class="btn btn-secondary">Menu Page</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function get_sub_category()
{
    var categoryid = document.getElementById("category_id").value;
    $.ajax({
        method: "POST",
        url: "ajax_get_sub_category.php",
        data: {categoryid: categoryid},
        success: function(result)
        {
            document.getElementById("subcategory_id").innerHTML = result;
        }
    });
}
</script>

<?php include "admin_footer.php"; ?>


