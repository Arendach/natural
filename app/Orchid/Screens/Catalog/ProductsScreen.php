<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Catalog;

use App\Models\Category;
use App\Models\Product;
use App\Orchid\Requests\Products\StoreRequest;
use App\Orchid\Requests\Products\UpdateRequest;
use App\Orchid\ScreenAbstract;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductsScreen extends ScreenAbstract
{
    protected string $model = Product::class;

    public function name(): ?string
    {
        return 'Товари';
    }

    public function description(): ?string
    {
        return 'Всі доступні товари';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.products',
        ];
    }

    public function query(): array
    {
        return [
            'products' => Product::with('seo', 'category')->orderByDesc('id')->paginate(100)
        ];
    }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Додати товар')
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

    public function asyncGetProduct(Product $product): array
    {
        $seo = $product->seo;

        return compact('product', 'seo');
    }

    public function store(StoreRequest $request): void
    {
        $product = Product::create($request->getData());

        $product->seo()->updateOrCreate([], []);

        Toast::info('Товар вдало створений');
    }

    public function update(UpdateRequest $request): void
    {
        $product = Product::findOrFail($request->input('product.id'));

        $product->update($request->getData());

        $product->seo()->updateOrCreate([], $request->getSeo());

        Toast::info('Товар вдало відредагований');
    }

    public function table(): Table
    {
        return Layout::table('products', [
            TD::make('id', 'ID')
                ->sort()
                ->filter(),

            TD::make('title', 'Назва')
                ->sort()
                ->filter(),

            TD::make('price', 'Ціна')
                ->sort()
                ->filter(),

            TD::make('picture', 'Фото')
                ->render(function (Product $product) {
                    return "<a href='$product->picture' target='_blank'><img src=\"$product->picture\" style=\"height: 50px\"></a>";
                }),

            TD::make('priority', 'Пріоритет')
                ->sort(),

            TD::make('is_active', 'Активний')
                ->sort()
                ->render(fn(Product $product) => $product->is_active ? 'Так' : 'Ні'),

            TD::make('category_id', 'Категорія')
                ->sort()
                ->render(fn(Product $product) => $product->category->title),

            TD::make('Дії')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Product $product) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            ModalToggle::make('Редагувати')
                                ->modal('edit')
                                ->icon('pencil')
                                ->method('update')
                                ->modalTitle('Редагування')
                                ->asyncParameters([
                                    'product' => $product->id
                                ]),
                            Button::make('Видалити')
                                ->icon('trash')
                                ->confirm('Ви впевнені що хочете видалити?')
                                ->method('destroy', ['id' => $product->id]),
                            Link::make('Фотогалерея')
                                ->route('platform.products.images', $product->id)
                                ->icon('picture'),
                        ]);
                }),
        ]);
    }

    public function editModal(): Modal
    {
        return Layout::modal('edit', Layout::tabs([
            'Основна інформація' => Layout::rows([
                Input::make('product.id')->hidden(),
                Input::make('product.title')->title('Назва')->required(),
                Input::make('product.slug')->title('Slug')->required(),
                Input::make('product.price')->title('Ціна')->required()->value(0),
                Input::make('product.discount')->title('Знижка(грн)'),
                Select::make('product.category_id')->title('Категорія')->options($this->getCategories())->required(),
                Input::make('product.priority')->title('Пріоритет')->value(0),
                Picture::make('product.picture')->title('Фото')->targetRelativeUrl(),
                TextArea::make('product.short_description')->title('Короткий опис'),
                Quill::make('product.description')->title('Опис'),
                CheckBox::make('product.is_active')->placeholder('Активний')->sendTrueOrFalse(),
                CheckBox::make('product.is_storage')->placeholder('Є в наявності')->sendTrueOrFalse(),
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
            ->title('Редагування товару')
            ->async('asyncGetProduct')
            ->size(Modal::SIZE_LG);
    }

    public function createModal(): Modal
    {
        return Layout::modal('create', Layout::rows([
            Input::make('title')->title('Назва')->required(),
            Input::make('slug')->title('Slug'),
            Input::make('price')->title('Ціна')->required()->value(0),
            Input::make('discount')->title('Знижка(грн)'),
            Select::make('category_id')->title('Категорія')->options($this->getCategories())->required(),
            Input::make('priority')->title('Пріоритет')->value(0),
            Picture::make('picture')->title('Фото')->targetRelativeUrl(),
            TextArea::make('shor_description')->title('Короткий опис'),
            Quill::make('description')->title('Опис'),
            CheckBox::make('is_active')->placeholder('Активний')->sendTrueOrFalse(),
            CheckBox::make('is_storage')->placeholder('Є в наявності')->sendTrueOrFalse(),
        ]))
            ->title('Новий товар')
            ->size(Modal::SIZE_LG);
    }

    private function getCategories(): array
    {
        return Category::where('is_active', true)
            ->get()
            ->mapWithKeys(fn(Category $category) => [$category->id => $category->title])
            ->toArray();
    }

}