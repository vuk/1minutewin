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
        $settings = Setting::where('settings_key', 'LIKE', 'settings')->first();
        $pageContent = [
            'settings' => json_decode($settings->value)
        ];

        if ($this->session->flashdata('error')) {
            $pageContent['error'] = $this->session->flashdata('error');
        }

        if ($this->session->flashdata('success')) {
            $pageContent['success'] = $this->session->flashdata('success');
        }

        $data = [
            'title' => 'Settings | 1 Minute Win',
            'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
            'pagecontent' => $this->load->view('admin/settings', $pageContent, true)
        ];

        $this->load->view('admin/header', $data);
        $this->load->view('admin/home', $data);
        $this->load->view('footer', $data);
    }

    public function save() {
        try {
            $settings = Setting::where('settings_key', 'LIKE', 'settings')->firstOrFail();
        } catch (Exception $e) {
            $settings = new Setting;
            $settings->settings_key = 'settings';
        }
        $settings_values = $this->input->post('settings');
        if ($settings_values['currency'] == '' || $settings_values['currency_symbol'] == '') {
            $settings_values['currency'] = 'USD';
            $settings_values['currency_symbol'] = '$';
        }
        if (!(int)$settings_values['initial_duration'] > 0) {
            $settings_values['initial_duration'] = 60;
        }
        if (!(int)$settings_values['going_once'] > 0) {
            $settings_values['going_once'] = 10;
        }
        if (!(int)$settings_values['going_twice'] > 0) {
            $settings_values['going_twice'] = 10;
        }

        $settings->value = json_encode($settings_values);
        $settings->save();
        $this->session->set_flashdata([
            'success' => 'Settings saved'
        ]);
        redirect('backoffice/settings/');
    }
}
