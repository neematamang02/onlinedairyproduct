<?php
include "../connection/connect.php";
session_start();
$message = array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Admin login</title>
</head>
<body>
<div class="login-page">
    <div class="welcoming">
    <h4>Expand your business with! Online dairy</h4>
    <p>New member?<span class="register-btn"><a href="vendorregister.php">Register</a></span> here</p>
    </div>
    <div class="containerbox">
  <div class="wrapper">
  <div class="titlelogo">
        <h1>Admin Panel</h1>
    </div>
    <h2>Login</h2>
    <?php 
    if(isset($_POST['login'])) {
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $sql = "SELECT * FROM `admin_login` WHERE email='$email' AND password='$pass'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
    
        if(mysqli_num_rows($res)>0) {
                $_SESSION['adminid'] = $row['id']; // Setting userid in session
                header('Location: adminpanel.php'); // Redirecting after successful login
        }
             else {
                // Set error message
                $message[] = "Invalid email or password";
            }
        }   
    ?>
    <form action="" method="post">
    <div class="error-box">
                <?php
                if (isset($message)) {
                    foreach ($message as $msg) {
                        echo '<p>' . $msg . '</p>';
                    }
                }
                ?>
            </div>
     
      <div class="input-box">
        <input type="text" placeholder="Enter your email" name="email" required>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Enter your password" name="pass" required>
      </div>
      <div class="input-box button">
        <input type="Submit" value="login Now" name="login">
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
        <li>Rozim Maharjan</li>
        </div>
        <!--/.footer-gray-->
        </div>
        </div>
    </footer>
    <div class="copyright">
        <h4>&copy; copyright code 2023/padmashree 4th sem project</h4>
    </div>
<script src="https://kit.fontawesome.com/927b7fa170.js" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>
