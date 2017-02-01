<?php

namespace Http;

class RequestServer extends RequestAbstract {
	
	public function __construct() {
		$this->createServer();
	}
	
	private function createServer() {
		 ( isset($_SERVER['HTTP_HOST']) ) {
                        if ( $_SERVER['HTTP_HOST'] !== $_SERVER ['SERVER_NAME'] )
                                $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
                        else
                                $url = "http://" . $_SERVER ['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
                } else {
                        $url = "http://" . $_SERVER ['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
                }
		
		parent::__construct( $url, $_SERVER['REQUEST_METHOD'] );
		
		if ( isset ( $_SERVER ['HTTP_REFERRER'] ) )
			$this->setReferrer ( $_SERVER ['HTTP_REFERRER'] );
		
		// $this->ip = $_SERVER ['REMOTE_ADDR'];
		//	$request->set ( $_SERVER ['REMOTE_ADDR'] );
		$this->setBody ( file_get_contents ( "php://input" ) );
		
		if ( $this->getMethod () !== 'POST' ) {
			parse_str ( $this->getBody (), $post_vars );
			$this->setPost ( $post_vars );
		} else {
			$this->setPost ( $_POST );
		}
		
		foreach ( getallheaders () as $k => $v ) {
				$this->addHeader ( $k, $v );
		}
	}
	
}
?>
