<?php

namespace App\Console\Commands;

use App\Models\PushNotification;
use Illuminate\Console\Command;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class NewProductsNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:new-products-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for new products and send push notifications';

    /**
     * Execute the console command.
     * @throws \ErrorException
     */
    public function handle(): void
    {
        $auth = [
            'VAPID' => [
                'subject' => 'mailto:janis.zogots@edu.rtu.lv',
                'publicKey' => env('PUSH_NOTIFICATION_PUBLIC_KEY'),
                'privateKey' => env('PUSH_NOTIFICATION_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);

        $payload = json_encode([
            'title' => 'New Arrivals!',
            'body' => 'Check out the latest items in our shop.',
            'url' => 'http://localhost:8000/',
        ]);

        $notifications = PushNotification::all();

        foreach ($notifications as $notification) {
            $webPush->sendOneNotification(
                Subscription::create($notification['subscriptions']),
                $payload,
                ['TTL' => 5000]
            );
        }

        foreach ($webPush->flush() as $report) {
            if (!$report->isSuccess()) {
                logger()->warning('Push failed', ['reason' => $report->getReason()]);
            }
        }

        $this->info('Notifications sent.');
    }
}
