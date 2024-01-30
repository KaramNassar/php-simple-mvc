<?php

declare(strict_types=1);

function dd($input)
{
    echo '<pre>';
    var_dump($input);
    echo '</pre>';

    exit;
}