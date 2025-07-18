<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'WEB PORTAL BERITA'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #6b21a8;
            --accent-color: #38bdf8;
            --light-bg: #1e1b2e;
            --text-color: #e0e7ff;
            --nav-bg: #111827;
            --header-bg: linear-gradient(135deg, #4f46e5, #9333ea, #38bdf8);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
        }

        #container {
            max-width: 1200px;
            margin: auto;
            background: #1e1b2e;
            border-radius: 12px;
            box-shadow: 0 0 30px rgba(56, 189, 248, 0.2);
            overflow: hidden;
        }

        header {
            background: var(--header-bg);
            color: white;
            padding: 40px 20px;
            text-align: center;
            border-bottom: 4px solid var(--accent-color);
        }

        header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.3);
        }

        nav {
            background: var(--nav-bg);
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 1rem;
            gap: 1rem;
        }

        nav a {
            color: #c4b5fd;
            padding: 10px 20px;
            font-weight: 500;
            border-radius: 6px;
            transition: background 0.3s, color 0.3s;
        }

        nav a:hover,
        nav a.active {
            background-color: var(--accent-color);
            color: #1e1b2e;
        }

        main.container {
            background-color: #1f1d2e;
            padding: 2rem;
            border-radius: 10px;
            margin: 2rem auto;
            box-shadow: 0 0 15px rgba(147, 51, 234, 0.2);
        }

        .entry {
            background-color: #2a2438;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(147, 51, 234, 0.15);
        }

        .entry h2 a {
            color: #a78bfa;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .entry h2 a:hover {
            color: #38bdf8;
            text-decoration: underline;
        }

        .entry p {
            color: #d1d5db;
            margin-top: 0.5rem;
        }

        .entry img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .divider {
            border-top: 1px solid #4c1d95;
            margin: 2rem 0;
        }

        footer {
            background: #0e0a1f;
            color: #94a3b8;
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <div id="container">
        <header>
            <h1>WEB PORTAL BERITA</h1>
        </header>

        <nav>
            <?php
            $currentPath = service('uri')->getPath();
            $navLinks = [
                'Home' => '/',
                'Artikel' => '/artikel',
                'About' => '/about',
                'Contact' => '/contact'
            ];

            foreach ($navLinks as $label => $path):
                $isActive = $currentPath === trim($path, '/') || ($path === '/' && $currentPath === '');
                if ($path === '/artikel' && strpos($currentPath, 'artikel') === 0) {
                    $isActive = true;
                }
            ?>
                <a href="<?= base_url($path); ?>" class="<?= $isActive ? 'active' : ''; ?>">
                    <?= $label; ?>
                </a>
            <?php endforeach; ?>
        </nav>

