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
<div class="adminpaneltxt" id="adminPanel">
    <h1>Welcome to Admin panel</h1><br>
    <p>Authorized user only</p>
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
