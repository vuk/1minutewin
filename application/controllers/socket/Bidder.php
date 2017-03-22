<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bidder extends CI_Controller {

    public $currentOrder = null;
    protected $settings = null;

    public function start () {
        if ($this->settings === null) {
            $this->settings = json_decode(Setting::where('settings_key', 'LIKE', 'settings')->first()->value);
        }
        while(true) {
            $this->fetchActiveOrder();
            sleep(5);
        }
    }

    public function fetchActiveOrder () {
        try {
            $order = Order::where('ended', '=', 0)->where('ending_at', '>', date('Y-m-d H:i:s', strtotime('now')))->firstOrFail();
            if ($this->shouldBid($order)) {
                $this->sendBid($order);
            }
        } catch (\Exception $e) {
            echo json_encode([
                'error' => 'Order does not exist'
            ]);
        }
    }

    public function shouldBid ($order) {
        if ($order->user_id <= 0 && $this->settings->highest_sale > $order->winning_price) {
            return true;
        }
        echo json_encode([
            'error' => 'Won\'t bid'
        ]);
        return false;
    }

    public function sendBid($order) {
        $order->winning_price += ceil($order->winning_price/10);
        $order->bids ++;
        $order->save();
        $order->product;
        $order->user;
        echo json_encode([
            'message' => 'Bid accepted',
            'order' => $order
        ]);
    }

}
