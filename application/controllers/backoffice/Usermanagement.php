<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usermanagement extends CI_Controller {

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
                'All Users' => [
                    'url' => 'backoffice/usermanagement',
                    'icon' => 'fa fa-users'
                ],
                'New User' => [
                    'url' => 'backoffice/usermanagement/new',
                    'icon' => 'fa fa-user'
                ]
            ]
        ];

        $users = User::where('user_level', '>', 1)->paginate(1);

        $pageContent = [
            'users' => $users,
            'links' => 'links'
        ];

        $data = [
            'title' => 'Admin Panel | 1 Minute Win',
            'sidemenu' => $this->load->view('admin/sidemenu', $submenuItems, TRUE),
            'pagecontent' => $this->load->view('admin/user_list', $pageContent, true)
        ];

        $this->load->view('admin/header', $data);
        $this->load->view('admin/home', $data);
        $this->load->view('footer', $data);
    }
}
