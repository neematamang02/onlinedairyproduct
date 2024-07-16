<?php
include "connection/connect.php";
session_start();
$errormessage=[];

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
} else {
    $userid = '';
}


if(isset($_POST['delete']))
{
    $cart_id = $_POST['cart_id'];
    $delete_cart_items="DELETE FROM `cart` WHERE id = '$cart_id'";
    $res=mysqli_query($conn,$delete_cart_items);
}
if(isset($_POST['update_qty'])) {
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $sub_total = $_POST['subtotal'];
    if($qty < 1) {
        $errormessage[] = "Quantity cannot be less than 1";
    } else {
        $update_qty = "UPDATE `cart` SET quantity = '$qty', subtotal = '$sub_total' WHERE id = '$cart_id'";
        $result = mysqli_query($conn, $update_qty);
        $message[] = 'Cart quantity updated';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">

    <title>Cart</title>
</head>
<body>
<?php include 'header.php';?>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>


            <li><a href="userdashboard.php">customer order</a></li>
            <li><a href="aboutus.php">About us</a></li>
            <li><a href="contactus.php">Contact us</a></li>

        </ul>
    </nav>
    <section class="orderlist">
        <h1>Cart</h1>
        <div class="order-items">
            <table border="0" cellspacing="0" class="cart-table">

                <thead>
                    <tr>
                        <th></th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity (Kg/Ltr)</th>
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <?php
      $grand_total = 0;
      $select_cart ="SELECT * FROM `cart` WHERE user_id ='$userid'";
      $cart_query=mysqli_query($conn,$select_cart);
      if(mysqli_num_rows($cart_query)>0){
         while($fetch_cart=mysqli_fetch_assoc($cart_query)){
        ?>
        <tr>
         <form action="" method="post">
         <?php
        if(!empty($errormessage)){
            foreach($errormessage as $emsg)
            {
                echo '<p>'.$emsg.'</p>';
            }
        }
        ?>
                        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">

                        <td><input type="submit" value="delete item" onclick="return confirm('delete this from cart?');"
                                class="delete-btn" name="delete">
                            <img src="vendor/uploadimage/<?php echo $fetch_cart['image']; ?>" alt="image" class="product-image">
                        </td>
                        <td><?= $fetch_cart['name']; ?></td>
                        <td>Rs.<?= $fetch_cart['price']; ?>/-</td>
                        <td>
                            <?php echo $fetch_cart['quantity']; ?>
                            <input type="hidden" name="update_qty" value="<?= $fetch_cart['id']; ?>">
                            <input type="hidden" name="subtotal" value="<?= $fetch_cart['subtotal']; ?>">
                            <input type="number" name="qty" class="quantity" value="<?= $fetch_cart['quantity']; ?>" min="1">
                            <input type="submit" value="Update" onclick="return confirm('Do you want to update your cart?')" name="update_qty">
                        </td>

                        <td>Rs.<?= $total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
                        <td>
                            <?php                         
                        if($fetch_cart['quantity']>=1000 && $fetch_cart['quantity']<=4999){
                            echo "30%";
                        }elseif($fetch_cart['quantity']>=500 && $fetch_cart['quantity']<=999){
                            echo"20%";
                        }elseif($fetch_cart['quantity']>=100 && $fetch_cart['quantity']<=499){
                            echo"10%";
                        }elseif($fetch_cart['quantity']>=50 && $fetch_cart['quantity']<=99){
                            echo"5%";
                        }elseif($fetch_cart['quantity']>=10 && $fetch_cart['quantity']<=49){
                            echo"1%";
                        }else{
                            echo"No Discount";
                        }
                        ?>
                        </td>
                        <td>
                            <?php 
                            if($fetch_cart['quantity']>=1000 && $fetch_cart['quantity']<=4999){
                                echo '$'. $sub_total = $total - ($total * 30/100);
                            }elseif($fetch_cart['quantity']>=500 && $fetch_cart['quantity']<=999){
                                echo '$'. $sub_total = $total - ($total * 20/100);
                            }elseif($fetch_cart['quantity']>=100 && $fetch_cart['quantity']<=499){
                                echo '$'. $sub_total = $total - ($total * 10/100);  
                            }elseif($fetch_cart['quantity']>=50 && $fetch_cart['quantity']<=99){
                                echo '$'. $sub_total = $total - ($total * 5/100);
                            }elseif($fetch_cart['quantity']>=10 && $fetch_cart['quantity']<=49){
                                echo '$'. $sub_total = $total - ($total * 1/100);
                            }else{
                                echo '$'.$sub_total = $total;
                            }
                            ?>
                        </td>
                    </form>
                </tr>
                <?php
                  $grand_total += $sub_total;
                      }
                  }else{
                      echo '<p class="empty">your cart is empty</p>';
                  }
                  ?>
            </table>
        </div>
        <div class="checkout-details">
            <table border="1" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="2">Cart totals</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Grand Total</td>
                        <td>$<?= $grand_total; ?>/-</td>
                    </tr>
                    <tr>
                        <td colspan="2"><a href="checkout.php"><button class="checkout-cart">checkout cart</button></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <br>
    <footer>
        <div class="flex-footer">
        <div class="footer-content">
            <br>
            <div class="socialmedia">
                <a href="#"><i class="fa-brands fa-facebook fa-2xl"></i></a>
                <a href="#"><i class="fa-brands fa-instagram fa-2xl"></i></a>
                <a href="#"><i class="fa-brands fa-twitter fa-2xl"></i></a>

            </div>
            <br>
            
            <div class="contact">
                <div class="number">
                    <i class="fa-solid fa-phone"></i>
                    <h5>+977 0000000000</h5>
                    <div class="address">
                        <i class="fa-solid fa-envelope"></i>
                        <h5>Onlinedairy@gmail.com</h5>

                    </div>

                </div>

            </div>
            <h1>ONLINE DAIRY</h1>

        </div>


        <div class="team-members-list">

        <h3>Team Members</h3>
        <li>Nima Tamang</li>
        <li>Rojim Maharjan</li>

      


        </div>
        <!--/.footer-gray-->




        </div>
        </div>

    </footer>
    

    

    <div class="copyright">
        <h4>&copy; copyright code 2024/padmashree 4th sem project</h4>


    </div>



    </div>
   
    <script src="script/script.js"></script>
</body>

</html>