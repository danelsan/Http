<?php
use Http\Response;
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
}
