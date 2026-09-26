<?php
require __DIR__ . '/vendor/autoload.php';

use Workerman\Worker;
use Workerman\Connection\TcpConnection;
use Workerman\Timer;
use PresenceEngine\Core\Config;
use PresenceEngine\Models\PresenceLog;

Config::load(__DIR__);

$ws = new Worker("websocket://" . Config::get('WS_HOST', '0.0.0.0') . ":" . Config::get('WS_PORT', '8080'));
$ws->count = 1;

$lastLogId = 0;

$ws->onWorkerStart = function() use (&$lastLogId) {
    $logModel = new PresenceLog();
    $lastLogId = $logModel->getMaxLogId();

    Timer::add(2, function() use (&$lastLogId, $logModel) {
        global $ws;

        $newLogs = $logModel->getNewLogs($lastLogId);

        if (!empty($newLogs)) {
            $lastLogId = (int) end($newLogs)['log_id'];
        }

        $online = $logModel->getOnline();

        $payload = json_encode([
            'type'  => 'online_list',
            'users' => $online,
            'new'   => $newLogs,
        ], JSON_UNESCAPED_UNICODE);

        foreach ($ws->connections as $conn) {
            $conn->send($payload);
        }
    });
};

$ws->onConnect = function(TcpConnection $connection) {
    $logModel = new PresenceLog();
    $online = $logModel->getOnline();

    $connection->send(json_encode([
        'type'  => 'online_list',
        'users' => $online,
        'new'   => [],
    ], JSON_UNESCAPED_UNICODE));
};

$ws->onMessage = function(TcpConnection $connection, $data) {};

$ws->onClose = function(TcpConnection $connection) {};

Worker::runAll();