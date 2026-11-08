<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    .linha-tabela { transition: transform 0.2s, background 0.2s; }
    .linha-tabela:hover {
        transform: scale(1.01);
        background: rgba(139, 92, 246, 0.05) !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
</style>

<div class="header-actions">
    <h1>Gestão de Categorias</h1>
    <a href="<?= BASE_URL ?>index.php?route=categorias/create" class="btn btn-primary magnetic-btn">+ Nova Categoria</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome da Categoria</th>
                    <th style="text-align: right;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias ?? [] as $cat): ?>
                <tr class="linha-tabela">
                    <td style="color: var(--text-muted);">#<?= $cat['id'] ?></td>
                    <td style="font-weight: 500;"><?= htmlspecialchars($cat['nome']) ?></td>
                    <td style="text-align: right;">
                        <a href="<?= BASE_URL ?>index.php?route=categorias/show&id=<?= $cat['id'] ?>" class="btn btn-outline" style="margin-right: 8px;">Ver Livros</a>
                        <a href="<?= BASE_URL ?>index.php?route=categorias/edit&id=<?= $cat['id'] ?>" class="btn btn-outline" style="margin-right: 8px;">Editar</a>
                        <button class="btn btn-danger" onclick="confirmarExclusao(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['nome']) ?>')">Excluir</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.from(".linha-tabela", { duration: 0.6, opacity: 0, y: 30, stagger: 0.08, ease: "power2.out" });
        
        // SweetAlert para Categorias
        window.confirmarExclusao = function(id, nome) {
            Swal.fire({
                title: 'Atenção!',
                html: `Excluir a categoria <b>"${nome}"</b>?<br><small>Isso pode afetar os livros vinculados.</small>`,
                icon: 'warning', background: '#18181b', color: '#fff',
                showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#27272a',
                confirmButtonText: 'Sim, excluir!', cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) window.location.href = `<?= BASE_URL ?>index.php?route=categorias/delete&id=${id}`;
            });
        }
    });
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>