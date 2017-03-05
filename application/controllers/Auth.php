<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->pages = Page::where('show_menu', '=', 1)->get();
    }

    public function signin() {

        if ($this->session->id > 0 && $this->session->user_level) {
            redirect('/');
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
            redirect('/');
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
                    ->firstOrFail();

                if (password_verify($this->input->post('password'), $user->password)) {
                    $this->session->set_userdata([
                        'id' => $user->id,
                        'email' => $user->email,
                        'user_level' => $user->user_level,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name
                    ]);
                    redirect('/');
                } else {
                    throw new Exception("Invalid data inserted", 100001);
                }
            } catch (\Exception $e) {
                $user = new User();
                $user->email = $this->input->post('email');
                $user->password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                $user->user_level = 50;
                $user->save();
                redirect('/');
            }
        }
    }

    public function social ($provider) {
        $config_file_path = './application/config/social.php';

        $hybridAuth = new Hybrid_Auth($config_file_path);

        $adapter = $hybridAuth->authenticate( $provider );
        $userProfile = $adapter->getUserProfile();

        try {
            $user = User::where('email', 'LIKE', $userProfile->email)->firstOrFail();
            $user->first_name = $userProfile->firstName;
            $user->last_name = $userProfile->lastName;
            if (strtolower($provider) == "google") {
                $user->google_id = $userProfile->identifier;
            }
            if (strtolower($provider) == "facebook") {
                $user->fb_id = $userProfile->identifier;
            }
            $user->save();
            $this->session->set_userdata([
                'id' => $user->id,
                'email' => $user->email,
                'user_level' => $user->user_level,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
            ]);
        } catch (\Exception $e) {
            $user = new User;
            $user->first_name = $userProfile->firstName;
            $user->last_name = $userProfile->lastName;
            $user->user_level = 50;
            if (strtolower($provider) == "google") {
                $user->google_id = $userProfile->identifier;
            }
            if (strtolower($provider) == "facebook") {
                $user->fb_id = $userProfile->identifier;
            }
            $user->active = 1;
            $user->save();
            $this->session->set_userdata([
                'id' => $user->id,
                'email' => $user->email,
                'user_level' => $user->user_level,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
            ]);
        } finally {
            $this->session->set_flashdata([
                'success' => 'Login success'
            ]);
            redirect('/');
        }
    }

    public function callback () {
        if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done']))
        {
            Hybrid_Endpoint::process();
        }
    }

    public function logout () {
        $this->session->sess_destroy();
        redirect('/');
    }
}
