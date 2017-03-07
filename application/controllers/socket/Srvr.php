<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
class Srvr extends CI_Controller {

    protected $server = null;

    public function start()
    {
        if ($this->server === null) {
            $this->server = IoServer::factory(
                new HttpServer(
                    new WsServer(
                        new SockServer()
                    )
                ),
                8080
            );

            echo "Socket server is running on port 8080. Started at " . date('Y-m-d H:i:s', strtotime('now'))."\n";
            $this->server->run();
        }
    }
}
