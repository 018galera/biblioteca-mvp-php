<?php require __DIR__ . '/../layouts/header.php'; ?>

<!-- Importando a biblioteca de Gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 40px; }
    
    .stat-card { 
        background: var(--bg-surface); border: 1px solid var(--border); border-radius: 16px; padding: 24px; 
        position: relative; opacity: 0; filter: blur(10px); overflow: hidden;
    }
    .stat-card h3 { font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase; }
    .stat-number { font-size: 2.5rem; font-weight: 800; color: #fff; margin-top: 8px; }
    
    .stat-card::after {
        content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, transparent 60%);
        opacity: 0; transition: opacity 0.3s;
    }
    .stat-card:hover::after { opacity: 1; }

    .charts-container { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 40px; }
    .chart-card { background: var(--bg-surface); border: 1px solid var(--border); border-radius: 16px; padding: 24px; opacity: 0; }
    .chart-card h3 { margin-bottom: 20px; font-weight: 600; color: #fff; font-size: 1.1rem; }
    .chart-wrapper { position: relative; height: 300px; width: 100%; display: flex; justify-content: center; }

    .recent-list { background: var(--bg-surface); border-radius: 16px; border: 1px solid var(--border); overflow: hidden; opacity: 0; }
    .recent-item { padding: 16px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; transition: background 0.2s; }
    .recent-item:hover { background: #1f1f22; }
</style>

<div class="header-actions" id="pageTitle">
    <h1>Visão Geral do Acervo</h1>
    <p style="color: var(--text-muted); font-size: 0.9rem;">Dados extraídos em tempo real do banco MySQL.</p>
</div>

<div class="dashboard-grid">
    <div class="stat-card">
        <h3>Total de Livros</h3>
        <div class="stat-number" id="numLivros">0</div>
    </div>
    <div class="stat-card">
        <h3>Autores</h3>
        <div class="stat-number" id="numAutores">0</div>
    </div>
    <div class="stat-card">
        <h3>Categorias</h3>
        <div class="stat-number" id="numCategorias">0</div>
    </div>
</div>

<div class="charts-container">
    <div class="chart-card" id="cardGrafico1">
        <h3>Distribuição do Acervo</h3>
        <div class="chart-wrapper">
            <canvas id="graficoCategorias"></canvas>
        </div>
    </div>
    
    <div class="chart-card" id="cardGrafico2">
        <h3>Radar de Sistema (Métricas)</h3>
        <div class="chart-wrapper">
            <canvas id="graficoRadar"></canvas>
        </div>
    </div>
</div>

<div class="recent-list" id="recentList">
    <div style="padding: 20px; border-bottom: 1px solid var(--border); background: #1f1f22;">
        <h3 style="font-weight: 600; color: #fff;">Últimas Adições</h3>
    </div>
    <?php foreach ($ultimosLivros ?? [] as $livro): ?>
        <div class="recent-item">
            <div>
                <div style="font-weight: 600;"><?= htmlspecialchars($livro['titulo']) ?></div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">por <?= htmlspecialchars($livro['autor']) ?></div>
            </div>
            <span class="badge"><?= htmlspecialchars($livro['categoria']) ?></span>
        </div>
    <?php endforeach; ?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.borderColor = '#27272a';

        const ctxDoughnut = document.getElementById('graficoCategorias').getContext('2d');
        
        // Correção dos avisos do Intelephense:
        const labels = <?= $labelsGrafico ?? '[]' ?>;
        const dataValues = <?= $valoresGrafico ?? '[]' ?>;

        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: dataValues,
                    backgroundColor: ['#8b5cf6', '#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } }
                },
                animation: { animateScale: true, animateRotate: true, duration: 2000, easing: 'easeOutQuart' }
            }
        });

        const ctxRadar = document.getElementById('graficoRadar').getContext('2d');
        new Chart(ctxRadar, {
            type: 'radar',
            data: {
                labels: ['Cadastros', 'Buscas', 'Acessos', 'Segurança', 'Performance'],
                datasets: [{
                    label: 'Métricas do Sistema',
                    data: [85, 92, 78, 100, 95],
                    backgroundColor: 'rgba(139, 92, 246, 0.2)',
                    borderColor: '#8b5cf6',
                    pointBackgroundColor: '#fff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: { color: '#27272a' },
                        grid: { color: '#27272a' },
                        pointLabels: { color: '#fff', font: { size: 12, weight: '500' } },
                        ticks: { display: false, min: 0, max: 100 }
                    }
                }
            }
        });

        const tl = gsap.timeline();

        tl.from("#pageTitle", { duration: 1, y: -20, opacity: 0, filter: "blur(10px)" })
          .to(".stat-card", { duration: 1, opacity: 1, filter: "blur(0px)", y: 0, stagger: 0.15, from: { y: 40, filter: "blur(15px)" }, ease: "back.out(1.5)" }, "-=0.5")
          .to("#cardGrafico1", { duration: 1, opacity: 1, x: 0, from: { x: -50 }, ease: "power3.out" }, "-=0.5")
          .to("#cardGrafico2", { duration: 1, opacity: 1, x: 0, from: { x: 50 }, ease: "power3.out" }, "-=0.8")
          .to("#recentList", { duration: 1, opacity: 1, y: 0, from: { y: 30 }, ease: "power3.out" }, "-=0.5");

        let contadores = [
            { id: "#numLivros", target: <?= $totalLivros ?? 0 ?> },
            { id: "#numAutores", target: <?= $totalAutores ?? 0 ?> },
            { id: "#numCategorias", target: <?= $totalCategorias ?? 0 ?> }
        ];

        contadores.forEach(cont => {
            let obj = { val: 0 };
            gsap.to(obj, {
                val: cont.target,
                duration: 2.5,
                delay: 0.5,
                ease: "power3.out",
                onUpdate: () => { document.querySelector(cont.id).innerText = Math.ceil(obj.val); }
            });
        });
    });
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>