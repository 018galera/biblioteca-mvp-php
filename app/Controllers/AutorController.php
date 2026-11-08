<?php
namespace App\Controllers;
use App\Models\Autor;

class AutorController {
    /** @var Autor */
    private $model;

    public function __construct() {
        $this->model = new Autor();
    }

    public function index(): void {
        $autores = $this->model->all();
        require __DIR__ . '/../Views/autores/index.php';
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $nacionalidade = trim($_POST['nacionalidade'] ?? '');

            if (empty($nome) || empty($nacionalidade)) {
                $_SESSION['erro'] = 'O nome e a nacionalidade são obrigatórios.';
            } else {
                $this->model->create($nome, $nacionalidade);
                $_SESSION['sucesso'] = 'Autor cadastrado com sucesso!';
                header('Location: ' . BASE_URL . 'index.php?route=autores/index');
                exit;
            }
        }
        require __DIR__ . '/../Views/autores/form.php';
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $autor = $this->model->find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $nacionalidade = trim($_POST['nacionalidade'] ?? '');

            if (empty($nome) || empty($nacionalidade)) {
                $_SESSION['erro'] = 'O nome e a nacionalidade são obrigatórios.';
            } else {
                $this->model->update($id, $nome, $nacionalidade);
                $_SESSION['sucesso'] = 'Autor atualizado com sucesso!';
                header('Location: ' . BASE_URL . 'index.php?route=autores/index');
                exit;
            }
        }
        require __DIR__ . '/../Views/autores/form.php';
    }

    public function delete(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            try {
                $this->model->delete($id);
                $_SESSION['sucesso'] = 'Autor excluído com sucesso.';
            } catch (\Exception $e) {
                $_SESSION['erro'] = 'Não é possível excluir: existem livros vinculados a este autor.';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?route=autores/index');
    }
}