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
    <h1>Gestão de Autores</h1>
    <a href="<?= BASE_URL ?>index.php?route=autores/create" class="btn btn-primary magnetic-btn">+ Novo Autor</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Autor</th>
                    <th>Nacionalidade</th>
                    <th style="text-align: right;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($autores ?? [] as $autor): ?>
                <tr class="linha-tabela">
                    <td style="color: var(--text-muted);">#<?= $autor['id'] ?></td>
                    <td style="font-weight: 500;"><?= htmlspecialchars($autor['nome']) ?></td>
                    <td style="color: var(--text-muted);"><?= htmlspecialchars($autor['nacionalidade']) ?></td>
                    <td style="text-align: right;">
                        <a href="<?= BASE_URL ?>index.php?route=autores/edit&id=<?= $autor['id'] ?>" class="btn btn-outline" style="margin-right: 8px;">Editar</a>
                        <button class="btn btn-danger" onclick="confirmarExclusao(<?= $autor['id'] ?>, '<?= htmlspecialchars($autor['nome']) ?>')">Excluir</button>
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
        
        // SweetAlert para Autores
        window.confirmarExclusao = function(id, nome) {
            Swal.fire({
                title: 'Tem certeza?',
                html: `Excluir o autor <b>"${nome}"</b>?`,
                icon: 'warning', background: '#18181b', color: '#fff',
                showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#27272a',
                confirmButtonText: 'Sim, excluir!', cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) window.location.href = `<?= BASE_URL ?>index.php?route=autores/delete&id=${id}`;
            });
        }
    });
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>