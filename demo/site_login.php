<?php
    session_start();

    echo '<pre>';
        $credentialFields = $_SESSION['loginForms'][$_GET['site']][0]->componentList;
        //print_r($_SESSION['loginForms'][$_GET['site']]);
        //print_r($credentialFields);
        
        $credentialFields[0]->value = ''; // site login id.
        $credentialFields[1]->value = ''; // site password.
        
        //echo '<br>';
        
        $cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
        $userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
    
        $login_form = array(
                        "cobSessionToken"                           => $cobSessionToken, 
                        "userSessionToken"                          => $userSessionToken,
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
    
                    print_r($login_form);
    die;
    
    /* Response after login success.
     * 
     * {
    "siteAccountId": 10109248,
    "isCustom": false,
    "credentialsChangedTime": 1455108764,
    "siteRefreshInfo": {
        "siteRefreshStatus": {
            "siteRefreshStatusId": 1,
            "siteRefreshStatus": "REFRESH_TRIGGERED"
        },
        "siteRefreshMode": {
            "refreshModeId": 2,
            "refreshMode": "NORMAL"
        },
        "updateInitTime": 1455108764,
        "nextUpdate": 1455109664,
        "code": 801,
        "suggestedFlow": {
            "suggestedFlowId": 2,
            "suggestedFlow": "REFRESH"
        },
        "noOfRetry": 0,
        "isMFAInputRequired": false,
        "siteAddStatus": {
            "siteAddStatusId": 13,
            "siteAddStatus": "ADD_IN_PROGRESS"
        },
        "memSiteAccId": 10109248
    },
    "siteInfo": {
        "popularity": 0,
        "siteId": 16441,
        "orgId": 1148,
        "defaultDisplayName": "Dag Site",
        "defaultOrgDisplayName": "Demo Bank",
        "enabledContainers": [
            {
                "containerName": "bank",
                "assetType": 1
            },
            {
                "containerName": "bills",
                "assetType": 0
            },
            {
                "containerName": "credits",
                "assetType": 2
            },
            {
                "containerName": "insurance",
                "assetType": 2
            },
            {
                "containerName": "stocks",
                "assetType": 1
            },
            {
                "containerName": "loans",
                "assetType": 2
            },
            {
                "containerName": "miles",
                "assetType": 0
            }
        ],
        "baseUrl": "http://64.14.28.129/dag/index.do",
        "loginForms": [],
        "isHeld": false,
        "isCustom": false,
        "siteSearchVisibility": true,
        "isAlreadyAddedByUser": true,
        "isOauthEnabled": false,
        "hdLogoLastModified": 0,
        "isHdLogoAvailable": false
    },
    "created": "2016-02-10T04:52:44-0800",
    "retryCount": 0,
    "disabled": false,
    "isAgentError": false,
    "isSiteError": false,
    "isUARError": false
}
     */
?>
<!DOCTYPE html>
<HTML>
<HEAD>
	<title>Demo - Step 3</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="css/codemirror.css">
	<link rel="stylesheet" href="css/eclipse.css">
	<style>
		body{
			padding: 10px;	
		}
		.c-method{
			margin-left: 20px;
		}
	</style>
</HEAD>
<BODY>
    <h5>Username : <?php echo $_SESSION['login_response']['Body']->loginName.' ('.$_SESSION['login_response']['Body']->userId.')'; ?></h5>
    <?php 
//        if(isset($_SESSION['loginForms'][$_GET['site']][0]) && count($_SESSION['loginForms'][$_GET['site']][0]->componentList) > 0) {
//            foreach($_SESSION['loginForms'][$_GET['site']][0]->componentList as $comp) {
//                print_r($comp);
//                //echo '<input type="/>';
//            }
//        }
    ?>
    <fieldset>
	<legend class="description"><b>Method</b>: Site Account Management - addSiteAccount </legend>
	
</fieldset>
</BODY>
</HTML>