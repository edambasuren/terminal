<?php
/**
 * Publisher Server
 * Process POST /subscribe/{TOPIC}
 * BODY { url: "http://localhost:8000/event"}
 */

$uri = ltrim($_SERVER["REQUEST_URI"], '/');
$info = pathinfo($uri);
$topic = $info['basename'];

$mc = new Memcached();
$mc->addServer("localhost", 11211);

$mc->delete("topic1");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$json = file_get_contents('php://input');
	$data = json_decode($json, true);
	$url = $data['url'];

	$servers = $mc->get($topic);
	if ($servers === false) {
		$servers = [];
	}
	if (!in_array($url, $servers)) {
		$servers[] = $url;
		$mc->set($topic, $servers);
	}

} else {
	header("HTTP/1.1 404 Not Found");
	echo "404 Not Found";
}

/*
$ curl -X POST -d '{ "url": "http://localhost:8080/event"}' http://localhost:8000/subscribe/topic1
*/

?>
