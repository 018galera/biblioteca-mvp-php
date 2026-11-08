<?php
namespace App\Controllers;
use App\Config\Database; 

class DashboardController {
    public function index() {
        $db = Database::getConnection();
        
        // 1. Contadores Gerais (Cards Superiores)
        $totalLivros = $db->query("SELECT COUNT(*) FROM livros")->fetchColumn();
        $totalAutores = $db->query("SELECT COUNT(*) FROM autores")->fetchColumn();
        $totalCategorias = $db->query("SELECT COUNT(*) FROM categorias")->fetchColumn();
        
        // 2. Dados para o Gráfico (Contagem de Livros por Categoria)
        $queryGrafico = "
            SELECT c.nome as categoria, COUNT(l.id) as total 
            FROM categorias c
            LEFT JOIN livros l ON c.id = l.categoria_id
            GROUP BY c.id, c.nome
            ORDER BY total DESC
        ";
        $dadosGrafico = $db->query($queryGrafico)->fetchAll();

        // 3. Últimos livros cadastrados (Lista Inferior)
        $ultimosLivros = $db->query("
            SELECT l.titulo, a.nome as autor, c.nome as categoria 
            FROM livros l
            JOIN autores a ON l.autor_id = a.id
            JOIN categorias c ON l.categoria_id = c.id
            ORDER BY l.id DESC LIMIT 5
        ")->fetchAll();

        // Transforma os dados do gráfico em JSON para o JavaScript ler
        $labelsGrafico = json_encode(array_column($dadosGrafico, 'categoria'));
        $valoresGrafico = json_encode(array_column($dadosGrafico, 'total'));

        require __DIR__ . '/../Views/dashboard/index.php';
    }
}