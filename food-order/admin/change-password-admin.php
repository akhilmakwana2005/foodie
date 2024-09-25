<?php include('partials/menu.php');
$get_id = $_GET['id'];


?>

<div class="main-content">
    <div class="wrapper">
        <h1> Change Password</h1>
        <br><br>

         <form action="" method="POST">

         <table class="tbl-30">

            <tr>
                   <td>Current Password</td>
                   <td>
                     <input type="text" name="current_password" placeholder="Current Password">
                    
                   </td>
                    </tr>
             <tr>
                <td>New Password</td> 
                <td>
                   <input type="password"name="new_password" placeholder=" New password">
                </td>               
            </tr>
 
            <tr>
                <td>Comfirm Password</td> 
                <td>
                    <input type="password" name="confirm_password" placeholder="comfirm password">
                </td>   
            </tr>

            <tr>
                   <td colspan="2">
                   <input type="hidden" name="id" value="<?php echo $get_id; ?>">
                   <input type="submit" name="submit" value="change password" class="btn-secondary">
                   </td>
            </tr>

          </table>

         </form>

    </div>


</div>

<?php

// ckeck whether the submit button is clicked  on not
if(isset($_POST['submit']))
{
    //1.get the data from form
    $id=$_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    //2. check whether user with current id current password exists or not
    $sql ="SELECT* FROM tbl_admin WHERE id=$id AND password='$current_password'";

    //execute the query
    $res = mysqli_query($conn,$sql);

    if($res==true)
    {
        //check whether data is availableor not
        $count= mysqli_num_rows($res);

        if($count==1)
        {
            //user exists and password can be changed
            //echo "user found";
            //check whether the new password and confirma match or not
            if($new_password==$confirm_password)
            {
                //update password
                $sql2 ="UPDATE tbl_admin SET
                password='$new_password' 
                WHERE id =$id
                ";

                //execute the query
                $res2 =mysqli_query($conn,$sql2);

                //check whether the query executed or not
                if($res==true)
                {
                    //display success message
                    //redirect to manage admin page with error message 
                     $_SESSION['change-pwd'] ="<div class ='success'>password changed successfully.</div>"; 
                     header('location:'.SITEURL.'admin/manage-admin.php');
                }
                else
                {
                    //display error message
                    //display success message
                    //redirect to manage admin page with error message 
                    $_SESSION['change-pwd'] ="<div class ='error'>failed to change password.</div>"; 
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //redirect to manage admin page with error message 
                $_SESSION['pwd-not-match'] ="<div class ='error'>password did not match.</div>"; 
                header('location:'.SITEURL.'admin/manage-admin.php');
            }

        }
        else
         {
             //user does not exist set message and redirect
             $_SESSION['user-not-found'] ="<div class ='error'>user not found.</div>"; 
             header('location:'.SITEURL.'admin/manage-admin.php');
         }  
    }
} 



?>


<?php include('partials/footer.php');?>