<?php
    session_start();

    echo '<pre>';
    print_r($_SESSION['loginForms']);
    echo '<br>';
    
    die;
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
    <h5>Username : <?php echo $_SESSION['login_response']['Body']->loginName.' ('.$_SESSION['login_response']['Body']->userId.')'; ?></h5>
    
</BODY>
</HTML>