<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Catalog;

use App\Models\Category;
use App\Orchid\Requests\Categories\StoreRequest;
use App\Orchid\Requests\Categories\UpdateRequest;
use App\Orchid\ScreenAbstract;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoriesScreen extends ScreenAbstract
{
    protected string $model = Category::class;

    public function name(): ?string
    {
        return 'Категорії товарів';
    }

    public function description(): ?string
    {
        return 'Всі доступні категорії товарів';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.categories',
        ];
    }

    public function query(): array
    {
        return [
            'categories' => Category::with('seo')->orderByDesc('id')->paginate(100)
        ];
    }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Додати категорію')
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

    public function asyncGetCategory(Category $category): array
    {
        $seo = $category->seo;

        return compact('category', 'seo');
    }

    public function store(StoreRequest $request): void
    {
        $category = Category::create($request->getData());

        $category->seo()->updateOrCreate([], []);

        Toast::info('Категорія створена');
    }

    public function update(UpdateRequest $request): void
    {
        $category = Category::findOrFail($request->input('category.id'));

        $category->update($request->getData());

        $category->seo()->updateOrCreate([], $request->getSeo());

        Toast::info('Категорія оновлена');
    }

    public function table(): Table
    {
        return Layout::table('categories', [
            TD::make('id', 'ID')
                ->sort()
                ->filter(),

            TD::make('title', 'Назва')
                ->sort()
                ->filter(),

            TD::make('slug', 'Slug')
                ->sort()
                ->filter(),

            TD::make('priority', 'Пріоритет')
                ->sort(),

            TD::make('is_active', 'Активна')
                ->sort()
                ->render(fn(Category $category) => $category->is_active ? 'Так' : 'Ні'),

            TD::make('Дії')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Category $category) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            ModalToggle::make('Редагувати')
                                ->modal('edit')
                                ->icon('pencil')
                                ->method('update')
                                ->modalTitle('Редагування категорії')
                                ->asyncParameters([
                                    'category' => $category->id
                                ]),
                            Button::make('Видалити')
                                ->icon('trash')
                                ->confirm('Ви впевнені що хочете видалити?')
                                ->method('destroy', ['id' => $category->id]),
                        ]);
                }),
        ]);
    }

    public function editModal(): Modal
    {
        return Layout::modal('edit', Layout::tabs([
            'Основна інформація' => Layout::rows([
                Input::make('category.id')->type('hidden'),
                Input::make('category.title')->title('Назва')->required(),
                Input::make('category.slug')->title('Slug')->required(),
                Input::make('category.priority')->title('Пріоритет'),
                Quill::make('category.description')->title('Опис'),
                CheckBox::make('category.is_active')->placeholder('Активна')->sendTrueOrFalse(),
            ]),
            'Сео'                => Layout::rows([
                Input::make('seo.title')->title('Title'),
                Input::make('seo.description')->title('Description'),
                Input::make('seo.keywords')->title('Keywords'),
                Input::make('seo.h1')->title('H1'),
                CheckBox::make('seo.is_index')->placeholder('Індекс')->sendTrueOrFalse(),
                CheckBox::make('seo.is_follow')->placeholder('Follow')->sendTrueOrFalse(),
            ])
        ]))
            ->title('Редагування категорії')
            ->async('asyncGetCategory')
            ->size(Modal::SIZE_LG);
    }

    public function createModal(): Modal
    {
        return Layout::modal('create', Layout::rows([
            Input::make('title')->title('Назва')->required(),
            Input::make('slug')->title('Slug'),
            Input::make('priority')->title('Пріоритет'),
            Quill::make('description')->title('Опис'),
            CheckBox::make('is_active')->placeholder('Активна')->sendTrueOrFalse(),
        ]))
            ->title('Нова категорія')
            ->size(Modal::SIZE_LG);
    }
}