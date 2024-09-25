<?php
// Include constants file for database connection settings
include('../config/constants.php');

// Check whether the id and image_name values are set or not
if (isset($_GET['id']) && isset($_GET['image_name'])) {
    // Get the values from the URL
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Validate ID (ensure it's an integer)
    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
        $_SESSION['delete'] = "<div class='error'>Invalid ID.</div>";
        header('location:' . SITEURL . 'admin/manage-category.php');
        exit();
    }

    // Prepare SQL statement to delete the category
    $stmt = $conn->prepare("DELETE FROM tbl_category WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        // Check if the image exists and delete it
        if ($image_name != "") {
            $path = "../images/category/" . $image_name;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // Set success message and redirect
        $_SESSION['delete'] = "<div class='success'>Category deleted successfully.</div>";
    } else {
        // Set error message if the deletion failed
        $_SESSION['delete'] = "<div class='error'>Failed to delete category.</div>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to manage category page
    header('location:' . SITEURL . 'admin/manage-category.php');
} else {
    // If ID or image_name is not set, set error message and redirect
    $_SESSION['delete'] = "<div class='error'>Unauthorized access.</div>";
    header('location:' . SITEURL . 'admin/manage-category.php');
}

?>
