<?php include('partials-front/menu.php'); ?>
 


    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            

          <?php
          
          //display all the category the are active
          //sql query

          $sql ="SELECT * FROM tbl_category WHERE active='yes'";

          //execute the query 
          $res = mysqli_query($conn,$sql);

          //count rows
          $count = mysqli_num_rows($res);

          //check whether categories available oe not
          if($count>0)
          {
            //categories available
            while($row=mysqli_fetch_assoc($res))
            {
                //get the value
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
                ?>
                <a href="<?php echo SITEURL;?>category-foods.php?category_id=<?php echo $id; ?>">
                     <div class="box-3 float-container">
                         <img src="images/pizza.jpg" alt="Pizza" class="img-responsive img-curve">

                          <h3 class="float-text text-white">Pizza</h3>
                    </div>
                </a>


                <?php
            
            }
          } 
          else
          {
            //categories not available
            echo"<div calss='error'>categories not available.</div>";
          }
  
          ?>

            

            <div class="clearfix"></div>
        </div>
    </section>
   
    <?php include('partials-front/footer.php'); ?>