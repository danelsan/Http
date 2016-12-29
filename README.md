# Http Namespace
  Http library for send a request or receive a response http
  
  Response and Request are objects.

# Request

  To call an object request you can use:

  $request = Request::Http('http://pippo.com', 'POST');

  $request = Request::Server();

  $request = Request::validate( $request );


# Response

  To call an object response you can use:
  
  $response = Response::Http();
  
  $response = Response::File( '/file' );
  
  $response = Response::Json( array( 'd1' => 1 ) );
  
  

  

