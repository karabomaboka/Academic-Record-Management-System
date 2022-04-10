<?php 
session_start();
if(!isset($_SESSION['sess_email']) || $_SESSION['sess_category'] != 'Faculty') 
{
    header('location: login.php');
}  
  
?>


<?php
// include database connection file
include("../components/connection.php");

if(isset($_POST['update']))  //update form is below on same file
{
// Get the project_id
$patent_id=intval($_GET['patent_id']);
// Posted Values  
$title=$_POST['title'];
$year=$_POST['year'];
$status=$_POST['status'];
$description=$_POST['description'];

// Query for Query for Updation
$sql="update patent set title=:title,year=:year,status=:status,description=:description where patent_id=$patent_id";
//Prepare Query for Execution
$query = $con->prepare($sql);
// Bind the parameters
$query->bindParam(':title',$title,PDO::PARAM_STR);
$query->bindParam(':year',$year,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
// Query Execution
$query->execute();
// Mesage after updation
echo "<script>alert('Record successfully updated!');</script>";
// Code for redirection
echo "<script>window.location.href='patent_index.php'</script>"; 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Research</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
     <!-- Optional JavaScript; choose one of the two! -->
     <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> -->
    <link rel = "icon" href = "../img/favicon.png" type = "image/x-icon">
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
</head>
<body>
    
    <!-- Side navigation -->

<!-- The sidebar -->
<div class="sidebar">
  <a class="active" href="../dashboard_faculty.php">Home</a>
  <a href="../publication_f/publication_index.php">Publication</a>
  <a href="../project_f/project_index.php">Project</a>
  <a href="patent_index.php"><b>Patent</b></a>
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
        $patent_id=intval($_GET['patent_id']);
        $sql = "SELECT * from patent where patent_id=$patent_id";
        //Prepare the query:
        $query = $con->prepare($sql);
        //Bind the parameters
        // $query->bindParam(':patent_id',$patent_id,PDO::PARAM_STR);
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


            <div class="add-form" >
            <div class="container"> 
            
            <h3>Update Patent</h3><hr>
                <form name="insertrecord" method="post" id="fileForm" role="form">

                    <div class="form-group">   
                        <label for="title"><span class="req"></span> Title: </label>
                        <input type="text" name="title" value="<?php echo htmlentities($result->title);?>" class="form-control" required>
                    </div><br>

                    <div class="form-group">   
                        <label for="year"><span class="req"></span> Year: </label>
                        <input type="number" name="year" min="2000" max="2100" value="<?php echo htmlentities($result->year);?>" class="form-control" required>
                    </div><br>
                    <div class="form-group">
                        <label for="status"> Status: </label>
                        <select name="status" class="form-select" id="status">
                          <option selected value="Granted">Granted</option>
                          <option value="Applied">Applied</option>
                        </select>
                    </div><br>

                    <div class="form-group">   
                        <label for="Description"><span class="req">Description</span> </label>
                        <textarea class="form-control" name="description" required><?php echo htmlentities($result->description);?></textarea>
                    </div>
                    
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



