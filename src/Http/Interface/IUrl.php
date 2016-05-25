<?php

namespace Http;

interface IUrl {
	public function set( $url );
	public function get();
	public function validated();
	public function getQuery($key);
	public function getQueries();
	public function getQueryString();
	public function setQuery($key,$value);
	public function getPath();
}

?>