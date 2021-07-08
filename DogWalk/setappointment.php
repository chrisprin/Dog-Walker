<?php
session_start();
var_dump($_SESSION);
?>

<html>
 <head>
  <title>Home</title>
 </head>
 <body>
 
 <h1> Scheduled Walks </h1>
 <form action="welcome.php" method="post">
Name: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
<input type="submit">
</form>

 
 </body>
</html>