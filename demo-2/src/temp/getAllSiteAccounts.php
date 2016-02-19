<?php session_start();
require_once "config.inc.php";
require_once "restclient.class.php";

## =================== / =======================================
## Parameters  
## =================== / =======================================

$cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
$userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
$sendParameters     = array('cobSessionToken' => $cobSessionToken, 'userSessionToken' => $userSessionToken);

$response = array();

$config = array(
	"url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_GET_ALL_SITE_ACCOUNTS,
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
    
    echo '<h2>List of linked Accounts</h2>';
    
    echo '<table border="1" width="100%">';
    echo '<tr height="30"><td><b>Site Account Id</b></td><td><b>Site Id</b></td><td><b>Org Id</b></td><td><b>Display Name</b></td><td><b>Enabled Services</b></td><td><b>status</b></td><td><b>Action</b></td></tr>';
    foreach ($response_to_request['Body'] as $site) {
        //print_r($site->siteInfo->enabledContainers);
        $service_info = array();
        foreach ($site->siteInfo->enabledContainers as $services) {
            $service_info[] = $services->containerName;
        }
        $siteAddStatus = $site->siteRefreshInfo->siteAddStatus->siteAddStatus;
        echo '<tr><td><a target="_blank" href="site_summaries.php?SiteAccId='.$site->siteAccountId.'">'.$site->siteAccountId.'</a></td><td>'.$site->siteInfo->siteId.'</td><td>'.$site->siteInfo->orgId.'</td><td>'.$site->siteInfo->defaultDisplayName.'</td><td>'.  implode(", ", $service_info).'</td><td>'.$siteAddStatus.'</td><td><a href="site_refresh.php?SiteAccId='.$site->siteAccountId.'">Refresh</a>&nbsp;&nbsp;<a href="remove_site.php?SiteId='.$site->siteAccountId.'">Remove</a></td></tr>';
    }
    echo '</table>';
    
    echo '<br/><br/>JSON Response : <pre>';
    
    print_r($response_to_request['Body']);
}
