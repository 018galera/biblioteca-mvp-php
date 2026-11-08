<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiblioSys - MVP</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- GSAP e Plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/TextPlugin.min.js"></script>
    
    <!-- SweetAlert2 para Modais Bonitos -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="<?= BASE_URL ?>public/style.css">
</head>
<body>
    <aside class="sidebar">
        <div class="brand">Biblio<span>Sys</span></div>
        <nav class="nav-links">
            <a href="<?= BASE_URL ?>index.php?route=dashboard/index" class="<?= strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active' : '' ?>">📊 Dashboard</a>
            <a href="<?= BASE_URL ?>index.php?route=livros/index" class="<?= strpos($_SERVER['REQUEST_URI'], 'livros') !== false ? 'active' : '' ?>">📚 Livros</a>
            <a href="<?= BASE_URL ?>index.php?route=autores/index" class="<?= strpos($_SERVER['REQUEST_URI'], 'autores') !== false ? 'active' : '' ?>">✍️ Autores</a>
            <a href="<?= BASE_URL ?>index.php?route=categorias/index" class="<?= strpos($_SERVER['REQUEST_URI'], 'categorias') !== false ? 'active' : '' ?>">📑 Categorias</a>
            <a href="<?= BASE_URL ?>index.php?route=api/livros" target="_blank">⚙️ API JSON</a>
            <a href="<?= BASE_URL ?>index.php?route=auth/logout" class="logout" style="margin-top: auto;">🚪 Sair</a>
        </nav>
    </aside>
    
    <main class="main-content">
        <?php if (isset($_SESSION['sucesso'])): ?>
            <div class="alert alert-success"><?= $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['erro'])): ?>
            <div class="alert alert-error"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
        <?php endif; ?>