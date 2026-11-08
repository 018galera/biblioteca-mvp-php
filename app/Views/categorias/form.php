<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="header-actions">
    <h1><?= isset($categoria) ? 'Editar Categoria' : 'Nova Categoria' ?></h1>
</div>

<div class="card" style="max-width: 600px;">
    <form method="POST">
        <div class="form-group">
            <label>Nome da Categoria</label>
            <input type="text" name="nome" class="form-control" value="<?= isset($categoria) ? htmlspecialchars($categoria['nome']) : '' ?>" required placeholder="Ex: Ficção Científica">
        </div>
        <div style="display: flex; gap: 12px; margin-top: 32px;">
            <button type="submit" class="btn btn-primary">Salvar Categoria</button>
            <a href="<?= BASE_URL ?>index.php?route=categorias/index" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>