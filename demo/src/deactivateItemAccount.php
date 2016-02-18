<?php session_start();
require_once "config.inc.php";
require_once "restclient.class.php";

## =================== / =======================================
## Parameters  
## =================== / =======================================
$SiteAccId        = $_GET['SiteAccId'];
$itemAccountId    = $_GET['itemAccountId'];
$cobSessionToken  = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
$userSessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
$sendParameters   = array('cobSessionToken' => $cobSessionToken, 'userSessionToken' => $userSessionToken, 'itemAccountId' => $itemAccountId);

$response = array();

$config = array(
	"url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_DEACTIVATE_ITEM_ACCOUNT,
	"parameters" => $sendParameters
	);

$response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);


if($response_to_request['Body']->errorOccurred == true){
    echo $response_to_request['Body']->message.'<br>';
    echo $response_to_request['Body']->detailedMessage;
}
else{
    echo '<pre>';
    print_r($response_to_request);
    //header('Location:site_summaries.php?SiteAccId='.$SiteAccId);
}

