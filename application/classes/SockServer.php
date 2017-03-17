<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use React\EventLoop\Factory;
use React\ChildProcess\Process;

class SockServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->initChildProcesses();
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

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    private function initChildProcesses () {
        /*$loop = Factory::create();

        // START RUNNER SERVICE
        $runner = new Process('php index.php socket/rnnr start');

        $runner->on('exit', function($exitCode, $termSignal) {
            echo "Runner process stopped";
        });

        $loop->addTimer(0.001, function($timer) use ($runner) {
            $runner->start($timer->getLoop());
            $runner->stdout->on('data', function($output) {
                $childData = json_decode($output);
                $message = [
                    'type'  => 'newOrder',
                    'data' => $childData
                ];
                $this->notifyAll(json_encode($message));
                echo json_encode($message);
            });
        });
        // END START RUNNER SERVICE

        // START BIDDER SERVICE
        $bidder = new Process('php index.php socket/bidder start');

        $bidder->on('exit', function($exitCode, $termSignal) {
            echo "Bidder process stopped";
        });

        $loop->addTimer(0.001, function($timer) use ($bidder) {
            $bidder->start($timer->getLoop());
            $bidder->stdout->on('data', function($output) {
                echo "{$output}";
            });
        });
        // END START BIDDER SERVICE

        $loop->run();*/
    }


    private function notifyAll($data) {
        foreach ($this->clients as $current) {
            $current->send($data);
        }
    }
}