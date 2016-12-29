<?php

namespace Http;

class Response  {
	
	public static function Json( $data = NULL ) {
		return new ResponseJson( $data );
	}
	
	public static function Http( $body = NULL, $status=200, $headers = array() ) {
		return new ResponseHttp( $body, $status, $headers );
	}
	
	public static function File( $path ) {
		return new ResponseFile( $path );
	}
}

?>
