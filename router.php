<?php
chdir(__DIR__);
$uri = ltrim($_SERVER["REQUEST_URI"], '/');
$info = pathinfo($uri);


if ($info['dirname']=='.') {
	$filePath = $info['basename'].'.php';
} else {
	$filePath = $info['dirname'].'.php';
}


//http://localhost:8000/publish/topic
//Array ( [dirname] => publish [basename] => topic [filename] => topic )

//http://localhost:8000/publish
//Array ( [dirname] => . [basename] => publish [filename] => publish ) 


if ($filePath && is_file($filePath)) {

	// php file; serve through interpreter
	include $filePath;

} else {
	header("HTTP/1.1 404 Not Found");
	echo "404 Not Found";
}
