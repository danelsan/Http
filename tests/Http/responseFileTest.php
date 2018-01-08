<?php
use PHPUnit\Framework\TestCase;
use Http\Response;

class ResponseFileTest extends TestCase {
	private $response;
	public function setUp() {
		$file = 'people.txt';
		$current = "John Smith\n";
		file_put_contents($file, $current);	
	}
	
	public function testResponseConstruct() {
		$response = Response::File( 'people.txt' );
		$this->assertEquals ( $response->isFile(), true );
		$response = Response::File( 'people.tx' );
		$this->assertEquals ( $response->isFile(), false );
		
	}
	public function testResponseSetBody() {
		$response = Response::File( 'people.txt' );
		
		ob_start();
		@$response->send();
		$send = ob_get_contents();
		ob_clean();
		ob_end_clean();
		unlink('people.txt');
		
		$this->assertEquals( $response->getHeaders(), array("Content-Type" => "text/plain","Content-Length"=> 11) );
		$this->assertEquals ( $send, "John Smith\n" );
	}
}
