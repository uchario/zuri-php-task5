<?php
session_start();

if (isset($_POST['signout']))
{
    if (isset($_SESSION['isLogged']))
    {
        unset($_SESSION['isLogged']);
        unset($_SESSION['email']);
        session_destroy();

        header("Location:login.php");
    }
}

?>