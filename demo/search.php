<?php
    session_start();

    if($_SESSION['login_response']['isValid']) {
        //print_r($_SESSION['login_response']['Body']);
        $cobSessionToken  = $_SESSION['login_response']['Body']->userContext->cobrandConversationCredentials->sessionToken;
        //echo '<br>';
        $userSessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
        //echo '<br>';
        
        $sessionToken = $_SESSION['login_response']['Body']->userContext->conversationCredentials->sessionToken;
    }
    else{
        die('Invalid response.');
    }
        
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
    
    <input type="hidden" id="cobSessionToken" placeholder="cobSessionToken" value="<?php echo $cobSessionToken; ?>" class="ref-cobSessionToken span13">
    <input type="hidden" id="userSessionToken" placeholder="userSessionToken" value="<?php echo $userSessionToken; ?>" class="ref-userSessionToken span13">
    
    <!-- Method search sites -->
    <fieldset>
            <legend class="description"><b>Method</b>: Search Sites</legend>
            <div class="c-method searchSite">
                <label>siteSearchString</label>
                        <input class="ref-SearchSites-siteSearchString span13" value="hdfc">
                <br><br>
                <button id="btn-searchSite" class="btn btn-searchSite btn-primary">Search</button>
                <br><br>
                <p id="response-searchSite">
                    <?php include_once 'src/getPopularSites.php'; ?>
                </p>
            </div>
    </fieldset>
    <!-- Method search sites -->
    
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $(function(){

        $.maskLoading = function(selector, opt){
		if(opt.showLoading){
			$(selector).attr("disabled","disabled").text(opt.msg).val(opt.msg);
		}else{
			$(selector).removeAttr("disabled").text(opt.msg).val(opt.msg);
		}
	}
        
        
        $("#btn-searchSite").click(function(e){
            if($("#cobSessionToken").val() == ""){
                    alert("You must get the Cobrand session token.");
                    return false;
            }

            if($("#userSessionToken").val() == ""){
                    alert("You must get the User Session Token.");
                    return false;
            }

            $("div.searchSite").find(".response").val("");
            $.maskLoading("button.btn-searchSite",{showLoading:true, msg:"Loading..."});
            $.ajax({
                    method: "POST",
                    data: {
                            'cobSessionToken': $("#cobSessionToken").val(),
                            'userSessionToken': $("#userSessionToken").val(),
                            'siteSearchString': $("input.ref-SearchSites-siteSearchString").val()
                    },
                    url: "src/searchSites.php",
                    success: function(data, textStatus, jqXHR){ //alert(data);
                            $("#response-searchSite").html(data);
                            $.maskLoading("button.btn-searchSite",{showLoading:false, msg:"Search"});
                    },
                    error: function(){
                            $.maskLoading("button.btn-searchSite",{showLoading:false, msg:"Search"});
                    }
            });
            return false;
        });
    });
    
    
    $.getNewTextArea = function(referenceId){
            return CodeMirror.fromTextArea(document.getElementById(referenceId), {
                    theme: "eclipse",
                    lineWrapping:true,
                    lineNumbers: true,
                    mode: "application/json"
            });
    }
</script>
</BODY>
</HTML>