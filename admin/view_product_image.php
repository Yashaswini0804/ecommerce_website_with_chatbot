
<?php 
$page_title = "View Product Images";
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
            <h3>All Product Images</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sno</th>
                        <th>Product Name</th>
                        <th>Image Name</th>
                        <th>Priority</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sno = 1;
                    $get_product_image_qry = "SELECT product_img_id, product_img_name, product_img_priority, product_img, product_id FROM product_img_tbl WHERE deleted='0'";
                    $get_product_image_res = $conn->query($get_product_image_qry);
                    
                    while($row = mysqli_fetch_array($get_product_image_res))
                    {
                        $id = $row['product_img_id'];
                        $name = $row['product_img_name'];
                        $priority = $row['product_img_priority'];
                        $product = $row['product_id'];
                        $image = $row['product_img'];

                        $product_name = "";
                        $product_name_qry = "SELECT product_name FROM product_tbl WHERE deleted='0' AND product_id ='$product'";
                        $product_name_res = $conn->query($product_name_qry);
                        if($product_name_row = mysqli_fetch_array($product_name_res))
                        {
                            $product_name = $product_name_row['product_name'];
                        }
                    ?>
                    <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo htmlspecialchars($product_name); ?></td>
                        <td><?php echo htmlspecialchars($name); ?></td>
                        <td><?php echo htmlspecialchars($priority); ?></td>
                        <td>
                            <?php if($image): ?>
                                <img src="../images/<?php echo htmlspecialchars($image); ?>" width="80" alt="Product Image" style="object-fit: cover; border-radius: 5px;">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="update_product_image.php?product_img_id=<?php echo $id; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="delete_pro(<?php echo $id; ?>)">Delete</button>
                        </td>
                    </tr>
                    <?php
                        $sno++;
                    }  
                    ?>
                </tbody>
            </table>
            
            <?php if($get_product_image_res->num_rows == 0): ?>
                <div class="alert alert-info">No product images found.</div>
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
        window.location.href = "delete_product_image.php?product_img_id=" + pro_id;
    } else {
        alert("Record not deleted");
    }
}
</script>

<?php include "admin_footer.php"; ?>


