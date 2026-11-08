<?php
namespace App\Models;

use PDO;

class Categoria {
    /** @var PDO */
    private $db;

    public function __construct() {
        $this->db = \App\Config\Database::getConnection();
    }

    public function all(): array {
        $stmt = $this->db->query("SELECT * FROM categorias ORDER BY nome ASC");
        return $stmt->fetchAll();
    }

    public function find(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(string $nome): bool {
        $stmt = $this->db->prepare("INSERT INTO categorias (nome) VALUES (?)");
        return $stmt->execute([$nome]);
    }

    public function update(int $id, string $nome): bool {
        $stmt = $this->db->prepare("UPDATE categorias SET nome = ? WHERE id = ?");
        return $stmt->execute([$nome, $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM categorias WHERE id = ?");
        return $stmt->execute([$id]);
    }
}