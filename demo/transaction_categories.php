<?php session_start(); ?>
<!DOCTYPE html>
<HTML>
<HEAD>
	<title>Demo - PHP</title>
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
    <ul>
        <li><a target="_blank" href="<?php echo SITE_URL; ?>search.php">Search / Add New Site</a></li>
    </ul>
    <?php 
        echo '<pre>';
            include_once 'src/getUserTransactionCategories.php'; 
        echo '</pre>';
    ?>
</BODY>
</HTML>