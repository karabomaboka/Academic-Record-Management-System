<?php $pagename = 'LOG IN'; ?>

<?php 
include("components/connection.php");
session_start();

if(isset($_SESSION['sess_email']) && $_SESSION['sess_category'] == 'Student') {
    header('location: dashboard_student.php');    
}
else if (isset($_SESSION['sess_email']) && $_SESSION['sess_category'] == 'Faculty')
{
  header('location: dashboard_faculty.php'); 
}
  
?>

<?php
$msg = ""; 
if(isset($_POST['login'])) {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  if($email != "" && $password != "") {
    try {
      $sql = "select * from `user` where `email`=:email";
      $query = $con->prepare($sql);
      $query->bindParam('email', $email, PDO::PARAM_STR);
      $query->execute();
      $count = $query->rowCount();
      $row   = $query->fetch(PDO::FETCH_ASSOC);
      if($count == 1 && !empty($row))
      {   // checks if the user actually exists(true/false returned)
          if (password_verify($_POST['password'], $row['password']))
          {
            session_start();
            $_SESSION['sess_id'] = $row['user_id'];
            $_SESSION['sess_category']   = $row['category'];
            $_SESSION['sess_email'] = $row['email'];
            $_SESSION['sess_name'] = $row['name'];
            $msg= "Successfully Login";

            if ($_SESSION['sess_category'] == 'Student') 
            {
              header('Location: dashboard_student.php');
            } 
            else 
            {
              header('Location: dashboard_faculty.php');
            }
            
            
            exit();
          }
          else
          {
            $msg = "Incorrect password!";
          }
      }
      else
      {
        $msg = "Incorrect credentials.";
      }
    } catch (PDOException $e) {
      echo "Error : ".$e->getMessage();
    }
  } else {
    $msg = "Both fields are required!";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <?php include 'components/head.html' ?>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="css/signup.css">
  <script src="js/signup_validation.js"></script>
</head>

<body>

  <?php include 'components/header.php'; ?>



  <div class="container">

    <div class="signup-form">
      <h1>Log In</h1>
      <h4>Do not have an account? <span><a href="signup.php">Signup </a></span></h4>
      </p>
      <form action="login.php" method="post" id="fileForm" role="form">

        <div class="form-group">
          <label for="email"><span class="req"></span> Email Address: </label>
          <input class="form-control" required type="text" name="email" id="email"
            placeholder="sample@sample.com" onchange="email_validate(this.value);" />
          <div class="status" id="status"></div>
        </div>

        <div class="form-group">
          <label for="password"><span class="req"></span> Password: </label>
          <input required name="password" type="password" class="form-control inputpass" minlength="4" maxlength="16"
            id="pass1" /> </p>
        </div>

        <div class="form-group">
          <hr>
          <input class="btn btn-success" type="submit" name="login" value="Login">
          &nbsp;&nbsp;<a href="forgotpassword.php">Forgot password?</a>
          <br><span class="loginMsg"><?php echo @$msg;?></span>
        </div>

      </form>
      <hr>
    </div>
  </div>

<?php include 'components/footer.html'; ?>

</body>

</html>