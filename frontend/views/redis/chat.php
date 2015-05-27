<?php
/**
 * Created by PhpStorm.
 * User: michaeldu
 * Date: 5/27/15
 * Time: 10:48 AM
 */
ini_set('default_socket_timeout', -1);
const HOST = "123.56.135.230";
const PORT_REDIS = 6379;

$redis = new Redis();
$redis->connect(HOST, PORT_REDIS);

function callback($redis, $chan, $msg) {
    switch($chan) {
        case 'chat':
            var_dump($msg);
            break;
        default:
            var_dump($msg);
    }
}
$redis->subscribe(array('chat'), 'callback');