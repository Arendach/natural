<?php

namespace App\Actions;

use App\Http\Requests\CreateFeedbackRequest;
use App\Models\Feedback;
use App\Tasks\Feedback\SmsNotificationsTask;

class CreateFeedbackAction
{
    private CreateFeedbackRequest $request;

    public function __construct(CreateFeedbackRequest $request)
    {
        $this->request = $request;
    }

    public function run(): Feedback
    {
        $feedback = Feedback::create($this->request->getData());

        app(SmsNotificationsTask::class)->run($feedback);

        return $feedback;
    }
}