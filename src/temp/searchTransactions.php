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
$sendParameters['transactionSearchRequest.containerType'] = 'all'; //bank, credits, stocks, insurance, loans, miles, mortgage
$sendParameters['transactionSearchRequest.higherFetchLimit'] = '500';
$sendParameters['transactionSearchRequest.lowerFetchLimit'] = '1';
$sendParameters['transactionSearchRequest.resultRange.startNumber'] = '1';
$sendParameters['transactionSearchRequest.resultRange.endNumber'] = '100';
$sendParameters['transactionSearchRequest.searchClients.clientId'] = '1';
$sendParameters['transactionSearchRequest.searchClients.clientName'] = 'DataSearchService';
$sendParameters['transactionSearchRequest.userInput'] = 'rent';
$sendParameters['transactionSearchRequest.ignoreUserInput'] = 'true';
$sendParameters['transactionSearchRequest.searchFilter.currencyCode'] = 'INR';
$sendParameters['transactionSearchRequest.searchFilter.postDateRange.fromDate'] = '01-11-2015';
$sendParameters['transactionSearchRequest.searchFilter.postDateRange.toDate'] = '01-01-2016';
$sendParameters['transactionSearchRequest.searchFilter.transactionSplitType'] = 'ALL_TRANSACTION'; // A, P, C 
$sendParameters['transactionSearchRequest.searchFilter.itemAccountId.identifier'] = $itemAccountId;

$config = array(
    "url" => Yodlee\ConfigInc\serviceBaseUrl . Yodlee\ConfigInc\URL_SEARCH_TRANSACTIONS,
    "parameters" => $sendParameters
);

$response_to_request = Yodlee\restClient::Post($config["url"], $config["parameters"]);

if ($response_to_request['Body']->errorOccurred == true) {
    die($response_to_request['Body']->message);
}
if ($response_to_request['Body']->errorCode > 0) {
    die('Error Code : ' . $response_to_request['Body']->errorCode . ', ' . $response_to_request['Body']->errorDetail);
} 
else {
    if (count($response_to_request['Body']) > 0) {
        $_SESSION['transactions']['searchIdentifier'] = isset($response_to_request['Body']->searchIdentifier->identifier) ? $response_to_request['Body']->searchIdentifier->identifier : '';
        $_SESSION['transactions']['countOfAllTransaction'] = isset($response_to_request['Body']->countOfAllTransaction) ? $response_to_request['Body']->countOfAllTransaction : '';
        $_SESSION['transactions']['debitTotalOfTxns'] = isset($response_to_request['Body']->debitTotalOfTxns->amount) ? $response_to_request['Body']->debitTotalOfTxns->amount . ' ' . $response_to_request['Body']->debitTotalOfTxns->currencyCode : '';
        $_SESSION['transactions']['creditTotalOfTxns'] = isset($response_to_request['Body']->creditTotalOfTxns->amount) ? $response_to_request['Body']->creditTotalOfTxns->amount . ' ' . $response_to_request['Body']->creditTotalOfTxns->currencyCode : '';

        header('Location:get_transactions.php');   
    }
}
