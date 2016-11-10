<?php
use Http\Response;
use Http\HttpStatusCode;

class ResponseTest extends PHPUnit_Framework_TestCase {
	private $response;
	public function setUp() {
	}
	public function testResponseConstruct() {
		$response = new Response ();
		$true =  $response->getStatus () instanceof Http\HttpStatusCode ;
		$this->assertTrue ( $true );
		$this->assertEquals ( $response->getStatus ()->getCode(), 200);
		$this->assertEquals ( $response->getBody (), '' );
		$this->assertEquals ( $response->getHeaders (), array () );
	}
	public function testResponseChangeBody() {
		$response = new Response ( 'Body', 404 );
		$this->assertEquals ( $response->getStatus ()->getCode(), 404 );
		$this->assertEquals ( $response->getBody (), 'Body' );
		$response->setBody ( 'BB' );
		$this->assertEquals ( $response->getBody (), 'BB' );
		
		$this->assertEquals ( $response->getHeaders (), array () );
	}
	public function testResponseChangeStatus() {
		$response = new Response ( 'Body', 404 );
		$this->assertEquals ( $response->getStatus ()->getCode(), 404 );
		$this->assertEquals ( $response->getBody (), 'Body' );
		$response->setStatus ( 200 );
		$this->assertEquals ( $response->getStatus ()->getCode(), 200 );
		$this->assertEquals ( $response->getHeaders (), array () );
	}
	public function testResponseChangeHeaders() {
		$response = new Response ( 'Body', 404 );
		$this->assertEquals ( $response->getStatus ()->getCode(), 404 );
		$this->assertEquals ( $response->getBody (), 'Body' );
		$response->addHeader ( 'Auth', 'author' );
		$this->assertEquals ( $response->getStatus ()->getCode(), 404 );
		$this->assertEquals ( $response->getHeaders (), array (
				'Auth' => 'author' 
		) );
		$response->addHeader ( 'Auth', 'author_change' );
		$this->assertEquals ( $response->getHeaders (), array (
				'Auth' => 'author_change' 
		) );
	}

	public function testStatus() {
		$response = new Response('body','200');

		$status = $response->getStatus()->getCode();
		$this->assertEquals ( $response->getStatus ()->getCode(), 200 );	
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
