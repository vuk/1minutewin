<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
class Srvr extends CI_Controller {

    public function start($slug = '')
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
    }
}
