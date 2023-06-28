<?php declare(strict_types=1);

namespace App\Http\Controllers;

abstract class AuthenticatedUserController
{
    public function getCurrentUserId(): int
    {
        return 1;
    }
}
