<?php include('config/constants.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Foodie website for exploring and ordering delicious meals.">
    <meta name="keywords" content="food, restaurant, pizza, burger, momo">
    <title>Foodie Website</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- Navbar Section Starts Here -->
<section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="#" alt="foodie Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL;?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL;?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL;?>foods.php">Foods</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                    
                </ul>
            </div>
            
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->