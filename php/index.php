<!DOCTYPE html>
<HTML>
<HEAD>
	<title>SampleApp - PHP</title>
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

<!-- Cobrand Session Token -->
<div class="cobSessionToken">
<fieldset>
	<legend>Cobrand Session Token</legend>
	<div class="c-method">
		<div class="notifications alert alert-error" style="display:none;"></div>
		<input type="text" class="span" value="sbCobmr.rakesh" title="cobrandLogin" id="cobrandLogin" placeholder="Enter the cobrand login">
		<input type="password" class="span" value="e00b8446-1c69-4cae-80de-abbce64b18e4" title="cobrandPassword" id="cobrandPassword" placeholder="Enter the cobrand password">
		<div class="input-prepend">
			<input type="button" class="btn btn-primary btn-cobSession-Token" value="Get CobSession Token" />
			<input type="text" name="cobSessionToken" class="span5" title="cobSessionToken"  id="cobSessionToken">
		</div>
		<p><strong>Response Json:</strong></p>
		<textarea id="response-cobSessionToken" class="response"></textarea>
	</div>
</fieldset>
</div>
<!-- Cobrand Session Token -->

<hr>

<!-- User Login -->
<div class="userSessionToken">
<fieldset>
	<legend>User Login</legend>
	<div class="c-method">
		<div class="notifications alert alert-error" style="display:none;"></div>
		<input type="text" class="span" value="sbMemmr.rakesh1" id="login" title="login" placeholder="Enter the username">
	    <input type="password" class="span" value="sbMemmr.rakesh1#123" title="password" id="password" placeholder="Enter the password">
		<div class="input-prepend">
			<input type="button" class="btn btn-primary btn-userSession-Token" value="Get UserSession Token" />
			<input type="text" name="userSessionToken" title="userSessionToken" class="span5" id="userSessionToken">
		</div>
		<p><strong>Response Json:</strong></p>
		<textarea id="response-userSessionToken" class="response span10"></textarea>
	</div>
</fieldset>
</div>
<!-- User Login -->

<hr>
<h1>REST service Implementation</h1>
<hr>

<!-- Method search sites -->
<fieldset>
	<legend class="description"><b>Method</b>: Search Sites</legend>
	<div class="c-method searchSite">
		<label>Cobrand session Token</label>
			<input placeholder="cobSessionToken" class="ref-cobSessionToken span13">
		<label>User session Token</label>
			<input placeholder="userSessionToken" class="ref-userSessionToken span13">
		<label>siteSearchString</label>
			<input class="ref-SearchSites-siteSearchString span13" value="APS">
		<br><br>
		<button class="btn btn-searchSite btn-primary">Send data</button>
		<br><br>
		<p><strong>Response Json:</strong></p>
		<textarea id="response-searchSite" class="response span10"></textarea>
	</div>
</fieldset>
<!-- Method search sites -->

<!-- Method getSiteLoginForm -->
<fieldset>
	<legend class="description"><b>Method</b>: Get Site Login Form</legend>
	<div class="c-method getSiteLoginForm">
		<label>Cobrand session Token</label>
			<input placeholder="cobSessionToken" class="ref-cobSessionToken span13">
		<label>User session Token</label>
			<input placeholder="userSessionToken" class="ref-userSessionToken span13">
		<label>siteId</label>
			<input class="ref-getSiteLoginForm-siteId span13" value="16441">
		<br><br>
		<button class="btn btn-getSiteLoginForm btn-primary">Send data</button>
		<br><br>
		<p><strong>Response Json:</strong></p>
		<textarea id="response-getSiteLoginForm" class="response span10"></textarea>
	</div>
</fieldset>
<!-- Method getSiteLoginForm -->

<!-- Method Site Account Management: addSiteAccount  -->
<fieldset>
	<legend class="description"><b>Method</b>: Site Account Management - addSiteAccount </legend>
	<form id="IDaddSiteAccount">
	<div class="c-method addSiteAccount ">
		<label>Cobrand session Token</label>
			<input placeholder="cobSessionToken" name="cobSessionToken" class="ref-cobSessionToken span13">
		<label>User session Token</label>
			<input placeholder="userSessionToken" name="userSessionToken" class="ref-userSessionToken span13">
		<label>siteId</label>
			<input class="ref-addSiteAccount-siteId span13" name="siteId" value="16441">

		<label>credentialFields[0].valueIdentifier</label>
			<input type="text" name="credentialFields[0].valueIdentifier" class="span13" value="LOGIN1">
		<label>credentialFields[0].valueMask</label>
			<input type="text" name="credentialFields[0].valueMask" class="span13" value="LOGIN_FIELD">
		<label>credentialFields[0].fieldType.typeName</label>
			<input type="text" name="credentialFields[0].fieldType.typeName" class="span13" value="IF_LOGIN">
		<label>credentialFields[0].size</label>
			<input type="text" name="credentialFields[0].size" class="span13" value="20">
		<label>credentialFields[0].value</label>
			<input type="text" name="credentialFields[0].value" class="span13" placeholder="Enter the login" value="">
		<label>credentialFields[0].maxlength</label>
			<input type="text" name="credentialFields[0].maxlength" class="span13" value="20">
		<label>credentialFields[0].name</label>
			<input type="text" name="credentialFields[0].name" class="span13" value="LOGIN1">
		<label>credentialFields[0].displayName</label>
			<input type="text" name="credentialFields[0].displayName" class="span13" value="Catalog">
		<label>credentialFields[0].isEditable</label>
			<input type="text" name="credentialFields[0].isEditable" class="span13" value="true">
		<label>credentialFields[0].isOptional</label>
			<input type="text" name="credentialFields[0].isOptional" class="span13" value="false">
		<label>credentialFields[0].isEscaped</label>
			<input type="text" name="credentialFields[0].isEscaped" class="span13" value="false">
		<label>credentialFields[0].helpText</label>
			<input type="text" name="credentialFields[0].helpText" class="span13" value="150862">
		<label>credentialFields[0].isOptionalMFA</label>
			<input type="text" name="credentialFields[0].isOptionalMFA" class="span13" value="false">
		<label>credentialFields[0].isMFA</label>
			<input type="text" name="credentialFields[0].isMFA" class="span13" value="false">

		<label>credentialFields[1].valueIdentifier</label>
			<input type="text" name="credentialFields[1].valueIdentifier" class="span13" value="PASSWORD1">
		<label>credentialFields[1].valueMask</label>
			<input type="text" name="credentialFields[1].valueMask" class="span13" value="LOGIN_FIELD">
		<label>credentialFields[1].fieldType.typeName</label>
			<input type="text" name="credentialFields[1].fieldType.typeName" class="span13" value="IF_PASSWORD">
		<label>credentialFields[1].size</label>
			<input type="text" name="credentialFields[1].size" class="span13" value="20">
		<label>credentialFields[1].value</label>
			<input type="text" name="credentialFields[1].value" class="span13" placeholder="Enter the password" value="Password">
		<label>credentialFields[1].maxlength</label>
			<input type="text" name="credentialFields[1].maxlength" class="span13" value="40">
		<label>credentialFields[1].name</label>
			<input type="text" name="credentialFields[1].name" class="span13" value="PASSWORD1">
		<label>credentialFields[1].displayName</label>
			<input type="text" name="credentialFields[1].displayName" class="span13" value="Password">
		<label>credentialFields[1].isEditable</label>
			<input type="text" name="credentialFields[1].isEditable" class="span13" value="true">
		<label>credentialFields[1].isOptional</label>
			<input type="text" name="credentialFields[1].isOptional" class="span13" value="false">
		<label>credentialFields[1].isEscaped</label>
			<input type="text" name="credentialFields[1].isEscaped" class="span13" value="false">
		<label>credentialFields[1].helpText</label>
			<input type="text" name="credentialFields[1].helpText" class="span13" value="150863">
		<label>credentialFields[1].isOptionalMFA</label>
			<input type="text" name="credentialFields[1].isOptionalMFA" class="span13" value="false">
		<label>credentialFields[1].isMFA</label>
			<input type="text" name="credentialFields[1].isMFA" class="span13" value="false">
		<label>credentialFields.enclosedType</label>
			<input type="text" name="credentialFields.enclosedType" value="com.yodlee.common.FieldInfoSingle" class="span13">

		<br><br>
		<button class="btn btn-addSiteAccount btn-primary">Send data</button>
		<br><br>
		<p><strong>Response Json:</strong></p>
		<textarea id="response-addSiteAccount" class="response span10"></textarea>
	</div>
	</form>
</fieldset>
<!-- Method Site Account Management: addSiteAccount  -->


<!-- Method getItemSummaries  -->
<fieldset>
	<legend class="description"><b>Method</b>: GetItem Summaries</legend>
	<div class="c-method getItemSummaries ">
		<label>Cobrand session Token</label>
			<input placeholder="cobSessionToken" class="ref-cobSessionToken span13">
		<label>User session Token</label>
			<input placeholder="userSessionToken" class="ref-userSessionToken span13">
		<br><br>
		<button class="btn btn-getItemSummaries btn-primary">Send data</button>
		<br><br>
		<p><strong>Response Json:</strong></p>
		<textarea id="response-getItemSummaries" class="response span10"></textarea>
	</div>
</fieldset>
<!-- Method getItemSummaries  -->

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js"></script>
<script src="js/codemirror.js"></script>
<script src="js/javascript.js"></script>
</BODY>
</HTML>