
<?php 
$page_title = "View Subcategories";
include "admin_navbar.php"; 
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
            <h3>All Subcategories</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sno</th>
                        <th>Category Name</th>
                        <th>Subcategory Name</th>
                        <th>Description</th>
                        <th>Priority</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sno = 1;
                    $get_subcategory_qry = "SELECT subcategory_id, subcategory_name, subcategory_discription, subcategory_priority, subcategory_img, category_id FROM subcategory_tbl WHERE deleted='0'";
                    $get_subcategory_res = $conn->query($get_subcategory_qry);
                    
                    while($row = mysqli_fetch_array($get_subcategory_res))
                    {
                        $id = $row['subcategory_id'];
                        $name = $row['subcategory_name'];
                        $discription = $row['subcategory_discription'];
                        $priority = $row['subcategory_priority'];
                        $image = $row['subcategory_img'];
                        $category = $row['category_id'];
                        
                        $category_name = "";
                        $category_name_qry = "SELECT category_name FROM category_tbl WHERE deleted='0' AND category_id ='$category'";
                        $category_name_res = $conn->query($category_name_qry);
                        if($category_name_row = mysqli_fetch_array($category_name_res))
                        {
                            $category_name = $category_name_row['category_name'];
                        }
                    ?>
                    <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo htmlspecialchars($category_name); ?></td>
                        <td><?php echo htmlspecialchars($name); ?></td>
                        <td><?php echo htmlspecialchars($discription); ?></td>
                        <td><?php echo htmlspecialchars($priority); ?></td>
                        <td>
                            <?php if($image): ?>
                                <img src="../images/<?php echo htmlspecialchars($image); ?>" width="80" alt="Subcategory Image" style="object-fit: cover; border-radius: 5px;">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="update_subcategory.php?subcategory_id=<?php echo $id; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="delete_subcat(<?php echo $id; ?>)">Delete</button>
                        </td>
                    </tr>
                    <?php
                        $sno++;
                    }  
                    ?>
                </tbody>
            </table>
            
            <?php if($get_subcategory_res->num_rows == 0): ?>
                <div class="alert alert-info">No subcategories found.</div>
            <?php endif; ?>
            
            <div style="margin-top: 20px;">
                <a href="admin_menu.php" class="btn btn-secondary">Menu Page</a>
            </div>
        </div>
    </div>
</div>

<script>
function delete_subcat(cat_id) {
    var con = confirm("Are you sure you want to delete this?");
    if (con) {
        window.location.href = "delete_subcategory.php?subcategory_id=" + cat_id;
    } else {
        alert("Record not deleted");
    }
}
</script>

<?php include "admin_footer.php"; ?>


