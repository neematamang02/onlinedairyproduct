<?php

include "connection/connect.php";
include "setting.php";

session_start();
$userid=$_SESSION['userid'];


if(isset($_SESSION['userid'])){
   $user_id = $_SESSION['userid'];
}else{
   $user_id = '';
   header('location:userlogin.php');
 
};

if(isset($_POST['order'])){
    $fullname = $_POST['fullname'];
    $number = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $total_price = $_POST['total_price'];
    $qty = $_POST['qty'];
    $check_cart = "SELECT * FROM `cart` WHERE user_id = '$user_id'";
    $check_res=mysqli_query($conn,$check_cart);
    if(mysqli_num_rows($check_res)>0){
       $insert_order = "INSERT INTO `billing_details`(user_id, f_name,number, email, address, total_price) VALUES('$user_id', '$fullname','$number', '$email', '$address', '$total_price')";
       $resorder=mysqli_query($conn,$insert_order);
       $get_order="SELECT * FROM `billing_details` WHERE user_id='$user_id' ORDER BY id DESC  LIMIT 1";
       $res_order=mysqli_query($conn,$get_order);
       $latest_order=mysqli_fetch_assoc($res_order);
       $b_id=$latest_order['id'];
       $check_cart = "SELECT * FROM `cart` WHERE user_id = '$user_id'";
       $check_res=mysqli_query($conn,$check_cart);
       while($items=mysqli_fetch_assoc($check_res))
       {
        $p_id=$items['pid'];
        $qty=$items['quantity'];
        $insert_order_item="INSERT INTO `orders` (b_id,p_id,qty) VALUES ('$b_id','$p_id','$qty')";
        $insert_order_item_res=mysqli_query($conn,$insert_order_item);

       }

       $delete_cart ="DELETE FROM `cart` WHERE user_id = '$user_id'";
       $del_res=mysqli_query($conn,$delete_cart);
      
       header('location:greetingpage.php');
    }else{
       $message[] = 'your cart is empty';
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

    <title>Online dairy</title>
</head>
</head>

<body>
<?php include 'header.php';?>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>


            <li><a href="userpage.php">customer order</a></li>
            <li><a href="aboutus.php">About us</a></li>
            <li><a href="contactus.php">Contact us </a></li>

        </ul>
    </nav>

    <section class="customer-detail">
        <h1>Checkout</h1>
        <div class="checkout-content">

        
<?php if (true):



$sql="SELECT * FROM `registerd_users` WHERE id='$userid'";
$res=mysqli_query($conn,$sql);
$fetch_user_id=mysqli_fetch_assoc($res);
?>




            <div class="billing-details">
                <h3>Billing details</h3>
                <hr>
                <form action="" method="post">
                    <div class="fullname">
                        <div class="firstn">
                            <h4>Full Name</h4>
                            <input type="text" class="textbox" name="fullname" value="<?php echo $fetch_user_id['full_name']; ?>" required>
                        </div>
                    </div>
                    <div class="userid">
                        <h4>Phone number</h4>
                        <input type="number" name="phone" value="<?php echo $fetch_user_id['phone']; ?>" required>
                        <h4>Email Address</h4>
                        <input type="text" name="email" id="emailaddress" value="<?php echo $fetch_user_id['email']; ?>" required>
                    </div>
                    <div class="address-details">
                        <h4>Full Address</h4>
                        <input type="text" name="address" value="<?php echo $fetch_user_id['address']; ?>" required>
                    </div>

            </div>
<?php endif; ?>
            
            

            

            <div class="customerorder">

                <h3>YOUR ORDERS</h3><br>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Subtotal</th>
                        </tr>
                        <tr>
                            <td>
                                <?php
                        $grand_total = 0;
                       
                        $select_cart ="SELECT * FROM `cart` WHERE user_id ='$user_id'";
                        $res=mysqli_query($conn,$select_cart);
                        if(mysqli_num_rows($res)>0){
                            while($fetch_cart = mysqli_fetch_assoc($res)){
                            
                            $subtotal = $fetch_cart['price']*$fetch_cart['quantity'];
                            $total = $subtotal; 
                    ?>
                                <p style="text-align:left;"> <?= $fetch_cart['name']; ?>
                                <?php 
                                if ($fetch_cart['quantity'] >= 1000 && $fetch_cart['quantity'] <= 4999) {
                                    $discount = $total * 0.3;
                                } elseif ($fetch_cart['quantity'] >= 500 && $fetch_cart['quantity'] <= 999) {
                                    $discount = $total * 0.2;
                                } elseif ($fetch_cart['quantity'] >= 100 && $fetch_cart['quantity'] <= 499) {
                                    $discount = $total * 0.1;
                                } elseif ($fetch_cart['quantity'] >= 50 && $fetch_cart['quantity'] <= 99) {
                                    $discount = $total * 0.05;
                                } elseif ($fetch_cart['quantity'] >= 10 && $fetch_cart['quantity'] <= 49) {
                                    $discount = $total * 0.01;
                                } else {
                                    $discount = 0;
                                }
                                $sub_total = $total - $discount;
                                $discounted_total = $sub_total;
                                $grand_total += $discounted_total;
                                ?>
                                    <span>(<?= 'Rs.'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?> = Rs.<?= $discounted_total ?>/-)</span>
                                </p>


                                <?php
                            }
                        }else{
                            echo '<p class="empty">your cart is empty!</p>';
                        }
                    ?>          <input type="hidden" name="qty" class="qty" value="<?= $fetch_cart['quantity']; ?>">
                                <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
                            </td>
                            <td></td>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <td>Subtotal</td>
                            <td>Rs.<?php echo $grand_total ?>/-</td>

                        </tr>
                        <tr>
                            <td><b>Grand Total</b></td>
                            <td><b>Rs.<?php echo $grand_total ?>/-</b></td>

                        </tr>
                    </tbody>
                </table>
                <div class="paymentmethods">
                    <div class="cards">
                        <h4>We accept</h4>
                        <img src="icons/icons8-visa-card-100.png" alt="visacards">
                        <img src="icons/icons8-mastercard-100.png" alt="mastercard">
                        <img src="icons/icons8-american-express-100.png" alt="AMEX">
                    </div>
                </div><br>
                <input type="submit" id="placeorder" value="Place Order" name="order" class="placeorder">
                <!-- <button type="submit" class="placeorder">Place order</button> -->
                </form>



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
                        <h5>onlinedairy@gmail.com</h5>

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

    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    <script src="https://kit.fontawesome.com/927b7fa170.js" crossorigin="anonymous"></script>
</body>

</html>