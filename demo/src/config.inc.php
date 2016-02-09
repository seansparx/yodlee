<?php
/****************************************************************/
/* Config Parameters for interactions with the RestApi Yodlee   */
/****************************************************************/
namespace Yodlee\ConfigInc{
	const serviceBaseUrl = "https://rest.developer.yodlee.com/services/srest/restserver/v1.0";
	// Url for get the value cobSessionToken for the user.
	const URL_COBRAND_SESSION_TOKEN = "/authenticate/coblogin";
	// Url for get the value userSessionToken for the user.
	const URL_USER_SESSION_TOKEN = "/authenticate/login";
	// Url for get search Site
	const URL_SEARCH_SITES = "/jsonsdk/SiteTraversal/searchSite";
	// Url for get Site Login Form
	const URL_GET_SITE_LOGIN_FORM = "/jsonsdk/SiteAccountManagement/getSiteLoginForm";
	// Url for get itemSummaries
	const URL_GET_ITEM_SUMMARIES = "/jsonsdk/DataService/getItemSummaries";
    // Url Site Account Management: addSiteAccount 
	const URL_ADD_SITE_ACCOUNT = "/jsonsdk/SiteAccountManagement/addSiteAccount";	
}
?>