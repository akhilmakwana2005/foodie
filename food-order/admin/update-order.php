<?php
include('partials/menu.php'); 
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br>

        <?php
        // Check whether id is set or not
        if (isset($_GET['id'])) {
            // Get the order detail 
            $id = $_GET['id'];

            // SQL query to get the order
            $sql = "SELECT * FROM tbl_order WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $order = $result->fetch_assoc();
            } else {
                // Set a session message and redirect to manage order page if no order found
                $_SESSION['error'] = "Order not found.";
                header('location: ' . SITEURL . 'admin/manage-order.php');
                exit();
            }
        } else {
            // Set a session message and redirect to manage order page
            $_SESSION['error'] = "Invalid order ID.";
            header('location: ' . SITEURL . 'admin/manage-order.php');
            exit();
        }

        // Handle form submission
        if (isset($_POST['submit'])) {
            $qty = $_POST['qty'];
            $status = $_POST['status'];
            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];

            // Update order in the database
            $update_sql = "UPDATE tbl_order SET qty = ?, status = ?, customer_name = ?, customer_contact = ?, customer_email = ?, customer_address = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("isssssi", $qty, $status, $customer_name, $customer_contact, $customer_email, $customer_address, $id);

            if ($update_stmt->execute()) {
                // Set a session message for successful update
                $_SESSION['success'] = "Order updated successfully.";
                header('location: ' . SITEURL . 'admin/manage-order.php');
                exit();
            } else {
                // Set a session message for error
                $_SESSION['error'] = "Failed to update order.";
                header('location: ' . SITEURL . 'admin/manage-order.php');
            }
        }
        ?>

        <!-- Display session messages -->
        <?php 
        if (isset($_SESSION['error'])) {
            echo "<div class='error'>{$_SESSION['error']}</div>";
            unset($_SESSION['error']); // Clear the message after displaying
        }
        if (isset($_SESSION['success'])) {
            echo "<div class='success'>{$_SESSION['success']}</div>";
            unset($_SESSION['success']); // Clear the message after displaying
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Food Name</td>
                    <td><?php echo $order['food']; ?></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><b>$<?php echo $order['price']; ?></b></td>
                </tr>
                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $order['qty']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status" required>
                            <option value="ordered" <?php if ($order['status'] == 'ordered') echo 'selected'; ?>>Ordered</option>
                            <option value="on delivery" <?php if ($order['status'] == 'on delivery') echo 'selected'; ?>>On Delivery</option>
                            <option value="delivered" <?php if ($order['status'] == 'delivered') echo 'selected'; ?>>Delivered</option>
                            <option value="cancelled" <?php if ($order['status'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $order['customer_name']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Customer Contact:</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $order['customer_contact']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Customer Email:</td>
                    <td>
                        <input type="email" name="customer_email" value="<?php echo $order['customer_email']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Customer Address:</td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5" required><?php echo $order['customer_address']; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>

<?php include('partials/footer.php'); ?>
