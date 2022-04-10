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

if(isset($_POST['update']))  //update form is below on same file
{
// Get the project_id
$project_id=intval($_GET['p_id']);
// Posted Values  
$title=$_POST['title'];
$date=$_POST['date'];
$status=$_POST['status'];
$description=$_POST['description'];
$budget=$_POST['budget'];
$funding_agency = $_POST['funding_agency'];

// Query for Query for Updation
$sql="update project set title=:title,date_of_project=:date,status=:status,funding_agency=:funding_agency,description=:description ,budget=:budget where project_id=$project_id";
//Prepare Query for Execution
$query = $con->prepare($sql);
// Bind the parameters
    $query->bindParam(':title',$title,PDO::PARAM_STR);
    $query->bindParam(':description',$description,PDO::PARAM_STR);
    $query->bindParam(':date',$date,PDO::PARAM_STR);
    $query->bindParam(':status',$status,PDO::PARAM_STR);
    $query->bindParam(':funding_agency',$funding_agency,PDO::PARAM_STR);
    $query->bindParam(':budget',$budget,PDO::PARAM_STR);
// Query Execution
$query->execute();
// Mesage after updation
echo "<script>alert('Record successfully updated!');</script>";
// Code for redirection
echo "<script>window.location.href='project_index.php'</script>"; 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Project</title>
    <!-- Bootstrap CSS -->
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
        <h1>Academic Records Management System</h1>
        <h3 style="color: #1e1f1f;">Subheading</h3>
    </div><hr>

        <?php 
        // Get the project_id
        $project_id=intval($_GET['p_id']);
        $sql = "SELECT * from project where project_id=$project_id";
        //Prepare the query:
        $query = $con->prepare($sql);
        //Bind the parameters
        // $query->bindParam(':p_id',$project_id,PDO::PARAM_STR);
        //Execute the query:
        $query->execute();
        //Assign the data which you pulled from the database (in the preceding step) to a variable.
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        // For serial number initialization
        $cnt=1;
        if($query->rowCount() > 0)
        {
            //In case that the query returned at least one record, we can echo the records within a foreach loop:
            foreach($results as $result)
        {               
        ?>



            <div class="container"> 
            <div class="add-form" >
            <h3>Update Project</h3><hr>
                <form name="insertrecord" method="post" id="fileForm" role="form">

                    <div class="form-group">   
                        <label for="title"><span class="req"></span>Project Title: </label>
                        <input type="text" name="title" value="<?php echo htmlentities($result->title);?>" class="form-control" required>
                    </div><br>


                    <div class="form-group">   
                        <label for="Date"><span class="req"></span> Date: </label>
                        <input type="date" name="date" value="<?php echo htmlentities($result->date_of_project);?>" class="form-control" required>
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
                        <input class="form-control" type="text" name="funding_agency" id = "txt" value="<?php echo htmlentities($result->funding_agency);?>" />
                    </div><br>

                    <div class="form-group">   
                        <label for="Description"><span class="req">Description</span> </label>
                        <textarea class="form-control" name="description" required><?php echo htmlentities($result->description);?></textarea>
                    </div><br>


                    <div class="form-group">   
                        <label for="title"><span class="req"></span>Budget: </label>
                        <input name="budget" value="<?php echo htmlentities($result->budget);?>" class="form-control" placeholder="in ₹" required>
                    </div><br>

                    
                    <div class="form-group">
                        <hr>
                        <input class="btn btn-success" type="submit" name="update" value="Update">
                    </div>
                </form>
            <hr>
        </div>
        
        <?php }} ?>
        </div>
 </div>
<?php include "../components/footer.html"; ?>
</body>
</html>



