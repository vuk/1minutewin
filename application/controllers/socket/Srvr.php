<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Srvr extends CI_Controller {
    protected $clients;
    protected $runner;
    protected $order;

    public function __construct() {
        parent::__construct();
        $this->clients = new \SplObjectStorage();
    }

    public function start () {
        $loop = React\EventLoop\Factory::create();
        $socket = new React\Socket\Server($loop);
        $conns = new \SplObjectStorage();
        $socket->on('connection', function ($conn) use ($conns) {
            $conns->attach($conn);
            $conn->on('data', function ($data) use ($conns, $conn) {
                foreach ($conns as $current) {
                    if ($conn === $current) {
                        continue;
                    }
                    $current->write($conn->getRemoteAddress().': ');
                    $current->write($data);
                }
            });
            $conn->on('end', function () use ($conns, $conn) {
                $conns->detach($conn);
            });
        });
        echo "Socket server listening on port 4000.\n";
        echo "You can connect to it by running: telnet localhost 8080\n";
        $socket->listen(8080);
        $loop->run();
    }

    private function notifyAll($data) {
        foreach ($this->clients as $current) {
            $current->write($data);
        }
    }
}
