<?php
require_once "config.inc.php";
require_once "restclient.class.php";

## =================== / =======================================
## Parameters  
## =================== / =======================================
//$params = ( isset($_POST["params"]) ) ? $_POST["params"] : "";
//$data = explode("&", $params);

$sendParameters = $login_form; //array();

$cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
$userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
//$siteId = ( isset($_POST["siteId"]) ) ? $_POST["siteId"] : "";
//$credentialFields = ( isset($_POST["credentialFields"]) ) ? $_POST["credentialFields"] : "";

$response = array();

$config = array(
	"url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_ADD_SITE_ACCOUNT,
	"parameters" => $sendParameters
	);

$response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);

if($response_to_request['Body']->errorOccurred == true){
    echo $response_to_request['Body']->message;
}
if($response_to_request['Body']->errorCode > 0) {
    echo 'Error Code : '.$response_to_request['Body']->errorCode.', '.$response_to_request['Body']->errorDetail;
}
else{
    $_SESSION['add_site_response'] = $response_to_request;
    echo 'Site Added. <pre>';
    header('Location:dashboard.php');
}
