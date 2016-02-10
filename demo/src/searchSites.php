<?php session_start();
require_once "config.inc.php";
require_once "restclient.class.php";

## =================== / =======================================
## Parameters  
## =================== / =======================================
if($_SESSION['login_response']['isValid']) {
    $cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
    $userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
    $siteSearchString   = ( isset($_POST["siteSearchString"]) ) ? $_POST["siteSearchString"] : "";
}
else{
    echo 'Invalid session.';
}

$response        = array();

$config = array(
	"url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_SEARCH_SITES,
	"parameters" => array(
			"cobSessionToken" => $cobSessionToken,
			"userSessionToken" => $userSessionToken,
			"siteSearchString" => $siteSearchString
		)
);

//print_r($config); die;
$response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);

//print json_encode($response_to_request);
//echo '<pre>';
//print_r($response_to_request['Body']);


echo '<table border="1" cellpadding="" width="100%">';
echo '<thead>';
echo '<tr><th>siteId</th><th>AlreadyAddedByUser</th><th>DisplayName</th><th>ServiceInfos</th><th>Base URL</th><th>Login URL</th><th>Help Text</th></tr>';
echo '</thead>';
echo '<tbody>';

if(sizeof($response_to_request['Body']) > 0) {
    foreach ($response_to_request['Body'] as $body) {
        
        $_SESSION['loginForms'][$body->siteId] = $body->loginForms;
        echo '<tr><td>'.$body->siteId.'</td><td>'.$body->isAlreadyAddedByUser.'</td><td><a href="http://localhost/yodlee/demo/site_login.php?site='.$body->siteId.'">'.$body->defaultDisplayName.'</a></td><td>'.json_encode($body->contentServiceInfos).'</td><td>'.$body->baseUrl.'</td><td>'.$body->loginUrl.'</td><td>'.$body->defaultHelpText.'</td></tr>';
        
        ////print_r($body);
    }
}
else{
    echo '<tr><td>data not found.</td></tr>';
}

echo '</tbody>';
echo '</table>';