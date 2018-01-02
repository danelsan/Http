<?php

namespace Http;

class Method {
	private $method;
	private $valid_methods = array('GET','POST','PUT','DELETE','OPTIONS');
	
	/**
	 * The url parameter is compresive of query string
	 *
	 * @param string $url        	
	 */
	public function __construct( $method = 'GET' ) {		
		$this->set( $method );
	}
	
	/**
	 * Set the url parameters
	 *
	 * @param unknown $url        	
	 */
	public function set( $method ) {
		$this->validate( $method );
		$this->method = strtoupper( $method );		
	}
		
	public function get( ) {
		return $this->method;
	}
	
	public function validate( $method ) {
		if ( !is_string( $method ) )
			throw new \Exception("Method '$method' is not a string");
		
		$method = strtoupper($method);
		if ( !in_array( $method, $this->valid_methods ) )
			throw new \Exception("Method '$method' not valid");
	}
}

?>
