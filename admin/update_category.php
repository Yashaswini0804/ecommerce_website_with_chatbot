
<?php 
$page_title = "Update Category";
include "admin_header.php"; 
include "admin_navbar.php";
?>

<?php
include "dbconnect.php";

if(isset($_GET['status']))
{
    if($_GET['status']== "success")
    {
        echo '<div class="alert alert-success">Category updated successfully!!!</div>';
    }
    else
    {
        echo '<div class="alert alert-error">Failed to update category</div>';
    }
}

$category_id = "";
$name = "";
$description = "";
$priority = "";
$image = "";

if(isset($_GET['category_id']))
{
    $category_id = $_GET['category_id'];
}

$get_category_qry = "SELECT category_name, category_id, category_discription, category_priority, category_img 
                     FROM category_tbl 
                     WHERE category_id='$category_id' AND deleted='0'";
$get_category_res = $conn->query($get_category_qry);

if($get_category_res->num_rows > 0)
{
    $row = mysqli_fetch_array($get_category_res);
    $name = $row['category_name'];
    $id = $row['category_id'];
    $description = $row['category_discription'];
    $priority = $row['category_priority'];
    $image = $row['category_img'];
}
?>

<div class="admin-content">
    <div class="card">
        <div class="card-header">
            <h3>Update Category</h3>
        </div>
        <div class="card-body">
            <form action="update_category_process.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="category_id" id="category_id" value="<?php echo $id; ?>">
                
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" name="category_name" id="category_name" value="<?php echo htmlspecialchars($name); ?>" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="category_discription">Category Description</label>
                    <textarea name="category_discription" id="category_discription" class="form-control" rows="3" required><?php echo htmlspecialchars($description); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="category_priority">Priority</label>
                    <input type="number" name="category_priority" id="category_priority" value="<?php echo $priority; ?>" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="category_img">Category Image</label>
                    <input type="file" name="category_img" id="category_img" class="form-control">
                </div>
                
                <?php if($image): ?>
                <div class="form-group">
                    <label>Current Image:</label>
                    <div>
                        <img src="images/<?php echo htmlspecialchars($image); ?>" width="100" alt="Category Image" style="border-radius: 5px;">
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <a href="view_category.php" class="btn btn-secondary">View Category List</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "admin_footer.php"; ?>


