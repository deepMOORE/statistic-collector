<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DbModels\User;
use App\Http\Response;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController
{
    public function login(Request $request): JsonResponse
    {
        $email = $request->get('email');
        $password = $request->get('password');

        if ($email === null || $password === null) {
            return Response::failure('Invalid email or password');
        }

        $user = User::query()
            ->where('email', $email)
            ->first();

        if ($user === null) {
            return Response::failure('Invalid email or password');
        }

        if (!Hash::check($user->password, $password)) {
            return Response::failure('Invalid email or password');
        }

        return Response::success([
            'id' => $user->id,
            'token' => JWT::encode([
                'id' => $user->id,
            ], 'qwerty', 'HS256'),
        ]);
    }
}
