<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Ratchet\Server\IoServer;
class Srvr extends CI_Controller {

    public function start($slug = '')
    {
        $server = IoServer::factory(
            new Srvr(),
            8080
        );

        $server->run();
    }
}
