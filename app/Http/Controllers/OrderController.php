<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrderAction;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Notifications\Telegram;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function create(CreateOrderAction $action): JsonResponse
    {
        $order = $action->run();

        $this->sendTelegram($order);
        $this->sms_notification($order->id);

        setcookie('cart_products', '', time() - 99999, '/');

        return response()
            ->json([
                'message' => 'Ваш заказ успешно принят! Дожидайтесь звонка менеджера!'
            ])->withCookie(cookie('cart_products', null, -1));
    }

    public function sms_notification($id)
    {
        if (settings('sms.use') == 1) {
            sendSms(settings('sms.number'), settings('sms.template'), 'Оповещеие об заказе №' . $id);
        }
    }

    private function sendTelegram($order)
    {

        try {
            $telegram_users = explode(',', config('telegram.telegram_users'));
            foreach ($telegram_users as $telegram_user_id) {
                Notification::send('telegram', new Telegram($telegram_user_id, $order));
            }
        } catch (Exception $exception) {
            $exception->getMessage();
        }

    }

}