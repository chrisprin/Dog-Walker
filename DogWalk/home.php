<?php
session_start();
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "dogwalkingcompany";
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
$dogquery = "SELECT d.name, d.dogID FROM dogs AS d, customers AS c, customers_dogs AS cd
WHERE c.customerID = cd.FK_customerID && d.dogID = cd.FK_dogID && c.customerID = " . $_SESSION["userID"];
$doglist = mysqli_query($conn, $dogquery);

$dogid = '';

//get dog id from button
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['getDogID'])) {
  $dogid = intval($_POST["getDogID"]);
  showDogInfo($dogid);
}

//Go to dog info page
function showDogInfo($dogid)
{
  $_SESSION["dogID"] = $dogid;
  header("Location: displaydog.php");
  exit;
}

?>

<html>

<head>
  <title>Home</title>
</head>

<body>

  <h1> Your Dogs: </h1>
  <?php
  if (mysqli_num_rows($doglist) > 0) {

    echo '<form action="home.php" method="post">';

    while ($row = mysqli_fetch_assoc($doglist)) {
      echo "<button name='getDogID' value='" . $row["dogID"] . "' type='submit'>" . $row["name"] . "</button>";
    }
    echo '</form>';
  } else {
    echo "No dogs!!!";
  }

  ?>

  <form action="adddog.php">
    <input type="submit" value="Add New Dog" />
  </form>
  <a href="signout.php">Sign Out.</a>

</body>

</html>