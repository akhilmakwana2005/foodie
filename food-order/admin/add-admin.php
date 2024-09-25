<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1> Add admin</h1>
        <br></br>

        <?php
    
        if(isset($_SESSION['add'])) //checking whether the session is set of not
        {
            echo $_SESSION['add']; //display the session message if set
            unset( $_SESSION['add']); //remove session message 
        }
        
        
        
        ?>

         <form action="" method="POST">

         <table class="tbl-30">

            <tr>
                   <td>full name</td>
                   <td>
                     <input type="text" name="full_name" placeholder="enter your name">
                   </td>
                    </tr>
             <tr>
                <td> user name</td> 
                <td>
                   <input type="text"name="username" placeholder="enter your user name">
                </td>               
            </tr>

            <tr>
                <td>Password</td> 
                <td>
                    <input type="password" name="password" placeholder="enter your password">
                </td>   
            </tr>

            <tr>
                   <td colspan="">
                   <input type="submit" name="submit" value="Add admin" class="btn-secondary">
                   </td>
            </tr>

          </table>

         </form>

    </div>


</div>


<?php include('partials/footer.php');?>


<?php

//process the value from and save it in database

//check whther the summit button is clicked or not

if(isset($_POST['submit']))
{
    //button clicked
    //echo"button clicked";

    //get the data from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);//password encryption md5

    //sql query to save the data into database
    $sql ="INSERT INTO tbl_admin SET
     full_name ='$full_name',
     username = '$username',
     password ='$password'
    
     ";
     // executing query and saving data into database
   $res= mysqli_query($conn,$sql)or die(mysqli_error());

   // check whether the (query is executed) data is inserted or not and display appropriate message
   if($res==TRUE)
   {
        //data insered
        //echo" data inserted";
        //create a session variable to display message
        $_SESSION['add'] = "admin added successfully";
        //redirect page manage admin
        header("location:".SITEURL.'admin/manage-admin.php');
   }
   else
   {
       //data not inserted
      // echo"data not inserted";
      $_SESSION['add'] = "failed to add admin";
        //redirect page to add admin
        header("location:".SITEURL.'admin/add-admin.php');

   }



}





?>