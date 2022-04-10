
<?php
require('components/connection.php');
if(isset($_POST['clear']))
{
  $sql = "SELECT name , email, college_id, batch, department, phno, company, designation from alumni where verified = '1' order by batch asc";
  $query = $con->prepare($sql);
  $query->execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
}

else if(isset($_POST['submit']))
{
  $department=$_POST['department'];
  $batch=$_POST['batch'];

  if($department == "all" && $batch == null)
  {
    $sql = "SELECT name , email, college_id, batch, department, phno, company, designation from alumni where verified = '1' order by batch asc";
    $query = $con->prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
  }

  else if ($department == "all" && $batch != null)
  {
    $sql = "SELECT name , email, college_id, batch, department, phno, company, designation from alumni where batch = :batch and verified = '1' order by batch asc";
    $query = $con->prepare($sql);
    $query->bindParam('batch', $batch, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
  } 

  else if ($batch == null)
  {
    $sql = "SELECT name , email, college_id, batch, department, phno, company, designation from alumni where department = :department and verified = '1' order by batch asc";
    $query = $con->prepare($sql);
    $query->bindParam('department', $department, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
  }
  else
  {    
    $sql = "SELECT name , email, college_id, batch, department, phno, company, designation from alumni where batch = :batch and department = :department and verified = '1' order by batch asc";
    $query = $con->prepare($sql);
    $query->bindParam('batch', $batch, PDO::PARAM_STR);
    $query->bindParam('department', $department, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
  }
}

else
{
  $sql = "SELECT name , email, college_id, batch, department, phno, company, designation from alumni where verified = '1' order by batch asc";
  $query = $con->prepare($sql);
  $query->execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
}

?>






<!DOCTYPE html>
<html lang="en">
<head>
  <title>Alumni</title>
 <!-- Required meta tags -->
 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/tableDisplay.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
    <!-- favicon link -->
    <link rel = "icon" href = "img/favicon.png" type = "image/x-icon">
</head>



<body>

      <!-- navigation bar -->
<?php include "components/header.php" ?>
             <div class="search">
                          <form name="display_research.php" method="post" id="fileForm" role="form" class="row gy-2 gx-3 align-items-center" required>

                                  <div class="col-md-4 col-md-offset-2">
                                    <label class="visually-hidden" for="department">Preference</label>
                                    <select name="department" class="form-select" id="department" required>
                                      <option value="all">Department (ALL) </option>
                                      <option value="EE">Electrical Engineering</option>
                                      <option value="IT">Information Technology</option>
                                      <option value="ECE">Electronics and Communication Engg.</option>
                                      <option value="IPE">Industrial & Production Engg.</option>
                                      <option value="CE">Civil Engineering</option>
                                      <option value="CSE">Computer Engineering</option>
                                      <option value="ME">Mechanical Engineering</option>
                                    </select>
                                  </div>

                                  <div class="col-md-4 col-md-offset-2">
                                    <input class="form-control" type="number" name="batch" id="batch" placeholder="Batch Year (Leave blank for all)" value=null min="1980" max="2017">
                                  </div>  

                                  <div class="col-md-3 col-md-offset-2">
                                  <input class="btn btn-success" type="submit" name="submit" value="Search">
                                  <input class="btn btn-success" type="submit" name="clear" value="Clear">
                                  </div>

                            </form>

            </div><br><hr><br>

<div class="container">
  <div  class= "home_display">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3><b>View alumni details</b></h3> <hr />
                <div class="table-responsive"><br>               
                <table id="mytable" class="table table-bordred table-striped">                 
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>College ID</th>
                        <th>Batch</th>
                        <th>Department</th>
                        <th>Phone No.</th>
                        <th>Company</th>
                        <th>Designation</th>
                    </thead>

                    <tbody>
    
                <?php 
                $cnt=1;

                if($query->rowCount() > 0)
                {
                //In case that the query returned at least one record, we can echo the records within a foreach loop:
                foreach($results as $result)
                {               
                ?>  
                <tr>
                    <td><?php echo htmlentities($cnt);?></td>
                    <td><?php echo htmlentities($result->name);?></td>
                    <td><?php echo htmlentities($result->email);?></td>
                    <td><?php echo htmlentities($result->college_id);?></td>
                    <td><?php echo htmlentities($result->batch);?></td>
                    <td><?php echo htmlentities($result->department);?></td>
                    <td><?php echo htmlentities($result->phno);?></td>
                    <td><?php echo htmlentities($result->company);?></td>
                    <td><?php echo htmlentities($result->designation);?></td>
                </tr>
                <?php    $cnt++;
                }}

                else{
                  echo '<strong>No results!</strong><div>'; }
              ?>
                </tbody>     
            </table>
            
            </div>            
            </div>
        </div>
    </div>
</div>
</div>
  <?php include 'components/footer.html'; ?>  
</body>
</html>