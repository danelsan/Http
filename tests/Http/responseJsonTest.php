<?php

use Http\Response;

class ResponseJsonTest extends PHPUnit_Framework_TestCase {
	private $response;
	public function setUp() {
	}
	public function testResponseConstruct() {
		$response = Response::Json();
		$true =  $response->getStatus () instanceof Http\HttpStatusCode ;
		$this->assertTrue ( $true );
		$this->assertEquals ( $response->getStatus ()->getCode(), 200);
		$this->assertEquals ( $response->getBody (), '' );
		$this->assertEquals ( $response->getHeaders (), array ('Content-Type'=>'application/json') );
	}
	public function testResponseSetBody() {
		$response = Response::Json ( 'Body' );
		$response->setStatus(404);
		$this->assertEquals ( $response->getStatus ()->getCode(), 404 );
		$this->assertEquals ( $response->getBody (), json_encode('Body') );
	
		ob_start();
		@$response->send();
		$send = ob_get_contents();
		var_dump($send);
		ob_clean();
		ob_end_clean();
		
		$this->assertEquals ( $response->getBody (), $send );
	}
}
