<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <!-- Add category form starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" placeholder="Category title" required>
                    </td>
                </tr>
                <tr>
                    <td>Select File</td>
                    <td>
                        <input type="file" name="image" accept="image/*" required>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="yes"> Yes
                        <input type="radio" name="featured" value="no" checked> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="yes"> Yes
                        <input type="radio" name="active" value="no" checked> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add category form ends -->

        <?php
        // Check whether the submit button is clicked
        if (isset($_POST['submit'])) {
            // Get values from the category form
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "no";
            $active = isset($_POST['active']) ? $_POST['active'] : "no";

            // Handle image upload
            $image_name = "";
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                // Upload the image
                $image_name = $_FILES['image']['name'];
                $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                $image_name = "food_category_" . rand(000, 999) . '.' . $ext;
                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../images/category/" . $image_name;

                // Validate file type
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($ext, $allowed_types)) {
                    $_SESSION['upload'] = "<div class='error'>Invalid file type. Please upload an image file.</div>";
                    header('location:' . SITEURL . 'admin/add-category.php');
                    die();
                }

                // Upload the image
                $upload = move_uploaded_file($source_path, $destination_path);
                if (!$upload) {
                    $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                    header('location:' . SITEURL . 'admin/add-category.php');
                    die();
                }
            }

            // Create SQL query to insert category into the database
            $sql = "INSERT INTO tbl_category SET
                title = '$title',
                image_name = '$image_name', 
                featured = '$featured',
                active = '$active'";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Check whether the query executed and data was added
            if ($res) {
                $_SESSION['add'] = "<div class='success'>Category added successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                $_SESSION['add'] = "<div class='error'>Failed to add category.</div>";
                header('location:' . SITEURL . 'admin/add-category.php');
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
