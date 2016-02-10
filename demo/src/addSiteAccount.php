<?php
require_once "config.inc.php";
require_once "restclient.class.php";

## =================== / =======================================
## Parameters  
## =================== / =======================================
$params = ( isset($_POST["params"]) ) ? $_POST["params"] : "";
$data = explode("&", $params);

$sendParameters = array();
$FIELD = 0;
$VALUE = 1; 

foreach( $data as $ref ){
    $f = explode("=", $ref);
    $sendParameters[urldecode($f[$FIELD])] = urldecode($f[$VALUE]);
}
/*
 * {
    "conjunctionOp": {
        "conjuctionOp": 1
    },
    "componentList": [
        {
            "valueIdentifier": "LOGIN",
            "valueMask": "LOGIN_FIELD",
            "fieldType": {
                "typeName": "IF_LOGIN"
            },
            "size": 20,
            "maxlength": 10,
            "fieldInfoType": "com.yodlee.common.FieldInfoSingle",
            "name": "LOGIN",
            "displayName": "Customer ID (Login ID)",
            "isEditable": true,
            "isOptional": false,
            "isEscaped": false,
            "helpText": "134623",
            "isOptionalMFA": false,
            "isMFA": false
        },
        {
            "valueIdentifier": "PASSWORD",
            "valueMask": "LOGIN_FIELD",
            "fieldType": {
                "typeName": "IF_PASSWORD"
            },
            "size": 20,
            "maxlength": 15,
            "fieldInfoType": "com.yodlee.common.FieldInfoSingle",
            "name": "PASSWORD",
            "displayName": "IPIN (password)",
            "isEditable": true,
            "isOptional": false,
            "isEscaped": false,
            "helpText": "134622",
            "isOptionalMFA": false,
            "isMFA": false
        }
    ],
    "defaultHelpText": "8772"
}
 */
//$cobSessionToken = ( isset($_POST["cobSessionToken"]) ) ? $_POST["cobSessionToken"] : "";
//$userSessionToken = ( isset($_POST["userSessionToken"]) ) ? $_POST["userSessionToken"] : "";

$cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
$userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
$siteId = ( isset($_POST["siteId"]) ) ? $_POST["siteId"] : "";
$credentialFields = ( isset($_POST["credentialFields"]) ) ? $_POST["credentialFields"] : "";

$response = array();

$config = array(
	"url" => Yodlee\ConfigInc\serviceBaseUrl.Yodlee\ConfigInc\URL_ADD_SITE_ACCOUNT,
	"parameters" => $sendParameters
	);

$response_to_request   = Yodlee\restClient::Post($config["url"], $config["parameters"]);

print json_encode($response_to_request);