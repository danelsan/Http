<?php

namespace Http;

class ResponseFile extends ResponseAbstract {
	
	private $path;
	
	public function __construct( $path = NULL ) {
		$this->path = $path;
		parent::__construct();
	}
	
	public function isFile( ) {
		return is_file($this->path );
	}
	
	public function send() {
		if ( !$this->isFile() ) {
			$this->setStatus(403);
			$this->setBody("File not founded");
			return parent::send();
		} 
			
		$contents = file_get_contents( $this->path );
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		
		$file_type = array(
			'mime'				=> finfo_file($finfo,  $this->path),
			'size'				=> filesize( $this->path),
			'last_modified'		=> filectime( $this->path ),
			'data'				=> $contents,
		);
		finfo_close($finfo);
		
		$this->setBody( $file_type['data'] );
		$this->addHeader('Content-Type', $file_type['mime']);
		$this->addHeader('Content-Length' , $file_type['size'] );
		return parent::send();
	}
	
}
