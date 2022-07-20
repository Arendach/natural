<?php

namespace App\Orchid;

use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

abstract class ScreenAbstract extends Screen
{
    protected string $model;

    public function destroy(Request $request)
    {
        $this->model::findOrFail($request->get('id'))->delete();

        Toast::info('Видалено вдало!');
    }
}