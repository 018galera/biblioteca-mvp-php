<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiblioSys - Acesso Restrito</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <style>
        :root {
            --bg-base: #09090b;
            --bg-surface: #18181b;
            --primary: #8b5cf6;
            --primary-hover: #7c3aed;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: #27272a;
            --input-bg: #121214;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        
        body {
            background-color: var(--bg-base);
            color: var(--text-main);
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* --- LADO ESQUERDO: Branding e Animação --- */
        .left-panel {
            flex: 1.2;
            background: linear-gradient(135deg, #18181b 0%, #09090b 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
            border-right: 1px solid var(--border);
        }

        /* Bolhas de fundo animadas (Efeito Blur) */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.6;
        }
        .blob-1 { width: 400px; height: 400px; background: rgba(139, 92, 246, 0.4); top: -100px; left: -100px; animation: float 8s infinite alternate; }
        .blob-2 { width: 300px; height: 300px; background: rgba(16, 185, 129, 0.2); bottom: 10%; right: -50px; animation: float 10s infinite alternate-reverse; }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(50px, 50px) scale(1.1); }
        }

        .left-content {
            position: relative;
            z-index: 1;
        }

        .brand-logo {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 20px;
            display: inline-block;
        }
        .brand-logo span { color: var(--primary); }

        .left-content h1 {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 16px;
            background: linear-gradient(to right, #ffffff, #a1a1aa);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .left-content p {
            font-size: 1.1rem;
            color: var(--text-muted);
            max-width: 80%;
            line-height: 1.6;
        }

        /* --- LADO DIREITO: Formulário de Login --- */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-base);
            position: relative;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            padding: 40px;
            background: rgba(24, 24, 27, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 10;
        }

        .login-box h2 {
            font-size: 1.8rem;
            margin-bottom: 8px;
            text-align: center;
            color: #fff;
        }

        .login-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            background-color: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text-main);
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.2);
            background-color: var(--bg-surface);
        }

        /* BOTÃO CORRIGIDO - SEM SVG, COM ANIMAÇÃO NEON */
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(90deg, var(--primary), #6d28d9, var(--primary));
            background-size: 200% auto;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: 0.5s;
            margin-top: 15px;
            text-transform: uppercase;
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.4);
            animation: pulse-glow 2s infinite;
        }

        .btn-login:hover {
            background-position: right center; /* Move o gradiente */
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(139, 92, 246, 0.8);
        }

        /* Animação do botão pulsando */
        @keyframes pulse-glow {
            0% { box-shadow: 0 0 10px rgba(139, 92, 246, 0.4); }
            50% { box-shadow: 0 0 20px rgba(139, 92, 246, 0.7); }
            100% { box-shadow: 0 0 10px rgba(139, 92, 246, 0.4); }
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
        }

        @media (max-width: 900px) {
            .left-panel { display: none; }
        }
    </style>
</head>
<body>

    <div class="left-panel" id="leftPanel">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        
        <div class="left-content">
            <div class="brand-logo" id="logoText">Biblio<span>Sys</span></div>
            <h1>A gestão do seu acervo na palma da mão.</h1>
            <p>Uma plataforma moderna, segura e intuitiva para conectar leitores, livros e conhecimento.</p>
        </div>
    </div>

    <div class="right-panel">
        <div class="login-box" id="loginBox">
            <h2>Bem-vindo de volta</h2>
            <p class="login-subtitle">Acesse o painel de controle para continuar.</p>

            <?php if (isset($_SESSION['erro'])): ?>
                <div class="alert-error" id="alertError">
                    <?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" id="loginForm">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" class="form-control" required value="admin@email.com" placeholder="Digite seu e-mail">
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="senha" class="form-control" required value="123456" placeholder="••••••••">
                </div>
                <!-- Botão Simples e Visível -->
                <button type="submit" class="btn-login" id="btnLogin">
                    Acessar Sistema
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Força a visibilidade do botão por segurança (se o GSAP falhar)
            gsap.set("#btnLogin", { opacity: 1, visibility: "visible" });

            const tl = gsap.timeline();

            // 1. Logo entra com desfoque
            tl.fromTo("#logoText", 
                { opacity: 0, filter: "blur(10px)", scale: 0.9 },
                { opacity: 1, filter: "blur(0px)", scale: 1, duration: 1, ease: "power3.out" }
            )
            // 2. Formulário entra deslizando
            .fromTo("#loginBox", 
                { y: 50, opacity: 0, filter: "blur(10px)" },
                { y: 0, opacity: 1, filter: "blur(0px)", duration: 0.8, ease: "back.out(1.2)" }, 
                "-=0.5"
            )
            // 3. Inputs aparecem em sequência
            .fromTo(".form-group",
                { y: 20, opacity: 0 },
                { y: 0, opacity: 1, duration: 0.4, stagger: 0.15, ease: "power2.out" },
                "-=0.4"
            )
            // 4. Botão "salta" para a tela
            .fromTo("#btnLogin",
                { scale: 0.8, opacity: 0 },
                { scale: 1, opacity: 1, duration: 0.6, ease: "elastic.out(1, 0.5)" },
                "-=0.2"
            );

            // Efeito de Tremor se der erro na senha
            if (document.getElementById("alertError")) {
                gsap.fromTo("#loginBox", 
                    { x: -10 }, 
                    { x: 10, duration: 0.1, repeat: 5, yoyo: true, ease: "rough({strength: 2, points: 10})", clearProps: "x" }
                );
            }
        });
    </script>
</body>
</html>