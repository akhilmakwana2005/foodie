<?php
include('partials/menu.php');

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch food details based on ID
    $sql = "SELECT * FROM tbl_food WHERE id = $id";
    $res = mysqli_query($conn, $sql);

    // Check if food details are available
    if ($res == true) {
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            // Food data is available
            $row = mysqli_fetch_assoc($res);

            // Get food details
            $title = $row['title'];
            $description = $row['description'];
            $price = $row['price'];
            $current_image = $row['image_name'];
            $category = $row['category_id'];
            $featured = $row['featured'];
            $active = $row['active'];
        } else {
            // Food not found
            $_SESSION['no-food-found'] = "<div class='error'>Food not found.</div>";
            header('location:' . SITEURL . 'admin/manage-food.php');
            exit();
        }
    } else {
        // Query failed
        $_SESSION['query-failed'] = "<div class='error'>Failed to retrieve food details.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
        exit();
    }
} else {
    // ID not set
    $_SESSION['no-id'] = "<div class='error'>No food ID specified.</div>";
    header('location:' . SITEURL . 'admin/manage-food.php');
    exit();
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of food" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="text" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            // Display the current image
                            echo "<img src='" . SITEURL . "images/food/" . $current_image . "' width='100px'>";
                        } else {
                            // No image available
                            echo "<div class='error'>Image not available</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            // Fetch and display categories
                            $sql2 = "SELECT * FROM tbl_category WHERE active = 'yes'";
                            $res2 = mysqli_query($conn, $sql2);

                            if ($res2 == true) {
                                while ($row2 = mysqli_fetch_assoc($res2)) {
                                    $category_id = $row2['id'];
                                    $category_title = $row2['title'];

                                    echo "<option value='$category_id' " . ($category_id == $category ? 'selected' : '') . ">$category_title</option>";
                                }
                            } else {
                                echo "<option value='0'>No category found</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="yes" <?php echo ($featured == 'yes' ? 'checked' : ''); ?>> Yes
                        <input type="radio" name="featured" value="no" <?php echo ($featured == 'no' ? 'checked' : ''); ?>> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="yes" <?php echo ($active == 'yes' ? 'checked' : ''); ?>> Yes
                        <input type="radio" name="active" value="no" <?php echo ($active == 'no' ? 'checked' : ''); ?>> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
// Handle form submission
if (isset($_POST['submit'])) {
    // Get data from the form
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $featured = isset($_POST['featured']) ? $_POST['featured'] : 'no';
    $active = isset($_POST['active']) ? $_POST['active'] : 'no';

    // Handle file upload
    if (isset($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        if ($image_name != "") {
            $ext = end(explode('.', $image_name));
            $image_name = "food-name-" . rand(0000, 9999) . "." . $ext;

            $src = $_FILES['image']['tmp_name'];
            $dst = "../images/food/" . $image_name;

            $upload = move_uploaded_file($src, $dst);

            if ($upload == false) {
                $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                header('location:' . SITEURL . 'admin/update-food.php?id=' . $id);
                exit();
            }
        } else {
            $image_name = $current_image; // Keep the existing image if no new image is selected
        }
    } else {
        $image_name = $current_image; // Keep the existing image if no new image is selected
    }

    // Update food details in the database
    $sql3 = "UPDATE tbl_food SET
        title = '$title',
        description = '$description',
        price = '$price',
        image_name = '$image_name',
        category_id = $category,
        featured = '$featured',
        active = '$active'
        WHERE id = $id";

    $res3 = mysqli_query($conn, $sql3);

    if ($res3 == true) {
        $_SESSION['update'] = "<div class='success'>Food updated successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to update food.</div>";
        header('location:' . SITEURL . 'admin/update-food.php?id=' . $id);
    }
}
?>

<?php include('partials/footer.php'); ?>
