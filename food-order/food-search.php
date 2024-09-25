<?php include('partials-front/menu.php'); ?>

<!-- Navbar Section Ends Here -->

<!-- Food Search Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <?php
        // Get the search keyword and sanitize it
        $search = isset($_POST['search']) ? htmlspecialchars(trim($_POST['search'])) : '';
        ?>
        <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>
    </div>
</section>
<!-- Food Search Section Ends Here -->

<!-- Food Menu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // Check if search keyword is not empty
        if ($search) {
            // Prepare the SQL query to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM tbl_food WHERE title LIKE ? OR description LIKE ?");
            $searchParam = "%$search%";
            $stmt->bind_param("ss", $searchParam, $searchParam);
            $stmt->execute();
            $res = $stmt->get_result();

            // Count rows
            $count = $res->num_rows;

            // Check whether food is available or not
            if ($count > 0) {
                // Food available
                while ($row = $res->fetch_assoc()) {
                    // Get the details
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $description = $row['description'];
                    ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            // Check whether image name is available
                            if ($image_name == "") {
                                // Image not available
                                echo "<div class='error'>Image not available.</div>";
                            } else {
                                // Image available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="img-responsive img-curve">
                                <?php
                            }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo htmlspecialchars($title); ?></h4>
                            <p class="food-price">$<?php echo htmlspecialchars($price); ?></p>
                            <p class="food-detail">
                                <?php echo htmlspecialchars($description); ?>
                            </p>
                            <br>

                            <a href="order.php?id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Food not available
                echo "<div class='error'>Food not found.</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='error'>Please enter a search term.</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Food Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
