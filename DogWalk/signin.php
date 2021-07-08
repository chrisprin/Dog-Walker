<?php
session_start();
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "dogwalkingcompany";

//connect
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
//initialize prepared statement
$customerstmt = mysqli_stmt_init($conn);
$employeestmt = mysqli_stmt_init($conn);
//prepare sql query
mysqli_stmt_prepare($customerstmt, "SELECT customerID FROM customers WHERE username = ? AND password = ?");
mysqli_stmt_prepare($employeestmt, "SELECT employeeID FROM employees WHERE username = ? AND password = ?");
//bind these variables to the parameters of the statement
mysqli_stmt_bind_param($customerstmt, "ss", $username, $password);
mysqli_stmt_bind_param($employeestmt, "ss", $username, $password);


//variables
$username = $password = $err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['customerLogin'])) {
  $username = check_empty($_POST["username"]);
  $password = check_empty($_POST["password"]);
  //now that we have the variables, execute prepared statement
  mysqli_stmt_execute($customerstmt);
  //bind the results of the statement to new variables
  mysqli_stmt_bind_result($customerstmt, $col1);

  //go through the results and print
  //while (mysqli_stmt_fetch($customerstmt)) {
  //  printf("Here is what I got %s %s\n", $col1, $col2);
  //}

  //only do this if username and password weren't empty
  if ($username && $password) {
    //checks if statement returned any rows, if yes bind ID to session variable
    if (mysqli_stmt_fetch($customerstmt) > 0) {
      $_SESSION["userID"] = $col1;
      echo "Session ID set to " . $_SESSION["userID"];
      header("Location: home.php");
      exit;
    } else {
      $err = "Incorrect username or password";
    }
  }
}

//run this if they click the employee login button
if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['employeeLogin'])) {
  $username = check_empty($_POST["username"]);
  $password = check_empty($_POST["password"]);
  mysqli_stmt_execute($employeestmt);
  mysqli_stmt_bind_result($employeestmt, $col1);
  if ($username && $password) {
    if (mysqli_stmt_fetch($employeestmt) > 0) {
      $_SESSION["userID"] = $col1;
      echo "Session ID set to " . $_SESSION["userID"];
      header("Location: schedule.php");
      exit;
    } else {
      $err = "Incorrect username or password";
    }
  }
}


//This function was originally intended to specify which field was missing input
//I couldn't figure out how to call the name of the input field whose value I passed
//works fine like this anyway
function check_empty($data)
{
  global $err;
  if (empty($data)) {
    $err = "Username and Password are required";
  } else {
    $data = test_input($data);
    return $data;
  }
}

function test_input($data)
{
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
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h3><span class="error"><?php echo $err; ?></span></h3>
    <h2>
      Username: <input type="text" name="username" value="<?php echo $username; ?>"><br>
      Password: <input type="text" name="password" value="<?php echo $password; ?>"><br>
      <input name="customerLogin" type="submit" value="Login"><br>
      <input name="employeeLogin" type="submit" value="Employee Login">

    </h2>

  </form>

  <h3> <button type="button">Sign Up</button> </h3>
</body>

</html>