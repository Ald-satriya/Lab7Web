<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'My Website' ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
    <style>
        :root {
            --bg-color: #0f172a;
            --nav-bg: #1e293b;
            --accent: #00ffe7;
            --text-color: #e2e8f0;
            --hover: #334155;
            --sidebar-bg: #1a202c;
        }

        body {
            margin: 0;
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', sans-serif;
        }

        header {
            background: linear-gradient(90deg, #00ffe7 0%, #007bff 100%);
            padding: 1.5rem;
            text-align: center;
            color: #0f172a;
            box-shadow: 0 4px 12px rgba(0, 255, 231, 0.2);
        }

        nav {
            background-color: var(--nav-bg);
            display: flex;
            justify-content: center;
            gap: 1rem;
            padding: 0.75rem;
        }

        nav a {
            color: var(--text-color);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: background 0.3s;
        }

        nav a:hover, nav a.active {
            background-color: var(--hover);
            color: var(--accent);
        }

        #container {
            max-width: 1200px;
            margin: 2rem auto;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        #wrapper {
            display: flex;
            gap: 2rem;
        }

        #main {
            flex: 3;
        }

        #sidebar {
            flex: 1;
            background-color: var(--sidebar-bg);
            padding: 1rem;
            border-radius: 10px;
        }

        .widget-box {
            background-color: #2d3748;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .widget-box h3 {
            margin-bottom: 0.5rem;
            color: var(--accent);
        }

        .widget-box ul {
            list-style: none;
            padding-left: 0;
        }

        .widget-box ul li {
            margin: 0.5rem 0;
        }

        .widget-box ul li a {
            color: #cbd5e1;
            text-decoration: none;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background-color: var(--nav-bg);
            color: var(--text-color);
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div id="container">
        <header>
            <h1><?= $title ?? 'WEB PORTAL ARTIKEL' ?></h1>
        </header>

        <nav>
            <a href="<?= base_url('/home'); ?>" class="<?= uri_string() === 'home' ? 'active' : '' ?>">Home</a>
            <a href="<?= base_url('/artikel'); ?>" class="<?= uri_string() === 'artikel' ? 'active' : '' ?>">Artikel</a>
            <a href="<?= base_url('/about'); ?>" class="<?= uri_string() === 'about' ? 'active' : '' ?>">About</a>
            <a href="<?= base_url('/contact'); ?>" class="<?= uri_string() === 'contact' ? 'active' : '' ?>">Kontak</a>
        </nav>

        <section id="wrapper">
            <section id="main">
                <?= $this->renderSection('content') ?>
            </section>

            <aside id="sidebar">
                <?= view_cell('App\\Cells\\ArtikelTerkini::render') ?>

                <div class="widget-box">
                    <h3 class="title">Widget Header</h3>
                    <ul>
                        <li><a href="#">Widget Link 1</a></li>
                        <li><a href="#">Widget Link 2</a></li>
                    </ul>
                </div>

                <div class="widget-box">
                    <h3 class="title">Tentang Kami</h3>
                    <p>Tempat berbagi informasi dan pengetahuan dengan tampilan galaksi yang elegan.</p>
                </div>
            </aside>
        </section>

        <footer>
            <p>&copy; <?= date('Y'); ?> - Universitas Pelita Bangsa</p>
        </footer>
    </div>
</body>
</html>
