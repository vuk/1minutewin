<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
    protected $submenuItems;
    protected $settings;

    public function __construct()
    {
        parent::__construct();
        if (!($this->session->id > 0) || !($this->session->user_level == 1)) {
            redirect(base_url('404'));
        }
        $this->submenuItems = [
            'items' => [
                'All Orders' => [
                    'url' => 'backoffice/orders',
                    'icon' => 'fa fa-shopping-basket'
                ]
            ]
        ];
        $this->settings = json_decode(Setting::where('settings_key', 'LIKE', 'settings')->first()->value);
    }

    /**
     * Index Page for this controller.
     */
    public function index($page = 1)
    {
        $orders = Order::where('user_id', '>', 0)->orderBy('created_at', 'desc')->offset(($page - 1) * 20)->limit(20)->get();
        $count = Order::where('user_id', '>', 0)->count();
        $pages = ceil($count / 20);

        if ($page > 1) {
            $pageLinks['First'] = base_url('/backoffice/orders/index/1');
            $pageLinks['Previous'] = base_url('/backoffice/orders/index/'.($page - 1));
        }

        for ($i = 1; $i <= $pages; $i ++) {
            if (abs($i - $page) < 4) {
                $pageLinks[$i] = base_url('/backoffice/orders/index/'.$i);
            }
        }

        if ($page < $pages) {
            $pageLinks['Next'] = base_url('/backoffice/orders/index/'.($page + 1));
            $pageLinks['Last'] = base_url('/backoffice/orders/index/'.$pages);
        }

        $pageContent = [
            'orders' => $orders,
            'settings' => $this->settings,
            'pageLinks' => $pageLinks
        ];

        $data = [
            'title' => 'All orders | 1 Minute Win',
            'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
            'pagecontent' => $this->load->view('admin/order_list', $pageContent, true)
        ];

        $this->load->view('admin/header', $data);
        $this->load->view('admin/home', $data);
        $this->load->view('footer', $data);
    }

    public function edit ($id) {
        try {
            $order = Order::findOrFail($id);
            $pageContent = [
                'order' => $order
            ];

            if ($this->session->flashdata('error')) {
                $pageContent['error'] = $this->session->flashdata('error');
            }

            if ($this->session->flashdata('success')) {
                $pageContent['success'] = $this->session->flashdata('success');
            }

            $data = [
                'title' => 'Edit order | 1 Minute Win',
                'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
                'pagecontent' => $this->load->view('admin/edit_order', $pageContent, true)
            ];

            $this->load->view('admin/header', $data);
            $this->load->view('admin/home', $data);
            $this->load->view('footer', $data);
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/orders');
        }
    }

    public function update () {
        $this->form_validation->set_rules('winning_price', 'Winning price', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata([
                'error' => 'Invalid action',
                'errors' => 'errors'
            ]);
            redirect('backoffice/orders');
        }
        else
        {
            try {
                $order = Order::findOrFail($this->input->post('order_id'));
                $order->winning_price = $this->input->post('winning_price');
                $order->status = $this->input->post('status');
                $order->save();
                $this->session->set_flashdata([
                    'success' => 'Order updated'
                ]);
                redirect('backoffice/orders/edit/'.$order->id);
            } catch (\Exception $e) {
                $this->session->set_flashdata([
                    'error' => 'Order does not exist'
                ]);
                redirect('backoffice/orders');
            }
        }
    }

    public function processing ($id) {
        try {
            $id = (int)$id;
            $order = Order::findOrFail($id);
            $order->status = 5;
            $order->save();
            $this->session->set_flashdata([
                'success' => 'Order processing'
            ]);
            redirect('backoffice/orders');
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/orders');
        }
    }

    public function ship ($id) {
        try {
            $id = (int)$id;
            $order = Order::findOrFail($id);
            $order->status = 10;
            $order->save();
            $this->session->set_flashdata([
                'success' => 'Order shipped'
            ]);
            redirect('backoffice/orders');
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/orders');
        }
    }

    public function complete ($id) {
        try {
            $id = (int)$id;
            $order = Order::findOrFail($id);
            $order->status = 15;
            $order->save();
            $this->session->set_flashdata([
                'success' => 'Order completed'
            ]);
            redirect('backoffice/orders');
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/orders');
        }
    }

    public function cancel ($id) {
        try {
            $id = (int)$id;
            $order = Order::findOrFail($id);
            $order->delete();
            $this->session->set_flashdata([
                'success' => 'Order canceled/deleted'
            ]);
            redirect('backoffice/orders');
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/orders');
        }
    }
}
