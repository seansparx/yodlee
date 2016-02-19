<?php
session_start();
require_once "config.inc.php";
require_once "restclient.class.php";

$cobSessionToken  = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
$userSessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
$itemAccountId    = $_GET['itemAccountId'];
$sendParameters   = array('cobSessionToken' => $cobSessionToken, 'userSessionToken' => $userSessionToken);

## =================== / =======================================
## Parameters  
## =================== / =======================================
$sendParameters['memSiteAccId'] = $_GET['SiteAccId'];
$sendParameters['refreshParameters.refreshPriority'] = 2; //REFRESH_PRIORITY_LOW
$sendParameters['refreshParameters.refreshMode.refreshModeId'] = 2;
$sendParameters['refreshParameters.refreshMode.refreshMode'] = 'NORMAL'; //MFA 
$sendParameters['refreshParameters.forceRefresh'] = false; //This indicates whether the refresh should be force refresh.


$config = array(
    "url" => Yodlee\ConfigInc\serviceBaseUrl . Yodlee\ConfigInc\URL_START_SITE_REFRESH,
    "parameters" => $sendParameters
);

$response_to_request = Yodlee\restClient::Post($config["url"], $config["parameters"]);

//echo '<pre>';
//print_r($response_to_request);
header('Location:index.php');   
