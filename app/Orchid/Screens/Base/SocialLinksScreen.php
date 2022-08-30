<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Base;

use App\Models\SocialLink;
use App\Orchid\Requests\SocialLinks\StoreRequest;
use App\Orchid\Requests\SocialLinks\UpdateRequest;
use App\Orchid\ScreenAbstract;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SocialLinksScreen extends ScreenAbstract
{
    protected string $model = SocialLink::class;

    public function name(): ?string
    {
        return 'Соцмережі';
    }

    public function description(): ?string
    {
        return 'Посилання на соцмережі магазину';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.social_links',
        ];
    }

    public function query(): array
    {
        return [
            'items' => SocialLink::all(),
        ];
    }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Додати посилання')
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

    public function asyncGetLink(SocialLink $socialLink): array
    {
        return ['link' => $socialLink];
    }

    public function update(UpdateRequest $request): void
    {
        SocialLink::findOrFail($request->input('link.id'))->update($request->getData());

        Toast::info('Посилання оновлено');
    }


    public function store(StoreRequest $request): void
    {
        SocialLink::create($request->getData());

        Toast::info('Посилання додано');
    }


    public function table(): Table
    {
        return Layout::table('items', [
            TD::make('title', 'Назва')
                ->sort()
                ->filter(),

            TD::make('url', 'URL')
                ->filter()
                ->sort(),

            TD::make('icon', 'Іконка')
                ->render(fn(SocialLink $link) => "<a target='_blank' href='$link->picture'><img style='max-width: 100px' src='$link->picture'></a>"),

            TD::make('is_active', 'Активна')
                ->sort()
                ->render(fn(SocialLink $link) => $link->is_active ? 'Так' : 'Ні'),

            TD::make('priority', 'Пріоритет')
                ->filter()
                ->sort(),

            TD::make('Дії')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (SocialLink $link) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            ModalToggle::make('Редагувати')
                                ->modal('edit')
                                ->icon('pencil')
                                ->method('update')
                                ->modalTitle('Редагувати доставку')
                                ->asyncParameters([
                                    'delivery' => $link->id
                                ]),
                            Button::make('Видалити')
                                ->icon('trash')
                                ->confirm('Ви впевнені що хочете видалити?')
                                ->method('destroy', ['id' => $link->id]),
                        ]);
                }),
        ]);
    }

    public function editModal(): Modal
    {
        return Layout::modal('edit', Layout::rows([
            Input::make('link.id')->type('hidden'),
            Input::make('link.title')->title('Назва')->required(),
            Input::make('link.url')->title('URL')->required(),
            Picture::make('link.picture')->title('Іконка')->targetRelativeUrl(),
            Input::make('link.priority')->title('Пріоритет')->type('number'),
            CheckBox::make('link.is_active')->placeholder('Активне')->sendTrueOrFalse(),
        ]))
            ->title('Редагування посилання')
            ->async('asyncGetLink')
            ->size(Modal::SIZE_LG);
    }

    public function createModal(): Modal
    {
        return Layout::modal('create', Layout::rows([
            Input::make('title')->title('Назва')->required(),
            Picture::make('picture')->title('Іконка')->targetRelativeUrl(),
            Input::make('url')->title('URL')->required(),
            Input::make('priority')->title('Пріоритет')->type('number')->required()->value(0),
            CheckBox::make('is_active')->placeholder('Активне')->sendTrueOrFalse(),
        ]))
            ->title('Нове посилання')
            ->size(Modal::SIZE_LG);
    }
}