<?php 
/**
 * MailChimp API 3.0 PHP Wrapper Class
 * 
 * Uses cURL to connect to the API with basic authorization
 * 
 * @author BlueFractals <admin@blue-fractals.com>
 * @version 1.0
 */

class MailChimp {
	private $apikey;
	private $endpoint = 'https://<dc>.api.mailchimp.com/3.0/';
	private $ssl = false;


	/**
	 * Constructor
	 * 
	 * @param string $apikey MailChimp API key. Base64 encoded in api_call() before sending through the headers.
	 * @param bool $ssl Default true. Setting this to false might help while working on localhost. 
	 */
	public function __construct($apikey, $ssl=true) {
		$this->apikey = $apikey;
		list(, $datacenter) = explode('-', $apikey);
		$this->endpoint = str_replace('<dc>', $datacenter, $this->endpoint);
		if ($ssl == false) $this->ssl = $ssl;
	}


	/**
	 *
	 * @param  string $method This may include a list id and other additional ids. See test.php file for examples.
	 * @param  string $action Default 'GET'. Allowed HTTP verbs: 'GET', 'POST', 'PATCH' or 'DELETE'.
	 * @param  array  $args   Array of arguments to send to the MailChimp API call.
	 * @param  int $timeout Default 10. Max. seconds to allow cURL functions to execute.
	 * @return array MailChimp API response
	 */
	public function call($method, $action, $args=array(), $timeout=10) {
		$allowed_actions = array ('GET', 'POST', 'PATCH', 'DELETE');
		if (in_array($action, $allowed_actions)) {
			return $this->api_call($method, $action, $args, $timeout);
		} else {
			return "Invalid action value. Use 'GET', 'POST', 'PATCH' or 'DELETE'.";
		}
	}
	
	/**
	 * MailChimp API call
	 */
	private function api_call($method, $action, $args=array(), $timeout=10) {
		$auth = base64_encode('apikey:'.$this->apikey);
		$url = $this->endpoint.$method;
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: Basic '.$auth
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_URL, $url);
		
		if ($action == "GET") {
			if (count($args)) {
				curl_setopt($ch, CURLOPT_URL, $url.'?'.http_build_query($args));
			}
		} else if ($action == "POST") {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
		} else if ($action == "PATCH") {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
		} else if ($action == "DELETE") {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		}
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->ssl);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response ? json_decode($response, true) : false;
	}
}
