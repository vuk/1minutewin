<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class Srvr extends CI_Controller {

    public function start () {
        try {
            $server = IoServer::factory(
                new HttpServer(
                    new WsServer(
                        new SockServer()
                    )
                ),
                8080
            );

            $server->run();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

}
