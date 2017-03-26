<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;

class Pay extends CI_Controller
{
    protected $settings = null;

    public function __construct()
    {
        parent::__construct();
        $this->settings = json_decode(Setting::where('settings_key', 'LIKE', 'settings')->first()->value);
    }

    public function index () {

    }

    public function pay ($order_id) {

        try {
            $order = Order::findOrFail($order_id);

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $item1 = new Item();
            $item1->setName($order->product->product_title)
                ->setCurrency($this->settings->currency)
                ->setQuantity(1)
                ->setSku($order->product->id) // Similar to `item_number` in Classic API
                ->setPrice($order->winning_price);

            $itemList = new ItemList();
            $itemList->setItems(array($item1));

            $details = new Details();
            $details->setShipping($order->product->shipping_price);

            $amount = new Amount();
            $amount->setCurrency($this->settings->currency)
                ->setTotal($order->product->shipping_price + $order->winning_price)
                ->setDetails($details);

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription("1 Minute Win Payment")
                ->setInvoiceNumber(uniqid());

            $baseUrl = base_url();
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl($baseUrl."home/cart?success=true&order=".$order->id . "&ref=".$order->reference)
                ->setCancelUrl($baseUrl."home/cart?success=false&order=".$order->id."&ref=".$order->reference);

            $payment = new Payment();
            $payment->setIntent("sale")
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions(array($transaction));

            $request = clone $payment;

            $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    'AcN5JJUy8u1CAtQQLubF974TdjBDvlTXbCgI01qBaQFHnyTBAcsM9DqOUEp0lW3GvUpiTfrde9XXe2ck',     // ClientID
                    'EKqA6l_xea-rRy2QurxX1WEzdBFpUls89IDbY0LVYR46k-c5Kkwu4ElwfVaxDbWRmeN2q3d7DXkqrzte'      // ClientSecret
                )
            );

            $apiContext->setConfig(
                array(
                    'mode' => 'live',
                    'log.LogEnabled' => true,
                    'log.FileName' => '../PayPal.log',
                    'log.LogLevel' => 'FINE', // PLEASE USE FINE LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                    'cache.enabled' => true,
                )
            );

            $payment->create($apiContext);

            $approvalUrl = $payment->getApprovalLink();

            redirect($approvalUrl);
/*
            echo "Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment;

            return $payment;*/

        } catch (PayPalConnectionException $e) {
            var_dump($e->getMessage());
            var_dump($e->getData());
            var_dump($e->getCode());
        }
    }

}