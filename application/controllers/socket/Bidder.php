<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bidder extends CI_Controller {

    public $currentOrder = null;
    protected $settings = null;
    protected $bid_value;

    public function start () {
        if ($this->settings === null) {
            $this->settings = json_decode(Setting::where('settings_key', 'LIKE', 'settings')->first()->value);
        }
        while(true) {
            $this->fetchActiveOrder();
            $rand = rand(3, 12);
            sleep($rand);
        }
    }

    public function fetchActiveOrder () {
        try {
            $order = Order::where('ended', '=', 0)->where('ending_at', '>', date('Y-m-d H:i:s', strtotime('now')))->firstOrFail();
            if ($order->id !== $this->currentOrder) {
                $this->currentOrder = $order->id;
                $this->bid_value = rand($this->settings->highest_sale, $this->settings->lowest_sale);
            }
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
        if ($order->user_id <= 0 && $this->bid_value > $order->winning_price) {
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
        $order->user_id = -1;
        $order->ending_at = date('Y-m-d H:i:s',
            strtotime('now')
            + intval($this->settings->initial_duration)
            + intval($this->settings->going_once)
            + intval($this->settings->going_twice)
        );
        $order->save();
        $order->product;
        $order->user;
        echo json_encode([
            'message' => 'Bid accepted',
            'order' => $order
        ]);
    }

}
