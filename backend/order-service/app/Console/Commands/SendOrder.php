<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RabbitMQService;

class SendOrder extends Command
{
    protected $signature = 'orders:send';
    protected $description = 'Send a test order to RabbitMQ';

    protected $rabbitMQ;

    public function __construct(RabbitMQService $rabbitMQ)
    {
        parent::__construct();
        $this->rabbitMQ = $rabbitMQ;
    }

    public function handle()
    {
        $order = [
            'id' => rand(1000, 9999),
            'product' => 'Test Product',
            'quantity' => 1,
        ];

        $this->rabbitMQ->publish('orders', $order);
        $this->info("Order sent!");
    }
}
