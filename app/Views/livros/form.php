<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    /* Barra de progresso do formulário */
    .progress-container {
        height: 4px;
        background: #27272a;
        border-radius: 2px;
        margin-bottom: 30px;
        overflow: hidden;
    }
    .progress-bar {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, var(--primary), #a78bfa);
        border-radius: 2px;
        transition: width 0.3s ease;
        box-shadow: 0 0 10px var(--primary);
    }
</style>

<div class="header-actions">
    <h1><?= isset($livro) ? 'Editar Livro' : 'Cadastrar Novo Livro' ?></h1>
</div>

<div class="card" style="max-width: 700px;">
    
    <!-- BARRA DE PROGRESSO -->
    <div class="progress-container">
        <div class="progress-bar" id="barraProgresso"></div>
    </div>

    <form method="POST" id="formLivro">
        <div class="form-group">
            <label>Título do Livro</label>
            <input type="text" name="titulo" class="form-control input-progresso" value="<?= isset($livro) ? htmlspecialchars($livro['titulo']) : '' ?>" required placeholder="Ex: O Senhor dos Anéis">
        </div>
        <div class="form-group">
            <label>Ano de Publicação</label>
            <input type="number" name="ano" class="form-control input-progresso" value="<?= isset($livro) ? $livro['ano_publicacao'] : '' ?>" required placeholder="Ex: 1954">
        </div>
        <div class="form-group">
            <label>Categoria</label>
            <select name="categoria_id" class="form-control input-progresso" required>
                <option value="">Selecione uma categoria...</option>
                <?php foreach ($categorias ?? [] as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (isset($livro) && $livro['categoria_id'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Autor</label>
            <select name="autor_id" class="form-control input-progresso" required>
                <option value="">Selecione um autor...</option>
                <?php foreach ($autores ?? [] as $aut): ?>
                    <option value="<?= $aut['id'] ?>" <?= (isset($livro) && $livro['autor_id'] == $aut['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($aut['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="display: flex; gap: 12px; margin-top: 32px;">
            <button type="submit" class="btn btn-primary" id="btnSalvar">Salvar Livro</button>
            <a href="<?= BASE_URL ?>index.php?route=livros/index" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Animação de entrada dos campos
        gsap.from(".form-group", {
            y: 20, opacity: 0, duration: 0.5, stagger: 0.1, ease: "power2.out"
        });

        const inputs = document.querySelectorAll('.input-progresso');
        const barra = document.getElementById('barraProgresso');

        function atualizarProgresso() {
            let preenchidos = 0;
            inputs.forEach(input => {
                if (input.value.trim() !== '') preenchidos++;
            });
            let porcentagem = (preenchidos / inputs.length) * 100;
            barra.style.width = porcentagem + '%';
            
            if(porcentagem === 100) {
                gsap.to("#btnSalvar", { scale: 1.05, duration: 0.3, yoyo: true, repeat: 1, boxShadow: "0 0 20px rgba(139, 92, 246, 0.8)" });
            }
        }

        inputs.forEach(input => {
            input.addEventListener('input', atualizarProgresso);
            input.addEventListener('change', atualizarProgresso);
        });
        atualizarProgresso();
    });
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>