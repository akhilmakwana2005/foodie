<?php include('partials-front/menu.php'); ?>

<?php
if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];
    $sql = "SELECT * FROM tbl_food WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $food_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    } else {
        header('location:' . SITEURL);
        exit;
    }
} else {
    header('location:' . SITEURL);
    exit;
}
?>

<section class="food-search">
    <div class="container">
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="#" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php
                    if ($image_name == "") {
                        echo "<div class='error'>Image not available.</div>";
                    } else {
                        echo "<img src='" . SITEURL . "images/food/" . htmlspecialchars($image_name) . "' alt='" . htmlspecialchars($title) . "' class='img-responsive img-curve'>";
                    }
                    ?>
                </div>
    
                <div class="food-menu-desc">
                    <h3><?php echo htmlspecialchars($title); ?></h3>
                    <input type="hidden" name="food" value="<?php echo htmlspecialchars($title); ?>">
                    <p class="food-price">$<?php echo htmlspecialchars($price); ?></p>
                    <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">
                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Makwana Akhil" class="input-responsive" required>
                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>
                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. akhilmakwana745@.com" class="input-responsive" required>
                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>
                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $food = $_POST['food'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $price * $qty;
            $order_date = date("Y-m-d H:i:s");
            $status = "ordered";
            $customer_name = $_POST['full-name'];
            $customer_contact = $_POST['contact'];
            $customer_email = $_POST['email'];
            $customer_address = $_POST['address'];

            $sql2 = "INSERT INTO tbl_order (food, price, qty, total, order_date, status, customer_name, customer_contact, customer_email, customer_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt2, "sdisssssss", $food, $price, $qty, $total, $order_date, $status, $customer_name, $customer_contact, $customer_email, $customer_address);
            $res2 = mysqli_stmt_execute($stmt2);

            if ($res2) {
                $_SESSION['order'] = "<div class='success text-center'>Food ordered successfully.</div>";
            } else {
                $_SESSION['order'] = "<div class='error text-center'>Failed to order food.</div>";
            }
            header('location:' . SITEURL);
            exit;
        }
        ?>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>
