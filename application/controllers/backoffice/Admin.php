<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        if (!isset($this->session->adminID)) {
            parent::__construct();
            redirect(base_url('404'));
        }
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $data = [
            'title' => 'Admin Panel | 1 Minute Win'
        ];

        $this->load->view('header', $data);

        $this->load->view('home', $data);

        $this->load->view('footer', $data);
    }
}
