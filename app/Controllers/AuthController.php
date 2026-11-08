<?php
namespace App\Controllers;
class AuthController {
    public function index() { $this->login(); }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['email'] === 'admin@email.com' && $_POST['senha'] === '123456') {
                $_SESSION['user'] = 'Admin';
                header('Location: ' . BASE_URL . 'index.php?route=dashboard/index');
                exit;
            } else { $_SESSION['erro'] = 'Credenciais inválidas.'; }
        }
        require __DIR__ . '/../Views/auth/login.php';
    }
    public function logout() { session_destroy(); header('Location: ' . BASE_URL . 'index.php?route=auth/login'); }
}