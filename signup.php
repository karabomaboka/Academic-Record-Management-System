<?php 
$pagename='SIGN UP'; 
require 'components/connection.php';
require 'phpmailer/mail.php';
session_start();

function email_validation($str)
{ 
    return (!preg_match( "^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9.-]+^", $str)) ? FALSE : TRUE; 
} 

$msg1="";
if(isset($_POST['submit']))
{  
    //Function call 
    if(!email_validation($_POST['email'])) { 
        $msg="Invalid email ID.";
    } 

    else if ($_POST['password'] !== $_POST['confirm_password'])
    {
        $msg='Passwords must match!';   
    }

    else {

    $_SESSION['name'] = trim($_POST['name']);
    $_SESSION['email'] = trim($_POST['email']);
    $_SESSION['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $_SESSION['category'] = $_POST['category'];
    $_SESSION['department'] = $_POST['department'];
    $result = 0;

    

    $sql = "SELECT COUNT(*) FROM user WHERE email = ?"; 
    $stmt = $con->prepare($sql); 
    $stmt->execute([$_SESSION['email']]); 
    $result = $stmt->fetchColumn();

    if($result>0)
    {
       $msg="User already exists";
    }
    else
    {
        $otp = rand(100000,999999);
        $_SESSION['otp']=$otp;
        $result1 = sendOTP($_SESSION['email'],$otp);

            if($result1==1)
            {
                $sql = "SELECT COUNT(*) FROM registration WHERE email = ?"; 
                $stmt = $con->prepare($sql); 
                $stmt->execute([$_SESSION['email']]); 
                $result2 = $stmt->fetchColumn();

                if($result2>0)
                {
                    $sql = "UPDATE registration SET otp=:otp WHERE email= :email";
                    $stmt = $con->prepare($sql);
                    $stmt->execute(['otp'=>$otp, 'email'=>$_SESSION['email']]);
            


                    echo "<script>alert('OTP sent to your email.');</script>";
                    header("Location: otp.php");
                    
                }
                else
                {
                    $sql = "INSERT INTO registration (otp, email) VALUES (:otp, :email)";
                
                    $stmt = $con->prepare($sql);

                    $stmt->execute(['otp'=>$otp, 'email'=>$_SESSION['email']]);


                    echo "<script>alert('OTP sent to your email.')</script>";
                    header("Location: otp.php");
                }   

            }
            else
            { 
                echo "<script>alert('OTP send failed!')</script>";
            }
        }

    }
$con = null;
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
    <div><?php include 'components/header.php' ?></div>

    <div class="container">

        <div class="signup-form">
            <h1>Sign Up</h1>
            <h4>Already have an account? <span><a href="login.php">Login </a></span></h4>

            <strong><span class="loginMsg"><?php echo @$msg;?></span></strong>
            <hr>
            <form action="#" method="post" id="fileForm" role="form">

                <div class="form-group">
                    <label for="name"><span class="req"></span> Name: </label>
                    <input class="form-control" type="text" name="name" id="name" required placeholder="Your full name" />
                </div>

                <div class="form-group">
                    <label for="email"><span class="req"></span> Email Address: </label>
                    <input class="form-control" required type="text" name="email" id="email"
                        placeholder="Email ID" />
                    <div class="status" id="status"></div>
                </div>


                <div class="form-group">
                    <label for="category"><span class="req"></span> Category: </label>
                    <select class="form-select" id="category" name="category">
                        <option selected value="Student">Student</option>
                        <option value="Faculty">Faculty</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="department"><span class="req"></span> Department: </label>
                    <select class="form-select" id="department" name="department">
                        <option value="SWCE">Soil & Water Conservation Engg.</option>
                        <option value="IDE">Irrigation and Drainage Engg.</option>
                        <option value="FMPE">Farm Machinery and Power Engg.</option>
                        <option value="PHPFE">Post-Harvest Process & Food Engg.</option>
                        <option value="EE">Electrical Engineering</option>
                        <option value="IT">Information Technology</option>
                        <option value="ECE">Electronics and Communication Engg.</option>
                        <option value="IPE">Industrial & Production Engg.</option>
                        <option value="CE">Civil Engineering</option>
                        <option value="CSE">Computer Engineering</option>
                        <option value="ME">Mechanical Engineering</option>
                    </select>
                    </p>
                </div>

                <div class="form-group">
                    <label for="password"><span class="req"></span> Password: </label>
                    <input required name="password" type="password" class="form-control inputpass" minlength="4"
                        maxlength="16" id="pass1" placeholder="Must be between 4-16 characters" /> </p>

                    <label for="confirm_password"><span class="req"></span> Confirm Password: </label>
                    <input required name="confirm_password" type="password" class="form-control inputpass" minlength="4"
                        maxlength="16" placeholder="Re-enter to validate" id="pass2"
                        onkeyup="checkPass(); return false;" />
                    <span id="confirmMessage" class="confirmMessage"></span> </p>
                </div>

                <div class="form-group">
                    <hr>
                    <input class="btn btn-success" type="submit" name="submit" id="submit">
                </div>
            </form>
        </div>
    </div>


    <?php include 'components/footer.html'  ?>
</body>

</html>