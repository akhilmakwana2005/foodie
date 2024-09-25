<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>
        
        <!-- Button to add category -->
        <a href="add-category.php" class="btn-primary">Add Category</a>
        <br><br>
        
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>

            <?php
            // Query to get all categories from the database
            $sql = "SELECT * FROM tbl_category";
            $res = mysqli_query($conn, $sql);

            // Count rows
            $count = mysqli_num_rows($res);

            // Create serial number variable and assign value as 1
            $sn = 1;

            // Check whether we have data in the database or not
            if ($count > 0) {
                // We have data in the database
                // Get the data and display
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = htmlspecialchars($row['title']);
                    $image_name = htmlspecialchars($row['image_name']);
                    $featured = htmlspecialchars($row['featured']);
                    $active = htmlspecialchars($row['active']);
                    ?>

                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>

                        <td>
                            <?php 
                            // Check whether image name is available or not
                            if ($image_name != "") {
                                // Display the image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px" >
                                <?php
                            } else {
                                // Display the message
                                echo "<div class='error'>Image not added.</div>";
                            }
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                            <a href="<?php echo SITEURL;?>admin/delete-category.php?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Category</a>
         
                        </td>
                    </tr>

                    <?php
                }
            } else {
                // No data in the database
                ?>
                <tr>
                    <td colspan="6"><div class="error">No category added.</div></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
