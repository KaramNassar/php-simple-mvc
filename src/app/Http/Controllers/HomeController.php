<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Attributes\Route;

class HomeController
{
    #[Route('/')]
    #[Route('/home')]
    public function index(): string
    {
        return 'Hello from home';
    }

}