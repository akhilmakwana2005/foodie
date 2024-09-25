<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>
        <br></br>
        <?php
        if(isset($_SESSION['update']))
              {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
              }
        ?>
    
        <br></br>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
            <?php
            // Get all the orders from the database
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
            // Execute query
            $res = mysqli_query($conn, $sql);
            // Count the rows
            $count = mysqli_num_rows($res);
            $sn = 1; // Create a serial number and set its initial value to 1

            if ($count > 0) {
                // Orders available
                while ($row = mysqli_fetch_assoc($res)) {
                    // Get all the order details
                    $food = htmlspecialchars($row['food']);
                    $price = htmlspecialchars($row['price']);
                    $qty = htmlspecialchars($row['qty']);
                    $total = $price * $qty; // Calculate total
                    $order_date = htmlspecialchars($row['order_date']);
                    $status = htmlspecialchars($row['status']);
                    $customer_name = htmlspecialchars($row['customer_name']);
                    $customer_contact = htmlspecialchars($row['customer_contact']);
                    $customer_email = htmlspecialchars($row['customer_email']);
                    $customer_address = isset($row['address']) ? htmlspecialchars($row['address']) : 'N/A'; // Error handling
                    $id = htmlspecialchars($row['id']); // Get the order ID
                    
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $food; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $order_date; ?></td>
                        <td><?php echo $status; ?></td>
                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_contact; ?></td>
                        <td><?php echo $customer_email; ?></td>
                        <td><?php echo $customer_address; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                // No orders available
                echo "<tr><td colspan='12' class='error'>Orders not available</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
