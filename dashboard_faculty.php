<?php 
session_start();
if(!isset($_SESSION['sess_email']) || $_SESSION['sess_category'] != 'Faculty') 
{
    header('location: login.php');
}  
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- Optional JavaScript; choose one of the two! -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <link rel = "icon" href = "img/favicon.png" type = "image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">

</head>

<body>

    <!-- Side navigation -->

    <!-- The sidebar -->
    <div class="sidebar">
        <a class="active" href="dashboard_faculty.php"><b>Home</b></a>
        <a href="publication_f/publication_index.php">Publication</a>
        <a href="project_f/project_index.php">Project</a>
        <a href="patent/patent_index.php">Patent</a>
        <a href="setting_f.php">Change Password</a>
        <a href="logout.php">Log Out</a>
    </div>

    <!-- Page content -->
    <div class="content">
        <div class="header">
            <h1>Academic Records Management System</h1>
            <h3 style="color: #1e1f1f;">College of Technology, Pantnagar</h3>
        </div>
        <hr>

        <div class="container">
            <h1><b> Welcome <?php echo $_SESSION['sess_name']; ?>!</b></h1>
            <p>Select below buttons to explore your work.<br>To add data, select the type from the left sidebar and then
                click Add.</p>
        </div>

        <div class="home_display">
            <!-- boxes of research, project and project with details start here -->
            <div class="row">
                <h1>Here's Your Work!<br></h1>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">Publication</div>
                        <div class="card-body">
                            <h5 class="card-title"><b>My Publications</b></h5>
                            <p class="card-text">Click below to Explore.</p>
                            <a href="publication_f/publication_index.php" class="btn btn-primary">Explore</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">Patent</div>
                        <div class="card-body">
                            <h5 class="card-title"><b>My Patents</b></h5>
                            <p class="card-text">Click below to Explore.</p>
                            <a href="patent/patent_index.php" class="btn btn-primary">Explore</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">Project</div>
                        <div class="card-body">
                            <h5 class="card-title"><b>My Projects</b></h5>
                            <p class="card-text">Click below to Explore.</p>
                            <a href="project_f/project_index.php" class="btn btn-primary">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "components/footer.html" ?>
</body>

</html>