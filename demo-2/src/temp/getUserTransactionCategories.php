<?php session_start();
require_once "config.inc.php";
require_once "restclient.class.php";
require_once "constants.php";

include_once 'src/getTransactionCategoryTypes.php'; 

## =================== / =======================================
## Parameters  
## =================== / =======================================

$cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
$userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
$sendParameters     = array('cobSessionToken' => $cobSessionToken, 'userSessionToken' => $userSessionToken);

$response = array();

$config = array(
	"url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_GET_USER_TRANSACTION_CATEGORY,
	"parameters" => $sendParameters
	);

$response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);

echo '<h2>Users Transaction Category</h2>';

if($response_to_request['Body']->errorOccurred == true){
    echo $response_to_request['Body']->message;
}
if($response_to_request['Body']->errorCode > 0) {
    echo 'Error Code : '.$response_to_request['Body']->errorCode.', '.$response_to_request['Body']->errorDetail;
}
else{
    
    echo '<table border="1" cellpadding="" width="100%">';
    echo '<thead>';
    echo '<tr><th>categoryId</th><th>categoryName</th><th>CategoryTypeId</th><th>isBudgetable</th><th>localizedCategoryName</th><th>categoryLevelId</th></tr>';
    echo '</thead>';
    echo '<tbody>';

    if(sizeof($response_to_request['Body']) > 0) {
        foreach ($response_to_request['Body'] as $body) {

            echo '<tr><td>'.$body->categoryId.'</td><td><a href="#">'.$body->categoryName.'</a></td><td>'.$cat_types[$body->transactionCategoryTypeId].'</td><td>'.$body->isBudgetable.'</td><td>'.$body->localizedCategoryName.'</td><td>'.$body->categoryLevelId.'</td></tr>';

        }
    }
    else{
        echo '<tr><td>data not found.</td></tr>';
    }

    echo '</tbody>';
    echo '</table>';
    
}
