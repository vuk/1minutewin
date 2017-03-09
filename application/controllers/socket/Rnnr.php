<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rnnr extends CI_Controller {

    protected $runner = null;

    public function start()
    {
        if ($this->runner === null) {
            $this->runner = Runner::getInstance();

            echo "Runner is started at " . date('Y-m-d H:i:s', strtotime('now'))."\n";
            $this->runner->run();
        }
    }
}
