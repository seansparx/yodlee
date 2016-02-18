<?php session_start();
require_once "config.inc.php";
require_once "restclient.class.php";
require_once "constants.php";

## =================== / =======================================
## Parameters  
## =================== / =======================================

$cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
$userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
$sendParameters     = array('cobSessionToken' => $cobSessionToken, 'userSessionToken' => $userSessionToken);

//$sendParameters['siteFilter.siteLevel'] = 'POPULAR_CITY'; //POPULAR_ZIP, POPULAR_CITY, POPULAR_STATE, POPULAR_COUNTRY

$response = array();

$config = array(
	"url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_TRANSACTION_CATEGORY_TYPE,
	"parameters" => $sendParameters
	);

$response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);

//echo '<pre>';
//    print_r($response_to_request);
//    die;
echo '<h2>Transaction Category Types</h2>';

if($response_to_request['Body']->errorOccurred == true){
    echo $response_to_request['Body']->message;
}
if($response_to_request['Body']->errorCode > 0) {
    echo 'Error Code : '.$response_to_request['Body']->errorCode.', '.$response_to_request['Body']->errorDetail;
}
else{
    $cat_types = array();
    echo '<table border="1" cellpadding="" width="100%">';
    echo '<thead>';
    echo '<tr><th>typeId</th><th>typeName</th><th>localizedTypeName</th></tr>';
    echo '</thead>';
    echo '<tbody>';

    if(sizeof($response_to_request['Body']) > 0) {
        foreach ($response_to_request['Body'] as $body) {
            
            $cat_types[$body->typeId] = $body->typeName; // Used in /home/sis069/236/rakesh_php/yodlee/demo/src/getUserTransactionCategories.php
            
            echo '<tr><td>'.$body->typeId.'</td><td><a href="#">'.$body->typeName.'</a></td><td>'.$body->localizedTypeName.'</td></tr>';

        }
    }
    else{
        echo '<tr><td>data not found.</td></tr>';
    }

    echo '</tbody>';
    echo '</table>';
}
