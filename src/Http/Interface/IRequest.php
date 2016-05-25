<?php

namespace Http;

interface IRequest {
	public static function create( $url, $method );
	public function setPost( $key, $value);
	public function getPost( $key );
	public function getPosts();
	public function setQuery( $key, $value );
	public function getQuery($key);
	public function getQueries();
	public function getUrl();
	public function getUri();
	public function setUrl( $url );
	public function getMethod();
	public function setMethod( $method );
	public function getBody();
	public function setBody( $body);
	public function getHeaders();
	//public function getSize();
	public function addHeader( $code,  $value);
	public function setProxy( $url );
	public function send();
}