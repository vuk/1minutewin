<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    /*public function __construct()
    {
        if (!isset($this->session->adminID)) {
            parent::__construct();
            redirect(base_url('404'));
        }
    }*/

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $data = [
            'title' => 'Admin Login | 1 Minute Win'
        ];

        $this->load->view('header', $data);

        $this->load->view('admin/login', $data);

        $this->load->view('footer', $data);
    }
}
