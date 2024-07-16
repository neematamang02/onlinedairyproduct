<?php

include "../connection/connect.php";
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: vendorlogin.php");
    exit();
}

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
} else {
    $userid = '';
}

if (isset($_SESSION['sellerid'])) {
    $sellerid = $_SESSION['sellerid'];
    $sql = "SELECT * FROM `registerd_vendor` WHERE id='$sellerid'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $username = $row['username']; // Fetching username from the database
    }
} else {
    header('Location: vendorlogin.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard</title>
    <link rel="stylesheet" href="../css/adminpagestyle.css">
</head>
<body>
<div class="header">
    <div class="h-left"><b><a href="#">Online dairy <br>seller center</a></b></div>
    <div class="spacing">
        <form method="post" class="logout">
            <h6>Welcome, <span style="color: grey;"><?php echo $username; ?></span></h6>
            <button name="logout" class="h-right">Logout</button>
        </form>
    </div>
</div>
<div class="adminsides">
    <div class="sidebar" id="sidebar">
        <div class="closebtnflex">
            <a class="addproduct active" href="addproduct.php">Add Product</a>
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        </div>
        <a class="addproduct" href="productlist.php">Product List</a>
        <a class="addproduct" href="ordermanage.php">Manage order</a>
    </div>
    <div id="main">
        <button class="openbtn" onclick="openNav()">☰</button>
    </div>
    <div class="adminpaneltxt" id="adminPanel">
        <?php
        $i = 1;
        $vendor_product = "SELECT t1.*, t2.*, t3.* FROM products t1 INNER JOIN orders t2 ON t1.id = t2.p_id INNER JOIN billing_details t3 ON t2.b_id = t3.id WHERE t1.vendor_id ='$sellerid'";
        $res_vendor_product = mysqli_query($conn, $vendor_product);
        if (mysqli_num_rows($res_vendor_product) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($res_vendor_product)) {
        ?> 
        <div class="ordermanage">
            <table border="1" cellspacing="0" class="manageordertbl">
                <thead class="orderhead">
                    <tr>
                        <th>S.N</th>
                        <th>Customer</th>
                        <th>Order</th>
                        <th>Delivery Date</th>
                        <th>Customer Address</th>
                        <th>Delivery Pricing</th>
                        <th>Delivery Status</th>
                        <th>Product image</th>
                    </tr>
                </thead>
                <tbody class="orderbody">
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><p><?= $fetch_orders['f_name']; ?></p></td>
                        <td><p><?= $fetch_orders['qty']; ?></p></td>
                        <td><p><?= $fetch_orders['placed_on']; ?></p></td>
                        <td><p><?= $fetch_orders['address']; ?></p></td>
                        <td><p>$<?= $fetch_orders['total_price']; ?>/-</p></td>
                        <td><p><span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span></p></td>
                        <td>E-sewa</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
            }
        } else {
            echo '<p class="empty">No orders placed yet!</p>';
        }
        ?>
    </div>
</div>
<script src="../script/adminscript.js"></script>
</body>
</html>
