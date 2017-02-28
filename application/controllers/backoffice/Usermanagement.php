<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usermanagement extends CI_Controller {

    protected $submenuItems;

    public function __construct()
    {
        parent::__construct();
        if (!($this->session->id > 0) || !($this->session->user_level == 1)) {
            redirect(base_url('404'));
        }
        $this->submenuItems = [
            'items' => [
                'All Users' => [
                    'url' => 'backoffice/usermanagement',
                    'icon' => 'fa fa-users'
                ],
                'New User' => [
                    'url' => 'backoffice/usermanagement/create',
                    'icon' => 'fa fa-user'
                ]
            ]
        ];
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {

        $users = User::where('user_level', '>', 1)->paginate(20);

        $pageContent = [
            'users' => $users,
            'links' => 'links'
        ];

        if ($this->session->flashdata('error')) {
            $pageContent['error'] = $this->session->flashdata('error');
        }

        if ($this->session->flashdata('success')) {
            $pageContent['success'] = $this->session->flashdata('success');
        }

        $data = [
            'title' => 'Admin Panel | 1 Minute Win',
            'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
            'pagecontent' => $this->load->view('admin/user_list', $pageContent, true)
        ];

        $this->load->view('admin/header', $data);
        $this->load->view('admin/home', $data);
        $this->load->view('footer', $data);
    }

    public function activate ($id) {
        try {
            $id = (int)$id;
            $user = User::findOrFail($id);
            $user->active = 1;
            $user->save();
            $this->session->set_flashdata([
                'success' => 'User activated'
            ]);
            redirect('backoffice/usermanagement');
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/usermanagement');
        }
    }

    public function deactivate ($id) {
        try {
            $id = (int)$id;
            $user = User::findOrFail($id);
            $user->active = 0;
            $user->save();
            $this->session->set_flashdata([
                'success' => 'User deactivated'
            ]);
            redirect('backoffice/usermanagement');
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/usermanagement');
        }
    }

    public function delete ($id) {
        try {
            $id = (int)$id;
            $user = User::findOrFail($id);
            $user->delete();
            $this->session->set_flashdata([
                'success' => 'Successfully deleted'
            ]);
            redirect('backoffice/usermanagement');
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/usermanagement');
        }
    }

    public function edit ($id) {

        try {
            $user = User::findOrFail($id);
            $pageContent = [
                'user'  => $user
            ];

            if ($this->session->flashdata('error')) {
                $pageContent['error'] = $this->session->flashdata('error');
            }

            if ($this->session->flashdata('success')) {
                $pageContent['success'] = $this->session->flashdata('success');
            }

            $data = [
                'title' => 'Edit user | 1 Minute Win',
                'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
                'pagecontent' => $this->load->view('admin/edit_user', $pageContent, true)
            ];

            $this->load->view('admin/header', $data);
            $this->load->view('admin/home', $data);
            $this->load->view('footer', $data);
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/usermanagement');
        }
    }

    public function update () {
        $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('user_level', 'User level', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata([
                'error' => 'Invalid action',
                'errors' => 'errors'
            ]);
            $this->edit($this->input->post('user_id'));
        }
        else
        {
            try {
                $user = User::findOrFail($this->input->post('user_id'));
                $user->first_name = $this->input->post('first_name');
                $user->last_name = $this->input->post('last_name');
                $user->email = $this->input->post('email_address');
                $user->user_level = $this->input->post('user_level');
                $user->promo_code = $this->input->post('promo_code');
                if ($this->input->post('password_value')) {
                    $user->password = password_hash($this->input->post('password_value'), PASSWORD_BCRYPT);
                }
                $user->save();
                $this->session->set_flashdata([
                    'success' => 'User updated'
                ]);
                redirect('backoffice/usermanagement/edit/'.$user->id);
            } catch (\Exception $e) {
                $this->session->set_flashdata([
                    'error' => 'Duplicate email address'
                ]);
                $this->edit($this->input->post('user_id'));
            }
        }
    }

    public function create() {

        $pageContent = [
            'links' => 'links'
        ];

        if ($this->session->flashdata('error')) {
            $pageContent['error'] = $this->session->flashdata('error');
        }

        if ($this->session->flashdata('success')) {
            $pageContent['success'] = $this->session->flashdata('success');
        }

        $data = [
            'title' => 'New user | 1 Minute Win',
            'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
            'pagecontent' => $this->load->view('admin/new_user', $pageContent, true)
        ];

        $this->load->view('admin/header', $data);
        $this->load->view('admin/home', $data);
        $this->load->view('footer', $data);
    }

    public function save() {
        $this->form_validation->set_rules('password_value', 'Password', 'required');
        $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('user_level', 'User level', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata([
                'error' => 'Invalid action',
                'errors' => 'errors'
            ]);
            $this->create();
        }
        else
        {
            try {
                $user = new User;
                $user->first_name = $this->input->post('first_name');
                $user->last_name = $this->input->post('last_name');
                $user->email = $this->input->post('email_address');
                $user->user_level = $this->input->post('user_level');
                $user->promo_code = $this->input->post('promo_code');
                $user->password = password_hash($this->input->post('password_value'), PASSWORD_BCRYPT);
                $user->save();
                $this->session->set_flashdata([
                    'success' => 'New user added'
                ]);
                redirect('backoffice/usermanagement/edit/'.$user->id);
            } catch (\Exception $e) {
                $this->session->set_flashdata([
                    'error' => 'Duplicate email address'
                ]);
                $this->create();
            }
        }
    }
}
