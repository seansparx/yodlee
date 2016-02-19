<?php session_start();
require_once "config.inc.php";
require_once "restclient.class.php";

## =================== / =======================================
## Parameters  
## =================== / =======================================

$cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
$userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
$memSiteAccId       = $_GET['SiteAccId'];
$sendParameters     = array('cobSessionToken' => $cobSessionToken, 'userSessionToken' => $userSessionToken, 'memSiteAccId' => $memSiteAccId);

$config = array(
	"url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_GET_ITEM_SUMMARIES_FOR_SITE,
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
    
    if(count($response_to_request['Body']) > 0){
        echo '<h2>Item Summaries :</h2>';
        echo '<table border="1" width="100%">';
        echo '<tr height="30"><td>itemAccountId</td><td>containerName</td><td>itemDisplayName</td><td><b>acctType</b></td><td><b>bankAccountId</b></td><td><b>accountNumber</b></td><td><b>accountHolder</b></td><td><b>availableBalance</b></td><td><b>Action</b></td></tr>';
    
        foreach ($response_to_request['Body'] as $item) {
            $containerName = $item->contentServiceInfo->containerInfo->containerName;
            if(count($item->itemData->accounts) > 0) {
                foreach ($item->itemData->accounts as $account) {
                    if($account->isDeleted == 0){
                        echo '<tr><td>'.$account->itemAccountId.'</td><td>'.$containerName.'</td><td><a target="_blank" href="search_transactions.php?itemAccountId='.$account->itemAccountId.'">'.$account->accountDisplayName->defaultNormalAccountName.'</a></td><td>'.$account->acctType.'</td><td>'.$account->bankAccountId.'</td><td>'.$account->accountNumber.'</td><td>'.$account->accountHolder.'</td><td>'.$account->availableBalance->amount.$account->availableBalance->currencyCode.'</td><td><a href="remove_site_items.php?SiteAccId='.$memSiteAccId.'&itemAccountId='.$account->itemAccountId.'&SiteAccId='.$item->memSiteAccId.'">Remove</a></td></tr>';
                    }
                }
            }
            else{
                echo '<tr><td colspan="7">'.  json_encode($response_to_request).'</td></tr>';
            }
        }
        echo '</table>';
        echo '<br/><b>( acceptable container names : bank, credits, stocks, insurance, loans, miles, mortgage )</b>';
    }    
    
    
    echo '<br/><br/>JSON Response : ';
    
    print_r($response_to_request['Body'][0]);
}
