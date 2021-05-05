<?php

namespace App\Core;

abstract class Controller
{
    private Response $response;

    public function __construct() {
        $this->response = App::get(Response::class);
    }

    public function renderView(string $view, string $layout = 'default', array $data = []): string {
        return $this->response->renderView($view, $layout, $data);
    }
}