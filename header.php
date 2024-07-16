<?php
include "connection/connect.php";

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
} else {
    $userid = '';
}

if(isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
    $sql = "SELECT * FROM `registerd_users` WHERE id='$userid'";
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $username = $row['full_name']; 
    }
}
?>

<header>
    <div class="top-link-item">
        <div class="top-item-list">
            <ul>
            <?php     
                 
            $select_profile ="SELECT * FROM `registerd_users` WHERE id ='$userid'";
            $res=mysqli_query($conn,$select_profile);
            if(mysqli_num_rows($res) > 0){
            $fetch_profile =mysqli_fetch_assoc($res);
         ?>
         <li>Welcome <b><?= $fetch_profile["full_name"]; ?></b>,</li>
         <li><a href="userdashboard.php">My Orders</a></li>
    
         <li><a href="logout.php" class="logout-btn" onclick="return confirm('Are you sure you want to logout?');">Logout</a></li>
         <?php
            }else{
         ?>

         <li><a href="userlogin.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
         <?php
            }
         ?>
            </ul>
        </div>
    </div>
    <div class="search-item">
        <div class="logo">
            <a href="index.php">
                <h1>ONLINE DAIRY</h1>
            </a>
        </div>

        <div class="cart">

        <?php 
        $count_cart_items="SELECT * FROM `cart` WHERE user_id ='$userid'";
        $result=mysqli_query($conn,$count_cart_items);
        if($result){
        $total_cart_counts=mysqli_num_rows($result);
        }
        ?>

<span class='count'><?php  echo $total_cart_counts; ?></span>
        <a href="cart.php"><img src="icons/icons8-cart-100.png" alt="cart icon"></a>
        </div>
    </div>
</header>
