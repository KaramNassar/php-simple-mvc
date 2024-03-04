<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Attributes\Get;
use App\Attributes\Post;
use App\Core\View;
use App\Models\Email;
use Symfony\Component\Mime\Address;

class UserController
{

    #[Get('/users/create')]
    public function create(): View
    {
        return View::make('users/register')->layout('app');
    }

    #[Post('/users')]
    public function register(): void
    {
        $name  = $_POST['name'];
        $email = $_POST['email'];

        $html = View::make('emails/welcome', [
            'name' => $name,
        ])->render();

        $text = strip_tags($html);

        (new Email())->queue(
            new Address($email),
            new Address('Support@example.com', 'Support'),
            'Welcome',
            $html,
            $text
        );
    }

}