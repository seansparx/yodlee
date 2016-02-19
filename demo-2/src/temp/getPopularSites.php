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

$sendParameters['siteFilter.siteLevel'] = 'POPULAR_CITY'; //POPULAR_ZIP, POPULAR_CITY, POPULAR_STATE, POPULAR_COUNTRY

$response = array();

$config = array(
	"url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_GET_POPULAR_SITES,
	"parameters" => $sendParameters
	);

$response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);

echo '<h2>Popular Sites</h2>';

if($response_to_request['Body']->errorOccurred == true){
    echo $response_to_request['Body']->message;
}
if($response_to_request['Body']->errorCode > 0) {
    echo 'Error Code : '.$response_to_request['Body']->errorCode.', '.$response_to_request['Body']->errorDetail;
}
else{
    //echo '<pre>';
    //print_r($response_to_request);
    
    echo '<table border="1" cellpadding="" width="100%">';
    echo '<thead>';
    echo '<tr><th>siteId</th><th>AlreadyAddedByUser</th><th>DisplayName</th><th>ServiceInfos</th><th>Base URL</th><th>Login URL</th><th>Help Text</th></tr>';
    echo '</thead>';
    echo '<tbody>';

    if(sizeof($response_to_request['Body']) > 0) {
        foreach ($response_to_request['Body'] as $body) {

            $_SESSION['loginForms'][$body->siteId] = $body->loginForms;
            echo '<tr><td>'.$body->siteId.'</td><td>'.$body->isAlreadyAddedByUser.'</td><td><a href="'.SITE_URL.'site_login.php?site='.$body->siteId.'">'.$body->defaultDisplayName.'</a></td><td>'.json_encode($body->contentServiceInfos).'</td><td>'.$body->baseUrl.'</td><td>'.$body->loginUrl.'</td><td>'.$body->defaultHelpText.'</td></tr>';

            ////print_r($body);
        }
    }
    else{
        echo '<tr><td>data not found.</td></tr>';
    }

    echo '</tbody>';
    echo '</table>';
    
    
//    echo '<table border="1" width="100%">';
//    echo '<tr height="30"><td><b>Site Account Id</b></td><td><b>Site Id</b></td><td><b>Org Id</b></td><td><b>Display Name</b></td><td><b>Enabled Services</b></td><td><b>Action</b></td></tr>';
//    foreach ($response_to_request['Body'] as $site) {
//        //print_r($site->siteInfo->enabledContainers);
//        $service_info = array();
//        foreach ($site->siteInfo->enabledContainers as $services) {
//            $service_info[] = $services->containerName;
//        }
//        echo '<tr><td><a target="_blank" href="site_summaries.php?SiteAccId='.$site->siteAccountId.'">'.$site->siteAccountId.'</a></td><td>'.$site->siteInfo->siteId.'</td><td>'.$site->siteInfo->orgId.'</td><td>'.$site->siteInfo->defaultDisplayName.'</td><td>'.  implode(", ", $service_info).'</td><td><a href="site_refresh.php?SiteAccId='.$site->siteAccountId.'">Refresh</a></td></tr>';
//    }
//    echo '</table>';
//    
//    echo '<br/><br/>JSON Response : <pre>';
//    
//    print_r($response_to_request['Body'][0]);
}
