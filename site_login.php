<?php
    include_once 'src/yodlee.php';
    
    if(isset($_POST['submit']) && (trim($_POST['login'])!='') && (trim($_POST['passwd'])!='')){
        $obj = new YodleeAggregation();
        $obj->addSiteAccount($_GET['site'], $_POST['login'], $_POST['passwd']);
        exit;
    }
    else{
        ?>
        <!DOCTYPE html>
        <HTML>
            <HEAD>
                <title>Demo - Step 3</title>
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
                <h5>Username : <?php echo $_SESSION['login_response']['Body']->loginName . ' (' . $_SESSION['login_response']['Body']->userId . ')'; ?></h5>
                <b>Please login to add your account</b>
                <form action="" method="post">
                    <input type="text" value="" placeholder="Enter site login" name="login"/>
                    <input type="password" value="" placeholder="Enter site password" name="passwd"/>
                    <input type="submit" name="submit" value="login"/>
                </form>
            </BODY>
        </HTML>
        <?php
    }
    
?>
