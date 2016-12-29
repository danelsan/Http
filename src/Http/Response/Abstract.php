<?php

namespace Http;

class ResponseAbstract implements IResponse {
	private $status;
	private $headers;
	private $body;
	public function __construct($body = '', $status = 200, $headers = array() ) {
		
		$this->setStatus($status);
		if ( !is_array($headers) || empty( $headers) )
			$this->headers = array();
		
		foreach ( $headers as $k=>$v ) {
				$this->addHeader( $k, $v );
		}
	
		$this->setBody($body);
	}
	public function setStatus( $status ) {
		$this->status = new HttpStatusCode( $status );
	}
	public function getStatus() {
		return $this->status->getStatus();
	}
	public function getStatusCode() {
		return $this->status->getCode();
	}
	public function getBody() {
		return $this->body;
	}
	public function setBody( $body ) {
		$this->body = $body;
	}
	public function getHeaders() {
		return $this->headers;
	}
	public function addHeader($code, $value) {
		$this->headers[$code] = $value;
	}
	public function send() {
		$str = 'HTTP/1.1 '.$this->getStatus()->getCode(). ' ' . $this->getStatus()->getStatus();
		header($str);
		foreach ( $this->getHeaders () as $k => $v ) {
			header ( $k . ': ' . $v );
		}
		if ( is_null( $this->getBody() ) || is_bool($this->getBody() ) || !is_string($this->getBody() ) )
			$this->setBody('');
		echo $this->getBody();
	}

	/**
	 * Request to string
	 */
	public function __toString() {
		$enter = "\n\r";
		$str = 'HTTP/1.1 '.$this->getStatus()->getCode(). ' ' . $this->getStatus()->getStatus() .$enter;
		foreach ($this->getHeaders() as $k=>$v) {
			$str .= $k.': '.$v .$enter;
		}
		$str .= $enter.$enter;
		$str .= $this->getBody();
		return $str;
	}
}
