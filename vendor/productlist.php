<?php

include "../connection/connect.php";

session_start();

$sellerid = $_SESSION['sellerid'];
if(isset($sellerid)) {
    $sql = "SELECT * FROM `registerd_vendor` WHERE id='$sellerid'";
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $username = $row['username']; // Fetching username from the database
    }
}
else{
    header('location:vendorlogin.php');
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
    <div class="h-left"><b><a href="vendordashboard.php">Online dairy <br>seller center</a></b></div>
    <form method="post" class="logout">
        <h6>Welcome, <span style="grey;"><?php echo $username; ?></span></h6>
        <button name="logout" class="h-right">Logout</button>
    </form>
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
        <div class="addproduct-box">
            <div class="addproduct-form">
                <table id="customers">
                    <tr>
                        <th>S.N</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Quantity</th>
                        <th>Product Image</th>
                        <th>Product Description</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $i = 1;
                    $select_products = "SELECT * FROM `products` WHERE vendor_id='$sellerid'";
                    $query = mysqli_query($conn, $select_products);
                    if (mysqli_num_rows($query) > 0) {
                        while ($fetch_products = mysqli_fetch_assoc($query)) {
                            ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $fetch_products['product_name']; ?></td>
                                <td>Rs.<?= $fetch_products['product_price']; ?>/-</td>
                                <td><?= $fetch_products['quantity']; ?> (Kg/Ltr)</td>
                                <!-- Display image -->
                                <td><img src="uploadimage/<?php echo $fetch_products['product_image']; ?>" alt="Product Image" class="uploadimg" style="width: 100px; height: 100px;"></td>

                                <td><?= $fetch_products['product_description']; ?></td>
                                <td>
                                    <div class="change-btn">
                                        <div class="edit"><a href="editproduct.php?update=<?= $fetch_products['id']; ?>"
                                                            class="option-btn">update</a></div>
                                        <div class="delete"><a href="deleteproduct.php?delete=<?= $fetch_products['id']; ?>"
                                                              class="delete-btn"
                                                              onclick="return confirm('delete this product?');">delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="7" class="empty">No products added yet!</td></tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: vendorlogin.php");
}
?>
<script src="../script/adminscript.js">
</script>
</body>
</html>
