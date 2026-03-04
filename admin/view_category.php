
<?php 
$page_title = "View Categories";
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
            <h3>All Categories</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sno</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Priority</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sno = 1;
                    $get_category_qry = "SELECT category_id, category_name, category_discription, category_priority, category_img FROM category_tbl WHERE deleted='0'";
                    $get_category_res = $conn->query($get_category_qry);
                    
                    while($row = mysqli_fetch_array($get_category_res))
                    {
                        $id = $row['category_id'];
                        $name = $row['category_name'];
                        $discription = $row['category_discription'];
                        $priority = $row['category_priority'];
                        $image = $row['category_img'];
                    ?>
                    <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo htmlspecialchars($name); ?></td>
                        <td><?php echo htmlspecialchars($discription); ?></td>
                        <td><?php echo htmlspecialchars($priority); ?></td>
                        <td>
                            <?php if($image): ?>
                                <img src="../images/<?php echo htmlspecialchars($image); ?>" width="80" alt="Category Image" style="object-fit: cover; border-radius: 5px;">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="update_category.php?category_id=<?php echo $id; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="delete_cat(<?php echo $id; ?>)">Delete</button>
                        </td>
                    </tr>
                    <?php
                        $sno++;
                    }  
                    ?>
                </tbody>
            </table>
            
            <?php if($get_category_res->num_rows == 0): ?>
                <div class="alert alert-info">No categories found.</div>
            <?php endif; ?>
            
            <div style="margin-top: 20px;">
                <a href="admin_menu.php" class="btn btn-secondary">Menu Page</a>
            </div>
        </div>
    </div>
</div>

<script>
function delete_cat(cat_id) {
    var con = confirm("Are you sure you want to delete this?");
    if (con) {
        window.location.href = "delete_category.php?category_id=" + cat_id;
    } else {
        alert("Record not deleted");
    }
}
</script>

<?php include "admin_footer.php"; ?>


