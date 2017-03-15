<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class SockServer implements MessageComponentInterface {
    protected $clients;
    protected $runner;
    protected $order;
    private static $instance = null;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->runner = \Runner::getInstance();
        $this->order = Order::where('ending_at', '>', date('Y-m-d H:i:s', strtotime('now')));
    }

    public static function getInstance () {
        if (SockServer::$instance == null) {
            SockServer::$instance = new SockServer();
        }
        return SockServer::$instance;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    /**
     * @param $message
     * Should update order to reflect new end time (full time restart)
     * Should update price of order to reflect bid amount
     * Should update bid count
     * Should update winning user of order
     * Should send out message to all clients with new values
     */
    public function newBid ($message) {

    }

    /**
     * Should update order to reflect end status of object
     * Should send out message to all clients with final results
     */
    public function auctionEnded () {

    }

    /**
     * Send notification to winner of an auction
     */
    public function notifyWinner () {

    }

    public function sendNewOrder ($order) {
        foreach ($this->clients as $client) {
            $client->send(json_encode([
                'type' => 'order',
                'payload' => [
                    'order' => $order
                ]
            ]));
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}