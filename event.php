<?php
/**
 * Subscribing Server
 * Process POST /event
 * BODY { "topic": "topic1", "data": {"msg" : "hello"}}
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$json = file_get_contents('php://input');
	$data = json_decode($json, true);
	//error_log(print_r($data, true));
	error_log("Received message. Topic: '".$data['topic']."' Body: '".$data['data']['msg']."'");

} else {
	header("HTTP/1.1 404 Not Found");
	echo "404 Not Found";
}

/*
$ curl -X POST -H "Content-Type: application/json" -d '{ "topic": "topic1", "data": {"msg" : "hello"}}' http://localhost:8080/event
*/

?>
