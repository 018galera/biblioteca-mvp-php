<?php
namespace App\Models;

use PDO;

class Autor {
    /** @var PDO */
    private $db;

    public function __construct() {
        $this->db = \App\Config\Database::getConnection();
    }

    public function all(): array {
        $stmt = $this->db->query("SELECT * FROM autores ORDER BY nome ASC");
        return $stmt->fetchAll();
    }

    public function find(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM autores WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(string $nome, string $nacionalidade): bool {
        $stmt = $this->db->prepare("INSERT INTO autores (nome, nacionalidade) VALUES (?, ?)");
        return $stmt->execute([$nome, $nacionalidade]);
    }

    public function update(int $id, string $nome, string $nacionalidade): bool {
        $stmt = $this->db->prepare("UPDATE autores SET nome = ?, nacionalidade = ? WHERE id = ?");
        return $stmt->execute([$nome, $nacionalidade, $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM autores WHERE id = ?");
        return $stmt->execute([$id]);
    }
}