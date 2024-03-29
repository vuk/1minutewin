<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rnnr extends CI_Controller {

    public $currentOrder = null;
    protected $settings = null;
    protected $previousProduct = null;

    public function start() {
        if ($this->settings === null) {
            $this->settings = json_decode(Setting::where('settings_key', 'LIKE', 'settings')->first()->value);
        }
        do {
            $this->checkCurrentOrder();
            $this->clearCurrentOrder();
            sleep(5);
        } while (true);
    }

    private function checkCurrentOrder () {
        if ($this->currentOrder === null) {
            try {
                $order = Order::where('ended', '=', 0)->where('ending_at', '>', date('Y-m-d H:i:s', strtotime('now')))->first();
                if (isset($order->id)) {
                    $order->product;
                    $order->user;
                    $order->duration = (strtotime($order->ending_at) - strtotime($order->updated_at)) * 1000;
                    $order->durationLeft = (strtotime($order->ending_at) - strtotime('now')) * 1000;
                    $this->currentOrder = $order;
                } else {
                    $product = Product::where('published', '=', 1)->where('stock', '>', 0)->inRandomOrder()->firstOrFail();
                    // Make sure two same products never come consecutively
                    $productCount = Product::where('published', '=', 1)->where('stock', '>', 0)->count();
                    if ($productCount > 1) {
                        while($product->id === $this->previousProduct) {
                            $product = Product::where('published', '=', 1)->where('stock', '>', 0)->inRandomOrder()->firstOrFail();
                        }
                    }
                    $this->previousProduct = $product->id;
                    // End make sure two same products never come consecutively
                    $order = new Order;
                    $order->product_id = $product->id;
                    $order->reference = substr(md5(date('Y-m-d H:i:s', strtotime('now'))), 0, 6);
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
                    $product->stock -= 1;
                    $product->save();
                    $this->currentOrder = $order;
                    $order->product;
                    $order->user;
                    $order->duration = (strtotime($order->ending_at) - strtotime($order->updated_at)) * 1000;
                    $order->durationLeft = (strtotime($order->ending_at) - strtotime('now')) * 1000;
                }
                echo json_encode($order);
            } catch (\Exception $e) {
                $e->getMessage();
            }
        }
    }

    private function clearCurrentOrder () {
        if ($this->currentOrder !== null) {
            if (strtotime($this->currentOrder->ending_at) < strtotime('now')) {
                $checkOrder = Order::find($this->currentOrder->id);
                if (strtotime($checkOrder->ending_at) < strtotime('now')) {
                    $this->currentOrder->ended = 1;
                    // If purchase is fake, return stock to previous value
                    if ($this->currentOrder->user_id < 1) {
                        $this->currentOrder->product->stock ++;
                        $this->currentOrder->product->save();
                    }
                    unset($this->currentOrder->productObject);
                    unset($this->currentOrder->userObject);
                    unset($this->currentOrder->duration);
                    unset($this->currentOrder->durationLeft);
                    $this->currentOrder->save();
                    $this->currentOrder = null;
                    echo json_encode([
                        'order' => 'clear'
                    ]);
                } else {
                    $this->currentOrder = $checkOrder;
                }
            }
        }
    }

    public static function slack($message, $room = "engineering", $icon = ":longbox:") {
        $room = ($room) ? $room : "engineering";
        $data = "payload=" . json_encode(array(
                "channel"       =>  "#{$room}",
                "text"          =>  $message,
                "icon_emoji"    =>  $icon
            ));

        // You can get your webhook endpoint from your Slack settings
        $ch = curl_init("https://hooks.slack.com/services/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");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        // Laravel-specific log writing method
        // Log::info("Sent to Slack: " . $message, array('context' => 'Notifications'));
        return $result;
    }
}
