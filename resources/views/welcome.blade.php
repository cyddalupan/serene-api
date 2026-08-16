<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Serene — serene.toybits.cloud</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 55%, #0ea5e9 130%);
            color: #e2e8f0;
            padding: 1rem;
        }
        .card {
            text-align: center;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 20px;
            padding: 3.5rem 3rem;
            max-width: 580px;
            box-shadow: 0 25px 60px rgba(2, 6, 23, 0.55);
        }
        h1 { font-size: 2.6rem; font-weight: 800; letter-spacing: -0.02em; }
        .wave { display: inline-block; animation: wave 2.4s ease-in-out infinite; transform-origin: 70% 70%; }
        @keyframes wave {
            0%, 60%, 100% { transform: rotate(0deg); }
            10%, 30% { transform: rotate(16deg); }
            20% { transform: rotate(-8deg); }
            40% { transform: rotate(8deg); }
        }
        p { margin-top: 1rem; color: #94a3b8; font-size: 1.05rem; line-height: 1.6; }
        .domain {
            display: inline-block;
            margin-top: 1.8rem;
            font-size: 0.85rem;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            color: #7dd3fc;
            background: rgba(14, 165, 233, 0.12);
            border: 1px solid rgba(14, 165, 233, 0.35);
            padding: 0.45rem 0.9rem;
            border-radius: 999px;
        }
        .badge {
            display: inline-block;
            margin-top: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #34d399;
            background: rgba(52, 211, 153, 0.12);
            border: 1px solid rgba(52, 211, 153, 0.35);
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
        }
        .stack {
            margin-top: 2rem;
            font-size: 0.8rem;
            color: #64748b;
            letter-spacing: 0.04em;
        }
        .stack strong { color: #94a3b8; }
    </style>
</head>
<body>
    <main class="card">
        <h1>Serene <span class="wave">🌊</span></h1>
        <p>Laravel backend, live on <strong>serene.toybits.cloud</strong>.</p>
        <span class="domain">https://serene.toybits.cloud</span><br>
        <span class="badge">🔒 SSL Active · Laravel {{ Illuminate\Foundation\Application::VERSION }}</span>
        <div class="stack">PHP {{ PHP_VERSION }} · Apache · SQLite</div>
    </main>
</body>
</html>
