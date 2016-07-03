<?php
require_once 'CoreAPI.php';
require_once 'Conection.class.php';

// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
    $API = new CoreAPI($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
    echo $API->processAPI();
} catch (Exception $e) {
	$status['code'] = 100;
	$status['message'] = $e->getMessage();
    echo json_encode(Array('status' => $status));
}

if($conn)
	mysql_close($conn);	
?>