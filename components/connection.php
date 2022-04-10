<?php
define('DB_SERVER', ''); // enter database server name here
define('DB_USERNAME', ''); //enter username here
define('DB_PASSWORD', ''); // password here
define('DB_NAME', ''); // name of database here
 
/* Attempt to connect to MySQL database */
try{
    $con = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>