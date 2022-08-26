<?php

namespace App\Orchid\Screens\Catalog;

use App\Models\Product;
use App\Models\RelatedImage;
use App\Orchid\Requests\RelatedImages\StoreRequest;
use App\Orchid\Requests\RelatedImages\UpdateRequest;
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

class ProductsImagesScreen extends ScreenAbstract
{
    protected string $model = RelatedImage::class;

    public function name(): ?string
    {
        return 'Зображення';
    }

    public function description(): ?string
    {
        return 'Фотогалерея для товарів';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.products',
        ];
    }

    public function query(Product $product): array
    {
        return [
            'images' => $product->relatedImages,
        ];
    }

    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Додати зображення')
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

    public function asyncGetRelatedImage(RelatedImage $image): array
    {
        return compact('image');
    }

    public function store(StoreRequest $request): void
    {
        /** @var Product $model */
        $model =$request->getModel();

        $model->relatedImages()->create($request->getData());

        Toast::info('Зображення вдало додано');
    }

    public function update(UpdateRequest $request): void
    {
        $image = RelatedImage::findOrFail($request->input('image.id'));

        $image->update($request->getData());

        Toast::info('Зображення вдало відредаговане');
    }

    public function table(): Table
    {
        return Layout::table('images', [
            TD::make('id', 'ID')
                ->sort()
                ->filter(),

            TD::make('alt', 'Alt text')
                ->sort()
                ->filter(),

            TD::make('path', 'Зображення')
                ->render(function (RelatedImage $image) {
                    return "<a href='$image->path' target='_blank'><img src=\"$image->path\" style=\"height: 50px\"></a>";
                }),

            TD::make('is_active', 'Активне')
                ->sort()
                ->render(fn(RelatedImage $image) => $image->is_active ? 'Так' : 'Ні'),

            TD::make('Дії')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (RelatedImage $image) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            ModalToggle::make('Редагувати')
                                ->modal('edit')
                                ->icon('pencil')
                                ->method('update')
                                ->modalTitle('Редагування')
                                ->asyncParameters([
                                    'relatedImage' => $image->id
                                ]),
                            Button::make('Видалити')
                                ->icon('trash')
                                ->confirm('Ви впевнені що хочете видалити?')
                                ->method('destroy', ['id' => $image->id]),
                        ]);
                }),
        ]);
    }

    public function editModal(): Modal
    {
        return Layout::modal('edit', Layout::rows([
            Input::make('image.id')->hidden(),
            Input::make('image.alt')->title('Alt text'),
            CheckBox::make('image.is_active')->placeholder('Активне')->sendTrueOrFalse(),
        ]))
            ->title('Редагування зображення')
            ->async('asyncGetRelatedImage');
    }

    public function createModal(): Modal
    {
        $product = request()->route('product');

        return Layout::modal('create', Layout::rows([
            Input::make('model_id')->hidden()->value($product?->id),
            Input::make('model_type')->hidden()->value(Product::class),
            Input::make('alt')->title('Alt'),
            Picture::make('path')->title('Зображення')->targetRelativeUrl()->required(),
            CheckBox::make('is_active')->placeholder('Активне')->sendTrueOrFalse(),
        ]))
            ->title('Нове зображення')
            ->size(Modal::SIZE_LG);
    }
}