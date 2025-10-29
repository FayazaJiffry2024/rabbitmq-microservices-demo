<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService
{
    protected $connection;
    protected $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('127.0.0.1', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
    }

    // Method to publish message
    public function publish($queue, $data)
    {
        $this->channel->queue_declare($queue, false, true, false, false);
        $msg = new AMQPMessage(json_encode($data));
        $this->channel->basic_publish($msg, '', $queue);
        echo " [x] Sent: " . json_encode($data) . "\n";
    }
}
