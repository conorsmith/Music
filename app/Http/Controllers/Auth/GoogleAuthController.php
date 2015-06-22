<?php

namespace ConorSmith\Music\Http\Controllers\Auth;

use ConorSmith\Music\Http\Controllers\Controller;

class GoogleAuthController extends Controller
{
    private $client;

    public function __construct(\Google_Client $client)
    {
        $this->client = $client;

        $this->middleware('auth', ['except' => 'callback']);
    }

    public function trigger()
    {
        return redirect($this->client->createAuthUrl());
    }

    public function callback()
    {
        if (\Request::has('code')) {
            $accessToken = $this->client->authenticate(\Request::get('code'));
            \Cache::put('google.access_token', $accessToken, 3600);
        }

        return redirect(env('GOOGLE_CALLBACK_ACTUAL_ROOT', "") . "/dashboard");
    }
}
