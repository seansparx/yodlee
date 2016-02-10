<?php
require_once "config.inc.php";
require_once "restclient.class.php";

## =================== / =======================================
## Parameters  
## =================== / =======================================
$login           = ( isset($_POST["login"]) ) ? $_POST["login"] : "";
$password        = ( isset($_POST["password"]) ) ? $_POST["password"] : "";
$cobSessionToken = ( isset($_POST["cobSessionToken"]) ) ? $_POST["cobSessionToken"] : "";
$response        = array();

$config = array(
	"url_cobrand_login" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_USER_SESSION_TOKEN,
	"cobrand_login" => array(
			"login" => $login,
			"password" => $password,
			"cobSessionToken" => $cobSessionToken
		)
);

$response_to_request   = Yodlee\restClient::Post($config["url_cobrand_login"], $config["cobrand_login"]);

$isErrorLocalExist     = array_key_exists("Error", $response_to_request);

if($isErrorLocalExist){
	$response = array(
		"isValid"      =>false,
		"ErrorServer"  => $response_to_request["Error"]
	);
} else {
	$response = array(
		"isValid"      => true,
		"Body"         => $response_to_request["Body"]
	);
}

print json_encode($response);