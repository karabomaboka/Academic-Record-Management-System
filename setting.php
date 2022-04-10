<?php 

require 'components/connection.php';

session_start();
if(!isset($_SESSION['sess_email']) || $_SESSION['sess_category'] != 'Student') 
{
    header('location: login.php');
} 
  
?>

<?php
     if(isset($_POST['save']))
     {
        $email=$_SESSION['sess_email'];
        $sql = "select * from `user` where `email`=:email";
        $query = $con->prepare($sql);
        $query->bindParam('email', $email, PDO::PARAM_STR);
        $query->execute();
        $row   = $query->fetch(PDO::FETCH_ASSOC);
        if(!password_verify($_POST['old_password'], $row['password']))
        {
            $msg='Please enter correct existing password!';   
        }

        else if ($_POST['password'] != $_POST['confirm_password'])
        {
            $msg='New passwords did not match!';   
        }
        else
         {
         $password=password_hash($_POST['password'], PASSWORD_DEFAULT);
         {   $sql = "UPDATE user SET password='$password' WHERE email='$email'";
             $stmt = $con->prepare($sql);
             $stmt->bindParam('password',$password,PDO::PARAM_STR);
             $stmt->execute();
             $msg='Password changed succesfully!';
             
         }
     }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- Optional JavaScript; choose one of the two! -->

    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel = "icon" href = "img/favicon.png" type = "image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
</head>

<body>

    <!-- Side navigation -->

    <!-- The sidebar -->
    <div class="sidebar">
        <a class="active" href="dashboard_student.php">Home</a>
        <a href="publication/publication_index.php">Publication</a>
        <a href="project/project_index.php">Project</a>
        <a href="setting.php"><b>Change Password</b></a>
        <a href="logout.php">Log Out</a>
    </div>

    <!-- Page content -->
    <div class="content">
        <div class="header">
            <h1>Academic Records Management System</h1>
            <h3 style="color: #1e1f1f;">Subheading</h3>
        </div>
        <hr>


        <div class="setting">
            <div class="home_display">
                <h3>Change Password</h3><span class="loginMsg"><?php echo @$msg;?></span><hr>
                <form action="#" method="post" id="fileForm" role="form">
                    <div class="form-group enter">
                        <label for="name"><span class="req"></span>Current Password:</label>
                        <input class="form-control" type="password" name="old_password" id="old_password" required />
                    </div><br>
                    <div class="form-group enter">
                        <label for="password"><span class="req"></span> New Password: </label>
                        <input required name="password" type="password" class="form-control inputpass" minlength="4"
                            maxlength="16" id="pass1" /><br>

                        <label for="confirm_password"><span class="req"></span> Confirm New Password: </label>
                        <input required name="confirm_password" type="password" class="form-control inputpass"
                            minlength="4" maxlength="16" placeholder="" id="pass2"
                            onkeyup="checkPass(); return false;" />
                        <span id="confirmMessage" class="confirmMessage"></span>
                    </div>
                    <div class="form-group enter">
                        <hr>
                        <input class="btn btn-success" type="submit" name="save" value="Change Password">
                        <br>
                    </div>
                </form>
                <hr>
            </div>
        </div>
    </div>
<?php include "components/footer.html"; ?>
</body>

</html>