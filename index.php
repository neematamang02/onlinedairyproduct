<?php
include "connection/connect.php";
session_start();

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
} else {
    $userid = '';
}


if(isset($_POST['add_to_cart']))
{
    if($userid == '')
    {
        header('location:userlogin.php');
    }

    else{
        $pid = $_POST['pid'];
        $name = $_POST['product_name'];
        $price = $_POST['product_price'];
        $image = $_POST['product_image'];
        $qty = $_POST['qty'];
        $check_cart_num="SELECT * FROM `cart` WHERE name = '$name' AND user_id ='$userid'";
        $sql=mysqli_query($conn,$check_cart_num);
        if(mysqli_num_rows($sql)>0){
            $message[] = 'Already added to cart!';
        }
        else{
            $insert_cart="INSERT INTO `cart`(user_id, pid, name, price, image, quantity) VALUES('$userid','$pid','$name','$price','$image','$qty')";
            $insert_sql=mysqli_query($conn,$insert_cart);

            if($insert_sql)
            {
                $message[] = 'Added to cart!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let currentIndex = 0;

    function showSlide(index) {
        if (index < 0) {
            index = slides.length - 1;
        } else if (index >= slides.length) {
            index = 0;
        }
        slider.style.transform = `translateX(-${index * 100}%)`;
        currentIndex = index;
    }

    function showNextSlide() {
        showSlide(currentIndex + 1);
    }

    function showPrevSlide() {
        showSlide(currentIndex - 1);
    }

    prevBtn.addEventListener('click', showPrevSlide);
    nextBtn.addEventListener('click', showNextSlide);

    // Automatic slideshow
    setInterval(showNextSlide, 5000); // Change slide every 5 seconds
});

    </script>

    <title>Online Dairy</title>
</head>

<body>
    <?php include 'header.php';?>

    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="userdashboard.php">Customer Order</a></li>
            <li><a href="aboutus.php">About us</a></li>
            <li><a href="contactus.php">Contact us</a></li>
        </ul>
    </nav>
    <div class="slider-container">
        <div class="slider">
            <div class="slide">
                <img src="./images/milk.jpg" alt="Slide 1">
                <div class="slide-text">MILK</div>
            </div>
            <div class="slide">
                <img src="./images/cheese.jpg" alt="Slide 2">
                <div class="slide-text">CHEESE</div>
            </div>
        </div>
        <button class="prev-btn">&#10094;</button>
        <button class="next-btn">&#10095;</button>
    </div>

    <div class="offer-deals">
        <div class="deal-1">
            <img src="images/Deal-Background-PNG.png" alt="dealpng" class="specialdeal">


        </div> 

        <div class="deal-2">

        <h1>GET DISCOUNT OFFER NOW ON</h1>
        <h2>For 10-49kg/ltr <span>1%</span></h2>
        <h2>For 50-99kg/ltr <span>5%</span></h2>
        <h2>For 100-499kg/ltr <span>10%</span></h2>
        <h2>For 500-999kg/ltr <span>20%</span></h2>
        <h2>For 1000-4999kg/ltr <span>30%</span></h2>
        <p>Hurry up!</p>
        

        </div>
    </div>

    <div class="dairy-items">
        <h1>Dairy products</h1>

        <div class="dairy-product-list-1">
            <?php
            $select_products = "SELECT * FROM `products` ORDER BY id DESC";
            $query=mysqli_query($conn,$select_products);
            if(mysqli_num_rows($query) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($query)) {
            ?>
                <div class="dairy-products">
                <a href="productdetail.php?pid=<?= $fetch_products['id']; ?>"><img src="vendor/uploadimage/<?php echo $fetch_products['product_image'] ?>" alt="image"></a>
                    <div class="details">
                        <h3><?php echo $fetch_products['product_name']; ?></h3>
                        <b><p style="color: red;">Rs. <?php echo $fetch_products['product_price']; ?>kg/ltr</p></b>
                        <p><?php echo $fetch_products['product_description']; ?></p>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                        <input type="hidden" name="product_name" value="<?= $fetch_products['product_name']; ?>">
                        <input type="hidden" name="product_price" value="<?= $fetch_products['product_price']; ?>">
                        <input type="hidden" name="product_image" value="<?= $fetch_products['product_image']; ?>">
                        <input type="hidden" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                        <input type="submit" class="addtocart" value="Add to cart" name="add_to_cart">
                    </form>
                </div>
            <?php
                }
            } else {
                echo '<p class="empty">No products added yet!</p>';
            }
            ?>
        </div>

        
    </div>

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

    <script src="https://kit.fontawesome.com/927b7fa170.js" crossorigin="anonymous"></script>
    <script src="script/script.js"></script>
    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    
</body>
</html>


