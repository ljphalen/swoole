<?php
$serv = new swoole_server("0.0.0.0", 9501, SWOOLE_BASE);
$serv->set(array(
	//'worker_num' => 1,
	//'daemonize' => true,
	//'log_file' => '/tmp/swoole.log'
));
$serv->on('timer', function($serv, $interval) {
	echo "onTimer: $interval\n";
});
$serv->on('workerStart', function($serv, $worker_id) {
	//if($worker_id == 0) $serv->addtimer(500);
});
$serv->on('connect', function ($serv, $fd, $from_id){
    //echo "[#".posix_getpid()."]\tClient@[$fd:$from_id]: Connect.\n";
});
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    //echo "[#".posix_getpid()."]\tClient[$fd]: $data\n";
    $serv->send($fd, "swoole: $data");
    //$serv->close($fd);
});
$serv->on('close', function ($serv, $fd, $from_id) {
    //echo "[#".posix_getpid()."]\tClient@[$fd:$from_id]: Close.\n";
});
$serv->start();

