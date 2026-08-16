<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Serene') — serene.toybits.cloud</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(160deg, #0f172a 0%, #1e3a5f 55%, #0ea5e9 130%);
            color: #e2e8f0;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.1rem 2rem;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .brand { font-size: 1.25rem; font-weight: 800; letter-spacing: -0.01em; }
        .brand .wave { display: inline-block; animation: wave 2.4s ease-in-out infinite; transform-origin: 70% 70%; }
        @keyframes wave {
            0%, 60%, 100% { transform: rotate(0deg); }
            10%, 30% { transform: rotate(16deg); }
            20% { transform: rotate(-8deg); }
            40% { transform: rotate(8deg); }
        }
        nav { display: flex; gap: 1.25rem; }
        nav a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
            padding: 0.35rem 0.6rem;
            border-radius: 8px;
            transition: color .15s, background .15s;
        }
        nav a:hover { color: #fff; background: rgba(255, 255, 255, 0.08); }
        main { flex: 1; width: 100%; max-width: 860px; margin: 0 auto; padding: 2.5rem 1.5rem 3rem; }
        article {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 20px;
            padding: 2.5rem 2.75rem;
            box-shadow: 0 25px 60px rgba(2, 6, 23, 0.45);
        }
        h1 { font-size: 2rem; font-weight: 800; letter-spacing: -0.02em; }
        .updated { margin-top: 0.4rem; font-size: 0.85rem; color: #7dd3fc; }
        h2 {
            margin-top: 2.2rem;
            font-size: 1.15rem;
            font-weight: 700;
            color: #f1f5f9;
            padding-bottom: 0.4rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }
        p { margin-top: 0.9rem; color: #cbd5e1; font-size: 0.98rem; line-height: 1.75; }
        ul { margin: 0.9rem 0 0 1.4rem; color: #cbd5e1; font-size: 0.98rem; line-height: 1.8; }
        li { margin-top: 0.3rem; }
        a { color: #7dd3fc; }
        strong { color: #f1f5f9; }
        .card-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.1rem; margin-top: 1.4rem; }
        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 1.2rem 1.3rem;
        }
        .card h3 { font-size: 0.95rem; font-weight: 700; color: #f1f5f9; }
        .card p { margin-top: 0.5rem; font-size: 0.9rem; line-height: 1.6; }
        .contact-box {
            margin-top: 1.4rem;
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid rgba(14, 165, 233, 0.35);
            border-radius: 14px;
            padding: 1.3rem 1.5rem;
            font-size: 0.95rem;
            line-height: 1.8;
        }
        .contact-box code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            color: #7dd3fc;
            background: rgba(14, 165, 233, 0.12);
            padding: 0.15rem 0.45rem;
            border-radius: 6px;
        }
        footer {
            text-align: center;
            padding: 1.2rem 1rem 1.5rem;
            font-size: 0.82rem;
            color: #64748b;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }
        footer a { color: #94a3b8; text-decoration: none; }
        footer a:hover { color: #7dd3fc; }
    </style>
</head>
<body>
    <header>
        <div class="brand">Serene <span class="wave">🌊</span></div>
        <nav>
            <a href="/">Home</a>
            <a href="/privacy">Privacy</a>
            <a href="/support">Support</a>
        </nav>
    </header>

    <main>
        <article>
            @yield('content')
        </article>
    </main>

    <footer>
        © {{ date('Y') }} Serene · serene.toybits.cloud ·
        <a href="/privacy">Privacy Policy</a> ·
        <a href="/support">Support</a>
    </footer>
</body>
</html>
