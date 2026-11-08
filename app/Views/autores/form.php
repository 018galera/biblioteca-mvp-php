<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="header-actions">
    <h1><?= isset($autor) ? 'Editar Autor' : 'Novo Autor' ?></h1>
</div>

<div class="card" style="max-width: 600px;">
    <form method="POST">
        <div class="form-group">
            <label>Nome do Autor</label>
            <input type="text" name="nome" class="form-control" value="<?= isset($autor) ? htmlspecialchars($autor['nome']) : '' ?>" required placeholder="Ex: J.K. Rowling">
        </div>
        <div class="form-group">
            <label>Nacionalidade</label>
            <input type="text" name="nacionalidade" class="form-control" value="<?= isset($autor) ? htmlspecialchars($autor['nacionalidade']) : '' ?>" required placeholder="Ex: Britânica">
        </div>
        <div style="display: flex; gap: 12px; margin-top: 32px;">
            <button type="submit" class="btn btn-primary">Salvar Autor</button>
            <a href="<?= BASE_URL ?>index.php?route=autores/index" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>