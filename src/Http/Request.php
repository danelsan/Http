<?php

namespace Http;

class Request  {

		public static function Http( $url, $method = 'GET' ) {
			return new RequestHttp( $url, $method );
		}
		
		public static function Server( ) {
			return new RequestServer();
		}
		
		public static function validate( IRequest $request ) {
			$url = $request->getUrl();
			return $url->validated();
		}
}
?>
