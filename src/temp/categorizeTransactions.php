<?php
    session_start();
    require_once "config.inc.php";
    require_once "restclient.class.php";
    ## =================== / =======================================
    ## Parameters  
    ## =================== / =======================================
    
    $cobSessionToken  = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
    $userSessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
    $itemAccountId    = $_GET['itemAccountId'];
    $sendParameters   = array('cobSessionToken' => $cobSessionToken, 'userSessionToken' => $userSessionToken);

    $sendParameters['userCategorizationObjects[0].container'] = 'BANK'; //BANK, CREDIT_CARD, INVESTMENT, INSURANCE, LOAN, REWARD_PROGRAM, MORTGAGE.
    $sendParameters['userCategorizationObjects[0].containerTransactionId'] = '';
    $sendParameters['userCategorizationObjects[0].targetTransactionCategoryId'] = '';
    $sendParameters['userCategorizationObjects[0].categoryLevelId'] = '';
    $sendParameters['userCategorizationObjects[0].transactionType'] = ''; //CREDIT, DEBIT and OTHER.
    
    $config = array(
        "url" => Yodlee\ConfigInc\serviceBaseUrl . Yodlee\ConfigInc\URL_GET_CATEGORIZE_TRANSACTION,
        "parameters" => $sendParameters
    );

    $response_to_request = Yodlee\restClient::Post($config["url"], $config["parameters"]);
    
    echo '<pre>';
    print_r($response_to_request);
    die;
    
    if($response_to_request['Body']->errorOccurred == true){
        echo 'Error Occurred : <pre>';
        print_r($response_to_request);
    }
    else{
        
        echo '<h2>User Transactions  :</h2>';
        
        if(count($response_to_request['Body']) > 0){
            $transactions          = isset($response_to_request['Body']->transactions) ? $response_to_request['Body']->transactions : array();        
            echo '<table border="1" width="100%">';
            echo '<tr height="30"><td><b>transactionId</b></td><td><b>Date</b></td><td>Type</td><td><b>description</b></td><td><b>checkNumber</b></td><td><b>category</b></td><td><b>amount</b></td><td><b>status</b></td></tr>';
    
            foreach ($response_to_request['Body'] as $item) {
                if(count($transactions) > 0) {
                    foreach ($transactions as $transaction) {
                        $transactionId   = $transaction->viewKey->transactionId;
                        $transactionDate = $transaction->transactionDate;
                        $transactionType = $transaction->transactionType;
                        $description     = $transaction->description->description;
                        $checkNumber     = $transaction->checkNumber->checkNumber;
                        $category        = $transaction->category->categoryName;
                        $amount          = $transaction->amount->amount.''.$transaction->amount->currencyCode;
                        $status          = $transaction->status->description;
                        $accountNumber   = $transaction->account->accountNumber;
                        $accountBalance  = $transaction->account->accountBalance;
                        echo '<tr><td>'.$transactionId.'</td><td>'.$transactionDate.'</td><td>'.$transactionType.'</td><td>'.$description.'</td><td>'.$checkNumber.'</td><td>'.$category.'</td><td>'.$amount.'</td><td>'.$status.'</td></tr>';
                    }
                }
                else{
                    echo '<tr><td colspan="7">'.  json_encode($response_to_request).'</td></tr>';
                }
            }
            
            echo '</table>';
        }    
    }
    
    if(isset($transactions)){
        print_r($transactions[0]);
    }
    
    
?>
