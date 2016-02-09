<?php
require_once "config.inc.php";
require_once "restclient.class.php";

## =================== / =======================================
## Parameters  
## =================== / =======================================
$params = ( isset($_POST["params"]) ) ? $_POST["params"] : "";
$data = explode("&", $params);

$sendParameters = array();
$FIELD = 0;
$VALUE = 1; 

foreach( $data as $ref ){
	$f = explode("=", $ref);
	$sendParameters[urldecode($f[$FIELD])] = urldecode($f[$VALUE]);
}

$cobSessionToken = ( isset($_POST["cobSessionToken"]) ) ? $_POST["cobSessionToken"] : "";
$userSessionToken = ( isset($_POST["userSessionToken"]) ) ? $_POST["userSessionToken"] : "";
$siteId = ( isset($_POST["siteId"]) ) ? $_POST["siteId"] : "";
$credentialFields = ( isset($_POST["credentialFields"]) ) ? $_POST["credentialFields"] : "";

$response = array();

$config = array(
	"url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_ADD_SITE_ACCOUNT,
	"parameters" => $sendParameters
	);

$response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);

print json_encode($response_to_request);