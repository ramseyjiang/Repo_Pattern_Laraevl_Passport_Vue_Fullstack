<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Rspafs\Models\User;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function deleteUser($email = 'test@qq.com')
    {
        User::where('email',$email)->delete();
    }

    /**
     * Login the given user or create the first if none supplied.
     *
     * @param $user
     *
     * @return User
     */
    public function loginAsUser($user = null)
    {
        $user = User::first();
        $this->actingAs($user, 'api');
        return $user;
    }

    /**
     * Return request headers needed to interact with the API.
     *
     * @return Array array of headers.
     */
    protected function headers($user = null)
    {
        if (is_null($user)) {
            $user = User::first();
        }

        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $user->createToken('Personal Access Token')->accessToken,
        ];
    }
}
