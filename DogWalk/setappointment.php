<?php
session_start();
var_dump($_SESSION);
?>

<html>

<head>
    <title>Home</title>
</head>

<body>

    <h1> Schedule a walk </h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" method="post">
        <h3>Date:</h3>
        <select name="day">
            <?php
            for ($i = 1; $i <= 31; $i++) {
                echo "<option value='" . $i . "'>" . $i . "</option>";
            }
            ?>
        </select>

        <input name="setappointment" type="submit" value="Schedule A Walk">
    </form>
    <a href="signout.php">Sign Out.</a>



</body>

</html>