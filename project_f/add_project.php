<?php 
session_start();
if(!isset($_SESSION['sess_email']) || $_SESSION['sess_category'] != 'Faculty') 
{
    header('location: ../login.php');
}   
  
?>


<?php
// include database connection file
include("../components/connection.php");
if(isset($_POST['add']))
{
// Posted Values  
$project_by=$_SESSION['sess_name'];   //$_SESSION['sess_name']
$title=$_POST['title'];
$date=$_POST['date'];
$status=$_POST['status'];
$funding_agency=$_POST['funding_agency'];
$budget=$_POST['budget'];
$description=$_POST['description'];
$user_id=$_SESSION['sess_id'];

try{
    // Query for Insertion into research table
    $sql="INSERT INTO project(title,description,date_of_project,project_by,status,funding_agency,budget,user_id) VALUES(:title,:description,:date,:project_by,:status,:funding_agency,:budget,:user_id)";
    
    //Prepare Query for Execution
    $query = $con->prepare($sql);
    // Bind the parameters
    $query->bindParam(':title',$title,PDO::PARAM_STR);
    $query->bindParam(':description',$description,PDO::PARAM_STR);
    $query->bindParam(':date',$date,PDO::PARAM_STR);
    $query->bindParam(':project_by',$project_by,PDO::PARAM_STR);
    $query->bindParam(':status',$status,PDO::PARAM_STR);
    $query->bindParam(':funding_agency',$funding_agency,PDO::PARAM_STR);
    $query->bindParam(':budget',$budget,PDO::PARAM_STR);
    $query->bindParam(':user_id',$user_id,PDO::PARAM_STR);
    // Query Execution
    $query->execute();
    // Message for successfull insertion
    echo "<script>alert('Record successfully inserted!');</script>";
    echo "<script>window.location.href='project_index.php'</script>"; 
}
catch(PDOException $e){
    echo "<script>alert('Something went wrong. Please try again.');</script>";
    echo "<script>window.location.href='project_index.php'</script>"; 
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel = "icon" href = "../img/favicon.png" type = "image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
</head>
<body>
    
    <!-- Side navigation -->

<!-- The sidebar -->
    <div class="sidebar">
        <a class="active" href="../dashboard_faculty.php">Home</a>
        <a href="../publication_f/publication_index.php">Publication</a>
        <a href="project_index.php"><b>Project</b></a>
        <a href="../patent/patent_index.php">Patent</a>
        <a href="../setting_f.php">Change Password</a>
        <a href="../logout.php">Log Out</a>
    </div>
<!-- Page content -->
<div class="content">
    <div class="header">
        <h2>Academic Records Management System</h2>
        <h4 style="color: #1e1f1f;">Subheading</h4>
    </div><hr>

    <div class="container"> 
        <div class="add-form" >
            <h3>Add Project</h3><hr>
                <form action="add_project.php" method="post" id="fileForm" role="form">

                    <div class="form-group">   
                        <label for="title"><span class="req"></span>Project Title: </label>
                        <input class="form-control" type="text" name="title" id = "txt" required />
                    </div><br>
                    <div class="form-group">   
                        <label for="Date"><span class="req"></span> Date: </label>
                        <input class="form-control" type="date" name="date" id = "txt" required />
                    </div><br>
                    <div class="form-group">
                        <label for="status">Status: </label>
                        <select name="status" class="form-select" id="status">
                          <option selected value="completed" >Completed</option>
                          <option value="ongoing">Ongoing</option>
                          <option value="proposed">Proposed</option>
                        </select>
                    </div><br>
                    <div class="form-group">   
                        <label for="funding_agency"><span class="req"></span> Funding agency: </label>
                        <input class="form-control" type="text" name="funding_agency" id = "txt" placeholder=""/>
                    </div><br>

                    <div class="form-group">   
                        <label for="description"><span class="req"></span>Description: </label>
                        <textarea rows = "5" cols = "100" name = "description" placeholder="Description about project" required></textarea>
                    </div><br>
                    <div class="form-group">   
                        <label for="title"><span class="req"></span>Budget: </label>
                        <input class="form-control" type="text" name="budget" id = "txt" required />
                    </div>
                    
                    <div class="form-group">
                        <hr>
                        <input class="btn btn-success" type="submit" name="add" value="Add Project">
                    </div>
                </form>
            <hr>
        </div>
    </div> 
</div>
<?php include "../components/footer.html"; ?>
</body>
</html>