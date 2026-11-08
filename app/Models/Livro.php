<?php
namespace App\Models;

use PDO;

class Livro {
    /** @var PDO */
    private $db;

    public function __construct() {
        // Chamada direta com barra invertida (à prova de erros de namespace)
        $this->db = \App\Config\Database::getConnection();
    }

    public function all(string $busca = ''): array {
        $sql = "SELECT l.*, c.nome as categoria_nome, a.nome as autor_nome 
                FROM livros l
                JOIN categorias c ON l.categoria_id = c.id
                JOIN autores a ON l.autor_id = a.id";
        
        if ($busca) {
            $sql .= " WHERE l.titulo LIKE ? OR a.nome LIKE ?";
            $stmt = $this->db->prepare($sql . " ORDER BY l.id DESC");
            $stmt->execute(["%$busca%", "%$busca%"]);
        } else {
            $stmt = $this->db->query($sql . " ORDER BY l.id DESC");
        }
        return $stmt->fetchAll();
    }

    public function find(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM livros WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(string $titulo, int $ano, int $categoria_id, int $autor_id): bool {
        $stmt = $this->db->prepare("INSERT INTO livros (titulo, ano_publicacao, categoria_id, autor_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$titulo, $ano, $categoria_id, $autor_id]);
    }

    public function update(int $id, string $titulo, int $ano, int $categoria_id, int $autor_id): bool {
        $stmt = $this->db->prepare("UPDATE livros SET titulo = ?, ano_publicacao = ?, categoria_id = ?, autor_id = ? WHERE id = ?");
        return $stmt->execute([$titulo, $ano, $categoria_id, $autor_id, $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM livros WHERE id = ?");
        return $stmt->execute([$id]);
    }
}