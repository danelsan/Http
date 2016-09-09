<?php

namespace Http;

class Request implements IRequest {
	private $method;
	private $post;
	private $url;
	private $agent;
	private $proxy;
// 	private $uploaded;
// 	private $parsed_url;
	private $headers;
	private $body;
// 	private $referrer;
// 	private $remote_address;
	private $validate = FALSE;
	private $follow;
	
	/**
	 * The url parameter is compresive of query string
	 *
	 * @param string $url        	
	 */
	public function __construct( $url, $method = 'GET') {
		$this->follow = true;
		$this->method = new Method($method);
		$this->post = array ();
		try {
			$this->url = new Url( $url );
			$this->validate = TRUE;
		}
		catch (\Exception $e ) {
			
		}
		$this->agent = "Agent Request Anonym";
		$this->headers = array();
		$this->body = '';
		$this->proxy = NULL;
		$this->setUrl ( $url );
	}
	
	public function setFollow( $follow = true ) {
		if ( $follow !== true )
			$this->follow = false;
		else
			$this->follow = true;
	}
	
	public static function create( $url, $method = 'GET') {
		$request = new Request($url,$method);
		return $request;
	}
	
// 	/**
// 	 * Create the request give from Server
// 	 *
// 	 * @return IRequest
// 	 */
// 	public static function createRequest() {
// 		$url = "http://" . $_SERVER ['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
		
// 		$request = new Request ( $url );
// 		if (isset ( $_SERVER ['HTTP_REFERRER'] ))
// 			$request->setReferrer ( $_SERVER ['HTTP_REFERRER'] );
		
// 		$request->setRemoteAddress ( $_SERVER ['REMOTE_ADDR'] );
// 		$request->setBody ( file_get_contents ( "php://input" ) );
// 		$request->setMethod ( $_SERVER ['REQUEST_METHOD'] );
		
// 		if ($request->getMethod () !== 'POST') {
// 			parse_str ( $request->getBody (), $post_vars );
// 			$request->setPost ( $post_vars );
// 		} else {
// 			$request->setPost ( $_POST );
// 		}
		
// 		foreach ( getallheaders () as $k => $v ) {
// 			$request->addHeader ( $k, $v );
// 		}
// 		return $request;
// 	}
// 	public function setReferrer($referrer) {
// 		$this->referrer = $referrer;
// 	}
// 	public function getReferrer() {
// 		return $this->referrer;
// 	}
// 	public function setRemoteAddress($remoteAddress) {
// 		$this->remote_address = $remoteAddress;
// 	}
	public function setQuery($key, $value = NULL) {
		$this->url->setQuery($key, $value);
// 		if (is_array ( $key ) && ! $value) {
// 			foreach ( $key as $k => $v ) {
// 				$this->query [$k] = $v;
// 			}
// 		} else
// 			$this->query [$key] = $value;
	}
	public function setPost($key, $value = NULL) {
		if (is_array ( $key ) && ! $value) {
			foreach ( $key as $k => $v ) {
				$this->post [$k] = $v;
			}
		} else
			$this->post [$key] = $value;
	}
	public function getQuery($key) {
		return $this->url->getQuery($key);
// 		if (! $key)
// 			return $this->query;
// 		else
// 			return (isset ( $this->query [$key] ) ? $this->query [$key] : NULL);
	}
	public function getPost($key = NULL) {
		if (! $key)
			return $this->post;
		else
			return (isset ( $this->post [$key] ) ? $this->post [$key] : NULL);
	}
	
	/**
	 * Set url with parsed method
	 *
	 * @see IRequest::setUrl()
	 */
	public function setUrl( $url) {
		$this->url->set($url);
	}
	
	/**
	 * Return url with query if exist
	 */
	public function getUrl() {
		return $this->url->get();
	}
	
	public function getUri() {
		return $this->url->getPath();	
	}
	
	public function getPosts() {
		return $this->post;
	}
	public function getQueries() {
		return $this->url->getQueries();
	}
	public function getMethod() {
		return $this->method->get();
	}
	public function setMethod( $method ) {
		$this->method->set($method);
	}
	public function getBody() {
		return $this->body;
	}
	public function setBody( $body) {
		if ( !is_null($body) && !is_string($body))
			throw new \Exception("Body is not a string");
		$this->body = $body;
	}
	public function getHeaders() {
		return $this->headers;
	}
	public function addHeader( $code,  $value) {
		$this->headers [$code] = $value;
	}
	public function setProxy( $url ) {
		$this->proxy = new Proxy($url);
	}
	public function send() {
		if ( !function_exists('curl_init') )
			throw new \Exception("Curl for php non found");
		
		switch ( $this->getMethod() ) {
			case 'GET':
				return  $this->getSend();
				break;
			case 'POST':
				return  $this->postSend();
				break;
			case 'PUT':
				return  $this->putSend();
				break;
			case 'DELETE':
				return  $this->deleteSend();
				break;
			default:
				throw new \Exception("Method not valid to send request");
				break;
		}
		
		
	}
	
	private function getProxyOptions() {
		$option = array();
		if ( !is_null( $this->proxy ) ) {
			$option[CURLOPT_PROXY] = $this->proxy->getDomain().':'.$this->proxy->getPort();
			$user = $this->proxy->getUser();
			if ( $user )
				$option[CURLOPT_PROXYUSERPWD] = $user.':'.$this->proxy->getPassword();
		}
		return $option;
	}
	private function getSend() {
		$curl = \curl_init();
		
		$option = $this->getProxyOptions();

		$option[CURLOPT_RETURNTRANSFER] = 1;
		$option[CURLOPT_URL] 			= $this->url->get();
		$option[CURLOPT_USERAGENT] 		= $this->agent;
		$option[CURLOPT_HEADER]			= 1;
		
		if ( !empty( $this->getPosts() ) ) {
			$data = $this->getPosts();
			$option[CURLOPT_POSTFIELDS]	= http_build_query( $data );
// 			$option[CURLOPT_POST]		= FALSE;
// 			$option[CURLOPT_HTTPGET]	= TRUE;
			$option[CURLOPT_CUSTOMREQUEST]= 'GET';
		}
// 		// Post the body like a json string
// 		if ( $this->getBody() !== '' || !is_null($this->getBody())) {
// 			$data = json_decode( $this->getBody(), true );
			
// 		}
		
		// Set some options - we are passing in a useragent too here
		curl_setopt_array( $curl, $option );
		
		// Send the request & save response to $resp
		$response = curl_exec($curl);
		$error = curl_error($curl);	 
		$info = curl_getinfo($curl);
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		curl_close($curl);
		if ( $error )
			throw new \Exception("Error to send request: ".$error );
		
		if ( empty($info['http_code']) ) 
			throw new \Exception("No HTTP code was returned");
			
		
		$header = http_parse_headers(substr( $response, 0, $header_size) );
		$body = substr($response, $header_size);
		$status = $info['http_code']; 
		return  ( new Response($body,$status,$header) );

	}
	
	private function putSend() {
		$curl = \curl_init();
		$option = $this->getProxyOptions();
		$option[CURLOPT_CUSTOMREQUEST]	= "PUT";
		$option[CURLOPT_RETURNTRANSFER] = 1;
		$option[CURLOPT_HTTPHEADER]		= $this->getHeaders();
		$option[CURLOPT_URL] 			= $this->url->get();
		$option[CURLOPT_USERAGENT] 		= $this->agent;
		$option[CURLOPT_HEADER]			= 1;
		$option[CURLOPT_POSTFIELDS]		= http_build_query($this->getPosts());
		curl_setopt_array($curl, $option );
		
		// Send the request & save response to $resp
		$response = curl_exec($curl);
		$error = curl_error($curl);
		$info = curl_getinfo($curl);
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		curl_close($curl);
		if ( $error )
			throw new \Exception("Error to send request: ".$error );
	
			if ( empty($info['http_code']) )
				throw new \Exception("No HTTP code was returned");
					
				$header = http_parse_headers(substr( $response, 0, $header_size) );
				$body = substr($response, $header_size);
				$status = $info['http_code'];
				return  ( new Response($body,$status,$header) );
	}
	
	private function deleteSend() {
		$curl = \curl_init();
		$option = $this->getProxyOptions();
		$option[CURLOPT_CUSTOMREQUEST]	= "DELETE";
		$option[CURLOPT_RETURNTRANSFER] = 1;
		$option[CURLOPT_HTTPHEADER]		= $this->getHeaders();
		$option[CURLOPT_URL] 			= $this->url->get();
		$option[CURLOPT_USERAGENT] 		= $this->agent;
		$option[CURLOPT_HEADER]			= 1;
		$option[CURLOPT_POSTFIELDS]		= http_build_query($this->getPosts());
		curl_setopt_array($curl, $option );
		
		// Send the request & save response to $resp
		$response = curl_exec($curl);
		$error = curl_error($curl);
		$info = curl_getinfo($curl);
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		curl_close($curl);
		if ( $error )
			throw new \Exception("Error to send request: ".$error );
	
			if ( empty($info['http_code']) )
				throw new \Exception("No HTTP code was returned");
					
				$header = http_parse_headers(substr( $response, 0, $header_size) );
				$body = substr($response, $header_size);
				$status = $info['http_code'];
				return  ( new Response($body,$status,$header) );
	}
	
	private function postSend() {
		$curl = \curl_init();
		$option = $this->getProxyOptions();
		$option[CURLOPT_CUSTOMREQUEST]	= "POST";
		$option[CURLOPT_RETURNTRANSFER] = 1;
		$option[CURLOPT_FOLLOWLOCATION] = $this->follow;
		if ( $this->follow )
			$option[CURLOPT_POSTREDIR]		= true;
		$option[CURLOPT_HTTPHEADER]		= $this->getHeaders();
		$option[CURLOPT_URL] 			= $this->url->get();
		$option[CURLOPT_USERAGENT] 		= $this->agent;
		$option[CURLOPT_HEADER]			= 1;
		$option[CURLOPT_POSTFIELDS]		= http_build_query($this->getPosts());
		curl_setopt_array($curl, $option );
		
		// Send the request & save response to $resp
		$response = curl_exec($curl);
		$error = curl_error($curl);
		$info = curl_getinfo($curl);
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		curl_close($curl);
		if ( $error )
			throw new \Exception("Error to send request: ".$error );
	
			if ( empty($info['http_code']) )
				throw new \Exception("No HTTP code was returned");
					
				$header = http_parse_headers(substr( $response, 0, $header_size) );
				$body = substr($response, $header_size);
				$status = $info['http_code'];
				return  ( new Response($body,$status,$header) );
	}
	
	/**
	 * Request to string
	 */
	public function __toString() {
		$enter = "\n\r";
		$str = $this->getMethod() .' '.$this->url->get(). ' HTTP/1.1'.$enter;
		foreach ($this->getHeaders() as $k=>$v) {
			$str .= $k.': '.$v .$enter;
		}
		$str .= $enter.$enter;
		if ( !empty($this->getPosts() ) ) {
			$this->setBody( http_build_query($this->getPosts()) );
		}
		$str .= $this->getBody();
		return $str;
	}
}

/**
 * Function return header from $_SERVER['HTTP_...']
 */
if (! function_exists ( 'getallheaders' )) {
	function getallheaders() {
		$headers = '';
		foreach ( $_SERVER as $name => $value ) {
			if (substr ( $name, 0, 5 ) == 'HTTP_') {
				$headers [str_replace ( ' ', '-', ucwords ( strtolower ( str_replace ( '_', ' ', substr ( $name, 5 ) ) ) ) )] = $value;
			}
		}
		return $headers;
	}
}

if (!function_exists('http_parse_headers')) {
	function http_parse_headers ($raw_headers) {
		$headers = array(); // $headers = [];
		$raw_headers = trim($raw_headers);
		foreach (explode("\n", $raw_headers) as $i => $h) {
			$h = explode(':', $h, 2);

			if (isset($h[1])) {
				if(!isset($headers[$h[0]])) {
					$headers[$h[0]] = trim($h[1]);
				} else if(is_array($headers[$h[0]])) {
					$tmp = array_merge($headers[$h[0]],array(trim($h[1])));
					$headers[$h[0]] = $tmp;
				} else {
					$tmp = array_merge(array($headers[$h[0]]),array(trim($h[1])));
					$headers[$h[0]] = $tmp;
				}
			}
		}

		return $headers;
	}
}
?>
