<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
class Srvr extends CI_Controller {

    public function start()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new SockServer()
                )
            ),
            8080
        );

        $server->run();
        print "Socket server is running on port 8080. Started at " . date('Y-m-d H:i:s', strtotime('now'));
    }
}
