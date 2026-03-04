
<?php 
$page_title = "Update Subcategory";
include "admin_header.php"; 
include "admin_navbar.php";
?>

<?php
include "dbconnect.php";

if(isset($_GET['status']))
{
    if($_GET['status']== "success")
    {
        echo '<div class="alert alert-success">Subcategory updated successfully!!!</div>';
    }
    else
    {
        echo '<div class="alert alert-error">Failed to update subcategory</div>';
    }
}

$name = "";
$discription = "";
$priority = "";
$image = "";
$category = "";
$subcategory_id = "";

if(isset($_GET['subcategory_id']))
{
    $subcategory_id = $_GET['subcategory_id'];
}

$get_subcategory_qry = "SELECT subcategory_name, subcategory_id, subcategory_discription, subcategory_priority, subcategory_img, category_id 
                        FROM subcategory_tbl 
                        WHERE subcategory_id='$subcategory_id' AND deleted='0'";
$get_subcategory_res = $conn->query($get_subcategory_qry);

if($get_subcategory_res->num_rows > 0)
{
    $row = mysqli_fetch_array($get_subcategory_res);
    $name = $row['subcategory_name'];
    $id = $row['subcategory_id'];
    $discription = $row['subcategory_discription'];
    $priority = $row['subcategory_priority'];
    $image = $row['subcategory_img'];
    $category = $row['category_id'];
}
?>

<div class="admin-content">
    <div class="card">
        <div class="card-header">
            <h3>Update Subcategory</h3>
        </div>
        <div class="card-body">
            <form action="update_subcategory_process.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control" required>
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
                
                <input type="hidden" name="subcategory_id" id="subcategory_id" value="<?php echo $id; ?>">
                
                <div class="form-group">
                    <label for="subcategory_name">Subcategory Name</label>
                    <input type="text" name="subcategory_name" id="subcategory_name" value="<?php echo htmlspecialchars($name); ?>" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="subcategory_discription">Subcategory Description</label>
                    <textarea name="subcategory_discription" id="subcategory_discription" class="form-control" rows="3" required><?php echo htmlspecialchars($discription); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="subcategory_priority">Priority</label>
                    <input type="number" name="subcategory_priority" id="subcategory_priority" value="<?php echo $priority; ?>" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="subcategory_img">Subcategory Image</label>
                    <input type="file" name="subcategory_img" id="subcategory_img" class="form-control">
                </div>
                
                <?php if($image): ?>
                <div class="form-group">
                    <label>Current Image:</label>
                    <div>
                        <img src="images/<?php echo htmlspecialchars($image); ?>" width="100" alt="Subcategory Image" style="border-radius: 5px;">
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <a href="view_subcategory.php" class="btn btn-secondary">View Subcategory List</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "admin_footer.php"; ?>


