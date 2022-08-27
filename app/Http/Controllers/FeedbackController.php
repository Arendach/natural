<?php

namespace App\Http\Controllers;

use App\Actions\CreateFeedbackAction;
use App\Models\Feedback;
use App\Repositories\BannerRepository;
use App\Resources\BannerResource;
use App\Resources\FeedbackResource;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function create(CreateFeedbackAction $action): JsonResponse
    {
        $feedback = $action->run();

        session()->put('lastFeedback', $feedback->id);

        return response()->json([
            'redirectUrl' => route('thank.feedback', [$feedback->id])
        ]);
    }

    public function thank(Feedback $feedback): View
    {
        abort_if(session('lastFeedback') !== $feedback->id, 404);

        $title = "Заявка прийнята! Id: $feedback->id";
        $breadcrumbs = [['Заявка прийнята']];
        $banners = BannerResource::collection(app(BannerRepository::class)->getBanners());
        $order = new FeedbackResource($feedback);

        return view('pages.thank', compact('order', 'banners', 'title', 'breadcrumbs'));
    }
}
