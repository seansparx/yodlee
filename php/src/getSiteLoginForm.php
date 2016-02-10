<?php
require_once "config.inc.php";
require_once "restclient.class.php";

## =================== / =======================================
## Parameters  
## =================== / =======================================
$cobSessionToken = ( isset($_POST["cobSessionToken"]) ) ? $_POST["cobSessionToken"] : "";
$userSessionToken = ( isset($_POST["userSessionToken"]) ) ? $_POST["userSessionToken"] : "";
$siteId = ( isset($_POST["siteId"]) ) ? $_POST["siteId"] : "";

$response        = array();

$config = array(
	"url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_GET_SITE_LOGIN_FORM,
	"parameters" => array(
			"cobSessionToken" => $cobSessionToken,
			"userSessionToken" => $userSessionToken,
			"siteId" => $siteId
		)
);

$response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);

print json_encode($response_to_request);