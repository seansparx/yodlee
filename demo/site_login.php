<?php
    session_start();

    $credentialFields = $_SESSION['loginForms'][$_GET['site']][0]->componentList;

    $credentialFields[0]->value = ''; // site login id.
    $credentialFields[1]->value = ''; // site password.

    $cobSessionToken    = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
    $userSessionToken   = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;

    $login_form = array(
                    "siteId"                                    => $_GET['site'], 
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
        echo '<pre>';
        include_once 'src/addSiteAccount.php';
    ?>
</BODY>
</HTML>