<?php
require_once 'API.class.php';
require_once 'User.class.php';
require_once 'Status.class.php';

class CoreAPI extends API
{
	protected $application_key;

    public function __construct($request, $origin) {
        parent::__construct($request);
		
		//get headers
		$headers = ''; 
        foreach ($_SERVER as $name => $value) 
        { 
           if (substr($name, 0, 5) == 'HTTP_') 
           { 
               $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
           } 
        }
		
		$this->application_key = $headers["Api-Key"];
		
		if($this->application_key != "appkey") {
			throw new Exception('Invalid API Key');
		}
    }
	
    /**
     * Endpoint
     */
	 
	 protected function user() {
		$user = new user;
		
		switch($this->method) {
		
			case 'POST':{
				$user->name = $this->request['name'];
				$user->email = $this->request['email'];
				$user->setPassword($this->request["password"]);
				$response = $user->save();
			}break;
			
			case 'GET': {
				$user->token = $this->key->token;
				$response = $user->isLoggedIn($this->token);
				
				if($response['status']['code'] == status::$SUCCESS) {
					$response = $user->get($this->args[0]);
				}
			}break;
			
			default: {
				throw new Exception('Unsupported method');	
			}
			
		}
		
		return $response;
	 }
 }
?>
