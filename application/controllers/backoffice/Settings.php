<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
    protected $submenuItems;

    public function __construct()
    {
        parent::__construct();
        if (!($this->session->id > 0) || !($this->session->user_level == 1)) {
            redirect(base_url('404'));
        }
        $this->submenuItems = [
            'items' => [
                'All Settings' => [
                    'url' => 'backoffice/orders',
                    'icon' => 'fa fa-cogs'
                ]
            ]
        ];
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {

        $pageContent = [];

        $data = [
            'title' => 'Settings | 1 Minute Win',
            'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
            'pagecontent' => $this->load->view('admin/welcome', $pageContent, true)
        ];

        $this->load->view('admin/header', $data);
        $this->load->view('admin/home', $data);
        $this->load->view('footer', $data);
    }
}
