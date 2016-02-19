<?php
session_start();
require_once "config.inc.php";
require_once "restclient.class.php";

$cobSessionToken  = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
$userSessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
$itemAccountId    = $_GET['itemAccountId'];
$SiteAccId        = $_GET['SiteAccId'];
$sendParameters   = array('cobSessionToken' => $cobSessionToken, 'userSessionToken' => $userSessionToken, 'itemAccountId' => $itemAccountId);


$config = array(
    "url" => Yodlee\ConfigInc\serviceBaseUrl . Yodlee\ConfigInc\URL_REMOVE_ITEM_ACCOUNT,
    "parameters" => $sendParameters
);

$response_to_request = Yodlee\restClient::Post($config["url"], $config["parameters"]);

//echo '<pre>';
//print_r($response_to_request); die;
header('Location:site_summaries.php?SiteAccId='.$SiteAccId);   
