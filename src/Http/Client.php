<?php

namespace Http;

class Client  {
	private $agent;
	
	/**
	 * Create the client object
	 *
	 * @param string $url        	
	 */
	public function __construct( ) {
		$this->agent = 'Mozilla/5.0 (X11; U; Linux i686; it; rv:1.8.1.12) Gecko/20080207 Ubuntu/7.10 (gutsy) Firefox/2.0.0.12';
	}
	
	public function createRequest( $url, $method = 'GET' ) {
		$request = new Request($url, $method);
		$request->addHeader('User-Agent', $this->getAgent() );
		return $request;
	}
	
	/**
	 * Send a request 
	 * 
	 * @param IRequest $request
	 * @return IResponse
	 */
	public function send( IRequest $request ) {
		return $request->send();
	}
	
	public function getAgent() {
		return $this->agent;
	}
}

?>