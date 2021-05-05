<?php

namespace App\Controller;

use App\Core\App;
use App\Core\Controller;
use App\Model\MovieModel;

class ApiController extends Controller
{
    /**
     * @return string
     * @throws \App\Core\Exception\ModelException
     */
    public function index(): string
    {
        $movieModel = App::getModel(MovieModel::class);
        $movies = $movieModel->findAllPaginated(1, 8,
            ["release_date" => "DESC", "title" => "ASC"]);
        return $this->response->jsonResponse($movies);
    }
}