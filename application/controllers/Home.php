<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    protected $pages;

    public function __construct()
    {
        parent::__construct();
        $this->pages = Page::where('show_menu', '=', 1)->get();
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
