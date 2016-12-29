<?php
use Http\Request;

class RequestTest extends PHPUnit_Framework_TestCase {
	private $request;
	public function setUp() {
		$_SERVER ['HTTP_HOST'] = 'www.example.pippo';
		$_SERVER ['SERVER_NAME'] = 'www.example.pippo';
		$_SERVER ['REQUEST_URI'] = '/example/uri?pippo=45&pluto=45';
		$_SERVER ['REMOTE_ADDR'] = '192.168.33.3';
		$_SERVER ['REQUEST_METHOD'] = 'GET';
		$_SERVER ['HTTP_REFERRER'] = 'http://pippo.com/it';
		$_SERVER ['HTTP_USER_AGENT'] = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:39.0) Gecko/20100101 Firefox/39.0';
	}
	
	public function testRequestCreate() {
		$request = Request::Http('http://pippo.it/pollo?p=o&c=4');
		$this->assertEquals ( $request->getMethod(), 'GET' );
		$this->assertEquals ( $request->getQueries(), array('p'=>'o','c'=>4) );
	}
// 	public function testRequestCreate() {
// 		$request = Request::create ('get', );
// 		$this->assertEquals ( $request->getQueries(), array (
// 				'pippo' => 45,
// 				'pluto' => 45 
// 		) );
// 		$this->assertEquals ( $request->getUrl (), 'http://www.example.pippo/example/uri?pippo=45&pluto=45' );
// 		$expect = array (
// 				'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:39.0) Gecko/20100101 Firefox/39.0',
// 				'Host' => 'www.example.pippo',
// 				'Referrer' => 'http://pippo.com/it' 
// 		);
// 		$this->assertEquals ( $request->getHeaders (), $expect );
// 	}
	
	public function testRequestConstructor() {
		$url ['valid'] = "http://www.example.com?pippo=d&o=pil";
		$url ['fail'] = NULL;
		try {
			$request = Request::Http ();
			$fail = TRUE;
		} catch ( \Exception $e ) {
			$fail = FALSE;
		}
		$this->assertFalse ( $fail );
		
		try {
			$request = Request::Http ( $url ['valid'] );
			$this->assertTrue ( true );
		} catch ( \Exception $e ) {
			$this->fail ( 'Expected exception Missing argument 1 for Http\Request::__construct()' );
		}
	}

	
	
// 	public function testRequestSize() {
// 		$post = array('post'=>'test1','post2'=>'test2');
// 		$url = "http://www.example.com?pippo=d&o=pil";
// 		$request = new Request ($url);
// 		$request->setPost($post);
// 		$this->assertEquals ( $request->getSize(), 22 );
// 		$request->setBody('test body');
// 		$this->assertEquals ( $request->getSize(), 9 );
// 	}
	public function testRequestGetUrl() {
		$url = "http://www.example.com?pippo=d&o=pil";
		$u="http://www.example.com";
		$q=array('pippo'=>'d','o'=>'pil');
		$request = Request::Http ( $url );
		$this->assertEquals ( $request->getUrl (), $url );
		$this->assertEquals ( $request->getQueries(), $q );
	}	
	
// 	public function testRequestSendGet() {
// 		$url = "http://www.example.com";
// 		$url_error = "http://www.example.com/d";
// 		$request = new Request ( $url );
// 		$response = $request->send();
// 		echo $response->getBody();
// 		echo $response->getStatus();
		
// 		$request = new Request ( $url_error );
// 		$response = $request->send();
	
// 		echo $response->getStatus();
// 		echo $response->getBody();	
// 	}
	
// 	public function testRequestSendGet() {
// 		$url = "http://ifconfig.me";
// 		$proxy = "https://52.90.187.35:8083";
// 		$request = new Request ( $url );
// 		$request->setProxy( $proxy );
		
// 		$response = $request->send();
// 		echo $response->getBody();
// 		echo $response->getStatus();

// 	}
	
}
