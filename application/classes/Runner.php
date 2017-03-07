<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Runner {

    public $currentOrder = null;
    protected $settings = null;
    /** @var SockServer */
    protected $server = null;
    private static $instance = null;

    public static function getInstance() {
        if (Runner::$instance == null) {
            Runner::$instance = new Runner;
        }
        return Runner::$instance;
    }

    public function run() {
        if ($this->server == null) {
            $this->server = \SockServer::getInstance();
        }
        if ($this->settings === null) {
            $this->settings = json_decode(Setting::where('settings_key', 'LIKE', 'settings')->first()->value);
        }
        do {
            $this->checkCurrentOrder();
        } while (true);
    }

    private function checkCurrentOrder () {
        if ($this->currentOrder === null) {
            try {
                $product = Product::where('published', '=', 1)->where('stock', '>', 0)->firstOrFail();
                $order = new Order;
                $order->product_id = $product->id;
                $order->user_id = 0;
                $order->bids = 0;
                $order->winning_price = $product->initial_price;
                $order->ending_at = date('Y-m-d H:i:s',
                    strtotime('now')
                    + intval($this->settings->initial_duration)
                    + intval($this->settings->going_once)
                    + intval($this->settings->going_twice)
                );
                $order->save();
                $this->currentOrder = $order;
                $this->server->sendNewOrder($order);
            } catch (\Exception $e) {
                $e->getMessage();
            }
        }
    }

}
