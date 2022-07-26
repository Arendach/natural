<?php

namespace App\Http\Controllers;

use App\Actions\CreateFeedbackAction;

class FeedbackController extends Controller
{
    public function create(CreateFeedbackAction $action)
    {
        $feedback = $action->run();

        return response()->json([
            'message' => "Вашу заявку принято! ID заявки $feedback->id! Очікуйте дзвінка від менеджера!"
        ]);
    }
}
