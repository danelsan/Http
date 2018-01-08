<?php
use PHPUnit\Framework\TestCase;
use Http\Method;

class MethodTest extends TestCase {
	private $methods;
	private $invalid;
	public function setUp() {
		$this->methods = array('get', 'post', 'put', 'delete');
		$this->invalid = array('gets', 'pos', 'puat', 'update');
	}
	
	public function testMethodCreate() {
		foreach ($this->methods as $m ) {
			try {
				$method = new Method($m);
				$fail = FALSE;
			} catch (\Exception $e) {
				$fail = TRUE;
			}
			$this->assertFalse ( $fail );
		}
	}
	
	public function testMethodCreateError() {
		foreach ($this->invalid as $m ) {
			try {
				$method = new Method($m);
				$fail = TRUE;
			} catch (\Exception $e) {
				$fail = FALSE;
			}
			$this->assertFalse ( $fail );
		}
	}
	
	public function testMethodGet() {
		$method = new Method('post');
		$this->assertEquals($method->get(), 'POST');
		$method->set('get');
		$this->assertEquals($method->get(), 'GET');
	}
}
