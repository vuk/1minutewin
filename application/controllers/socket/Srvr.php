<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
class Srvr extends CI_Controller {

    protected $server = null;

    public function start()
    {
        try {
            $connection = @fsockopen('localhost', 8080);

            if (!is_resource($connection))
            {
                if ($this->server === null) {
                    $this->server = IoServer::factory(
                        new HttpServer(
                            new WsServer(
                                SockServer::getInstance()
                            )
                        ),
                        8080
                    );

                    echo "Socket server is running on port 8080. Started at " . date('Y-m-d H:i:s', strtotime('now'))."\n";
                    Runner::slack("Socket server is running on port 8080. Started at " . date('Y-m-d H:i:s', strtotime('now'))."\n", "socket");
                    $this->server->run();
                } else {
                    log_message('debug', "Server is running ok...");
                }
            } else {
                fclose($connection);
            }
        } catch (\Exception $e) {
            //echo "Socket server is already started"."\n";
        }
    }
}
