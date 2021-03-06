<?php

use PHPUnit\Framework\TestCase;
use Http\Url;
use Http\Request;

class urlTest extends TestCase {
	private $urls;
	private $test_urls;
	public function setUp() {
		$this->test_urls = array (
				'http://popplo.com/pollo/prova?pipp=po&p=123#pollo',
				'https://popplo.com/pollo/prova?pipp=po&p=123#pollo',
				'https://popplo.com:8888/pollo/prova?pipp=po&p=123#pollo',
				'http://user:pdpf@popplo/pollo/prova?pippo=4' 
		);
		foreach ( $this->test_urls as $url ) {
			$this->urls [] = new Url ( $url );
		}
	}
	public function testUrlNotValid() {
		$urls = array();
		$test_urls = array (
				'https:popplo.com/pollo/prova',
				'ftp:popplo.com/pollo/prova?pippo=4',
		);
		foreach ( $test_urls as $url ) {
			try {
				$urls [] = new Url ( $url );
				$fail = false;
			} catch (\Exception $e ) {
				$fail = true;
			}
			$this->assertTrue ( $fail );
		}
		
	}
	
	public function testUrlCreate() {

		$this->assertEquals ( $this->urls [0]->validated (), TRUE );
		$this->assertEquals ( $this->urls [1]->validated (), TRUE );
		$this->assertEquals ( $this->urls [2]->validated (), TRUE );
		$this->assertEquals ( $this->urls [3]->validated (), TRUE );
	}
	public function testUrlGet() {
		$this->assertEquals ( $this->urls [0]->get (), $this->test_urls [0] );
		$this->assertEquals ( $this->urls [1]->get (), $this->test_urls [1] );
		$this->assertEquals ( $this->urls [2]->get (), $this->test_urls [2] );
		$this->assertEquals ( $this->urls [3]->get (), $this->test_urls [3] );
	}
	
	public function testUrlSetQuery() {
		try {
			$this->urls[0]->setQuery('db','dd');
			$ctrl = true;
		} catch (\Exception $e) {
			$ctrl = false;
		}
		$this->assertTrue($ctrl);
		$val = $this->urls[0]->getQuery('db');
		$this->assertEquals($val,'dd');
		
		try {
			$this->urls[0]->setQuery('db',array('a','b') );
			$ctrl = true;
		} catch (\Exception $e) {
			$ctrl = false;
		}
		$this->assertTrue($ctrl);
		
		try {
			$this->urls[0]->setQuery('db', new Url(null) );
			$ctrl = false;
		} catch (\Exception $e) {
			$ctrl = true;
		}
		$this->assertTrue($ctrl);
	}

	public function testUrlErrorRequest() {
		$url_not = 'abckd';
		try {
			$request = Request::Http( $url_not );
//			$url = new Url( $url_not );
			$this->assertTrue(false);
		} catch ( \Exception $e ) {
			$this->assertTrue(true);
		}
	//	$request = Request::Http( $url_not );
//		$url = $request->getURL();
//		var_dump($url);
	}
}
