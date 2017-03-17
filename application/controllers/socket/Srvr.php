<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;

class Srvr extends CI_Controller {

    public function start () {
        try {
            $loop = Factory::create();
            $socketServer = new SockServer($loop);
            $server = IoServer::factory(
                new HttpServer(
                    new WsServer(
                        $socketServer
                    )
                ),
                8080
            );

            $socketServer->setServer($server);

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

}
