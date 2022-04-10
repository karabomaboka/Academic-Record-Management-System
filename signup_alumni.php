<?php 

require 'components/connection.php';
require 'phpmailer/mail.php';
session_start();


$msg1="";
if(isset($_POST['submit']))
{  
    $_SESSION['email'] = trim($_POST['email']);
    $_SESSION['name'] = trim($_POST['name']);
    $_SESSION['college_id'] = $_POST['college_id'];
    $_SESSION['batch'] = $_POST['batch'];
    $_SESSION['department'] = $_POST['department'];
    $_SESSION['phno'] = $_POST['phno'];
    $_SESSION['company'] = $_POST['company'];
    $_SESSION['designation'] = $_POST['designation'];
   
    
    $result = 0;

    $sql = "SELECT COUNT(*) FROM alumni WHERE email = ?"; 
    $stmt = $con->prepare($sql); 
    $stmt->execute([$_SESSION['email']]); 
    $result = $stmt->fetchColumn();

    if($result>0)
    {   
         echo "<script>alert('Already registered!')</script>";

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

                    echo "<script>alert('OTP sent to your email.')</script>";
                    header("Location: otp_alumni.php");
                    
                }
                else
                {
                    $sql = "INSERT INTO registration (otp, email) VALUES (:otp, :email)";
                
                    $stmt = $con->prepare($sql);

                    $stmt->execute(['otp'=>$otp, 'email'=>$_SESSION['email']]);


                    echo "<script>alert('OTP sent to your email.')</script>";
                    header("Location: otp_alumni.php");
                }   

            }
            else
            {
                echo "<script>alert('OTP send failed.')</script>";
                header("Location: signup_alumni.php");
            }       
       
            
    }

$con = null;
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include 'components/head.html' ?>
    <title>Alumni Register</title>
    <link rel="stylesheet" type="text/css" href="css/signup.css">
    <script src="js/signup_validation.js"></script>
</head>

<body>
    <div><?php include 'components/header.php' ?></div>

    <div class="container">

        <div class="signup-form">
        
            <h1 style="color: black">Alumni Registration</h1>     
            

            <strong><span class="loginMsg"><?php echo @$msg;?></span></strong>
            <hr>
            <form action="#" method="post" id="fileForm" role="form">

                <div class="form-group">
                    <label for="name"><span class="req"></span> Name: </label>
                    <input class="form-control" type="text" name="name" id="name" required />
                </div>
                <div class="form-group">
                    <label for="email"><span class="req"></span> Email Address: </label>
                    <input class="form-control" required type="text" name="email" id="email" placeholder="" />
                    <div class="status" id="status"></div>
                </div>
                  <div class="form-group">
                    <label for="college_id"><span class="req"></span> College ID No.: </label>
                    <input class="form-control" required type="text" name="college_id" id="college_id" placeholder="" />
                </div>
                <div class="form-group">
                    <label for="college_id"><span class="req"></span> Batch: </label>
                    <input class="form-control" required type="number" min="1980" max="2017" name="batch" id="college_id" placeholder="" />
                </div>               
                <div class="form-group">
                    <label for="department"><span class="req"></span> Department: </label>
                    <select class="form-select" id="department" name="department">
                        
                        <option value="EE">Electrical Engineering</option>
                        <option value="IT">Information Technology</option>
                        <option value="ECE">Electronics and Communication Engg.</option>
                        <option value="IPE">Industrial & Production Engg.</option>
                        <option value="CE">Civil Engineering</option>
                        <option value="CSE">Computer Engineering</option>
                        <option value="ME">Mechanical Engineering</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email"><span class="req"></span> Contact number: </label>
                    <input class="form-control" required type="text" name="phno" id="phno"
                        placeholder="+91xxxxxxxxxx" />
                </div>
                 <div class="form-group">
                    <label for="name"><span class="req"></span> Currently working at: </label>
                    <input class="form-control" type="text" name="company" id="company" required />
                </div>
                 <div class="form-group">
                    <label for="name"><span class="req"></span> Designation: </label>
                    <input class="form-control" type="text" name="designation" id="designation" required />
                </div>           
                <div class="form-group">
                    <hr>
                    <input class="btn btn-success" type="submit" name="submit" id="submit">
                    <br>
                </div>
                <br>
            </form>
        </div>
    </div>


    <?php include 'components/footer.html'  ?>
</body>

</html>