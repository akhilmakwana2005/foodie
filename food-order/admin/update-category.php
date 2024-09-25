<?php
include('partials/menu.php');
//include('../config/constants.php'); // Ensure this includes database connection

// Check if the ID is provided in the query string
if (isset($_GET['id'])) {
    // Get the ID from the query string
    $id = $_GET['id'];

    // Validate ID (ensure it's an integer)
    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
        header('location:' . SITEURL . 'admin/manage-category.php');
        exit();
    }

    // Fetch the current category data
    $sql = "SELECT * FROM tbl_category WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();

    if (!$category) {
        header('location:' . SITEURL . 'admin/manage-category.php');
        exit();
    }

    $current_image = $category['image_name'];
    $title = htmlspecialchars($category['title']);
    $featured = htmlspecialchars($category['featured']);
    $active = htmlspecialchars($category['active']);
} else {
    header('location:' . SITEURL . 'admin/manage-category.php');
    exit();
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];
    $id = $_POST['id'];

    // Validate form data
    if (empty($title) || !isset($featured) || !isset($active)) {
        $_SESSION['update'] = "<div class='error'>All fields must be filled.</div>";
        header('location:' . SITEURL . 'admin/update-category.php?id=' . $id);
        exit();
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $new_image_name = "category_" . $id . "." . $image_ext;
        $image_path = "../images/category/" . $new_image_name;

        // Move uploaded file
        if (move_uploaded_file($image_tmp, $image_path)) {
            // Delete old image if exists
            if ($current_image && file_exists("../images/category/" . $current_image)) {
                unlink("../images/category/" . $current_image);
            }
            $image_to_update = $new_image_name;
        } else {
            $_SESSION['update'] = "<div class='error'>Failed to upload new image.</div>";
            header('location:' . SITEURL . 'admin/update-category.php?id=' . $id);
            exit();
        }
    } else {
        // Use the old image if no new image was uploaded
        $image_to_update = $current_image;
    }

    // Update category in the database
    $sql = "UPDATE tbl_category SET title = ?, image_name = ?, featured = ?, active = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $image_to_update, $featured, $active, $id);

    if ($stmt->execute()) {
        $_SESSION['update'] = "<div class='success'>Category updated successfully.</div>";
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to update category.</div>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to manage category page
    header('location:' . SITEURL . 'admin/manage-category.php');
    exit();
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image) {
                            echo "<img src='" . SITEURL . "images/category/" . $current_image . "' width='100px'>";
                        } else {
                            echo "No image found.";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="yes" <?php if ($featured == "yes") echo "checked"; ?>> Yes
                        <input type="radio" name="featured" value="no" <?php if ($featured == "no") echo "checked"; ?>> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="yes" <?php if ($active == "yes") echo "checked"; ?>> Yes
                        <input type="radio" name="active" value="no" <?php if ($active == "no") echo "checked"; ?>> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>
