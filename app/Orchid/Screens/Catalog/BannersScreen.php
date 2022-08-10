<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Catalog;

use App\Models\Banner;
use App\Orchid\Requests\Banners\StoreRequest;
use App\Orchid\Requests\Banners\UpdateRequest;
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

class BannersScreen extends ScreenAbstract
{
    protected string $model = Banner::class;

    public function name(): ?string
    {
        return 'Баннери';
    }

    public function description(): ?string
    {
        return 'Баннери на головній сторінці';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.banners',
        ];
    }

    public function query(): array
    {
        return [
            'banners' => Banner::query()->orderByDesc('id')->get()
        ];
    }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Додати баннер')
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

    public function asyncGetBanner(Banner $banner): array
    {
        return compact('banner');
    }

    public function store(StoreRequest $request): void
    {
        Banner::create($request->getData());

        Toast::info('Баннер успішно створений!');
    }

    public function update(UpdateRequest $request): void
    {
        $category = Banner::findOrFail($request->input('banner.id'));

        $category->update($request->getData());

        Toast::info('Баннер успішно оновлений');
    }

    public function table(): Table
    {
        return Layout::table('banners', [
            TD::make('id', 'ID')
                ->sort()
                ->filter(),

            TD::make('title', 'Текст баннера')
                ->sort()
                ->filter(),

            TD::make('url', 'URL')
                ->sort()
                ->filter(),

            TD::make('picture_desktop', 'Зображення (десктоп)')
                ->render(function (Banner $banner) {
                    return "<a href='$banner->picture_desktop' target='_blank'><img src=\"$banner->picture_desktop\" style=\"height: 50px\"></a>";
                }),

            TD::make('picture_mobile', 'Зображення (мобайл)')
                ->render(function (Banner $banner) {
                    return "<a href='$banner->picture_mobile' target='_blank'><img src=\"$banner->picture_mobile\" style=\"height: 50px\"></a>";
                }),

            TD::make('color', 'Колір тексту')
                ->sort()
                ->filter()
                ->render(fn(Banner $banner) => "<span style=\"color: $banner->color\">$banner->color</span>"),

            TD::make('priority', 'Пріоритет')
                ->sort(),

            TD::make('is_active', 'Активий')
                ->sort()
                ->render(fn(Banner $banner) => $banner->is_active ? 'Так' : 'Ні'),

            TD::make('Дії')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Banner $banner) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            ModalToggle::make('Редагувати')
                                ->modal('edit')
                                ->icon('pencil')
                                ->method('update')
                                ->modalTitle('Редагування баннера')
                                ->asyncParameters([
                                    'banner' => $banner->id
                                ]),
                            Button::make('Видалити')
                                ->icon('trash')
                                ->confirm('Ви впевнені що хочете видалити?')
                                ->method('destroy', ['id' => $banner->id]),
                        ]);
                }),
        ]);
    }

    public function editModal(): Modal
    {
        return Layout::modal('edit', Layout::rows([
            Input::make('banner.id')->type('hidden'),
            Input::make('banner.title')->title('Текст баннера'),
            Input::make('banner.url')->title('URL'),
            Input::make('banner.color')->title('Колір')->type('color'),
            Input::make('banner.priority')->title('Пріоритет')->value(0),
            Picture::make('banner.picture_desktop')->title('Зображення 1920x400 (десктоп)')->required()->targetRelativeUrl(),
            Picture::make('banner.picture_mobile')->title('Зображення 991х400(мобайл)')->required()->targetRelativeUrl(),
            CheckBox::make('banner.is_active')->placeholder('Активний')->sendTrueOrFalse(),
        ]))
            ->title('Редагування баннера')
            ->async('asyncGetBanner')
            ->size(Modal::SIZE_LG);
    }

    public function createModal(): Modal
    {
        return Layout::modal('create', Layout::rows([
            Input::make('title')->title('Текст баннера'),
            Input::make('url')->title('URL'),
            Input::make('color')->title('Колір')->type('color'),
            Input::make('priority')->title('Пріоритет')->value(0),
            Picture::make('picture_desktop')->title('Зображення (десктоп)')->required()->targetRelativeUrl(),
            Picture::make('picture_mobile')->title('Зображення (мобайл)')->required()->targetRelativeUrl(),
            CheckBox::make('is_active')->placeholder('Активний')->sendTrueOrFalse(),
        ]))
            ->title('Новий баннер')
            ->size(Modal::SIZE_LG);
    }
}