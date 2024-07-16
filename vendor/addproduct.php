<?php
include "../connection/connect.php";
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: vendorlogin.php");
    exit();
}

if (isset($_SESSION['sellerid'])) {
    $sellerid = $_SESSION['sellerid'];
    $sql = "SELECT * FROM `registerd_vendor` WHERE id='$sellerid'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $username = $row['username']; // Fetching username from the database
    }
}

else {
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
    <div class="h-left"><b><a href="vendordashboard.php">Online dairy <br>seller center</a></b></div>
    <form method="post" class="logout">
        <h6>Welcome, <span style="color: grey;"><?php echo htmlspecialchars($username); ?></span></h6>
        <button type="submit" name="logout" class="h-right">Logout</button>
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
            <?php
            if (isset($_POST['add_product'])) {
                $name = $_POST['productname'];
                $price = $_POST['productprice'];
                $qty = $_POST['qty'];
                $details = $_POST['productdescription'];
                $image_01 = $_FILES['uploadfile']['name'];
                $image_size_01 = $_FILES['uploadfile']['size'];
                $image_tmp_name_01 = $_FILES['uploadfile']['tmp_name'];
                $image_folder_01 = "uploadimage/" . $image_01;
                $id = $_SESSION["sellerid"];
            
                $select_products = "SELECT * FROM `products` WHERE product_name='$name'";
                $query = mysqli_query($conn, $select_products);
                if (mysqli_fetch_row($query) > 0) {
                    echo "Product name already exists!";
                } else {
                    $insert_products = "INSERT INTO `products` (product_name, product_price, quantity, product_image, product_description, vendor_id) VALUES ('$name', '$price', '$qty', '$image_01', '$details', '$id')";
                    $sql = mysqli_query($conn, $insert_products);
            
                    if ($sql) {
                        if ($price <= 0) {
                            throw new Exception("Error");
                        }
                    }
            
                    if ($insert_products) {
                        if ($image_size_01 > 2000000) {
                            echo "Image size is too large!";
                        } else {
                            move_uploaded_file($image_tmp_name_01, $image_folder_01);
                            echo "Product added successfully!";
                        }
                    }
                }
            }
            ?>

            <form action="" method="post" enctype="multipart/form-data" id="addproductform">
                <div class="username">
                    <br>
                    <h4>Product Name</h4>
                    <input type="text" name="productname" placeholder="Enter product name" required class="input-box">
                </div>
                <div class="username">
                    <br>
                    <h4>Product Price</h4>
                    <input type="text" name="productprice" placeholder="Enter product price" required class="input-box" id="productprice">
                </div>
                <div class="username">
                    <br>
                    <h4>Quantity(Kg/Ltr)</h4>
                    <input type="number" name="qty" class="input-box" placeholder="Enter quantity" id="productqty">
                </div>
                <div class="username">
                    <br>
                    <h4>Product Image</h4>
                    <input type="file" name="uploadfile" accept="image/jpg, image/jpeg, image/png, image/webp" placeholder="Enter product image" required class="input-box">
                </div>
                <div class="username">
                    <br>
                    <h4>Product Description</h4>
                    <textarea type="text" name="productdescription" placeholder="Enter product description" required class="input-box"></textarea>
                </div>
                <br>
                <button class="login-btn" name="add_product">SUBMIT</button>
            </form>
        </div>
    </div>
</div>
</div>
<script src="../script/adminscript.js"></script>
</body>
</html>
