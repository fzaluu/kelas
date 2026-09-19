<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Pemeliharaan Sistem — Website Kelas PPLG</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-brand-primary: #2f5aa8;
            --color-brand-primary-hover: #26478a;
            --color-brand-primary-light: #eaf0fb;
            --color-brand-accent: #f5d675;
            --color-brand-accent-soft: #faecb0;
            --color-surface-default: #f8fafc;
            --color-surface-raised: #ffffff;
            --color-surface-sunken: #f1f5f9;
            --color-text-primary: #1e293b;
            --color-text-secondary: #64748b;
            --color-text-inverse: #ffffff;
            --color-border-default: #e2e8f0;
            --color-feedback-success: #16a34a;
            --color-feedback-success-soft: #dcfce7;
            --color-feedback-warning: #d97706;
            --color-feedback-warning-soft: #fef3c7;
            --color-feedback-danger: #dc2626;
            --color-feedback-danger-soft: #fee2e2;
            --ease-standard: cubic-bezier(0.16, 1, 0.3, 1);
            --duration-standard: 200ms;
            --duration-emphasis: 300ms;
        }
        * { box-sizing: border-box; }
        html, body {
            margin: 0; padding: 0; height: 100%;
            font-family: 'Plus Jakarta Sans', 'Instrument Sans', ui-sans-serif, system-ui, -apple-system,
                'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(to bottom, color-mix(in srgb, var(--color-brand-primary-light) 60%, transparent), var(--color-surface-raised) 55%, var(--color-surface-sunken));
            color: var(--color-text-primary);
        }
        .error-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 1.25rem;
        }
        .error-card {
            max-width: 30rem;
            width: 100%;
            text-align: center;
        }
        .error-badge {
            width: 6rem; height: 6rem;
            border-radius: 1.75rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem auto;
            font-weight: 800;
            font-size: 1.85rem;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.04);
        }
        h1.error-title {
            font-size: 1.65rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin: 0 0 0.6rem 0;
            color: var(--color-text-primary);
        }
        p.error-desc {
            font-size: 0.85rem;
            color: var(--color-text-secondary);
            max-width: 24rem;
            margin: 0 auto;
            line-height: 1.6;
        }
        .error-actions {
            margin-top: 1.75rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.75rem;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.8rem 1.5rem;
            border-radius: 0.85rem;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: transform var(--duration-standard) var(--ease-standard),
                        background-color var(--duration-standard) var(--ease-standard),
                        box-shadow var(--duration-standard) var(--ease-standard);
        }
        .btn:active { transform: scale(0.96); }
        .btn-primary {
            background: var(--color-brand-primary);
            color: var(--color-text-inverse);
            box-shadow: 0 8px 16px -4px color-mix(in srgb, var(--color-brand-primary) 35%, transparent);
        }
        .btn-primary:hover { background: var(--color-brand-primary-hover); transform: translateY(-1px); }
        .btn-secondary {
            background: var(--color-surface-sunken);
            color: var(--color-text-secondary);
        }
        .btn-secondary:hover { background: var(--color-border-default); color: var(--color-text-primary); }
        .status-pill {
            display: inline-block;
            padding: 0.55rem 1.1rem;
            border-radius: 0.85rem;
            background: var(--color-surface-sunken);
            color: var(--color-text-secondary);
            font-weight: 700;
            font-size: 0.7rem;
        }
        .brand-footer {
            margin-top: 2.5rem;
            font-size: 0.65rem;
            color: var(--color-text-secondary);
            opacity: 0.7;
        }
</style>
</head>
<body>
    <div class="error-wrapper">
        <div class="error-card">
            <div class="error-badge" style="background:var(--color-brand-accent-soft); color:var(--color-brand-primary);">&#128295;</div>
            <h1 class="error-title">Sistem Dalam Pemeliharaan</h1>
            <p class="error-desc">Website XI PPLG 2 sedang dalam proses pembaruan fitur. Kami akan kembali online sebentar lagi.</p>
            <div class="status-pill">Status: Pembaruan Rutin</div>
            <div class="error-actions">
                
                <button type="button" class="btn btn-primary" onclick="pplgGoBack()">&larr; Kembali</button>
            </div>
            <div class="brand-footer">Website Kelas XI PPLG 2 &middot; SMKN 4 Kota Tasikmalaya</div>
        </div>
    </div>
    
    <script>
        function pplgGoBack() {
            try {
                var ref = document.referrer;
                if (ref) {
                    var refHost = new URL(ref).host;
                    if (refHost === window.location.host) {
                        window.location.href = ref;
                        return;
                    }
                }
            } catch (e) {}
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
        }
    </script>

</body>
</html>
