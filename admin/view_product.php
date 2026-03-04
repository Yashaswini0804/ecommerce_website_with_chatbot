
<?php 
$page_title = "View Products";
include "admin_navbar.php"; 
include "admin_header.php";
?>

<?php 
include "dbconnect.php"; 
?>

<div class="admin-content">
    <?php
    if(isset($_GET['status']))
    {
        if($_GET['status'] == 'success')
        {
            echo '<div class="alert alert-success">Deleted successfully!</div>';
        }
        else{
            echo '<div class="alert alert-error">Failed to delete</div>';
        }
    }
    ?>

    <div class="card">
        <div class="card-header">
            <h3>All Products</h3>
        </div>
        <div class="card-body">
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sno</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 1;
                        $get_product_qry = "SELECT product_id, product_name, product_discription, category_id, subcategory_id, selling_price, stock FROM product_tbl WHERE deleted='0'";
                        $get_product_res = $conn->query($get_product_qry);
                        
                        while($row = mysqli_fetch_array($get_product_res))
                        {
                            $id = $row['product_id'];
                            $name = $row['product_name'];
                            $discription = $row['product_discription'];
                            $category = $row['category_id'];
                            $subcategory = $row['subcategory_id'];
                            $sp = $row['selling_price'];
                            $stock = $row['stock'];
                            
                            // Get category name
                            $category_name = "";
                            $category_name_qry = "SELECT category_name FROM category_tbl WHERE deleted='0' AND category_id ='$category'";
                            $category_name_res = $conn->query($category_name_qry);
                            if($category_name_row = mysqli_fetch_array($category_name_res))
                            {
                                $category_name = $category_name_row['category_name'];
                            }
                            
                            // Get subcategory name
                            $subcategory_name = "";
                            $subcategory_name_qry = "SELECT subcategory_name FROM subcategory_tbl WHERE deleted='0' AND subcategory_id ='$subcategory'";
                            $subcategory_name_res = $conn->query($subcategory_name_qry);
                            if($subcategory_name_row = mysqli_fetch_array($subcategory_name_res))
                            {
                                $subcategory_name = $subcategory_name_row['subcategory_name'];
                            }
                        ?>
                        <tr>
                            <td><?php echo $sno; ?></td>
                            <td><?php echo htmlspecialchars($category_name); ?></td>
                            <td><?php echo htmlspecialchars($subcategory_name); ?></td>
                            <td><?php echo htmlspecialchars($name); ?></td>
                            <td><?php echo htmlspecialchars(substr($discription, 0, 50)) . (strlen($discription) > 50 ? '...' : ''); ?></td>
                            <td>Rs. <?php echo htmlspecialchars($sp); ?></td>
                            <td><?php echo htmlspecialchars($stock); ?></td>
                            <td>
                                <a href="update_product.php?product_id=<?php echo $id; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="delete_pro(<?php echo $id; ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php
                            $sno++;
                        }  
                        ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($get_product_res->num_rows == 0): ?>
                <div class="alert alert-info">No products found.</div>
            <?php endif; ?>
            
            <div style="margin-top: 20px;">
                <a href="admin_menu.php" class="btn btn-secondary">Menu Page</a>
            </div>
        </div>
    </div>
</div>

<script>
function delete_pro(pro_id) {
    var con = confirm("Are you sure you want to delete this?");
    if (con) {
        window.location.href = "delete_product.php?product_id=" + pro_id;
    } else {
        alert("Record not deleted");
    }
}
</script>

<?php include "admin_footer.php"; ?>


