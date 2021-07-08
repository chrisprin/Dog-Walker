<?php
session_start();
var_dump($_SESSION);
$schedulequery = "SELECT e.firstName, d.name, s.scheduleTime FROM schedule AS s, employees AS e, dogs AS d
WHERE s.FK_dogID = " . $_SESSION["dogID"] . " AND d.dogID = " . $_SESSION["dogID"] . " AND s.FK_employeeID = " . $_SESSION["userID"] . " AND e.employeeID = " . $_SESSION["userID"];
?>

<html>

<head>
    <title>Home</title>
</head>

<body>

    <h1> Scheduled Walks </h1>
    <form action="schedule.php" method="post">
        Select Date: <select name="listdate">
            <option value="">Select...</option>
        
        </select>
        <br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>


</body>

</html>