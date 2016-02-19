<?php
    include_once 'src/yodlee.php';
    
    $obj = new YodleeAggregation();
    $obj->searchTransactions($_GET['itemAccountId']);
?>