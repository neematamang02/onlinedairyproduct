<?php

include "../connection/connect.php";

session_start();



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
    <h6>Welcome, <span style="grey;"><?php echo $username; ?></span><h6>
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
            <h1 class="heading">Vendors</h1>

            <div class="box-container">

                <?php
      $select_orders ="SELECT * FROM `registerd_vendor`";

      $select_orders_res=mysqli_query($conn,$select_orders);
      if(mysqli_num_rows($select_orders_res)>0){
         while($fetch_vendordetail = mysqli_fetch_assoc($select_orders_res)){ 
    
   ?>
                <div class="box">



                    <table border="1" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email address</th>
                                <th>Address</th>
                                <th>Phone number</th>
                                
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><p><?= $fetch_vendordetail['username']; ?></td>
                                <td><?= $fetch_vendordetail['email']; ?></p></td>
                                <td><?= $fetch_vendordetail['address']; ?></p></td>
                                <td><?= $fetch_vendordetail['phno']; ?></p></td>
             
                            </tr>
                        </tbody>

                    </table>
                </div>
                <?php
         
        
    }
      }else{
         echo '<p class="empty">no registerd vendor yet!</p>';
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
