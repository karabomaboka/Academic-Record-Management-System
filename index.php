<?php $pagename='HOME'; ?>

<?php
require('components/connection.php');

$user = $con->query('SELECT COUNT(*) FROM user')->fetchColumn();
$publication = $con->query('SELECT COUNT(*) FROM publication')->fetchColumn();
$project = $con->query('SELECT COUNT(*) FROM project')->fetchColumn();
$patent = $con->query('SELECT COUNT(*) FROM patent')->fetchColumn();
$alumni = $con->query("SELECT COUNT(*) FROM alumni where verified = '1'")->fetchColumn();
$con = null;
?>


<!doctype html>
<html lang="en">

<head>
  <?php include 'components/head.html'; ?>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/egg.js/1.0/egg.min.js"></script>
  <title>Home</title>
</head>

<body>
  <?php include('components/header.php'); ?>
  <!-- <div class="container-fluid" id="main-para"> -->
  <div id="main-para" style="padding-left: 7%; padding-right: 7%;">
    <h2><b> Welcome!</b></h2>
    <ul>
      <li>This is a CRUD based CMS project.</li>
      <li>To view all publications, research or projects, click the cards below or navigate through the navigation bar.</li>
      <li>To add your data, first signup and then login to add.</li>
      <li>To register as an alumni, select alumni in navigation bar and click register.</li>
    </ul>

    <!-- boxes of research, project and project with details start here -->
    <div class="row">
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><b>Publications</b></h5>
            <p class="card-text">Papers published by the faculty and students of the college.</p>
            <a href="display_publication.php" class="btn btn-primary">Explore</a>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><b>Patents</b></h5>
            <p class="card-text">Patents filed by the faculty of the college.</p>
            <a href="display_patent.php" class="btn btn-primary">Explore</a>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><b>Projects</b></h5>
            <p class="card-text">Projects done by the faculty and students of the college.</p>
            <a href="display_project.php" class="btn btn-primary">Explore</a>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><b>Alumni</b></h5>
            <p class="card-text">View a list of all resistered alumni.</p>
            <a href="display_alumni.php" class="btn btn-primary">Explore</a>
          </div>
        </div>
      </div>
    </div>


  </div>


  <!-- boxes describing stats of the data in database -->
  <div class="container-fluid" id="container-stats">
    <div class="row">

      <div class="col stats-box">
        <div>
          <h3>Total Users</h3>
        </div>
        <div>
          <h3><?php echo $user ?></h3>
        </div>
      </div>

      <div class="col stats-box">
        <div>
          <h3>Total Publications</h3>
        </div>
        <div>
          <h3><?php echo $publication ?></h3>
        </div>
      </div>

       <div class="col stats-box">
        <div>
          <h3>Total Patents</h3>
        </div>
        <div>
          <h3><?php echo $patent ?></h3>
        </div>
      </div>

      <div class="col stats-box">
        <div>
          <h3>Total Projects</h3>
        </div>
        <div>
          <h3><?php echo $project ?></h3>
        </div>
      </div>
      <div class="col stats-box">
        <div>
          <h3>Alumni Registered</h3>
        </div>
        <div>
          <h3><?php echo $alumni ?></h3>
        </div>
      </div>

     
    </div>
  </div>


  <?php include('components/footer.html'); ?>


</body>

</html>