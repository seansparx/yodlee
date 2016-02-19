<?php
    require_once "config.inc.php";
    require_once "restclient.class.php";
    require_once 'constants.php';
    //error_reporting(1);
    session_start();
    
    /**
     * Class for interactions with the Yodlee aggregation RestApi.
     * 
     * @package Yodlee R&D
     * @author Sean Rock <sean@sparxitsolutions.com>
     * @since 18 feb 2016
     */
    class YodleeAggregation 
    {
        private $cobrandLogin    = API_USER;
        
        private $cobrandPassword = API_PASS;
        
        private $userLogin       = '';
        
        private $userPassword    = '';
        
        private $cobSessionToken = null;
        
        private $userSessionToken= null;
        
        private $response        = array();
        
        private $config          = array();
        
        private $response_to_request = null;
        
        /** 
         * Class constructor.
         */
        public function __constructor()
        {   
            
        }
        
        
        /**
         * Get All Transaction Categories.
         */
        public function userRegistration()
        {                
            /**
             *  Username and Password Guidelines
                The values of userCredentials.loginName and userCredentials.password input parameters should adhere to the following guidelines:

                @Username 
                The username must be at least 3 characters and not more than 150 characters.
                The username should contain at least one alphabet and no white space or control characters are allowed.
                
                @Password
                The password must be at least 6 characters and not more than 50 characters.
                The password must contain at least one alphabet and a number.
                No white space or control characters are allowed.
                The password should not be same as the username.
                The password should not contain a sequence or repeated characters. For example, aaa123 is an invalid password.
             */
                $this->cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
                //$this->userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
                $sendParameters  = array('cobSessionToken' => $this->cobSessionToken);
                
                $sendParameters['userCredentials.loginName'] = '';
                $sendParameters['userCredentials.password'] = '';
                $sendParameters['userCredentials.objectInstanceType'] = '';
                $sendParameters['userProfile.emailAddress'] = '';
                $sendParameters['userPreferences[0]'] = '';
                $sendParameters['userPreferences[1]'] = '';
                $sendParameters['userProfile.firstName'] = '';
                $sendParameters['userProfile.lastName'] = '';
                $sendParameters['userProfile.middleInitial'] = '';
                $sendParameters['userProfile.objectInstanceType'] = '';
                $sendParameters['userProfile.address1'] = '';
                $sendParameters['userProfile.address2'] = '';
                $sendParameters['userProfile.city'] = '';
                $sendParameters['userProfile.country'] = '';
                
                //$this->response = array();

                $config = array(
                        "url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_USER_REGISTRATION,
                        "parameters" => $sendParameters
                        );

                $this->response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);

                print_r($this->response_to_request);
        }
        
        
        /** 
         * 1st Step.
         */
        private function cobrandSessionToken()
        {                
                $this->config = array(			 
                "url_cobrand_login"  => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_COBRAND_SESSION_TOKEN,
                "cobrand_login"      => array(
                        "cobrandLogin"   => $this->cobrandLogin,
                        "cobrandPassword"=> $this->cobrandPassword
                ));

                $this->response_to_request   = Yodlee\restClient::Post($this->config["url_cobrand_login"], $this->config["cobrand_login"]);

                $this->response = array(
                    "isValid"      => true,
                    "Body"         => $this->response_to_request["Body"]
                );

//                echo '<pre>';
//                print_r($this->response); die;
                
                if($this->response['isValid']){
                    
                    $cobrandId      = $this->response['Body']->cobrandId;
                    $applicationId  = $this->response['Body']->applicationId;
                    $session_token  = $this->response['Body']->cobrandConversationCredentials->sessionToken;
                    
                    $_SESSION['cobrandId']       = $cobrandId;
                    $_SESSION['applicationId']   = $applicationId;
                    $_SESSION['cobSessionToken'] = $session_token;
                    
                    $this->userSessionToken();
                    //header('Location:'.SITE_URL.'user_login.php?token='.$session_token);
                }
                else{
                    echo 'Error :';
                    print_r($this->response);
                }
        }
        
        
        /** 
         * 2nd Step.
         */
        private function userSessionToken()
        {
            //echo '<pre>';
            //print_r($_POST);
            
            $this->config = array(
                    "url_cobrand_login" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_USER_SESSION_TOKEN,
                    "cobrand_login" => array(
                                    "login" => $this->userLogin,
                                    "password" => $this->userPassword,
                                    "cobSessionToken" => $_SESSION['cobSessionToken']
                            )
            );

            $this->response_to_request   = Yodlee\restClient::Post($this->config["url_cobrand_login"], $this->config["cobrand_login"]);

            $isErrorLocalExist     = array_key_exists("Error", $this->response_to_request);

            if($isErrorLocalExist){
                    $this->response = array(
                            "isValid"      =>false,
                            "ErrorServer"  => $this->response_to_request["Error"]
                    );
            } else {
                    $this->response = array(
                            "isValid"      => true,
                            "Body"         => $this->response_to_request["Body"]
                    );
            }

            //echo '<pre>';
//            print_r($response);
            
            if($this->response['isValid']){
                $_SESSION['login_response'] = $this->response;
                //print_r($_SESSION);
                header('Location:'.SITE_URL.'dashboard.php');
            }
            else{
                echo 'Error :';
                print_r($this->response);
            }
        }
        
        
        /** 
         * 3rd Step.
         */
        public function getAllSiteAccounts()
        {
            $this->getOAuthAccessToken();
            
                $this->cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
                $this->userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
                $sendParameters     = array('cobSessionToken' => $this->cobSessionToken, 'userSessionToken' => $this->userSessionToken);

                //$this->response = array();

                $this->config = array(
                        "url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_GET_ALL_SITE_ACCOUNTS,
                        "parameters" => $sendParameters
                        );

                $this->response_to_request   = Yodlee\restClient::Post($this->config["url"], $this->config["parameters"]);

                if($this->response_to_request['Body']->errorOccurred == true){
                    return $this->response_to_request['Body']->message;
                }
                if($this->response_to_request['Body']->errorCode > 0) {
                    return 'Error Code : '.$this->response_to_request['Body']->errorCode.', '.$this->response_to_request['Body']->errorDetail;
                }
                else{
                    $HTML  = '<h2>List of linked Accounts</h2>';
                    $HTML .= '<table border="1" width="100%">';
                    $HTML .= '<tr height="30"><td><b>Site Account Id</b></td><td><b>Site Id</b></td><td><b>Org Id</b></td><td><b>Display Name</b></td><td><b>Enabled Services</b></td><td><b>status</b></td><td><b>Action</b></td></tr>';
                    foreach ($this->response_to_request['Body'] as $site) {
                        //print_r($site->siteInfo->enabledContainers);
                        $service_info = array();
                        foreach ($site->siteInfo->enabledContainers as $services) {
                            $service_info[] = $services->containerName;
                        }
                        $siteAddStatus = $site->siteRefreshInfo->siteAddStatus->siteAddStatus;
                        $HTML .= '<tr><td><a target="_blank" href="site_summaries.php?SiteAccId='.$site->siteAccountId.'">'.$site->siteAccountId.'</a></td><td>'.$site->siteInfo->siteId.'</td><td>'.$site->siteInfo->orgId.'</td><td>'.$site->siteInfo->defaultDisplayName.'</td><td>'.  implode(", ", $service_info).'</td><td>'.$siteAddStatus.'</td><td><a href="site_refresh.php?SiteAccId='.$site->siteAccountId.'">Refresh</a>&nbsp;&nbsp;<a href="remove_site.php?SiteId='.$site->siteAccountId.'">Remove</a></td></tr>';
                    }
                    $HTML .= '</table>';
                    //$HTML .= '<br/><br/>JSON Response : <pre>';
                    
                    return $HTML;
                    //print_r($this->response_to_request['Body']);
                }
        }
        
        
        /** 
         * 4th Step.
         */
        public function getPopularSites()
        {
                $this->cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
                $this->userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
                $sendParameters     = array('cobSessionToken' => $this->cobSessionToken, 'userSessionToken' => $this->userSessionToken);

                $sendParameters['siteFilter.siteLevel'] = 'POPULAR_CITY'; //POPULAR_ZIP, POPULAR_CITY, POPULAR_STATE, POPULAR_COUNTRY

                $this->response = array();

                $this->config = array(
                        "url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_GET_POPULAR_SITES,
                        "parameters" => $sendParameters
                        );

                $this->response_to_request   = Yodlee\restClient::Post($this->config["url"], $this->config["parameters"]);

                $HTML = '<h2>Popular Sites</h2>';

                if($this->response_to_request['Body']->errorOccurred == true){
                    echo $this->response_to_request['Body']->message;
                }
                if($this->response_to_request['Body']->errorCode > 0) {
                    echo 'Error Code : '.$this->response_to_request['Body']->errorCode.', '.$this->response_to_request['Body']->errorDetail;
                }
                else{
                    //echo '<pre>';
                    //print_r($this->response_to_request);

                    $HTML .= '<table border="1" cellpadding="" width="100%">';
                    $HTML .= '<thead>';
                    $HTML .= '<tr><th>siteId</th><th>AlreadyAddedByUser</th><th>DisplayName</th><th>ServiceInfos</th><th>Base URL</th><th>Login URL</th><th>Help Text</th></tr>';
                    $HTML .= '</thead>';
                    $HTML .= '<tbody>';

                    if(sizeof($this->response_to_request['Body']) > 0) {
                        foreach ($this->response_to_request['Body'] as $body) {

                            $_SESSION['loginForms'][$body->siteId] = $body->loginForms;
                            $HTML .= '<tr><td>'.$body->siteId.'</td><td>'.$body->isAlreadyAddedByUser.'</td><td><a href="'.SITE_URL.'site_login.php?site='.$body->siteId.'">'.$body->defaultDisplayName.'</a></td><td>'.json_encode($body->contentServiceInfos).'</td><td>'.$body->baseUrl.'</td><td>'.$body->loginUrl.'</td><td>'.$body->defaultHelpText.'</td></tr>';

                            ////print_r($body);
                        }
                    }
                    else{
                        $HTML .= '<tr><td>data not found.</td></tr>';
                    }

                    $HTML .= '</tbody>';
                    $HTML .= '</table>';
                    
                    return $HTML;
                }
        }
        
        
        /** 
         * 5th Step.
         */
        public function searchSites()
        {
                if($_SESSION['login_response']['isValid']) {
                    $this->cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
                    $this->userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
                    $siteSearchString   = ( isset($_POST["siteSearchString"]) ) ? $_POST["siteSearchString"] : "";
                }
                else{
                    echo 'Invalid session.';
                }

                $this->config = array(
                        "url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_SEARCH_SITES,
                        "parameters" => array(
                                        "cobSessionToken" => $this->cobSessionToken,
                                        "userSessionToken" => $this->userSessionToken,
                                        "siteSearchString" => $siteSearchString
                                )
                );

                $this->response_to_request   = Yodlee\restClient::Post($this->config["url"], $this->config["parameters"]);

                $HTML = '<h2>Search Result</h2>';

                $HTML .= '<table border="1" cellpadding="" width="100%">';
                $HTML .= '<thead>';
                $HTML .= '<tr><th>siteId</th><th>AlreadyAddedByUser</th><th>DisplayName</th><th>ServiceInfos</th><th>Base URL</th><th>Login URL</th><th>Help Text</th></tr>';
                $HTML .= '</thead>';
                $HTML .= '<tbody>';

                if(sizeof($this->response_to_request['Body']) > 0) {
                    foreach ($this->response_to_request['Body'] as $body) {

                        $_SESSION['loginForms'][$body->siteId] = $body->loginForms;
                        $HTML .= '<tr><td>'.$body->siteId.'</td><td>'.$body->isAlreadyAddedByUser.'</td><td><a href="'.SITE_URL.'site_login.php?site='.$body->siteId.'">'.$body->defaultDisplayName.'</a></td><td>'.json_encode($body->contentServiceInfos).'</td><td>'.$body->baseUrl.'</td><td>'.$body->loginUrl.'</td><td>'.$body->defaultHelpText.'</td></tr>';

                        ////print_r($body);
                    }
                }
                else{
                    $HTML .= '<tr><td>data not found.</td></tr>';
                }

                $HTML .= '</tbody>';
                $HTML .= '</table>';
                
                return $HTML;
        }
        
        
        /** 
         * 6th Step.
         */
        public function addSiteAccount($site, $login, $passwd)
        {
            
            $this->cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
            $this->userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
            $credentialFields           = $_SESSION['loginForms'][$site][0]->componentList;
            $credentialFields[0]->value = $login; // site login id.
            $credentialFields[1]->value = $passwd; // site password.
        
            $login_form = array(
                    "siteId"                                    => $site, 
                    "cobSessionToken"                           => $this->cobSessionToken, 
                    "userSessionToken"                          => $this->userSessionToken,
                    "credentialFields[0].valueIdentifier"       => $credentialFields[0]->valueIdentifier,
                    "credentialFields[0].valueMask"             => $credentialFields[0]->valueMask,
                    "credentialFields[0].fieldType.typeName"    => $credentialFields[0]->fieldType->typeName,
                    "credentialFields[0].size"                  => $credentialFields[0]->size,
                    "credentialFields[0].value"                 => $credentialFields[0]->value,
                    "credentialFields[0].maxlength"             => $credentialFields[0]->maxlength,
                    "credentialFields[0].name"                  => $credentialFields[0]->name,
                    "credentialFields[0].displayName"           => $credentialFields[0]->displayName,
                    "credentialFields[0].isEditable"            => $credentialFields[0]->isEditable,
                    "credentialFields[0].isOptional"            => $credentialFields[0]->isOptional,
                    "credentialFields[0].isEscaped"             => $credentialFields[0]->isEscaped,
                    "credentialFields[0].helpText"              => $credentialFields[0]->helpText,
                    "credentialFields[0].isOptionalMFA"         => $credentialFields[0]->isOptionalMFA,
                    "credentialFields[0].isMFA"                 => $credentialFields[0]->isMFA,
                    "credentialFields[1].valueIdentifier"       => $credentialFields[1]->valueIdentifier,
                    "credentialFields[1].valueMask"             => $credentialFields[1]->valueMask,
                    "credentialFields[1].fieldType.typeName"    => $credentialFields[1]->fieldType->typeName,
                    "credentialFields[1].size"                  => $credentialFields[1]->size,
                    "credentialFields[1].value"                 => $credentialFields[1]->value,
                    "credentialFields[1].maxlength"             => $credentialFields[1]->maxlength,
                    "credentialFields[1].name"                  => $credentialFields[1]->name,
                    "credentialFields[1].displayName"           => $credentialFields[1]->displayName,
                    "credentialFields[1].isEditable"            => $credentialFields[1]->isEditable,
                    "credentialFields[1].isOptional"            => $credentialFields[1]->isOptional,
                    "credentialFields[1].isEscaped"             => $credentialFields[1]->isEscaped,
                    "credentialFields[1].helpText"              => $credentialFields[1]->helpText,
                    "credentialFields[1].isOptionalMFA"         => $credentialFields[1]->isOptionalMFA,
                    "credentialFields[1].isMFA"                 => $credentialFields[1]->isMFA,
                    "credentialFields.enclosedType"             => (isset($credentialFields[0]->fieldInfoType) ? $credentialFields[0]->fieldInfoType : "com.yodlee.common.FieldInfoSingle")
                );
        
                $sendParameters = $login_form; //array();

                $this->config = array(
                        "url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_ADD_SITE_ACCOUNT,
                        "parameters" => $sendParameters
                        );

                $this->response_to_request   = Yodlee\restClient::Post($this->config["url"], $this->config["parameters"]);

                if($this->response_to_request['Body']->errorOccurred == true){
                    die($this->response_to_request['Body']->message);
                }
                if($this->response_to_request['Body']->errorCode > 0) {
                    die('Error Code : '.$this->response_to_request['Body']->errorCode.', '.$this->response_to_request['Body']->errorDetail);
                }
                else{
                    $_SESSION['add_site_response'] = $this->response_to_request;
                    echo 'Site Added. <pre>';
                    header('Location:dashboard.php');
                }

        }
        
        
        /** 
         * 6th Step.
         */
        public function getItemSummariesForSite($SiteAccId)
        {
                ## =================== / =======================================
                ## Parameters  
                ## =================== / =======================================

                $this->cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
                $this->userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
                $memSiteAccId       = $SiteAccId;
                $sendParameters     = array('cobSessionToken' => $this->cobSessionToken, 'userSessionToken' => $this->userSessionToken, 'memSiteAccId' => $memSiteAccId);

                $this->config = array(
                        "url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_GET_ITEM_SUMMARIES_FOR_SITE,
                        "parameters" => $sendParameters
                        );

                $this->response_to_request   = Yodlee\restClient::Post($this->config["url"], $this->config["parameters"]);

                if($this->response_to_request['Body']->errorOccurred == true){
                    echo $this->response_to_request['Body']->message;
                }
                if($this->response_to_request['Body']->errorCode > 0) {
                    echo 'Error Code : '.$this->response_to_request['Body']->errorCode.', '.$this->response_to_request['Body']->errorDetail;
                }
                else{  

                    if(count($this->response_to_request['Body']) > 0){
                        $HTML = '<h2>Item Summaries :</h2>';
                        $HTML .= '<table border="1" width="100%">';
                        $HTML .=  '<tr height="30"><td>itemAccountId</td><td>containerName</td><td>itemDisplayName</td><td><b>acctType</b></td><td><b>bankAccountId</b></td><td><b>accountNumber</b></td><td><b>accountHolder</b></td><td><b>availableBalance</b></td><td><b>Action</b></td></tr>';

                        foreach ($this->response_to_request['Body'] as $item) {
                            $containerName = $item->contentServiceInfo->containerInfo->containerName;
                            if(count($item->itemData->accounts) > 0) {
                                foreach ($item->itemData->accounts as $account) {
                                    if($account->isDeleted == 0){
                                        $HTML .=  '<tr><td>'.$account->itemAccountId.'</td><td>'.$containerName.'</td><td><a target="_blank" href="search_transactions.php?itemAccountId='.$account->itemAccountId.'">'.$account->accountDisplayName->defaultNormalAccountName.'</a></td><td>'.$account->acctType.'</td><td>'.$account->bankAccountId.'</td><td>'.$account->accountNumber.'</td><td>'.$account->accountHolder.'</td><td>'.$account->availableBalance->amount.$account->availableBalance->currencyCode.'</td><td><a href="remove_site_items.php?SiteAccId='.$memSiteAccId.'&itemAccountId='.$account->itemAccountId.'&SiteAccId='.$item->memSiteAccId.'">Remove</a></td></tr>';
                                    }
                                }
                            }
                            else{
                                $HTML .=  '<tr><td colspan="7">'.  json_encode($this->response_to_request).'</td></tr>';
                            }
                        }
                        $HTML .=  '</table>';
                        $HTML .=  '<br/><b>( acceptable container names : bank, credits, stocks, insurance, loans, miles, mortgage )</b>';
                    }    


                    $HTML .=  '<br/><br/>JSON Response : ';
                    return $HTML;
                    //print_r($this->response_to_request['Body'][0]);
                }
        }
        
        /** 
         * 7th Step.
         */
        public function searchTransactions($itemAccountId)
        {
                $this->cobSessionToken  = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
                $this->userSessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
                $sendParameters   = array('cobSessionToken' => $this->cobSessionToken, 'userSessionToken' => $this->userSessionToken);

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

                $this->config = array(
                    "url" => Yodlee\ConfigInc\serviceBaseUrl . Yodlee\ConfigInc\URL_SEARCH_TRANSACTIONS,
                    "parameters" => $sendParameters
                );

                $this->response_to_request = Yodlee\restClient::Post($this->config["url"], $this->config["parameters"]);

                if ($this->response_to_request['Body']->errorOccurred == true) {
                    die($this->response_to_request['Body']->message);
                }
                if ($this->response_to_request['Body']->errorCode > 0) {
                    die('Error Code : ' . $this->response_to_request['Body']->errorCode . ', ' . $this->response_to_request['Body']->errorDetail);
                } 
                else {
                    if (count($this->response_to_request['Body']) > 0) {
                        $_SESSION['transactions']['searchIdentifier'] = isset($this->response_to_request['Body']->searchIdentifier->identifier) ? $this->response_to_request['Body']->searchIdentifier->identifier : '';
                        $_SESSION['transactions']['countOfAllTransaction'] = isset($this->response_to_request['Body']->countOfAllTransaction) ? $this->response_to_request['Body']->countOfAllTransaction : '';
                        $_SESSION['transactions']['debitTotalOfTxns'] = isset($this->response_to_request['Body']->debitTotalOfTxns->amount) ? $this->response_to_request['Body']->debitTotalOfTxns->amount . ' ' . $this->response_to_request['Body']->debitTotalOfTxns->currencyCode : '';
                        $_SESSION['transactions']['creditTotalOfTxns'] = isset($this->response_to_request['Body']->creditTotalOfTxns->amount) ? $this->response_to_request['Body']->creditTotalOfTxns->amount . ' ' . $this->response_to_request['Body']->creditTotalOfTxns->currencyCode : '';

                        header('Location:get_transactions.php');   
                    }
                }
        }
        
        
        /**
         * 8th Step.
         */
        public function getUserTransactions()
        {
                ## =================== / =======================================
                ## Parameters  
                ## =================== / =======================================

                $this->cobSessionToken  = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
                $this->userSessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
                
                $sendParameters   = array('cobSessionToken' => $this->cobSessionToken, 'userSessionToken' => $this->userSessionToken);

                $sendParameters['searchFetchRequest.searchIdentifier.identifier']   = $_SESSION['transactions']['searchIdentifier']; // Session sets in "searchTransactions.php".
                $sendParameters['searchFetchRequest.searchResultRange.startNumber'] = 1;
                $sendParameters['searchFetchRequest.searchResultRange.endNumber']   = $_SESSION['transactions']['countOfAllTransaction']; // Session sets in "searchTransactions.php".

                $this->config = array(
                    "url" => Yodlee\ConfigInc\serviceBaseUrl . Yodlee\ConfigInc\URL_GET_USER_TRANSACTIONS,
                    "parameters" => $sendParameters
                );

                $this->response_to_request = Yodlee\restClient::Post($this->config["url"], $this->config["parameters"]);

                if($this->response_to_request['Body']->errorOccurred == true){
                    echo 'Error Occurred : <pre>';
                    print_r($this->response_to_request);
                }
                else{

                    $HTML = '<h2>User Transactions  :</h2>';

                    if(count($this->response_to_request['Body']) > 0){
                        $transactions          = isset($this->response_to_request['Body']->transactions) ? $this->response_to_request['Body']->transactions : array();        
                        $HTML .= '<table border="1" width="100%">';
                        $HTML .= '<tr height="30"><td><b>transactionId</b></td><td><b>Date</b></td><td>Type</td><td><b>description</b></td><td><b>checkNumber</b></td><td><b>category</b></td><td><b>amount</b></td><td><b>status</b></td></tr>';

                        foreach ($this->response_to_request['Body'] as $item) {
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
                                    $HTML .= '<tr><td>'.$transactionId.'</td><td>'.$transactionDate.'</td><td>'.$transactionType.'</td><td>'.$description.'</td><td>'.$checkNumber.'</td><td>'.$category.'</td><td>'.$amount.'</td><td>'.$status.'</td></tr>';
                                }
                            }
                            else{
                                $HTML .= '<tr><td colspan="7">'.  json_encode($this->response_to_request).'</td></tr>';
                            }
                        }

                        $HTML .= '</table>';
                    }    
                }

                return $HTML;
        }
        
        
        /**
         * Remove Site
         */
        public function removeSiteAccount()
        {
            $this->cobSessionToken  = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
            $this->userSessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
            $memSiteAccId    = $_GET['SiteId'];
            $sendParameters   = array('cobSessionToken' => $this->cobSessionToken, 'userSessionToken' => $this->userSessionToken, 'memSiteAccId' => $memSiteAccId);


            $config = array(
                "url" => Yodlee\ConfigInc\serviceBaseUrl . Yodlee\ConfigInc\URL_REMOVE_SITE_ACCOUNT,
                "parameters" => $sendParameters
            );

            $this->response_to_request = Yodlee\restClient::Post($config["url"], $config["parameters"]);

            //echo '<pre>';
            //print_r($this->response_to_request);
            header('Location:dashboard.php');   
        }
        
        
        /**
         * Remove Site Item Account.
         */
        public function removeItemAccount()
        {
            $this->cobSessionToken  = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
            $this->userSessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
            $itemAccountId    = $_GET['itemAccountId'];
            $SiteAccId        = $_GET['SiteAccId'];
            $sendParameters   = array('cobSessionToken' => $this->cobSessionToken, 'userSessionToken' => $this->userSessionToken, 'itemAccountId' => $itemAccountId);


            $config = array(
                "url" => Yodlee\ConfigInc\serviceBaseUrl . Yodlee\ConfigInc\URL_REMOVE_ITEM_ACCOUNT,
                "parameters" => $sendParameters
            );

            $this->response_to_request = Yodlee\restClient::Post($config["url"], $config["parameters"]);

            //echo '<pre>';
            //print_r($this->response_to_request); die;
            header('Location:site_summaries.php?SiteAccId='.$SiteAccId);   

        }
        
        /**
         * Refresh site account.
         */
        public function startSiteRefresh()
        {
            $this->cobSessionToken  = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
            $this->userSessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
            $itemAccountId    = $_GET['itemAccountId'];
            $sendParameters   = array('cobSessionToken' => $this->cobSessionToken, 'userSessionToken' => $this->userSessionToken);

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

            $this->response_to_request = Yodlee\restClient::Post($config["url"], $config["parameters"]);

            //echo '<pre>';
            //print_r($this->response_to_request);
            header('Location:index.php');   

        }
        
        
        /**
         * Get All Transaction Categories.
         */
        public function getTransactionCategoryTypes($data_only = false)
        {
            $this->cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
            $this->userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
            $sendParameters     = array('cobSessionToken' => $this->cobSessionToken, 'userSessionToken' => $this->userSessionToken);

            //$sendParameters['siteFilter.siteLevel'] = 'POPULAR_CITY'; //POPULAR_ZIP, POPULAR_CITY, POPULAR_STATE, POPULAR_COUNTRY

            $this->response = array();

            $config = array(
                    "url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_TRANSACTION_CATEGORY_TYPE,
                    "parameters" => $sendParameters
                    );

            $this->response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);

            //echo '<pre>';
            //    print_r($this->response_to_request);
            //    die;
            $HTML = '<h2>Transaction Category Types</h2>';

            if($this->response_to_request['Body']->errorOccurred == true){
                echo $this->response_to_request['Body']->message;
            }
            if($this->response_to_request['Body']->errorCode > 0) {
                echo 'Error Code : '.$this->response_to_request['Body']->errorCode.', '.$this->response_to_request['Body']->errorDetail;
            }
            else{
                $cat_types = array();
                $HTML .= '<table border="1" cellpadding="" width="100%">';
                $HTML .= '<thead>';
                $HTML .= '<tr><th>typeId</th><th>typeName</th><th>localizedTypeName</th></tr>';
                $HTML .= '</thead>';
                $HTML .= '<tbody>';

                if(sizeof($this->response_to_request['Body']) > 0) {
                    foreach ($this->response_to_request['Body'] as $body) {
                        $cat_types[$body->typeId] = $body->typeName; 
                        $HTML .= '<tr><td>'.$body->typeId.'</td><td><a href="#">'.$body->typeName.'</a></td><td>'.$body->localizedTypeName.'</td></tr>';
                    }
                }
                else{
                    $HTML .= '<tr><td>data not found.</td></tr>';
                }

                $HTML .= '</tbody>';
                $HTML .= '</table>';

                if($data_only){
                    return $cat_types;
                }
                else{
                    return $HTML;
                }
            }
        }
        
        
        /**
         * Get All Transaction Categories.
         */
        public function getUserTransactionCategories()
        {
            $cat_types = $this->getTransactionCategoryTypes(true);

            $this->cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
            $this->userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
            $sendParameters     = array('cobSessionToken' => $this->cobSessionToken, 'userSessionToken' => $this->userSessionToken);

            //$this->response = array();

            $config = array(
                    "url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_GET_USER_TRANSACTION_CATEGORY,
                    "parameters" => $sendParameters
                    );

            $this->response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);

            $HTML = '<h2>Users Transaction Category</h2>';

            if($this->response_to_request['Body']->errorOccurred == true){
                $HTML .= $this->response_to_request['Body']->message;
            }
            if($this->response_to_request['Body']->errorCode > 0) {
                $HTML .= 'Error Code : '.$this->response_to_request['Body']->errorCode.', '.$this->response_to_request['Body']->errorDetail;
            }
            else{
                $HTML .= '<table border="1" cellpadding="" width="100%">';
                $HTML .= '<thead>';
                $HTML .= '<tr><th>categoryId</th><th>categoryName</th><th>CategoryTypeId</th><th>isBudgetable</th><th>localizedCategoryName</th><th>categoryLevelId</th></tr>';
                $HTML .= '</thead>';
                $HTML .= '<tbody>';

                if(sizeof($this->response_to_request['Body']) > 0) {
                    foreach ($this->response_to_request['Body'] as $body) {
                        $HTML .= '<tr><td>'.$body->categoryId.'</td><td><a href="#">'.$body->categoryName.'</a></td><td>'.$cat_types[$body->transactionCategoryTypeId].'</td><td>'.$body->isBudgetable.'</td><td>'.$body->localizedCategoryName.'</td><td>'.$body->categoryLevelId.'</td></tr>';
                    }
                }
                else{
                    $HTML .= '<tr><td>data not found.</td></tr>';
                }

                $HTML .= '</tbody>';
                $HTML .= '</table>';
            }
            return $HTML;
        }
        
        
        /**
         * Get Login.
         */
        public function login()
        {
            $this->userLogin = isset($_POST['username']) ? $_POST['username'] : '';
            $this->userPassword = isset($_POST['passwd']) ? $_POST['passwd'] : '';
            $this->cobrandSessionToken();
        }
        
        
        /**
         * @return object
         */
        public function getOAuthAccessToken()
        {
            $bridgetAppId = '10003200';
            $this->cobSessionToken  = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
            $this->userSessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;

            $sendParameters   = array('cobSessionToken' => $this->cobSessionToken, 'userSessionToken' => $this->userSessionToken, 'bridgetAppId' => $bridgetAppId);

            $config = array(
                "url" => Yodlee\ConfigInc\serviceBaseUrl . Yodlee\ConfigInc\URL_GET_ACCESS_TOKEN,
                "parameters" => $sendParameters
            );

            $this->response_to_request = Yodlee\restClient::Post($config["url"], $config["parameters"]);

            return $this->response_to_request['Body'];
        }
        
        
        /**
         * Get Logout.
         */
        public function logout()
        {
                $this->cobSessionToken  = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
                $this->userSessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
                
                $sendParameters   = array('cobSessionToken' => $this->cobSessionToken, 'userSessionToken' => $this->userSessionToken);

                $config = array(
                    "url" => Yodlee\ConfigInc\serviceBaseUrl . Yodlee\ConfigInc\URL_GET_LOGOUT,
                    "parameters" => $sendParameters
                );

                $this->response_to_request = Yodlee\restClient::Post($config["url"], $config["parameters"]);

                //session_destroy();
                //print_($this->response_to_request);
                if(!isset($_SESSION['login_response'])) {
                    echo 'You have logout successfully..';
                }
                else{
                    print_($this->response_to_request);
                }
        }
    }
?>