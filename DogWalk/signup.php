<?php
session_start();
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "dogwalkingcompany";
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

$err = $firstName = $lastName = $username = $password = $dogName = $newCustomerID = $newDogID = "";

//init prep statements
$customerStmt = mysqli_stmt_init($conn);
$dogStmt = mysqli_stmt_init($conn);
$combineStmt = mysqli_stmt_init($conn);
//prep statements
mysqli_stmt_prepare($customerStmt, "INSERT INTO customers (firstName, lastName, username, password) VALUES (?, ?, ?, ?);");
mysqli_stmt_prepare($dogStmt, "INSERT INTO dogs (name) VALUES (?);");
mysqli_stmt_prepare($combineStmt, "INSERT INTO customers_dogs (FK_customerID, FK_dogID) VALUES (?, ?);");
//bind variables
mysqli_stmt_bind_param($customerStmt, "ssss", $firstName, $lastName, $username, $password);
mysqli_stmt_bind_param($dogStmt, "s", $dogName);
mysqli_stmt_bind_param($combineStmt, "ii", $newCustomerID, $newDogID);


if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['signup'])){
    //set variables to inputted values
    $firstName = check_empty($_POST["firstname"]);
    $lastName = check_empty($_POST["lastname"]);
    $username = check_empty($_POST["username"]);
    $password = check_empty($_POST["password"]);
    $dogName = check_empty($_POST["dogname"]);

    if ($firstName && $lastName && $username && $password && $dogName){
        //execute first statement
        mysqli_stmt_execute($customerStmt);
        //assign new customer ID to variable
        $newCustomerID = mysqli_insert_id($conn);
        //execute second statement
        mysqli_stmt_execute($dogStmt);
        //assign new dog ID to variable
        $newDogID = mysqli_insert_id($conn);
        //execute combine statement using those primary key IDs
        mysqli_stmt_execute($combineStmt);
    }
}


//copied from signin.php. later move functions to separate file and use
//this function could use an error string parameter to specify what field is empty
function check_empty($data)
{
  global $err;
  if (empty($data)) {
    $err = "All fields are required";
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

    <h1> Create Account </h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3><span class="error"><?php echo $err; ?></span></h3>
        <h2>
            First Name: <input type="text" name="firstname" value="<?php echo $firstName; ?>"><br>
            Last Name: <input type="text" name="lastname" value="<?php echo $lastName; ?>"><br>
            Username: <input type="text" name="username" value="<?php echo $username; ?>"><br>
            Password: <input type="text" name="password" value="<?php echo $password; ?>"><br>
            Dog Name: <input type="text" name="dogname" value="<?php echo $dogName; ?>"><br>
            <input name="signup" type="submit" value="Complete Registration">
        </h2>
    </form>
    <form action="signin.php" method="post">
      <input name="cancel" type="submit" value="Cancel Registration">
  </form>
</body>

</html>