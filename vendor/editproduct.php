<?php
include "../connection/connect.php";
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: vendorlogin.php");
    exit();
}

$successmessage = [];

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

if (isset($_GET['update'])) {
    $id = $_GET['update'];
    $select_products = "SELECT * FROM `products` WHERE id='$id'";
    $sql = mysqli_query($conn, $select_products);

    if (mysqli_num_rows($sql) > 0) {
        $fetch_products = mysqli_fetch_assoc($sql);
        
        if (isset($_POST['update'])) {
            $name = $_POST['productname'];
            $price = $_POST['productprice'];
            $qty = $_POST['qty'];
            $details = $_POST['productdescription'];
            
            // Update product details in the database
            $update_products = "UPDATE `products` SET product_name='$name', product_price='$price', quantity='$qty', product_description='$details' WHERE id='$id'";
            mysqli_query($conn, $update_products);
            $successmessage[] = "Product details updated successfully";
            
            // Handle file upload
            if (isset($_FILES['uploadfile']) && $_FILES['uploadfile']['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES['uploadfile']['name'];
                $image_tmp_name = $_FILES['uploadfile']['tmp_name'];
                $image_folder = "uploadimage/" . $image;
                
                if (move_uploaded_file($image_tmp_name, $image_folder)) {
                    // Update product image in the database
                    $update_image = "UPDATE `products` SET product_image ='$image' WHERE id = '$id'";
                    mysqli_query($conn, $update_image);
                    $successmessage[] = "Product updated successfully";
                } else {
                    $successmessage[] = "Failed to upload image";
                }
            }
        }
    }
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
        <h6>Welcome, <span style="color: grey;"><?php echo $username; ?></span></h6>
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
            <form action="" method="post" enctype="multipart/form-data">
                <div class="success-box">
                    <?php
                    if (!empty($successmessage)) {
                        foreach ($successmessage as $smsg) {
                            echo '<p>' . $smsg . '</p>';
                        }
                    }
                    ?>
                </div>
                <div class="username">
                    <br>
                    <h4>Product Name</h4>
                    <input type="text" name="productname" placeholder="Enter product name" class="input-box" value="<?php echo $fetch_products['product_name']; ?>">
                </div>
                <div class="username">
                    <br>
                    <h4>Product Price</h4>
                    <input type="text" name="productprice" placeholder="Enter product price" class="input-box" value="<?php echo $fetch_products['product_price']; ?>">
                </div>
                <div class="username">
                    <br>
                    <h4>Quantity(Kg/Ltr)</h4>
                    <input type="number" name="qty" class="input-box" placeholder="Enter quantity" value="<?php echo $fetch_products['quantity']; ?>">
                </div>
                <div class="username">
                    <br>
                    <h4>Product Image</h4>
                    <input type="file" name="uploadfile" accept="image/jpg, image/jpeg, image/png, image/webp" placeholder="Enter product image" class="input-box">
                </div>
                <div class="username">
                    <br>
                    <h4>Product Description</h4>
                    <textarea type="text" name="productdescription" placeholder="Enter product description" class="input-box"><?php echo $fetch_products['product_description']; ?></textarea>
                </div>
                <input type="hidden" name="pid" value="<?php echo $id; ?>">
                <br>
                <button class="login-btn" name="update">SUBMIT</button>
            </form>
        </div>
    </div>
</div>
</div>
<script src="../script/adminscript.js"></script>
</body>
</html>
