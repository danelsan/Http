<?php

namespace Http;

class Response implements IResponse {
	private $status;
	private $headers;
	private $body;
	public function __construct($body = '', $status = 200, $headers = NULL ) {
		
		$this->setStatus($status);
		if (is_array($headers) ) {
			foreach ( $headers as $k=>$v ) {
				$this->addHeader( $k, $v );
			}
		} else 
			$this->headers = array();
		$this->setBody($body);
	}
	public function setStatus( $status ) {
		$this->status = new HttpStatusCode( $status );
	}
	public function getStatus() {
		return $this->status;
	}
	public function getBody() {
		return $this->body;
	}
	public function setBody( $body ) {
		if ( !is_null($body) && !is_string($body) )
			throw new \Exception("Body is not a string");
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
