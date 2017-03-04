<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_login extends CI_Controller {

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
        if ($this->session->id > 0 && $this->session->user_level) {
            redirect('backoffice/admin');
            die();
        }
        $data = [
            'title' => 'Admin Login | 1 Minute Win'
        ];

        if ($this->session->flashdata('error')) {
            $data['error'] = $this->session->flashdata('error');
        }

        $this->load->view('header', $data);

        $this->load->view('admin/login', $data);

        $this->load->view('footer', $data);
    }

    public function signin() {

        if ($this->session->id > 0 && $this->session->user_level) {
            redirect('backoffice/admin');
            die();
        }

        $this->form_validation->set_rules('password', 'Password', 'required',
            array('required' => 'You must provide a %s.')
        );
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata([
                'error' => 'Invalid login'
            ]);
            redirect('backoffice/login');
        }
        else
        {
            // USED FOR INITIAL ADMIN INSERT
            /*$user = new User();
            $user->first_name = 'Vuk';
            $user->last_name = 'Stankovic';
            $user->email = $this->input->post('email');
            $user->password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            $user->user_level = 1;
            $user->save();*/
            try {
                $user = User::where('email', 'LIKE', $this->input->post('email'))
                    ->where('user_level', '=', 1)
                    ->firstOrFail();

                if (password_verify($this->input->post('password'), $user->password)) {
                    $this->session->set_userdata([
                        'id' => $user->id,
                        'email' => $user->email,
                        'user_level' => $user->user_level,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name
                    ]);
                    redirect('backoffice/login');
                } else {
                    throw new Exception("Invalid data inserted", 100001);
                }
            } catch (\Exception $e) {
                $this->session->set_flashdata([
                    'error' => 'Invalid login'
                ]);
                redirect('backoffice/login');
            }
        }
    }

    public function logout () {
        $this->session->sess_destroy();
        redirect('backoffice/login');
    }
}
