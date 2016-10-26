<?php

namespace Http;

class Url implements IUrl {
	private $scheme;
	private $host;
	private $port;
	private $user;
	private $pass;
	private $path;
	private $query;
	private $fragment;
	private $valid;
	
	/**
	 * The url parameter is compresive of query string
	 *
	 * @param string $url        	
	 */
	public function __construct( $url ) {
		if (!is_string($url) )
			throw new \Exception("Url is not a string");
		
		$this->set ( $url );
		$this->exceptionValidate();
	}

	public function removeQuery( $key ) {
		if ( isset( $this->query[$key] ) )
			unset( $this->query[$key] );
	}
	
	/**
	 * Set the url parameters
	 *
	 * @param unknown $url        	
	 */
	public function set($url) {
		$parse_url = parse_url ( $url );
		if ( $parse_url )
			$this->valid = TRUE;
		else
			$this->valid = FALSE;
		
		if ( isset ( $parse_url ['scheme'] ))
			$this->scheme = $parse_url ['scheme'];
		else
			$this->valid = FALSE;
		
		if (isset ( $parse_url ['host'] ))
			$this->host = $parse_url ['host'];
		else
			$this->valid = FALSE;
		if (isset ( $parse_url ['port'] ))
			$this->port = $parse_url ['port'];
		if (isset ( $parse_url ['user'] ))
			$this->user = $parse_url ['user'];
		if (isset ( $parse_url ['pass'] ))
			$this->pass = $parse_url ['pass'];
		if (isset ( $parse_url ['path'] ))
			$this->path = $parse_url ['path'];
		if (isset ( $parse_url ['query'] )) {
			parse_str($parse_url ['query'], $query);
			if (!is_array( $query ) )
				$this->query = array();
			else
				$this->query = $query;
		} else 
			$this->query = array();
		if (isset ( $parse_url ['fragment'] ))
			$this->fragment = $parse_url ['fragment'];
	}
	public function validated() {
		return $this->valid;
	}
	public function domain() {	
		return $this->host;
	}
	
	public function setQuery($key, $value = NULL ) {
		if ( is_array($key) && is_null($value) ) {
			foreach ( $key as $k => $v ) {
				$this->query [$k] = $v;
			}
			return;
		}
		if ( !is_string($key) )
			throw new \Exception('Name query not is a string');
		if ( !is_null($value) && ( !is_string($value) && !is_array($value) && !is_numeric($value)) )
			throw new \Exception('Value of query "'.$key.'" not is a string');
		$this->query[$key] = $value;
	}
	
	public function getQuery($key) {
		if (!is_string($key))
			throw new \Exception('Key query is not a string');
		
		if ( isset($this->query[$key] ) )
			return $this->query[$key];
	}
	
	public function getQueries() {
		return $this->query;
	}
	
	public function getQueryString() {
		return http_build_query($this->query);
	}
	
	public function base() {
		if (! $this->validated ())
			return '';
		
		$url = $this->scheme . '://';
		
		if ($this->user && $this->pass)
			$url .= $this->user . ':' . $this->pass . '@';
		
		$url .= $this->host;
		return $url;
	}
	
	/**
	 * Return the parent url
	 *
	 * @return Url or FALSE
	 */
	public function parentUrl() {
		if (! $this->validated ())
			return FALSE;
		
		if ($this->path != '/' || $this->path != '' || is_null ( $this->path ))
			return new Url ( $this->base () );
		
		$path_arr = explode ( '/', $this->path );
		unset ( $path_arr [count ( $path_arr ) - 1] );
		$path = implode ( '/', $path_arr );
		$new_url = $this->base . $this->path;
		return new Url ( $new_url );
	}
	
	/**
	 * Return the string of url comprensive o query
	 */
	public function get() {
		if (! $this->validated () )
			return '';
		
		$url = $this->scheme . '://';
		
		if ($this->user && $this->pass)
			$url .= $this->user . ':' . $this->pass . '@';
		
		$url .= $this->host;
		
		if ($this->port)
			$url .= ':' . $this->port;
		
		if ($this->path)
			$url .= '/' . trim ( $this->path, '/' );
		
		if ($this->query)
			$url .= '?' . $this->getQueryString();
		
		if ($this->fragment)
			$url .= '#' . $this->fragment;
		
		return $url;
	}
	
	public function getPath() {
		return $this->path;	
	}
	//Return domani withoud user and password
	public function getDomain() {
		$url = $this->scheme . '://';
		$url .= $this->host;
		return $url;
	}
	
	public function getUser() {
		return $this->user;
	}
	
	public function getPassword() {
		return $this->pass;
	}
	
	public function getPort() {
		return $this->port;
	}
	
	private function exceptionValidate() {
		if (!$this->validated())
			throw new \Exception("Url is not valid");
	}
	
	public function __toString() {
		return $this->get ();
	}
}

?>
