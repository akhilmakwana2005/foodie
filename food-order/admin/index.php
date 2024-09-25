<?php include('partials/menu.php'); ?>

<!--main content section starts-->
    <div class="main-content">
         <div class="wrapper">
            <h1> Dashboard </h1>
            <br></br>
            <?php 
         
                if(isset($_SESSION['login']))
                 {
                     echo $_SESSION['login'];
                     unset($_SESSION['login']);
                 } 
     
            ?>
            <br></br>

             <div class="col-4 text-center"> 
                <h1>7</h1>
                </br>
                 categories
             </div>
             <div class="col-4 text-center"> 
                <h1>5</h1>
                </br>
                 Foods
             </div>
             <div class="col-4 text-center"> 
                <h1>8</h1>
                </br>
                 Total Orders
             </div>
             <div class="col-4 text-center"> 
                <h1>$100</h1>
                <br/>
                 Revenuy collection
             </div>
             <div class="clearfix"></div>
           </div>
    </div>
    <!--main content section ends-->

   <?php include('partials/footer.php')?>