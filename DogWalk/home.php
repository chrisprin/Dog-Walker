<?php
session_start();
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "dogwalkingcompany";
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
echo $_SESSION["userID"];
$dogstmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($logstmt, "SELECT customerID FROM customers WHERE username = ? AND password = ?");
?>

<html>
 <head>
  <title>Home</title>
 </head>
 <body>
 
 <h1> Your Dogs: </h1>
 
 <?php
 
 
 
 ?>
 
 </body>
</html>