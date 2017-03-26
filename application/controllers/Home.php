<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    protected $pages;
    protected $settings = null;

    public function __construct()
    {
        parent::__construct();
        $this->pages = Page::where('show_menu', '=', 1)->get();
        $this->settings = json_decode(Setting::where('settings_key', 'LIKE', 'settings')->first()->value);
    }

    /**
     * @param $slug string
     * Index Page for this controller.
     */
    public function index($slug = '')
    {
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

            $this->load->view('home', $data);

            $this->load->view('footer', $data);
        } catch (\Exception $e) {
            $this->not_found();
        }
    }

    public function bid ($user_id, $order_id, $amount) {
        try {
            $user = User::findOrFail($user_id);
            $order = Order::findOrFail($order_id);
            if (intval($amount) > intval($order->winning_price) && $order->ended == 0) {
                $order->user_id = $user->id;
                $order->winning_price = $amount;
                $order->bids ++;
                $order->ending_at = date('Y-m-d H:i:s',
                    strtotime('now')
                    + intval($this->settings->initial_duration)
                    + intval($this->settings->going_once)
                    + intval($this->settings->going_twice)
                );
                $order->save();
                $order->product;
                $order->user;
                header('Content-Type: application/json');
                echo json_encode([
                    'message' => 'Bid accepted',
                    'order' => $order
                ]);
            } else {
                throw new \Exception('Price offered was lower than current price or time expired');
            }
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'error' => 14001,
                'message' => 'Bid wasn\'t accepted',
                'exception' => $e->getMessage()
            ]);
        }
    }

    public function cart () {
        if (!($this->session->id > 0)) {
            redirect(base_url('404'));
        }
        $data = [
            'title' => 'Cart | 1 Minute Win',
            'pages' => $this->pages,
            'settings' => $this->settings
        ];

        if (($this->input->get('success') === 'true' || $this->input->get('success') === 'false')) {
            if ($this->input->get('success') === 'true') {
                $paymentId = $this->input->get('paymentId');
                $token = $this->input->get('token');
                $PayerID = $this->input->get('PayerID');
                $ref = $this->input->get('ref');
                $order_id = $this->input->get('order');
                $order = Order::where('id', '=', $order_id)->where('reference', 'LIKE', $ref)->where('reference', '<>', '')->first();
                if (!isset($order->id)) {
                    $data['error'] = 'Payment failed';
                } else {
                    $order->paymentId = $paymentId;
                    $order->token = $token;
                    $order->PayerID = $PayerID;
                    $order->status = 2;
                    $order->reference = '';
                    $order->save();
                    $data['success'] = 'Payment successfully processed';
                }
            }
            else {
                $data['error'] = 'Payment failed';
            }
        }

        $data['bought'] = Order::where('status', '=', 1)->where('user_id', '=', $this->session->id)->orderBy('ending_at', 'desc')->get();
        $data['paid'] = Order::where('status', '=', 2)->where('user_id', '=', $this->session->id)->orderBy('ending_at', 'desc')->get();
        $data['delivered'] = Order::where('status', '=', 15)->where('user_id', '=', $this->session->id)->orderBy('ending_at', 'desc')->get();

        $this->load->view('header', $data);

        $this->load->view('cart', $data);

        $this->load->view('footer', $data);
    }

    public function not_found ()
    {
        $data = [
            'title' => 'Page not found | 1 Minute Win',
            'pages' => $this->pages
        ];

        $this->load->view('header', $data);

        $this->load->view('not_found', $data);

        $this->load->view('footer', $data);
    }

    public function page ($slug) {

        try {
            $page = Page::where('slug', 'LIKE', $slug)->firstOrFail();
            $data = [
                'title' => $page->page_title,
                'page'  => $page,
                'pages' => $this->pages
            ];
            $this->load->view('header', $data);

            $this->load->view('page', $data);

            $this->load->view('footer', $data);
        } catch (\Exception $e) {
            $this->not_found();
        }
    }
}
