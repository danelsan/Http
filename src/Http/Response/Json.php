<?php

namespace Http;

class ResponseJson extends ResponseAbstract {
		
	public function __construct( $data = array(), $status = 200 ) {
		parent::__construct( $data , $status );
		$this->addHeader('Content-Type', 'application/json');
	}
	
	public function getBody() {
		if ( ! parent::getBody() )
			return;
		return  json_encode( parent::getBody() );
	}
}
