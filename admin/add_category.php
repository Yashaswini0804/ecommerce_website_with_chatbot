
<?php 
$page_title = "Add Category";
include "admin_navbar.php"; 
include "admin_header.php";
?>

<?php
include "session_page.php";
?>

<div class="admin-content">
    <?php
    if(isset($_GET["status"]))
    {
        if($_GET["status"]== "success")
        {
            echo '<div class="alert alert-success">Category added successfully!!!</div>';
        }
        else
        {
            echo '<div class="alert alert-error">Failed to add category</div>';
        }
    }
    ?>

    <div class="card">
        <div class="card-header">
            <h3>Add New Category</h3>
        </div>
        <div class="card-body">
            <form action="add_category_process.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" name="category_name" id="category_name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="category_discription">Category Description</label>
                    <textarea name="category_discription" id="category_discription" class="form-control" rows="3" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="category_priority">Priority</label>
                    <input type="number" name="category_priority" id="category_priority" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="category_img">Category Image</label>
                    <input type="file" name="category_img" id="category_img" class="form-control" required>
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


