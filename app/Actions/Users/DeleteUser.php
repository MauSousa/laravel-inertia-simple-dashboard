<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;

class DeleteUser
{
    /**
     * Delete the given user.
     */
    public function handle(User $user): void
    {
        // TODO: Add authorization and prevent deleting admin user
        $user->delete();
    }
}
