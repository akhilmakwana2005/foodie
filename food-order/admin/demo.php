
<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1> update order</h1>
        <br></br>

        <?php
        //check whether id is set or not
        if(isset($_GET['id']))
        {
            //get  the order detail 
            $id=$_GET['id'];

            //get all other details  based on this id
            //sql query to get the order
            $sql = "SELECT * FROM tbl_order WHERE id=$id";
            //execute query
            
        }
        else
        {
            //redirect to manage order page
            header('location:'.SITEURL.'admin/manage-order.php');
        }
        
        
        
        
        ?>

        <form action="" method="POST">

          <table class="tbl-30">
            <tr>
                <td>food name</td>
                <td></td>
           </tr>
           <tr>
                    <td>Price</td>
                    <td><b>$<></b></td>
                </tr>
           
           <tr>
            <td>Qty</td>
            <td>
                <input type="number" name="qty" value="">
            </td>
           </tr>
           <tr>
            <td>status</td>
            <td>
                <select name="status">
                      <option value="ordered">ordered</option>
                      <option value="on delivery">on delivery</option>
                      <option value="delivered">delivered</option>
                      <option value="cancelled">cancelled</option>

                </select>
            </td>
           </tr>
           <tr>
            <td> Customer Name:</td>
            <td>
                <input type="text" name="customer_name" value="">
            </td>
           </tr>
           <tr>
            <td> Customer contact:</td>
            <td>
                <input type="text" name="customer_contact" value="">
            </td>
           </tr>
           <tr>
            <td> Customer Email:</td>
            <td>
                <input type="text" name="customer_email" value="">
            </td>
           </tr>
           <tr>
            <td> Customer Address:</td>
            <td>
                <textarea name ="customer_address"  cols="30" rows="5"></textarea>
            </td>
           </tr>

           <tr> 
            <td colspan="2">
                <input type="submit" name="submit" value="update order" class="btn-secondary">
            </td>
           </tr>
        
           </tr>
         </table>
        </form>

    </div>
</div>

 
<?php include('partials/footer.php');?>       