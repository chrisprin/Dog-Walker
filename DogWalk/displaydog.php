<?php
session_start();
var_dump($_SESSION);
?>

<html>
 <head>
  <title>Home</title>
 </head>
 <body>
 
 <h1> Dog Info </h1>
 <form action="setappointment.php" method="post">
      <input name="setappointment" type="submit" value="Schedule A Walk">
  </form>
 

 
 </body>
</html>