#!/usr/bin/sh

php -S localhost:8000 router.php > publisherServer.log 2>&1 &

php -S localhost:8080 router.php > eventServer.log 2>&1 &

