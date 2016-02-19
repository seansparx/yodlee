<?php
    include_once 'src/yodlee.php';
    
    if(isset($_POST['submit']) && $_POST['submit'] == 'user_login'){
        $obj = new YodleeAggregation();
        $obj->login();
    }
    
?>

<!DOCTYPE html>
<HTML>
    <HEAD>
        <title>Demo - Login</title>
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="css/codemirror.css">
        <link rel="stylesheet" href="css/eclipse.css">
        <style>
        body{
        padding: 10px;	
        }
        .c-method{
        margin-left: 20px;
        }
        </style>
    </HEAD>
    <BODY>
        <h5>Please login</h5>
        <form action="" method="post">
            <input type="text" value="sbMemsean.rock1" placeholder="Enter username" name="username"/>
            <input type="password" value="sbMemsean.rock1#123" placeholder="Enter password" name="passwd"/>
            <input type="submit" name="submit" value="user_login"/>
        </form>
    </BODY>
</HTML>