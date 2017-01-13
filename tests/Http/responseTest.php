<?php

use Http\Response;
use Http\HttpStatusCode;

class ResponseTest extends PHPUnit_Framework_TestCase {
	private $response;
	public function setUp() {
	}
	public function testResponseConstruct() {
		$response = Response::Http ();
		
		$this->assertTrue( $response instanceof Http\ResponseHttp );
		$true =  is_string( $response->getStatus () );
		$this->assertTrue ( $true );
		$this->assertEquals ( $response->getStatusCode (), 200);
		$this->assertEquals ( $response->getBody (), '' );
		$this->assertEquals ( $response->getHeaders (), array () );
	}
	public function testResponseChangeBody() {
		$response = Response::Http ( 'Body', 404 );
		$this->assertEquals ( $response->getStatusCode (), 404 );
		$this->assertEquals ( $response->getBody (), 'Body' );
		$response->setBody ( 'BB' );
		$this->assertEquals ( $response->getBody (), 'BB' );
		
		$this->assertEquals ( $response->getHeaders (), array () );
	}
	public function testResponseChangeStatus() {
		$response = Response::Http ( 'Body', 404 );
		$this->assertEquals ( $response->getStatusCode (), 404 );
		$this->assertEquals ( $response->getBody (), 'Body' );
		$response->setStatus ( 200 );
		$this->assertEquals ( $response->getStatusCode (), 200 );
		$this->assertEquals ( $response->getHeaders (), array () );
	}
	public function testResponseChangeHeaders() {
		$response =  Response::Http ( 'Body', 404 );
		$this->assertEquals ( $response->getStatusCode(), 404 );
		$this->assertEquals ( $response->getBody (), 'Body' );
		$response->addHeader ( 'Auth', 'author' );
		$this->assertEquals ( $response->getStatusCode (), 404 );
		$this->assertEquals ( $response->getHeaders (), array (
				'Auth' => 'author' 
		) );
		$response->addHeader ( 'Auth', 'author_change' );
		$this->assertEquals ( $response->getHeaders (), array (
				'Auth' => 'author_change' 
		) );
	}

	public function testStatus() {
		$response = Response::Http('body','200');

		$status = $response->getStatusCode();
		$this->assertEquals ( $response->getStatusCode (), 200 );	
	}

	public function testHttpStatusCode() {
		$status = new HttpStatusCode('200');
		$this->assertEquals ( $status->getCode (), 200 );
		
		try {	
			$status = new HttpStatusCode( array(200));
        	        $result = false;
		} catch ( \Exception $e ) {
			$result = true;
		}
		$this->assertTrue( $result );
	}
}
