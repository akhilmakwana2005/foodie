<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
        if (isset($_SESSION['upload'])) 
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of food">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="text" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            // Create PHP code to display categories from the database
                            $sql = "SELECT * FROM tbl_category WHERE active = 'yes'";
                            $res = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<option value='{$row['id']}'>{$row['title']}</option>";
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
                        <input type="radio" name="featured" value="yes"> Yes
                        <input type="radio" name="featured" value="no"> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="yes"> Yes
                        <input type="radio" name="active" value="no"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
// Check whether the submit button is clicked
if (isset($_POST['submit'])) {
    // Add the food to the database

    // 1. Get data from the form
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Check whether radio buttons for featured and active are checked or not
    $featured = isset($_POST['featured']) ? $_POST['featured'] : "no";
    $active = isset($_POST['active']) ? $_POST['active'] : "no";

    // 2. Upload the image if selected
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
                header('location:' . SITEURL . 'admin/add-food.php');
                die();
            }
        }
    } else {
        $image_name = ""; // Setting default value as blank
    }

    // 3. Insert into the database
    $sql2 = "INSERT INTO tbl_food SET
        title = '$title',
        description = '$description',
        price = '$price',
        image_name = '$image_name',
        category_id = $category,
        featured = '$featured',
        active = '$active'";

    $res2 = mysqli_query($conn, $sql2);

    if ($res2) {
        $_SESSION['add'] = "<div class='success'>Food added successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
}
?>

<?php include('partials/footer.php'); ?>
