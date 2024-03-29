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
            $user->email = $userProfile->email;
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

    public function register () {
        if ($this->session->id > 0 && $this->session->user_level) {
            redirect('/');
            die();
        }
        try {
            $order = Order::where('ended', '=', 0)->firstOrFail();
            $settings = json_decode(Setting::where('settings_key', 'LIKE', 'settings')->first()->value);
            $data = [
                'title' => '1 Minute Win',
                'pages' => $this->pages,
                'order' => $order,
                'product'=>$order->product,
                'settings' => $settings
            ];

            $this->load->view('header', $data);

            $this->load->view('register', $data);

            $this->load->view('footer', $data);
        } catch (\Exception $e) {
            $this->not_found();
        }
    }

    public function registration () {
        if ($this->session->id > 0 && $this->session->user_level) {
            redirect('/');
            die();
        }

        $this->form_validation->set_rules('password', 'Password', 'required',
            array('required' => 'You must provide a %s.')
        );
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata([
                'error' => 'Invalid registration'
            ]);
            redirect('/');
        }
        else
        {
            try {
                $user = User::where('email', 'LIKE', $this->input->post('email'))
                    ->first();
                if (isset($user->id)) {
                    throw new Exception('User with this email is already registered');
                } else {
                    $user = new User;
                    $user->first_name = $this->input->post('first_name');
                    $user->last_name = $this->input->post('last_name');
                    $user->password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                    $user->email = $this->input->post('email');
                    $user->active = 0;
                    $user->user_level = 50;
                    $user->hash = md5($this->input->post('password'));
                    $user->save();


                    $this->load->library('email');

                    $this->email->clear();
                    $this->email->from('registration@1minutewin.com', '1minutewin');
                    $this->email->to($user->email);

                    $this->email->subject('1 Minute Win Registration');
                    $this->email->message('To complete your registration, please click here: ' . base_url('auth/validate/' . $user->hash));

                    $this->email->send();
                    $this->session->set_flashdata([
                        'success' => 'Registration successful'
                    ]);
                    redirect('/');
                }
            } catch (\Exception $e) {
                $this->session->set_flashdata([
                    'error' => 'Registration failed'
                ]);
                redirect('/');
            }
        }
    }

    public function validate ($hash) {
        try {
            $user = User::where('hash', 'LIKE', $hash)->firstOrFail();
            $user->hash = '';
            $user->active = 1;
            $user->save();
            $this->session->set_flashdata([
                'success' => 'Validation success'
            ]);

            $this->session->set_userdata([
                'id' => $user->id,
                'email' => $user->email,
                'user_level' => $user->user_level,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
            ]);
            redirect('/');
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid link'
            ]);
            redirect('/');
        }
    }
}
