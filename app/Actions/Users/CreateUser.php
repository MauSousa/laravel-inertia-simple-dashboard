<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    /**
     * Handle the action.
     *
     * @param  array<string, mixed>  $data
     */
    public function handle(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
        ]);
    }
}
