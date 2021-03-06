<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
class AuthService {

    public function createToken($user, array $attributes) : array
    {

        try {
            $tokenResult = $user->createToken('Personal Access Token');

            $token = $tokenResult->token;
            if (isset($attributes['remember_me']))
                $token->expires_at = Carbon::now()->addWeeks(1);

            $token->save();

            return [
                'message' => 'Authorized',
                'details' => [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
                ],
                'http_code' => 202
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage(),[
                'LEVEL' => 'Services',
                'TRACE' => $e->getTrace()//ponerlo asi a todos
            ]);

            throw $e;
        }


    }

}
