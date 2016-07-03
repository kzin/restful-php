<?php
class status {
	
	static $INTERNAL_ERROR = 500;
	
	static $SUCCESS = 200;
	static $FAILED = 100;
	
	//User
	static $INVALID_NAME = 102;
	static $INVALID_EMAIL = 103;
	static $INVALID_PASSWORD = 105;
	static $INVALID_USER = 118;
	
	protected function _requestStatus($code) {
        $status = array(
            self::$INTERNAL_ERROR => 'Internal Error',
			self::$FAILED => 'Failed to processe request',
			self::$INVALID_NAME => 'Invalid name',
			self::$INVALID_EMAIL => 'Invalid email address',
			self::$INVALID_PASSWORD => 'Invalid password must be at least 6 characters',
			self::$INVALID_USER => 'Invalid user',
        );

		$response['code'] = ($status[$code])?$code:self::$INTERNAL_ERROR;
		$response['message'] = ($status[$code])?$status[$code]:$status[self::$INTERNAL_ERROR];

        return $response;
    }

}
?>
