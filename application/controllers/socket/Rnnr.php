<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rnnr extends CI_Controller {

    protected $runner = null;
    protected $socket = null;

    public function start()
    {
        try {
            $this->socket = socket_create_listen(8081);
            $this->runner = Runner::getInstance();
            echo "Runner is started at " . date('Y-m-d H:i:s', strtotime('now'))."\n";
            Runner::slack("Runner is started at " . date('Y-m-d H:i:s', strtotime('now'))."\n", "runner");
            $this->runner->run();
        } catch (Exception $e) {
            echo "Runner is working ok \n";
        }
    }
}
