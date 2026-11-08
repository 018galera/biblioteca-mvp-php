<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    /* Estilos para os Filtros em Pílula (Pill) */
    .filter-pills {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }
    .pill {
        padding: 8px 16px;
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .pill:hover, .pill.active {
        background: rgba(139, 92, 246, 0.15);
        border-color: var(--primary);
        color: var(--primary);
        box-shadow: 0 0 10px rgba(139, 92, 246, 0.2);
    }

    /* Efeito Hover 3D na Tabela */
    .linha-tabela {
        transition: transform 0.2s, background 0.2s;
    }
    .linha-tabela:hover {
        transform: scale(1.01) translateY(-2px);
        background: rgba(139, 92, 246, 0.05) !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        z-index: 10;
        position: relative;
    }

    /* Barra de Busca Vidro */
    .search-box {
        background: rgba(24, 24, 27, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);
        transition: all 0.3s;
    }
    .search-box:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 20px rgba(139, 92, 246, 0.2);
    }
    .search-box input {
        background: transparent;
        border: none;
        color: white;
        font-size: 1rem;
        flex: 1;
        outline: none;
    }
</style>

<div class="header-actions">
    <div>
        <h1>Catálogo de Livros</h1>
        <!-- CONTADOR ANIMADO -->
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 5px;">
            <span id="contador-livros" style="color: var(--primary); font-weight: 600;">0</span> livros encontrados no banco de dados.
        </p>
    </div>
    <!-- BOTÃO MAGNÉTICO -->
    <a href="<?= BASE_URL ?>index.php?route=livros/create" class="btn btn-primary magnetic-btn" style="box-shadow: 0 0 15px rgba(139, 92, 246, 0.4);">+ Novo Livro</a>
</div>

<div class="card">
    <!-- FILTROS EM PÍLULA -->
    <div class="filter-pills">
        <a href="<?= BASE_URL ?>index.php?route=livros/index" class="pill <?= !isset($_GET['categoria']) ? 'active' : '' ?>">Todos</a>
        <?php foreach ($categorias ?? [] as $cat): ?>
            <a href="<?= BASE_URL ?>index.php?route=livros/index&categoria=<?= $cat['id'] ?>" 
               class="pill <?= (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id']) ? 'active' : '' ?>">
                <?= htmlspecialchars($cat['nome']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- BUSCA -->
    <form method="GET" class="search-box">
        <input type="hidden" name="route" value="livros/index">
        <input type="text" name="busca" placeholder="🔍 Pesquisar por título ou autor..." value="<?= htmlspecialchars($busca ?? '') ?>" autocomplete="off">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <?php if(!empty($busca)): ?>
            <a href="<?= BASE_URL ?>index.php?route=livros/index" class="btn btn-outline">Limpar</a>
        <?php endif; ?>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título do Livro</th>
                    <th>Autor</th>
                    <th>Categoria</th>
                    <th style="text-align: right;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $cores = ['#8b5cf6', '#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#ec4899']; ?>
                <!-- CORREÇÃO DO ERRO AQUI: Adicionado ?? [] -->
                <?php foreach ($livros ?? [] as $livro): ?>
                <tr class="linha-tabela">
                    <td style="color: var(--text-muted); font-family: monospace;">#<?= $livro['id'] ?></td>
                    <td style="font-weight: 600; font-size: 1.05rem;">
                        <?= htmlspecialchars($livro['titulo']) ?> 
                        <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 400;">(<?= $livro['ano_publicacao'] ?>)</span>
                    </td>
                    <td style="color: #cbd5e1;"><?= htmlspecialchars($livro['autor_nome']) ?></td>
                    <td>
                        <?php $corBadge = $cores[$livro['categoria_id'] % count($cores)]; ?>
                        <span class="badge" style="background: <?= $corBadge ?>15; color: <?= $corBadge ?>; border: 1px solid <?= $corBadge ?>40; text-shadow: 0 0 10px <?= $corBadge ?>40;">
                            <?= htmlspecialchars($livro['categoria_nome']) ?>
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <a href="<?= BASE_URL ?>index.php?route=livros/edit&id=<?= $livro['id'] ?>" class="btn btn-outline" style="margin-right: 8px;">Editar</a>
                        <!-- CHAMADA DO SWEETALERT -->
                        <button class="btn btn-danger" onclick="confirmarExclusao(<?= $livro['id'] ?>, '<?= htmlspecialchars($livro['titulo']) ?>')">Excluir</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <!-- CORREÇÃO DO ERRO AQUI: Adicionado ?? [] -->
                <?php if (empty($livros ?? [])): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 40px;">
                        <div style="font-size: 3rem; margin-bottom: 10px; opacity: 0.5;">📚</div>
                        Nenhum livro encontrado no acervo.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        
        // 1. Contador Animado (Text Scramble)
        gsap.to("#contador-livros", {
            duration: 2,
            text: { value: "<?= count($livros ?? []) ?>", delimiter: "" },
            ease: "power2.out"
        });

        // 2. Animação em Cascata na Tabela
        gsap.from(".linha-tabela", {
            duration: 0.6,
            opacity: 0,
            y: 30,
            stagger: 0.08,
            ease: "power2.out",
            delay: 0.3
        });

        // 3. Efeito Botão Magnético
        const btn = document.querySelector('.magnetic-btn');
        if(btn) {
            btn.addEventListener('mousemove', (e) => {
                const rect = btn.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                gsap.to(btn, { x: x * 0.4, y: y * 0.4, duration: 0.2 });
            });
            btn.addEventListener('mouseleave', () => {
                gsap.to(btn, { x: 0, y: 0, duration: 0.7, ease: "elastic.out(1, 0.3)" });
            });
        }

        // 4. SweetAlert2 para Exclusão
        window.confirmarExclusao = function(id, titulo) {
            Swal.fire({
                title: 'Tem certeza?',
                html: `Você está prestes a excluir o livro <b>"${titulo}"</b>.<br>Essa ação não pode ser desfeita.`,
                icon: 'warning',
                background: '#18181b',
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#27272a',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `<?= BASE_URL ?>index.php?route=livros/delete&id=${id}`;
                }
            });
        }
    });
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>