<?php
    session_start();

    //echo '<pre>';
    
    //print_r($_SESSION);
    
    if($_SESSION['cobSessionToken']) {
        include_once 'src/userSessionToken.php';
    }
    else{
        die('session token not found.');
    }
    
?>