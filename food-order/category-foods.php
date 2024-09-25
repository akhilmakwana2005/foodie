<?php include('partials-front/menu.php'); ?>

<?php
// Check whether id is passed or not
if (isset($_GET['category_id'])) {
    // Category id is set and get the id
    $category_id = $_GET['category_id'];

    // Prepare SQL query to get the category title based on category id
    $sql = "SELECT title FROM tbl_category WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $category_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Get the value from database
    if ($row = mysqli_fetch_assoc($result)) {
        // Get the title
        $category_title = htmlspecialchars($row['title']); // Prevent XSS
    } else {
        // Category not found, redirect to home page
        header('location:' . SITEURL);
        exit;
    }
} else {
    // Category not passed, redirect to home page
    header('location:' . SITEURL);
    exit;
}
?>

<!-- Food Search Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>
    </div>
</section>
<!-- Food Search Section Ends Here -->

<!-- Food Menu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>
        <?php
        // Create SQL query to get foods based on selected category
        $sql2 = "SELECT * FROM tbl_food WHERE category_id=?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, 'i', $category_id);
        mysqli_stmt_execute($stmt2);
        $res2 = mysqli_stmt_get_result($stmt2);

        // Check whether food is available or not 
        if (mysqli_num_rows($res2) > 0) {
            // Food is available
            while ($row2 = mysqli_fetch_assoc($res2)) 
            {
                $id = $row2['id'];
                $title = htmlspecialchars($row2['title']); // Prevent XSS
                $price = $row2['price'];
                $description = htmlspecialchars($row2['description']); // Prevent XSS
                $image_name = $row2['image_name'];
                ?>

                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        if ($image_name == "") {
                            // Image not available
                            echo "<div class='error'>Image not available</div>";
                        } else {
                            // Image available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                    </div>
                    <div class="food-menu-desc">
                        <h4><?php echo $title; ?></h4>
                        <p class="food-price">$<?php echo $price; ?></p>
                        <p class="food-detail"><?php echo $description; ?></p>
                        <br>
                        <a href="#" class="btn btn-primary" aria-label="Order <?php echo $title; ?>">Order Now</a>
                    </div>
                </div>

                <?php
            }
        } else {
            // Food not available
            echo "<div class='error'>Food not available.</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Food Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
