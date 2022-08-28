<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Client;

use App\Models\Feedback;
use App\Orchid\Requests\Feedbacks\UpdateRequest;
use App\Orchid\ScreenAbstract;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class FeedbacksScreen extends ScreenAbstract
{
    protected string $model = Feedback::class;

    public function name(): ?string
    {
        return 'Feedbacks';
    }

    public function description(): ?string
    {
        return 'Заявки зворотнього звяку, перетелефонуйте мені';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.feedbacks',
        ];
    }

    public function query(): array
    {
        return [
            'feedbacks' => Feedback::orderByDesc('id')->paginate(50),
        ];
    }

    public function layout(): iterable
    {
        return [
            $this->table(),
            $this->editModal(),
        ];
    }

    public function asyncGetFeedback(Feedback $feedback): array
    {
        return compact('feedback');
    }

    public function update(UpdateRequest $request): void
    {
        Feedback::findOrFail($request->input('feedback.id'))->update($request->getData());

        Toast::info('Feedback оновлений');
    }

    public function table(): Table
    {
        return Layout::table('feedbacks', [
            TD::make('name', 'Імя')
                ->sort()
                ->filter(),

            TD::make('phone', 'Номер телефону')
                ->render(fn(Feedback $feedback) => "<a href='tel:" . $feedback->getPhone() . "'>" . $feedback->getPhone() . "</a>")
                ->filter()
                ->sort(),

            TD::make('message', 'Коментар клієнта')
                ->render(fn(Feedback $feedback) => mb_substr((string)$feedback->message, 0, 100)),

            TD::make('is_accepted', 'Прийнятий')
                ->filter(TD::FILTER_SELECT, [0 => 'Ні', 1 => 'Так'])
                ->sort()
                ->render(fn(Feedback $delivery) => $delivery->is_accepted ? 'Так' : 'Ні'),

            TD::make('created_at', 'Створено')
                ->filter(TD::FILTER_DATE_RANGE)
                ->sort()
                ->render(fn(Feedback $feedback) => $feedback->created_at->format('Y.m.d H:i')),

            TD::make('Дії')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Feedback $feedback) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            ModalToggle::make('Редагувати')
                                ->modal('edit')
                                ->icon('pencil')
                                ->method('update')
                                ->modalTitle('Редагувати доставку')
                                ->asyncParameters([
                                    'delivery' => $feedback->id
                                ]),
                            Button::make('Видалити')
                                ->icon('trash')
                                ->confirm('Ви впевнені що хочете видалити?')
                                ->method('destroy', ['id' => $feedback->id]),
                        ]);
                }),
        ]);
    }

    public function editModal(): Modal
    {
        return Layout::modal('edit', Layout::rows([
            Input::make('feedback.id')->type('hidden'),
            Input::make('feedback.name')->title('Імя')->required(),
            Input::make('feedback.phone')->title('Номер телефону')->required(),
            TextArea::make('feedback.message')->title('Коментар'),
            CheckBox::make('feedback.is_accepted')->placeholder('Прийнятий')->sendTrueOrFalse(),
        ]))
            ->title('Редагування feedback')
            ->async('asyncGetFeedback')
            ->size(Modal::SIZE_LG);
    }
}