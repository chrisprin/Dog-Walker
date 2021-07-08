<?php
 session_start();
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "dogwalkingcompany";

//connect
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

//initialize prepared statement
$logstmt = mysqli_stmt_init($conn);
//prepare sql query
mysqli_stmt_prepare($logstmt, "SELECT customerID FROM customers WHERE username = ? AND password = ?");
//bind the variables to the parameters of the statement
mysqli_stmt_bind_param($logstmt, "ss", $username, $password);

 
//variables
$username = $password = $err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = check_empty($_POST["username"]);
  $password = check_empty($_POST["password"]);
  //now that we have the variables, execute prepared statement
  mysqli_stmt_execute($logstmt);
  //bind the results of the statement to new variables
  mysqli_stmt_bind_result($logstmt, $col1);
  //go through the results and print
  //while (mysqli_stmt_fetch($logstmt)) {
  //  printf("Here is what I got %s %s\n", $col1, $col2);
  //}
    
	//checks if statement returned any rows, if yes bind ID to session variable
  if (mysqli_stmt_fetch($logstmt) > 0) {
  $_SESSION["userID"] = $col1;
  echo "Session ID set to " . $_SESSION["userID"];
  header("Location: home.php");
    exit;
  } else {
  echo "Incorrect username or password";
  }
  
  
}

function check_empty($data){
	global $err;
	if (empty($data)) {
    $err = "Username and Password are required";
  } else {
    $data = test_input($data);
    return $data;
  }
}

function test_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<html>
 <head>
  <title>Login</title>
 </head>
 <body>
 
 <h1> Login </h1>
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
 <h3><span class="error"><?php echo $err;?></span></h3>
 <h2>
 Username: <input type="text" name="username" value="<?php echo $username;?>"><br>
 Password: <input type="text" name="password" value="<?php echo $password;?>"><br>
 <input type="submit" value="Login">
 </h2>
 
 </form>
 
 <h3> <button type="button">Sign Up</button> </h3>
 <h3> <button type="button">Employee Login</button> </h3>
 </body>
</html>
