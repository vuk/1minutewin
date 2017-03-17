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
            $server = IoServer::factory(
                new HttpServer(
                    new WsServer(
                        new SockServer($loop)
                    )
                ),
                8080
            );

            $loop->addTimer(0.001, function($timer) use ($server) {
                $server->run($timer->getLoop());
            });

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

}
