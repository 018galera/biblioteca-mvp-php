<?php
namespace App\Controllers;
use App\Models\Livro;

class ApiController {
    /** @var Livro */
    private $model;

    public function __construct() {
        $this->model = new Livro();
    }

    public function livros(): void {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this->model->all());
        exit;
    }
}