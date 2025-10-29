<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RabbitMQService;

class ConsumeOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * We can run this using: php artisan orders:consume
     */
    protected $signature = 'orders:consume';

    /**
     * The console command description.
     */
    protected $description = 'Consume orders from RabbitMQ queue';

    protected $rabbitMQService;

    /**
     * Create a new command instance.
     */
    public function __construct(RabbitMQService $rabbitMQService)
    {
        parent::__construct();
        $this->rabbitMQService = $rabbitMQService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Waiting for orders...');

        // Call the consume method with queue name AND callback
        $this->rabbitMQService->consume('orders', function ($message) {
            $data = json_decode($message->body, true);
            $this->info('Received order: ' . $data['id'] ?? 'Unknown');

            // You can add more logic here, e.g., send email notification
        });

        // Keep the script running
        while ($this->rabbitMQService->hasCallbacks()) {
            $this->rabbitMQService->wait();
        }
    }
}
