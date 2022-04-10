<?php 
$pagename='SIGN UP'; 
require 'components/connection.php';
require 'phpmailer/mail.php';
session_start();


if(isset($_POST['submit']))
{
    
    $_SESSION['email'] = trim($_POST['email']);
   
    
    $result = 0;

    $sql = "SELECT COUNT(*) FROM user WHERE email = ?"; 
    $stmt = $con->prepare($sql); 
    $stmt->execute([$_SESSION['email']]); 
    $result = $stmt->fetchColumn();

    if($result>0)
    { 	
		$otp = rand(100000,999999);
            $_SESSION['otp']=$otp;
            $result1 = sendOTP($_SESSION['email'],$otp);

            if($result1==1)
            {
                $sql = "SELECT COUNT(*) FROM forgotpassword WHERE email = ?"; 
                $stmt = $con->prepare($sql); 
                $stmt->execute([$_SESSION['email']]); 
                $result2 = $stmt->fetchColumn();

                if($result2>0)
                {
                    $sql = "UPDATE forgotpassword SET otp=:otp WHERE email= :email";
                    $stmt = $con->prepare($sql);
                    $stmt->execute(['otp'=>$otp, 'email'=>$_SESSION['email']]);
            


                    echo "<script>alert('OTP sent to your email.')</script>";
                    header("Location: otpforgotpassword.php");
                    
                }
                else
                {
                    $sql = "INSERT INTO forgotpassword (otp, email) VALUES (:otp, :email)";
                
                    $stmt = $con->prepare($sql);

                    $stmt->execute(['otp'=>$otp, 'email'=>$_SESSION['email']]);


                    echo "<script>alert('OTP sent to your email.')</script>";
                    header("Location: otpforgotpassword.php");
                }   

            }
            else
            {
                echo "<script>alert('OTP send failed.')</script>";
                header("Location: signup.php");
            }
    }
    else
    {	
        
        echo "<script>alert('User does not exist')</script>";
       
			
    }

}
$con = null;
?>

<!DOCTYPE html>
<html>

<head>
    <?php include 'components/head.html' ?>
    <title>SignUp</title>
    <link rel="stylesheet" type="text/css" href="css/signup.css">
    <script src="js/signup_validation.js"></script>
</head>

<body>
    <?php include 'components/header.php' ?>
    <div class="container">

        <div class="signup-form">
            <h1>Forgot password</h1>

            <form action="#" method="post" id="fileForm" role="form">



                <div class="form-group">
                    <label for="email"><span class="req"></span> Email Address: </label>
                    <input class="form-control" required type="text" name="email" id="email"
                        placeholder="email" onchange="email_validate(this.value);" />
                    <div class="status" id="status"></div>
                </div>


                <div class="form-group">
                    <hr>
                    <input class="btn btn-success" type="submit" name="submit" id="submit" value="Next">
                </div>
            </form>
            <hr>
        </div>
    </div>


    <?php include 'components/footer.html'  ?>
</body>

</html>