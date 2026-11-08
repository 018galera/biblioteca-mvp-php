<?php
namespace App\Controllers;
use App\Models\Categoria;
use App\Models\Livro;

class CategoriaController {
    /** @var Categoria */
    private $model;

    public function __construct() {
        $this->model = new Categoria();
    }

    public function index(): void {
        $categorias = $this->model->all();
        require __DIR__ . '/../Views/categorias/index.php';
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            if (empty($nome)) {
                $_SESSION['erro'] = 'O nome é obrigatório.';
            } else {
                $this->model->create($nome);
                $_SESSION['sucesso'] = 'Categoria criada!';
                header('Location: ' . BASE_URL . 'index.php?route=categorias/index');
                exit;
            }
        }
        require __DIR__ . '/../Views/categorias/form.php';
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $categoria = $this->model->find($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            if (empty($nome)) {
                $_SESSION['erro'] = 'O nome é obrigatório.';
            } else {
                $this->model->update($id, $nome);
                $_SESSION['sucesso'] = 'Categoria atualizada!';
                header('Location: ' . BASE_URL . 'index.php?route=categorias/index');
                exit;
            }
        }
        require __DIR__ . '/../Views/categorias/form.php';
    }

    public function delete(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            try {
                $this->model->delete($id);
                $_SESSION['sucesso'] = 'Categoria excluída.';
            } catch (\Exception $e) {
                $_SESSION['erro'] = 'Não é possível excluir: existem livros vinculados.';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?route=categorias/index');
    }

    public function show(): void {
        $id = (int)($_GET['id'] ?? 0);
        $categoria = $this->model->find($id);
        
        $livroModel = new Livro();
        $todosLivros = $livroModel->all(); 
        $livros = array_filter($todosLivros, fn($l) => $l['categoria_id'] == $id);
        
        require __DIR__ . '/../Views/categorias/show.php';
    }
}