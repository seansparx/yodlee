<?php
    include_once 'src/yodlee.php';
    
    if($_SESSION['cobSessionToken']) {
        $obj = new YodleeAggregation();
        $obj->userSessionToken();
    }
    else{
        die('session token not found.');
    }
    
?>