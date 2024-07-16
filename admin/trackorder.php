<?php

include "../connection/connect.php";

session_start();

$message=[];
$admin_id = $_SESSION['adminid'];


if(!isset($admin_id)){
   header('location:adminlogin.php');
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/adminpagestyle.css">
</head>
<body>
<div class="header">    
    <div class="h-left"><b><a href="adminpanel.php">Online dairy <br>Admin Panel</a></b></div>
    <form method="post" class="logout">
    <h6>Welcome, Admin<h6>
        <button name="logout" class="h-right">Logout</button>
    </form>
</div>
<div class="adminsides">
<div class="sidebar" id="sidebar">
<div class="closebtnflex">
<a class="addproduct" href="trackorder.php">Track orders</a>
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    </div>
    <hr>
    <a href="vendormanagement.php" class="addproduct">Vendor Management</a>
    <hr>
    <a href="usermanagement.php" class="addproduct">User Management</a>
    <hr>
    <a href="productview.php" class="addproduct">Product view</a>
</div>

<div id="main">
  <button class="openbtn" onclick="openNav()">☰</button> 
</div>

<div class="adminpaneltxt" id="adminPanel">

<div class="addproduct-box">
        <div class="addproduct-form">
<?php 
if(isset($_POST['update_payment'])){
    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    $update_payment ="UPDATE `billing_details` SET payment_status ='$payment_status' WHERE id ='$order_id'";
    $result_update_pymt=mysqli_query($conn,$update_payment);
    $message[] = 'Order status updated successfully';
 }
 
 if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_order ="DELETE FROM `billing_details` WHERE id = '$delete_id'";
    $delete_res=mysqli_query($conn,$delete_order);
    header('location:trackorder.php');
 }
?>
            <h1 class="heading">Orders</h1>
            <div class="success-box">
                    <?php
                    if (!empty($message)) {
                        foreach ($message as $smsg) {
                            echo '<p>' . $smsg . '</p>';
                        }
                    }
                    ?>
                </div>

            <div class="box-container">

                <?php
      $select_orders ="SELECT bd.* FROM (SELECT DISTINCT b_id FROM orders) AS unique_orders INNER JOIN billing_details bd ON unique_orders.b_id = bd.id";

      $select_orders_res=mysqli_query($conn,$select_orders);
      if(mysqli_num_rows($select_orders_res)>0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders_res)){ 
           

   ?>
                <div class="box">
                



                    <table border="1" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Ph.Number</th>
                                <th>Email address</th>
                                <th>Ordered date</th>
                                <th>C.Address</th>
                               
                                <th>Total price</th>
                                <th>Order status</th>
                                
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><p><?= $fetch_orders['f_name']; ?></p></td>
                                <td><?= $fetch_orders['number']; ?></p></td>
                                <td><p><?= $fetch_orders['email']; ?></p></td>
                                <td><p><?= $fetch_orders['placed_on']; ?></p></td>
                                <td><p><?= $fetch_orders['address']; ?></p></td>
                                <td> <p>Rs.<?= $fetch_orders['total_price']; ?>/-</p></td>
                                <td><form action="" method="post" class="flex-content">
                                    <div class="menu">
                                <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                        <select name="payment_status" class="select">
                            <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
                            <option value="pending">pending</option>
                            <option value="completed">completed</option>
                        </select>
                                    </div>

                        <div class="flex-btn">
                                    <div class="edit-tracking">
                            <input type="submit" value="update" class="option-btn" name="update_payment">
                                    </div>
                                    <div class="delete">
                            <a href="trackorder.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn"
                                onclick="return confirm('delete this order?');">delete</a>

                                    </div>
                        </div>

                        
                                </form>
                            
                            
                            </td>
             
                            </tr>
                        </tbody>

                    </table>
                </div>
                <?php
         
        
    }
      }else{
         echo '<p class="empty">no order to track!</p>';
      }
   ?>

            </div>
        </div>
    </div>





</div>
</div>


<?php 
    if(isset($_POST['logout'])){
        session_destroy();
        header("location: vendorlogin.php");
    }
    ?>
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
<script src="../script/adminscript.js"></script>

</body>
</html>
