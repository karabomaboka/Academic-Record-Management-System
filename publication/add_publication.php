<?php 
session_start();
if(!isset($_SESSION['sess_email']) || $_SESSION['sess_category'] != 'Student') 
{
    header('location: login.php');
} 
?>


<?php
// include database connection file
include("../components/connection.php");
if(isset($_POST['add']))
{ 
// Posted Values
$author=$_SESSION['sess_name'];  
$title=$_POST['title'];
$year=$_POST['year'];
$type = $_POST['type'];
$citation=$_POST['citation'];
$description=$_POST['description'];
$user_id=$_SESSION['sess_id'];

try{
    
// Query for Insertion
$sql="INSERT INTO publication(title,year,citation,type,description,author,user_id) VALUES(:title,:year,:citation,:type,:description,:author,:user_id)";
//Prepare Query for Execution
$query = $con->prepare($sql);
// Bind the parameters
$query->bindParam(':title',$title,PDO::PARAM_STR);
$query->bindParam(':year',$year,PDO::PARAM_STR);
$query->bindParam(':type',$type,PDO::PARAM_STR);
$query->bindParam(':citation',$citation,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':author',$author,PDO::PARAM_STR);
$query->bindParam(':user_id',$user_id,PDO::PARAM_STR);
// Query Execution
$query->execute();
    // Message for successfull insertion
    echo "<script>alert('Record successfully inserted!');</script>";
    echo "<script>window.location.href='publication_index.php'</script>"; 
}
catch(PDOException $e){
echo "<script>alert('Something went wrong. Please try again.');</script>";
echo "<script>window.location.href='publication_index.php'</script>"; 
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Publication</title>
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
  <a class="active" href="../dashboard_student.php">Home</a>
  <a href="publication_index.php"><b>Publication</b></a>
  <a href="../project/project_index.php">Project</a>
  <a href="../setting.php">Change Password</a>
  <a href="../logout.php">Log Out</a>
</div>

<!-- Page content -->
<div class="content">
    <div class="header">
        <h2>Academic Records Management System</h2>
        <h4 style="color: #1e1f1f;">Subheading</h4>
    </div><hr>
<div class="add-form" >
    <div class="container"> 
        
            <h3>Add publication</h3><hr>
                <form action="add_publication.php" method="post" id="fileForm" role="form">
                    <div class="form-group">
                        <label for="status"> Type: </label>
                        <select name="type" class="form-select" id="type">
                          <option value="National Conference" >National Conference</option>
                          <option value="International Conference">International Conference</option>
                          <option value="Book Chapter">Book chapter</option>
                          <option selected value="Other">Other</option>
                        </select>
                    </div><br>

                    <div class="form-group">   
                        <label for="title"><span class="req"></span> Title: </label>
                        <input class="form-control" type="text" name="title" id = "txt" required />
                    </div><br>

                    <div class="form-group">   
                        <label for="year"><span class="req"></span> Year: </label>
                        <input class="form-control" type="number" min="2000" max="2100" name="year" id = "year" required />
                    </div><br>
                    

                    <div class="form-group">   
                        <label for="citation"><span class="req"></span> Citation: </label>
                        <input class="form-control" type="text" name="citation" id = "citation" placeholder="enter N/A if unavailable" >
                    </div><br>

                    <div class="form-group">   
                        <label for="description"><span class="req"></span> Description: </label>
                        <textarea rows = "5" cols = "100" id="description" name = "description" placeholder="Description about publication" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <hr>
                        <input class="btn btn-success" type="submit" name="add" value="Add Publication">
                    </div>
                </form>
            <hr>
        </div>
    </div> 
</div>
<?php include "../components/footer.html"; ?>
</body>
</html>