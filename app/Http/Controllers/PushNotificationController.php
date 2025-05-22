<?php

namespace App\Http\Controllers;

use App\Models\PushNotification;
use Illuminate\Http\Request;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PushNotificationController extends Controller
{
    public function createSubscription(Request $request): \Illuminate\Http\JsonResponse
    {
        $notification = new PushNotification();
        $notification->subscriptions = json_decode($request->getContent(), true);
        $notification->save();

        return response()->json(['message' => 'Subscription created'], 200);
    }

    public function sendNotification(Request $request): \Illuminate\Http\JsonResponse
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
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'url' => $request->get('url'),
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

        return response()->json(['message' => 'Push Notification Sent Successfully'], 200);
    }
}
