<?php 
    // setcookie("loggedin", "", time()-3600); //cookie weggooien, time-3600 is om de cookie terug in de tijd te nemen
    session_start(); //server weet wie wij zijn, met welke data
    session_destroy();
    header('location: index.php');