<?php session_start();
require_once "config.inc.php";
require_once "restclient.class.php";
include_once 'constants.php';

## =================== / =======================================
## Parameters  
## =================== / =======================================
$cobrandLogin    =   API_USER;
$cobrandPassword =   API_PASS;
$response        =   array();

$config = array(			 
	"url_cobrand_login"  => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_COBRAND_SESSION_TOKEN,
	"cobrand_login"      => array(
		"cobrandLogin"   => $cobrandLogin,
		"cobrandPassword"=> $cobrandPassword
	));

$response_to_request   = Yodlee\restClient::Post($config["url_cobrand_login"], $config["cobrand_login"]);

$response = array(
    "isValid"      => true,
    "Body"         => $response_to_request["Body"]
);

if($response['isValid']){
    $session_token = $response['Body']->cobrandConversationCredentials->sessionToken;
    $_SESSION['cobSessionToken'] = $session_token;
    header('Location:'.SITE_URL.'user_login.php?token='.$session_token);
}
else{
    echo 'Error :';
    print_r($response);
}
//print json_encode($response);