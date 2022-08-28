<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Base;

use App\Models\Delivery;
use App\Orchid\Requests\Deliveries\StoreRequest;
use App\Orchid\Requests\Deliveries\UpdateRequest;
use App\Orchid\ScreenAbstract;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DeliveriesScreen extends ScreenAbstract
{
    protected string $model = Delivery::class;

    public function name(): ?string
    {
        return 'Доставки';
    }

    public function description(): ?string
    {
        return 'Способи доставок доступних для інтернет магазину, опис та вартість';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.deliveries',
        ];
    }

    public function query(): array
    {
        return [
            'deliveries' => Delivery::all()
        ];
    }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Додати доставку')
                ->modal('create')
                ->icon('plus')
                ->method('store')
        ];
    }

    public function layout(): iterable
    {
        return [
            $this->table(),
            $this->editModal(),
            $this->createModal(),
        ];
    }

    public function asyncGetDelivery(Delivery $delivery): array
    {
        return compact('delivery');
    }

    public function update(UpdateRequest $request): void
    {
        Delivery::findOrFail($request->input('delivery.id'))->update($request->getData());

        Toast::info('Доставка оновлена');
    }


    public function store(StoreRequest $request): void
    {
        Delivery::create($request->getData());

        Toast::info('Доставка створена');
    }


    public function table(): Table
    {
        return Layout::table('deliveries', [
            TD::make('title', 'Назва')
                ->sort()
                ->filter(),

            TD::make('slug', 'Slug')
                ->filter()
                ->sort(),

            TD::make('picture', 'Іконка')
                ->render(fn(Delivery $delivery) => "<a target='_blank' href='$delivery->picture'><img style='max-width: 100px' src='$delivery->picture'></a>"),

            TD::make('is_active', 'Активна')
                ->sort()
                ->render(fn(Delivery $delivery) => $delivery->is_active ? 'Так' : 'Ні'),

            TD::make('Дії')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Delivery $delivery) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            ModalToggle::make('Редагувати')
                                ->modal('edit')
                                ->icon('pencil')
                                ->method('update')
                                ->modalTitle('Редагувати доставку')
                                ->asyncParameters([
                                    'delivery' => $delivery->id
                                ]),
                            Button::make('Видалити')
                                ->icon('trash')
                                ->confirm('Ви впевнені що хочете видалити?')
                                ->method('destroy', ['id' => $delivery->id]),
                        ]);
                }),
        ]);
    }

    public function editModal(): Modal
    {
        return Layout::modal('edit', Layout::rows([
            Input::make('delivery.id')->type('hidden'),
            Input::make('delivery.title')->title('Назва')->required(),
            Input::make('delivery.slug')->title('Slug')->required(),
            Quill::make('delivery.description')->title('Умови доставки'),
            Picture::make('delivery.picture')->title('Іконка')->targetRelativeUrl(),
            CheckBox::make('delivery.is_active')->placeholder('Активна')->sendTrueOrFalse(),
        ]))
            ->title('Редагування доставки')
            ->async('asyncGetDelivery')
            ->size(Modal::SIZE_LG);
    }

    public function createModal(): Modal
    {
        return Layout::modal('create', Layout::rows([
            Input::make('title')->title('Назва')->required(),
            Input::make('slug')->title('Slug'),
            Quill::make('description')->title('Опис'),
            Picture::make('picture')->title('Іконка')->targetRelativeUrl(),
            CheckBox::make('is_active')->placeholder('Активна')->sendTrueOrFalse(),
        ]))
            ->title('Нова доставка')
            ->size(Modal::SIZE_LG);
    }
}