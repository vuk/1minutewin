<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!($this->session->id > 0) || !($this->session->user_level == 1)) {
            redirect(base_url('404'));
        }
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $submenuItems = [
            'items' => [
                'Home' => [
                    'url' => 'backoffice/admin',
                    'icon' => 'fa fa-home'
                ],
                'Settings' => [
                    'url' => 'backoffice/settings',
                    'icon' => 'fa fa-cogs'
                ]
            ]
        ];

        $pageContent = [];

        $data = [
            'title' => 'Admin Panel | 1 Minute Win',
            'sidemenu' => $this->load->view('admin/sidemenu', $submenuItems, TRUE),
            'pagecontent' => $this->load->view('admin/welcome', $pageContent, true)
        ];

        $this->load->view('admin/header', $data);
        $this->load->view('admin/home', $data);
        $this->load->view('footer', $data);
    }
}
