<?php
namespace App\Controllers;

use App\Models\Livro;
use App\Models\Categoria;
use App\Models\Autor;

class LivroController {
    /** @var Livro */
    private $model;
    /** @var Categoria */
    private $categoriaModel;
    /** @var Autor */
    private $autorModel;

    public function __construct() {
        $this->model = new Livro();
        $this->categoriaModel = new Categoria();
        $this->autorModel = new Autor();
    }

    public function index(): void {
        // Pega a busca de texto e o filtro de categoria (se existir)
        $busca = $_GET['busca'] ?? '';
        $categoria_id = $_GET['categoria'] ?? null; 
        
        // Busca todas as categorias para renderizar as pílulas na tela
        $categorias = $this->categoriaModel->all();
        
        // Busca os livros no banco (com o filtro de texto, se houver)
        $todosLivros = $this->model->all($busca);
        
        // Aplica o filtro de categoria via PHP, se uma pílula foi clicada
        $livros = $todosLivros;
        if ($categoria_id) {
            $livros = array_filter($todosLivros, fn($l) => $l['categoria_id'] == $categoria_id);
        }

        // Envia as variáveis para a View
        require __DIR__ . '/../Views/livros/index.php';
    }

    public function create(): void {
        $categorias = $this->categoriaModel->all();
        $autores = $this->autorModel->all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $ano = filter_var($_POST['ano'] ?? '', FILTER_VALIDATE_INT);
            $categoria_id = (int)($_POST['categoria_id'] ?? 0);
            $autor_id = (int)($_POST['autor_id'] ?? 0);

            if (empty($titulo) || !$ano || !$categoria_id || !$autor_id) {
                $_SESSION['erro'] = 'Preencha todos os campos. O ano deve ser um número.';
            } else {
                $this->model->create($titulo, $ano, $categoria_id, $autor_id);
                $_SESSION['sucesso'] = 'Livro cadastrado!';
                header('Location: ' . BASE_URL . 'index.php?route=livros/index');
                exit;
            }
        }
        require __DIR__ . '/../Views/livros/form.php';
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $livro = $this->model->find($id);
        $categorias = $this->categoriaModel->all();
        $autores = $this->autorModel->all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $ano = filter_var($_POST['ano'] ?? '', FILTER_VALIDATE_INT);
            $categoria_id = (int)($_POST['categoria_id'] ?? 0);
            $autor_id = (int)($_POST['autor_id'] ?? 0);

            if (empty($titulo) || !$ano || !$categoria_id || !$autor_id) {
                $_SESSION['erro'] = 'Preencha todos os campos corretamente.';
            } else {
                $this->model->update($id, $titulo, $ano, $categoria_id, $autor_id);
                $_SESSION['sucesso'] = 'Livro atualizado!';
                header('Location: ' . BASE_URL . 'index.php?route=livros/index');
                exit;
            }
        }
        require __DIR__ . '/../Views/livros/form.php';
    }

    public function delete(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            $this->model->delete($id);
            $_SESSION['sucesso'] = 'Livro excluído.';
        }
        header('Location: ' . BASE_URL . 'index.php?route=livros/index');
    }
}