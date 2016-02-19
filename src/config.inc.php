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

        const URL_GET_ALL_SITE_ACCOUNTS = "/jsonsdk/SiteAccountManagement/getAllSiteAccounts";	

        const URL_GET_ITEM_SUMMARIES_FOR_SITE = "/jsonsdk/DataService/getItemSummariesForSite";	

        const URL_SEARCH_TRANSACTIONS = "/jsonsdk/TransactionSearchService/executeUserSearchRequest";	

        const URL_GET_USER_TRANSACTIONS = "/jsonsdk/TransactionSearchService/getUserTransactions";	

        const URL_START_SITE_REFRESH = "/jsonsdk/Refresh/startSiteRefresh";

        const URL_GET_SITE_REFRESH_INFO = "/jsonsdk/Refresh/Refresh/getSiteRefreshInfo";
        
        const URL_GET_POPULAR_SITES = "/jsonsdk/SiteTraversal/getPopularSites";
        
        const URL_DEACTIVATE_ITEM_ACCOUNT = "/jsonsdk/ItemAccountManagement/deactivateItemAccount";
        
        const URL_TRANSACTION_CATEGORY_TYPE = "/jsonsdk/TransactionCategorizationService/getTransactionCategoryTypes";
        
        const URL_GET_USER_TRANSACTION_CATEGORY = "/jsonsdk/TransactionCategorizationService/getUserTransactionCategories";
        
        const URL_GET_CATEGORIZE_TRANSACTION = "/jsonsdk/TransactionCategorizationService/categorizeTransactions";
        
        const URL_REMOVE_SITE_ACCOUNT = "/jsonsdk/SiteAccountManagement/removeSiteAccount";
        
        const URL_REMOVE_ITEM_ACCOUNT = "/jsonsdk/ItemAccountManagement/removeItemAccount";
        
        const URL_GET_ACCESS_TOKEN = "/jsonsdk/OAuthAccessTokenManagementService/getOAuthAccessToken";
        
        const URL_USER_REGISTRATION = "/jsonsdk/UserRegistration/register3";
        
        const URL_GET_LOGOUT = "/jsonsdk/Login/logout";
    }
?>