<?php

use PHPUnit\Framework\TestCase;
use Http\Request;

class RequestServerTest extends TestCase {
	private $request;
	public function setUp() {
		$_SERVER ['REQUEST_SCHEME'] = 'http';
		$_SERVER ['HTTP_HOST'] = 'www.example.pippo';
		$_SERVER ['SERVER_NAME'] = 'www.example.pippo';
		$_SERVER ['REQUEST_URI'] = '/example/uri?pippo=45&pluto=45';
		$_SERVER ['REMOTE_ADDR'] = '192.168.33.3';
		$_SERVER ['REQUEST_METHOD'] = 'GET';
		$_SERVER ['HTTP_REFERRER'] = 'http://pippo.com/it';
		$_SERVER ['HTTP_USER_AGENT'] = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:39.0) Gecko/20100101 Firefox/39.0';
	}
	
	public function testRequestCreateGet() {
		$server = Request::Server();
		$this->assertEquals ( $server->getUrl() , 'http://www.example.pippo/example/uri?pippo=45&pluto=45' );
	}

	public function testRequestCreatePost() {
                $_SERVER ['REQUEST_METHOD'] = 'POST';
		$_POST['pippo'] = 'ok';
		$_POST['pluto'] = 'pippo';

		$server = Request::Server();
                $this->assertEquals ( $server->getMethod() , 'POST' );
		$this->assertEquals ( $server->getPost('pippo'), 'ok' );
		$this->assertEquals ( $server->getPost('pluto'), 'pippo' );
        }

}
