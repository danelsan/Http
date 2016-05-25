<?php

namespace Http;

class Server  {
	private $request;
	private $ip;
	
	/**
	 * Create the client object
	 *
	 * @param string $url        	
	 */
	public function __construct( ) {
		$this->setRequest();
	}
	
	private function setRequest() {
		$url = "http://" . $_SERVER ['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
		
		$request = new Request ( $url, $_SERVER['REQUEST_METHOD'] );
		if ( isset ( $_SERVER ['HTTP_REFERRER'] ) )
			$request->setReferrer ( $_SERVER ['HTTP_REFERRER'] );
		
		$this->ip = $_SERVER ['REMOTE_ADDR'];
		//	$request->set ( $_SERVER ['REMOTE_ADDR'] );
		$request->setBody ( file_get_contents ( "php://input" ) );
		
		if ( $request->getMethod () !== 'POST' ) {
			parse_str ( $request->getBody (), $post_vars );
			$request->setPost ( $post_vars );
		} else {
			$request->setPost ( $_POST );
		}
		
		foreach ( getallheaders () as $k => $v ) {
				$request->addHeader ( $k, $v );
		}
		$this->request = $request;
	}
	
	public function getRequest() {
		return $this->request;
	}
	
	public function createResponse( $body, $status = 200, $headers = array() ) {
		$response = new Response($body, $status, $headers);
		return $response;
	}
	
	
}

?>