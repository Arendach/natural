<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Base;

use App\Models\Delivery;
use App\Models\Setting;
use App\Orchid\ScreenAbstract;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
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

    public function layout(): iterable
    {
        return [
            $this->table(),
            $this->editModal(),
        ];
    }

    public function asyncGetSetting(Setting $setting): array
    {
        return compact('setting');
    }

    public function update(Request $request): void
    {
        Setting::findOrFail($request->input('setting.id'))->update($request->input('setting'));

        Toast::info('Перемінна оновлена');
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
                ->render(fn(Delivery $delivery) => "<img src='{$delivery->picture}'>"),

            TD::make('Дії')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Setting $setting) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            ModalToggle::make('Редагувати')
                                ->modal('edit')
                                ->icon('pencil')
                                ->method('update')
                                ->modalTitle('Редагувати перемінну')
                                ->asyncParameters([
                                    'setting' => $setting->id
                                ]),
                        ]);
                }),
        ]);
    }

    public function editModal(): Modal
    {
        return Layout::modal('edit', Layout::rows([
            Input::make('setting.id')->type('hidden'),
            Input::make('setting.title')->title('Перемінна')->readonly(),
            TextArea::make('setting.content')->title('Значення'),
        ]))
            ->title('Редагування перемінної')
            ->async('asyncGetSetting')
            ->size(Modal::SIZE_LG);
    }
}