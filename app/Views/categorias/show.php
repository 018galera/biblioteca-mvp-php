<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="header-actions">
    <!-- O SEGREDO ESTÁ AQUI: Adicionado o ?? [] no nome da categoria e no foreach -->
    <h1>Acervo: <span style="color: var(--primary);"><?= htmlspecialchars($categoria['nome'] ?? 'Categoria não encontrada') ?></span></h1>
    <a href="<?= BASE_URL ?>index.php?route=categorias/index" class="btn btn-outline">Voltar</a>
</div>

<div class="card">
    <?php if (empty($livros)): ?>
        <p style="color: var(--text-muted); text-align: center; padding: 40px 0;">Nenhum livro cadastrado nesta categoria.</p>
    <?php else: ?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título do Livro</th>
                    <th>Autor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livros ?? [] as $livro): ?>
                <tr>
                    <td style="color: var(--text-muted);">#<?= $livro['id'] ?></td>
                    <td style="font-weight: 500;"><?= htmlspecialchars($livro['titulo']) ?></td>
                    <td style="color: var(--text-muted);"><?= htmlspecialchars($livro['autor_nome']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>