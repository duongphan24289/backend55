<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail as MailHelper;

class UserMail
{
    public function register($user)
    {
        MailHelper::send(
            'mail.user.register',
            [
                'user'	=> $user,
            ],
            function ($message) use ($user) {
                $message->from('no-reply@laravel55.dev', 'Laravel 55');
                $message->to($user->email, $user->name)->subject('Welcome');
            }

        );
    }
}
