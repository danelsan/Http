<?php

namespace Http;

interface IResponse {
	public function getStatus();
	public function getStatusCode();
	public function setStatus( $status );
	public function getBody();
	public function setBody( $body );
	public function getHeaders();
	public function addHeader($code, $value);
	public function send();
}
