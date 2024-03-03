<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Attributes\Get;
use App\Core\Attributes\Post;
use App\Core\View;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class UserController
{

    public function __construct(protected MailerInterface $mailer)
    {
    }

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

        $html =  View::make('emails/welcome', [
            'name' => $name
        ])->render();

        $text = strip_tags($html);

        $emailObject = (new Email())
            ->from('support@example.com')
            ->to($email)
            ->subject('Welcome!')
            ->html($html)
            ->text($text);

        $this->mailer->send($emailObject);
    }

}