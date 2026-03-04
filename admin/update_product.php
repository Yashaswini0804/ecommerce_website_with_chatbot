
<?php 
$page_title = "Update Product";
include "admin_header.php"; 
include "admin_navbar.php";
?>

<?php
include "dbconnect.php";

if(isset($_GET['status']))
{
    if($_GET['status']== "success")
    {
        echo '<div class="alert alert-success">Product updated successfully!!!</div>';
    }
    else
    {
        echo '<div class="alert alert-error">Failed to update product</div>';
    }
}

$name = "";
$discription = "";
$category = "";
$subcategory = "";
$sp = "";
$stock = "";
$product_id = "";

if(isset($_GET['product_id']))
{
    $product_id = $_GET['product_id'];
}

$get_product_qry = "SELECT product_name, product_id, product_discription, category_id, subcategory_id, selling_price, stock 
                    FROM product_tbl 
                    WHERE deleted='0' AND product_id='$product_id'";
$get_product_res = $conn->query($get_product_qry);

if($get_product_res->num_rows > 0)
{
    $row = mysqli_fetch_array($get_product_res);
    $name = $row['product_name'];
    $id = $row['product_id'];
    $discription = $row['product_discription'];
    $category = $row['category_id'];
    $subcategory = $row['subcategory_id'];
    $sp = $row['selling_price'];
    $stock = $row['stock'];
}
?>

<div class="admin-content">
    <div class="card">
        <div class="card-header">
            <h3>Update Product</h3>
        </div>
        <div class="card-body">
            <form action="update_product_process.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="category_id">Category</label>
                    _id" id="<select name="categorycategory_id" class="form-control" required onchange="update_subcategory()">
                        <option value="">-- Select Category --</option>
                        <?php
                        $get_category_name_qry = "SELECT category_name, category_id FROM category_tbl WHERE deleted='0'";
                        $get_category_name_res = $conn->query($get_category_name_qry);
                        while($row = mysqli_fetch_array($get_category_name_res))
                        {
                            $cat_id = $row['category_id'];
                            $cat_name = $row['category_name'];
                            echo '<option value="'.$cat_id.'"'.($category === $cat_id ? ' selected' : '').'>'.$cat_name.'</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="subcategory_id">Subcategory</label>
                    <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                        <option value="">-- Select Subcategory --</option>
                        <?php
                        $get_subcategory_name_qry = "SELECT subcategory_name, subcategory_id FROM subcategory_tbl WHERE deleted='0'";
                        $get_subcategory_name_res = $conn->query($get_subcategory_name_qry);
                        while($row = mysqli_fetch_array($get_subcategory_name_res))
                        {
                            $subcat_id = $row['subcategory_id'];
                            $subcat_name = $row['subcategory_name'];
                            echo '<option value="'.$subcat_id.'"'.($subcategory === $subcat_id ? ' selected' : '').'>'.$subcat_name.'</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <input type="hidden" name="product_id" id="product_id" value="<?php echo $id; ?>">
                
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" id="product_name" value="<?php echo htmlspecialchars($name); ?>" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="product_discription">Product Description</label>
                    <textarea name="product_discription" id="product_discription" class="form-control" rows="4" required><?php echo htmlspecialchars($discription); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="selling_price">Selling Price</label>
                    <input type="number" name="selling_price" id="selling_price" value="<?php echo $sp; ?>" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" id="stock" value="<?php echo $stock; ?>" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <a href="view_product.php" class="btn btn-secondary">View Product List</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
function update_subcategory()
{
    var categoryid = document.getElementById("category_id").value;
    var current_subcategory = document.getElementById('subcategory_id').value;
    $.ajax({
        method: "POST",
        url: "ajax_update_subcategory.php",
        data: {categoryid: categoryid, current_subcategory: current_subcategory},
        success: function(result)
        {
            document.getElementById("subcategory_id").innerHTML = result;
        }
    });
}
</script>

<?php include "admin_footer.php"; ?>


