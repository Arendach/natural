<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserFiltersLayout;
use App\Orchid\Layouts\User\UserListLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'users' => User::with('roles')
                ->filters()
                ->filtersApplySelection(UserFiltersLayout::class)
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Користувачі';
    }

    public function description(): ?string
    {
        return 'Всі зареєстровані користувачі';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Додати')
                ->icon('plus')
                ->route('platform.systems.users.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            UserFiltersLayout::class,
            UserListLayout::class,

            Layout::modal('asyncEditUserModal', UserEditLayout::class)
                ->async('asyncGetUser'),
        ];
    }

    public function asyncGetUser(User $user): iterable
    {
        return [
            'user' => $user,
        ];
    }

    public function saveUser(Request $request, User $user): void
    {
        $request->validate([
            'user.email' => [
                'required',
                Rule::unique(User::class, 'email')->ignore($user),
            ],
        ]);

        $user->fill($request->input('user'))->save();

        Toast::info('Користувач доданий');
    }

    public function remove(Request $request): void
    {
        User::findOrFail($request->get('id'))->delete();

        Toast::info( 'Користувач видалений');
    }
}
