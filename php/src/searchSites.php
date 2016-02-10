<?php
require_once "config.inc.php";
require_once "restclient.class.php";

## =================== / =======================================
## Parameters  
## =================== / =======================================
$cobSessionToken = ( isset($_POST["cobSessionToken"]) ) ? $_POST["cobSessionToken"] : "";
$userSessionToken = ( isset($_POST["userSessionToken"]) ) ? $_POST["userSessionToken"] : "";
$siteSearchString = ( isset($_POST["siteSearchString"]) ) ? $_POST["siteSearchString"] : "";

$response        = array();

$config = array(
	"url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_SEARCH_SITES,
	"parameters" => array(
			"cobSessionToken" => $cobSessionToken,
			"userSessionToken" => $userSessionToken,
			"siteSearchString" => $siteSearchString
		)
);

$response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);

print json_encode($response_to_request);