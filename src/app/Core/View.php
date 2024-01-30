<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\ViewNotFoundException;

class View
{

    public function __construct(
        public string $view,
        public array $params = [],
        private $layout = ''
    ) {
    }

    public static function make(string $view, array $params = []): static
    {
        return new static($view, $params);
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';

        if ( ! file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }

        extract($this->params);

        ob_start();

        include $viewPath;

        $viewContent = ob_get_clean();

        if ($this->layout !== '') {
            $layoutPath = VIEW_PATH . '/layouts/' . $this->layout . '.php';

            if ( ! file_exists($layoutPath)) {
                throw new ViewNotFoundException();
            }

            ob_start();

            include $layoutPath;

            return str_replace('{{content}}', $viewContent, ob_get_clean());
        } else {
            return $viewContent;
        }
    }

    public function layout(string $layout = ''): static
    {
        $this->layout = $layout;

        return $this;
    }

}