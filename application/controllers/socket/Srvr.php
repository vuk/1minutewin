<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Srvr extends CI_Controller {
    protected $clients;
    protected $runner;
    protected $order;

    public function __construct() {
        parent::__construct();
        $this->clients = new \SplObjectStorage();
    }

    public function start () {
        try {
            $loop = React\EventLoop\Factory::create();
            $socket = new React\Socket\Server($loop);

            // START RUNNER SERVICE
            $runner = new React\ChildProcess\Process('php index.php socket/rnnr start');

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
            $bidder = new React\ChildProcess\Process('php index.php socket/bidder start');

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

            $socket->on('connection', function ($conn) {
                $this->clients->attach($conn);
                $conn->on('data', function ($data) use ($conn) {
                    foreach ($this->clients as $current) {
                        if ($conn === $current) {
                            continue;
                        }
                        $current->write($conn->getRemoteAddress().': ');
                        $current->write($data);
                    }
                });
                $conn->on('end', function () use ($conn) {
                    $this->clients->detach($conn);
                });
            });
            echo "Socket server listening on port 8080.\n";
            $socket->listen(8080, '0.0.0.0');
            $loop->run();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    private function notifyAll($data) {
        foreach ($this->clients as $current) {
            $current->write($data);
        }
    }
}
