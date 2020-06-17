<?php
/**
 * Publisher Server
 * Process POST /publish/{TOPIC}
 * BODY { "message": "hello"}
 */

$uri = ltrim($_SERVER["REQUEST_URI"], '/');
$info = pathinfo($uri);
$topic = $info['basename'];

$mc = new Memcached();
$mc->addServer("localhost", 11211);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$json = file_get_contents('php://input');
	$data = json_decode($json, true);
	$message = $data['message'];

	$servers = $mc->get($topic);
	if ($servers === false) {
		$servers = [];
	}

	$data = [
		"topic" => $topic,
		"data" => ["msg" => $message]
	];
	$data_string = json_encode($data);

	foreach($servers as $url) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		if(curl_error($ch)) {
			print_r(curl_error($ch));
		}
		curl_close($ch);
		print_r($result);
	}

} else {
	header("HTTP/1.1 404 Not Found");
	echo "404 Not Found";
}

/*
$ curl -X POST -H "Content-Type: application/json" -d '{"message": "hello"}' http://localhost:8000/publish/topic1
*/

?>
