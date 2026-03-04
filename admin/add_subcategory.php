
<?php 
$page_title = "Add Subcategory";
include "admin_navbar.php"; 
include "admin_header.php";
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
            echo '<div class="alert alert-success">Subcategory added successfully!!!</div>';
        }
        else
        {
            echo '<div class="alert alert-error">Failed to add subcategory</div>';
        }
    }
    ?>

    <div class="card">
        <div class="card-header">
            <h3>Add New Subcategory</h3>
        </div>
        <div class="card-body">
            <form action="add_subcategory_process.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control" required>
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
                    <label for="subcategory_name">Subcategory Name</label>
                    <input type="text" name="subcategory_name" id="subcategory_name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="subcategory_discription">Subcategory Description</label>
                    <textarea name="subcategory_discription" id="subcategory_discription" class="form-control" rows="3" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="subcategory_priority">Priority</label>
                    <input type="number" name="subcategory_priority" id="subcategory_priority" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="subcategory_img">Subcategory Image</label>
                    <input type="file" name="subcategory_img" id="subcategory_img" class="form-control" required>
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

<?php include "admin_footer.php"; ?>


