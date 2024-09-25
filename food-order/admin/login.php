
<?php include('../config/constants.php');?>



<html>
     <head>
           <title> login - food order system</title>
           <link rel="stylesheet" href="../css/admin.css">
     </head>

     <body>
        
     <div class="login">
       <h1 class="text-center">Login</h1>
       <br></br> 

       <?php 
         
          if(isset($_SESSION['login']))
          {
             echo $_SESSION['login'];
             unset($_SESSION['login']);
          }
          if(isset($_SESSION['no-login-message']))
          {
             echo $_SESSION['no-login-message'];
             unset($_SESSION['no-login-message']);
          }
    
       ?>
       <br></br>

       <!-- login form starts here-->

       <form  action="" method="POST" class="text-center">
        Username:<br>
        <input type="text" name="username"placeholder="enter username"></br><br>
        Password:<br>
        <input type="text" name="password"placeholder="enter password"></br><br>
        
        <input type="submit" name="submit" value="login" class="btn-primary">
        <br>
       </br>

       </form>
       <!-- login form ends here-->


     <p  class="text-center">created by- <a href="www.akhilmakwana.com"> akhil makwana</a></p>
     </div>
    
    </body>

</html>

<?php

  //check whether the submit button is clicked or not

  if(isset($_POST['submit']))
  {
    //process for login
    //1.get the data from login form
      $username = $_POST['username'];
      $password = md5($_POST['password']);

      //sql to check whether the user with username and password exists or not
      $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

      //excute the query
      $res = mysqli_query($conn, $sql);
      
      //count row to check whether the user exists  or not
      $count = mysqli_num_rows($res);

      if($count==1)
      {
          //user available and login successfully
          $_SESSION['login'] = "<div class='success'>login successfully.</div>";
          $_SESSION['user'] = $username; //to check whether the user is logged in or not and logout will unset it
          //redirect to home page/dashboard
          header('location:'.SITEURL.'admin/');
      }
      else
      {
          //user not available and login failed
           $_SESSION['login'] ="<div class='error text-center'>username and password did not match.</div>";
           //redirect to home page/dashboard
           header('location:'.SITEURL.'admin/login.php');
      }
  }

?>