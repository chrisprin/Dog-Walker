<?php
session_start();
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "dogwalkingcompany";
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

//Query pulls the days that the logged in user is scheduled for in chronological order
$scheduledDaysQuery =  "SELECT DISTINCT date(date_format(s.scheduleTime, '%Y-%m-%d')) 'ScheduledTime'
                        FROM schedule AS s, employees AS e, dogs AS d
                        WHERE e.employeeID = s.FK_employeeID
                        AND d.dogID = s.FK_dogID
                        AND e.employeeID = '" . $_SESSION["userID"] . "'
                        GROUP BY date(date_format(s.scheduleTime, '%Y-%m-%d'))
                        ORDER BY s.scheduleTime ASC";
$scheduledDays = mysqli_query($conn, $scheduledDaysQuery);

$selectedTime = $err = '';

?>

<html>

<head>
    <title>Home</title>
</head>

<body>
    <h1> Scheduled Walks </h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Select Date: <select name="listdate">
            <option value="">Select...</option>
            <?php
            while ($scheduleArray = mysqli_fetch_array($scheduledDays, MYSQLI_ASSOC)) {
                $formattedTime = getDate(date(strtotime($scheduleArray['ScheduledTime'])));
                echo "<option value='" . $scheduleArray['ScheduledTime'] . "'>$formattedTime[weekday], $formattedTime[month] $formattedTime[mday]</option>";
            }
            ?>
        </select>
        <br>
        <input type="submit">
    </form>

    <?php
    //Only runs after date is selected
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedTime = $_POST["listdate"];

        //Use the selected drop down option to show all appointments of that day and what dog it is with
        $listAppointmentsQuery = "SELECT s.scheduleTime 'ScheduledTime', d.name 'DogName'
        FROM schedule AS s, employees AS e, dogs AS d
        WHERE e.employeeID = s.FK_employeeID
        AND d.dogID = s.FK_dogID
        AND e.employeeID = 1
        AND s.scheduleTime LIKE '" . $selectedTime . "%'
        ORDER BY s.scheduleTime ASC";
        $scheduleDetails = mysqli_query($conn, $listAppointmentsQuery);

        if ($selectedTime) {
            //List the scheduled Dates
            $formattedTime = date("m-d-Y", strtotime($selectedTime));
            echo "Your Walks on $formattedTime";
            echo "<ul>";
            while ($detailsArray = mysqli_fetch_array($scheduleDetails, MYSQLI_ASSOC)) {
                $formattedTime = date("h A", strtotime($detailsArray["ScheduledTime"]));
                echo "<li>" . $detailsArray["DogName"] . " at " . $formattedTime . "</li>";
            }
            echo "</ul>";
        } else {
            $err = "Please select a date.";
            echo $err;
        }
    }
    ?>
</body>
<a href="signout.php">Sign Out.</a>

</html>