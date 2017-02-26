<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $data = [
            'title' => '1 Minute Win'
        ];

        $this->load->view('header', $data);

        $this->load->view('home', $data);

        $this->load->view('footer', $data);
    }

    public function not_found ()
    {
        $data = [
            'title' => 'Page not found | 1 Minute Win'
        ];

        $this->load->view('header', $data);

        $this->load->view('not_found', $data);

        $this->load->view('footer', $data);
    }
}
