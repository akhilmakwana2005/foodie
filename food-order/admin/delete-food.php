<?php
include('../config/constants.php');

// Check if the ID is set
if (isset($_GET['id'])) {
    // Get the ID
    $id = $_GET['id'];

    // Fetch the image name from the database
    $sql = "SELECT image_name FROM tbl_food WHERE id = $id";
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            // Food item exists
            $row = mysqli_fetch_assoc($res);
            $image_name = $row['image_name'];

            // Delete the food item from the database
            $sql2 = "DELETE FROM tbl_food WHERE id = $id";
            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == true) {
                // Successfully deleted the food item
                if ($image_name != "") {
                    // Image file exists, delete it
                    $path = "../images/food/" . $image_name;
                    $remove = unlink($path);

                    if ($remove == false) {
                        $_SESSION['remove'] = "<div class='error'>Failed to remove image file.</div>";
                    }
                }

                $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            } else {
                // Failed to delete the food item
                $_SESSION['delete'] = "<div class='error'>Failed to delete food item.</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            }
        } else {
            // Food item not found
            $_SESSION['delete'] = "<div class='error'>Food item not found.</div>";
            header('location:' . SITEURL . 'admin/manage-food.php');
        }
    } else {
        // Query failed
        $_SESSION['delete'] = "<div class='error'>Failed to retrieve food item.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
} else {
    // ID not set
    $_SESSION['delete'] = "<div class='error'>No food ID specified.</div>";
    header('location:' . SITEURL . 'admin/manage-food.php');
}
?>
