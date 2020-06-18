# Pangaea BE Coding Challenge

Details are at https://pangaea-interviews.now.sh/be.

## Prerequisites

php - version 7.4.7 <br />
memcached - version 1.5.22

Tested on Ubuntu 20.04 LTS.

## Download code:
```
$ git clone https://github.com/edambasuren/terminal.git
$ cd terminal
```

## Start memcached service
```
$ sudo service memcached start
```

## Start Publisher and Subscribing Servers
```
$ cd terminal
$ ./start-server.sh
```

## Start monitoring Subscribing Server output
```
$ cd terminal
$ tail -f eventServer.log
```

## Execute test commands
```
$ curl -X POST -d '{ "url": "http://localhost:8080/event"}' http://localhost:8000/subscribe/topic1
$ curl -X POST -H "Content-Type: application/json" -d '{"message": "hello"}' http://localhost:8000/publish/topic1
```

## Results
Output of Subscribing Server is
```
$ tail -f eventServer.log
[Wed Jun 17 19:47:56 2020] PHP 7.4.7 Development Server (http://localhost:8080) started
[Wed Jun 17 19:53:25 2020] 127.0.0.1:52668 Accepted
[Wed Jun 17 19:53:25 2020] Received message. Topic: 'topic1' Body: 'hello'
[Wed Jun 17 19:53:25 2020] 127.0.0.1:52668 Closing
```

## Comments:

* To keep runtime state of Publisher Server we use "memcached" service. 
We could have used SQL databases instead (slower, more complex), 
or Redis (more scalable, offers greater flexibility).

* PHP entry point router.php is for tests with PHP built-in web server only, it is not needed
for full webservers like Apache or NGINX, other methods used to hide PHP file extensions in URL.

* Due to use of PHP built-in web server, I had to run 2 different web servers on different ports: 8000 and 8080.

* In more developed environments a lot of lower level code will be replaced by use of frameworks and libraries.






