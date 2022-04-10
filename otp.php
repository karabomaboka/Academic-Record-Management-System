<?php
session_start();
if(!isset($_SESSION['email']))
{
    header("Location: index.php");
}
require 'components/connection.php';



if(isset($_POST['save']))
{
        
	if($_POST['otpvalue']==$_SESSION['otp'])
	{
        $sql = "INSERT INTO user (name, email, password, category, department) VALUES (:name, :email, :password, :category, :department)";
        $stmt = $con->prepare($sql);
        $stmt->execute(['name'=>$_SESSION['name'], 'email'=>$_SESSION['email'], 'password'=>$_SESSION['password'], 'category'=>$_SESSION['category'], 'department'=>$_SESSION['department']]);
        session_unset();
        session_destroy();
		echo "<script>alert('Registration Successful! Login to continue...');</script>";
        echo "<script>window.location.href='login.php'</script>";
	}
	else{
	   echo "<script>alert('Invalid OTP');</script>";
	}
}

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
    <div class="container" style="height: auto;">

        <div class="signup-form">
            <h1>OTP</h1>
            <p>Check your email for the OTP.</p>
            <form action="#" method="post" id="fileForm" role="form">
                <div class="form-group">
                    <label for="name"><span class="req"></span> Enter OTP:</label>
                    <input class="form-control" type="text" name="otpvalue" id="user_otp" onkeyup="Validate(this)"
                        required />
                </div>
                <div class="form-group">
                    <hr>
                    <input class="btn btn-success" type="submit" name="save" value="Confirm">
                    <!-- <input class="btn btn-success" type="submit" name="resend" value="Resend" disabled> -->
                </div>
            </form>
            <div><?php if(isset($message)) { echo $message; } ?>
            </div>
            <hr>
        </div>
    </div>


    <?php include 'components/footer.html'  ?>


</body>

</html>