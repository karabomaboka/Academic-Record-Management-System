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
        $sql = "INSERT INTO alumni (name, email, college_id, batch, department, phno, company, designation) VALUES (:name, :email, :college_id, :batch, :department, :phno, :company, :designation)";
        $stmt = $con->prepare($sql);
        $stmt->execute(['name'=>$_SESSION['name'], 'email'=>$_SESSION['email'], 'college_id'=>$_SESSION['college_id'], 'batch'=>$_SESSION['batch'], 'department'=>$_SESSION['department'], 'phno'=>$_SESSION['phno'], 'company'=>$_SESSION['company'], 'designation'=>$_SESSION['designation']]);
            session_unset();
            session_destroy(); 
            $msg = 'Registered Successfully! \\nDetails will be updated on alumni section after verification.\\nThank you for filling out your information.';
            echo "<script type>alert(\"$msg\");</script>";
            echo "<script>window.location.href='index.php'</script>"; 
	}
	else
    {
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