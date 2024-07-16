<?php

include "../connection/connect.php";
session_start();
$validmessage="";
$emailValidation=" ";
$errormessage = [];
if(isset($_POST['signup']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $pass=$_POST['pass'];
    $cpass=$_POST['cpass'];
    $hashpass=password_hash($pass, PASSWORD_DEFAULT);
    $hashcpass=password_hash($cpass,PASSWORD_DEFAULT);
    $sql="SELECT email FROM `registerd_vendor` WHERE email='$email'";    
    $res=mysqli_query($conn,$sql);
if(!$res||mysqli_num_rows($res)>0)
{
    // echo"Email already exist";
    $emailValidation="Email already exist";
}

else

{
    if($pass===$cpass)
    {
        $sql = "INSERT INTO `registerd_vendor` (username, email,address,phno,pass) VALUES ('$name','$email','$address','$phone','$hashpass')";
$res=mysqli_query($conn,$sql);
if($res)
{
     $validmessage="Data inserted successfully";
}

else{
    $errormessage[]="Error in data insertion";
}

    }

    else{
        $errormessage[]="Password do not match";
        
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
    <link rel="stylesheet" href="../css/style.css">
    
    <title>Vendor Registration</title>
</head>
<body>



<div class="register-page">
  
    <div class="welcoming">
    <h4>Create your Online seller account</h4>
    
    <p>Already member?<span class="register-btn"><a href="vendorlogin.php">Login</a></span> here</p>
    </div>


    <div class="containerbox">
  <div class="wrapper">
    <h2>Sign Up</h2>
    <form action="" method="post">
                <div class="valid-box">
                    <?php if (!empty($validmessage)) { echo '<p>' . $validmessage . '</p>'; } ?>
                </div>
                <div class="error-box">
                    <?php
                    if (!empty($errormessage)) {
                        foreach ($errormessage as $emsg) {
                            echo '<p>' . $emsg . '</p>';
                        }
                    }
                    ?>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Enter your name" name="name">
                    <span id="nameError" style="color: red;"></span>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Enter your email" name="email" id="email">
                    <span id="emailError" style="color: red;"></span>
                </div>
                <div class="input-box">
                    <input type="number" placeholder="Enter your phone number" name="phone" id="number">
                    <span id="phoneError" style="color: red;"></span>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Enter your address" name="address">
                    <span id="addressError" style="color: red;"></span>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Create password" name="pass" id="pass">
                    <span id="passError" style="color: red;"></span>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Confirm password" name="cpass" id="cpass">
                    <span id="cpassError" style="color: red;"></span>
                </div>
                <div class="policy">
                    <input type="checkbox" required>
                    <h3>I accept all terms & conditions</h3>
                </div>
                <?php
                     echo "<span style='color: red;'>$emailValidation</span>";
                ?>

                <div class="input-box button">
                    <input type="submit" value="Register Now" name="signup">
                </div>
                <div class="text">
                    <h3>Already have an account? <a href="vendorlogin.php">Login now</a></h3>
                </div>
            </form>
  </div>
    </div>

</div>




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

 
    <?php
session_destroy();
?>

<script src="../validate.js"></script>
<script src="./script/script.js"></script>
<script src="https://kit.fontawesome.com/927b7fa170.js" crossorigin="anonymous"></script>

</body>
</html>