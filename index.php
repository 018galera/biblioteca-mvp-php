<?php
// index.php
declare(strict_types=1);
session_start();

// --- CONFIGURAÇÃO DE AMBIENTE ---
$scriptName = $_SERVER['SCRIPT_NAME'];
$baseDir = str_replace('\\', '/', dirname($scriptName));
define('BASE_URL', ($baseDir === '/' ? '' : $baseDir) . '/');
// --------------------------------

// Autoloader PSR-4 para os Models e Controllers
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

// =====================================================================
// FORÇANDO O CARREGAMENTO DO BANCO DE DADOS (A PROVA DE FALHAS)
// =====================================================================
$caminhoDb = __DIR__ . '/app/Config/config.php';
if (file_exists($caminhoDb)) {
    require_once $caminhoDb;
} else {
    // Se a pasta estiver com "c" minúsculo, ele tenta carregar assim:
    $caminhoDbMinusculo = __DIR__ . '/app/config/config.php';
    if (file_exists($caminhoDbMinusculo)) {
        require_once $caminhoDbMinusculo;
    } else {
        die("<h1>ERRO FATAL</h1><p>O arquivo de conexão não foi encontrado! Verifique se ele está em app/Config/config.php</p>");
    }
}
// =====================================================================

// Roteamento
$route = $_GET['route'] ?? 'auth/login';
$routeParts = explode('/', $route);
$rotaBase = ucfirst($routeParts[0]);

// Converte plurais
if ($rotaBase === 'Livros') $rotaBase = 'Livro';
if ($rotaBase === 'Categorias') $rotaBase = 'Categoria';
if ($rotaBase === 'Autores') $rotaBase = 'Autor';
if ($rotaBase === 'Dashboard') $rotaBase = 'Dashboard';

$controllerName = 'App\\Controllers\\' . $rotaBase . 'Controller';
$methodName = $routeParts[1] ?? 'index';

// Auth Check (Protege as rotas)
if (!isset($_SESSION['user']) && $routeParts[0] !== 'auth' && $routeParts[0] !== 'api') {
    header('Location: ' . BASE_URL . 'index.php?route=auth/login');
    exit;
}

// Executa o Controller
if (class_exists($controllerName) && method_exists($controllerName, $methodName)) {
    $controller = new $controllerName();
    $controller->$methodName();
} else {
    http_response_code(404);
    echo "<h1>404 - Página não encontrada</h1>";
    echo "<p>O sistema tentou carregar a classe: <b>" . htmlspecialchars($controllerName) . "</b></p>";
}