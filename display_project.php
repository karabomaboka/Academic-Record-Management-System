<?php
require('components/connection.php');
if(isset($_POST['clear']))
{
  $sql = "SELECT user.name as project_by,user.category,user.department,title,YEAR(date_of_project) as Year,status,funding_agency,description,budget from project INNER JOIN user ON user.user_id = project.user_id order by user.name";
  // Prepare the query:
  $query = $con->prepare($sql);
  //Execute the query:
  $query->execute();
  //Assign the data which you pulled from the database (in the preceding step) to a variable.
  $results=$query->fetchAll(PDO::FETCH_OBJ);
}

else if(isset($_POST['submit']))
{
  $category=$_POST['category'];
  $department=$_POST['department'];
  $year=$_POST['year'];

  if($category=='none' && $department == 'none' && $year==null )
    {
      $sql = "SELECT user.name as project_by,user.category,user.department,title,YEAR(date_of_project) as Year,status,funding_agency,description,budget from project INNER JOIN user ON user.user_id= project.user_id order by user.name";
      $query = $con->prepare($sql);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
    }
            
    else if($category=='none' && $department == 'none' && $year !=null)
    {
      $sql = "SELECT user.name as project_by,user.category,user.department,title,YEAR(date_of_project) as Year,status,funding_agency,description,budget from project INNER JOIN user ON user.user_id= project.user_id where YEAR(date_of_project)=".':year order by user.name';
      $query = $con->prepare($sql);
      $query->bindParam('year', $year, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
    }


    else if($category!='none' && $department == 'none' && $year==null)
    {
      $sql = "SELECT user.name as project_by,user.category,user.department,title,YEAR(date_of_project) as Year,status,funding_agency,description,budget from project INNER JOIN user ON user.user_id= project.user_id where user.category=".':category order by user.name';
      $query = $con->prepare($sql);
      $query->bindParam('category', $category, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
    }

    else if($category!='none' && $department == 'none' && $year!=null)
    {
      $sql = "SELECT user.name as project_by,user.category,user.department,title,YEAR(date_of_project) as Year,status,funding_agency,description,budget from project INNER JOIN user ON user.user_id= project.user_id where user.category=".':category and YEAR(date_of_project)='.':year order by user.name';
      $query = $con->prepare($sql);
      $query->bindParam('category', $category, PDO::PARAM_STR);
      $query->bindParam('year', $year, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
    }

    else if($category=='none' && $department != 'none' && $year==null)
    {
      $sql = "SELECT user.name as project_by,user.category,user.department,title,YEAR(date_of_project) as Year,status,funding_agency,description,budget from project INNER JOIN user ON user.user_id= project.user_id where user.department=".':department order by user.name';
      $query = $con->prepare($sql);
      $query->bindParam('department', $department, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
    }

    else if($category=='none' && $department != 'none' && $year!=null)
    {
      $sql = "SELECT user.name as project_by,user.category,user.department,title,YEAR(date_of_project) as Year,status,funding_agency,description,budget from project INNER JOIN user ON user.user_id= project.user_id where user.department=".':department and YEAR(date_of_project)='.':year order by user.name';
      $query = $con->prepare($sql);
      $query->bindParam('department', $department, PDO::PARAM_STR);
      $query->bindParam('year', $year, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);

    }

    else if($category!='none' && $department != 'none' && $year==null)
    {
      $sql = "SELECT user.name as project_by,user.category,user.department,title,YEAR(date_of_project) as Year,status,funding_agency,description,budget from project INNER JOIN user ON user.user_id= project.user_id where user.department=".':department and user.category='.':category order by user.name';
      $query = $con->prepare($sql);
      $query->bindParam('department', $department, PDO::PARAM_STR);
      $query->bindParam('category', $category, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
    }


    else
    {
      $sql = "SELECT user.name as project_by,user.category,user.department,title,YEAR(date_of_project) as Year,status,funding_agency,description,budget from project INNER JOIN user ON user.user_id = project.user_id where user.category=".':category'." and user.department=".':department'." and YEAR(date_of_project)=".':year order by user.name';
      $query = $con->prepare($sql);            
      $query->bindParam('category', $category, PDO::PARAM_STR);
      $query->bindParam('department', $department, PDO::PARAM_STR);
      $query->bindParam('year', $year, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
    } 

}

else
{
  
$sql = "SELECT user.name as project_by,user.category,user.department,title,YEAR(date_of_project) as Year,status,funding_agency,description,budget from project INNER JOIN user ON user.user_id = project.user_id order by user.name";
// Prepare the query:
$query = $con->prepare($sql);
//Execute the query:
$query->execute();
//Assign the data which you pulled from the database (in the preceding step) to a variable.
$results=$query->fetchAll(PDO::FETCH_OBJ);
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
  <title>Projects</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- css -->
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/tableDisplay.css">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
  </script>

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
  <!-- favicon link -->
  <link rel="icon" href="img/favicon.png" type="image/x-icon">
</head>

<body>

  <!-- navigation bar -->
  <?php include "components/header.php" ?>

  <div class="search">
    <form name="display_project.php" method="post" id="fileForm" role="form" class="row gy-2 gx-3 align-items-center">

      <div class="col-md-3 col-md-offset-2">

        <label class="visually-hidden" for="category"></label>
        <select name="category" class="form-select" id="category" required>
          <option selected value="none">Category (All)</option>
          <option value="student">Student</option>
          <option value="faculty">Faculty</option>
        </select>
      </div>

      <div class="col-md-3 col-md-offset-2">
        <label class="visually-hidden" for="department">Preference</label>
        <select name="department" class="form-select" id="department" required>
          <option selected value="none">Department (All)</option>
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
      </div>
       <div class="col-md-3 col-md-offset-2">
          <input class="form-control" type="number" min="2000" max="2021" name="year" id="year" placeholder="Year (Leave blank for all)" value="none">
        </div> 
      <div class="col-md-3 col-md-offset-2">
        <input class="btn btn-success" type="submit" name="submit" value="Search">
        <input class="btn btn-success" type="submit" name="clear" value="Clear">
      </div>

    </form>


  </div><br>
  <hr><br>


  <?php if($query->rowCount() > 0) ?>
  <div class="container">
    <div class="home_display">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h3><b>Project</b></h3>
            <hr />
            <div class="table-responsive"><br>
              <table id="mytable" class="table table-bordred table-striped">
                <thead>
                  <th>#</th>
                  <th>Project by</th>
                  <th>Category</th>
                  <th>Department</th>
                  <th>Title</th>
                  <th>Status</th>
                  <th>Funding Agency</th>
                  <th>Description</th>
                  <th>Year</th>
                  <th>Budget</th>
                </thead>

                <tbody>

                  <?php 
                // $sql = "SELECT user.name as project_by,user.category,user.department,title,YEAR(date_of_project) as Year,weblink,description,budget from project INNER JOIN user ON user.user_id = project.user_id";
                // //Prepare the query:
                // $query = $con->prepare($sql);
                // //Execute the query:
                // $query->execute();
                // //Assign the data which you pulled from the database (in the preceding step) to a variable.
                // $results=$query->fetchAll(PDO::FETCH_OBJ);
                // For serial number initialization
                $cnt=1;

                if($query->rowCount() > 0)
                {
                //In case that the query returned at least one record, we can echo the records within a foreach loop:
                foreach($results as $result)
                {               
                ?>
                  <tr>
                    <td><?php echo htmlentities($cnt);?></td>
                    <td><?php echo htmlentities($result->project_by);?></td>
                    <td><?php echo htmlentities($result->category);?></td>
                    <td><?php echo htmlentities($result->department);?></td>
                    <td><?php echo htmlentities($result->title);?></td>
                    <td><?php echo htmlentities($result->status);?></td>
                    <td><?php echo htmlentities($result->funding_agency);?></td>
                    <td><?php echo htmlentities($result->description);?></td>
                    <td><?php echo htmlentities($result->Year);?></td>
                    <td><?php echo htmlentities($result->budget);?></td>
                  </tr>
                  <?php    $cnt++;
                }}

                else{
                  echo "No record found!<br>"; }
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