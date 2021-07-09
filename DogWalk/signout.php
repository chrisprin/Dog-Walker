<?php
session_start();
?>
<html>
    <head></head>
    <body>
        <?php
        //unset session variables
        session_unset();
        
        //destroy session
        session_destroy();
        
        //return to login
        header('Location: signin.php');
        ?>
    </body>
</html>