<?php
namespace Yodlee;

class restClient{
	private static function _getErrors($errors){
		$Errors = array();
		foreach ($errors->Error as $key => $value) {
			$Errors []= $value->errorDetail;
		}
		return $Errors; 
	}

	public static function Post( $url, $parameters = array() ) {
		$return_values = array();

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 360);

		if(count($parameters)>0){
			curl_setopt($ch, CURLOPT_POST, count($parameters));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		}

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
               $return_values['Error'] = "Failed to reach $url.";
        } else {
			if ($response) {
				if(gettype($response) == "string"){
					$result = json_decode($response);
					if($result){
						$exitsError = array_key_exists("Error", $result);
						if($exitsError){
							$return_values["Body"] = self::_getErrors($result);
						}else{
							$return_values["Body"] = $result;
						}
					}else{
						$result = simplexml_load_string($response);
						$return_values["Body"] = $response;
					}
	        	}else{
	        		$result = json_decode($response);
	        		if($result === null) {
						$return_values['Body'] = "The request does not return any value.";
					} else {
						$return_values["Body"] = $result;
					}
	        	}
			}else{
				$return_values['Error'] = "Failed to reach $url.";
			}
        }
		curl_close($ch);
		return $return_values;
	}
}