<?= $this->include('template/header'); ?>

<style>
    :root {
        --dark-bg: #0b0c2a;
        --card-bg: #1a1c3f;
        --primary: #00ffe7;
        --secondary: #ff6ec7;
        --text-color: #e0e0ff;
        --muted: #aaaacc;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    body {
        background: radial-gradient(circle at top left, #0b0c2a, #000010 70%);
        color: var(--text-color);
    }

    header {
        background: linear-gradient(120deg, #3e1e68, #9b27b0, #1c92d2);
        padding: 2rem 1rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }

    header h1 {
        font-size: 2.7rem;
        font-weight: bold;
        color: #fff;
        text-shadow: 0 0 10px #00ffe7;
    }

    header p {
        font-size: 1.1rem;
        color: #e0f7fa;
        margin-top: 0.5rem;
    }

    main {
        max-width: 1000px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .article {
        background-color: var(--card-bg);
        border-left: 4px solid var(--primary);
        border-radius: 10px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 0 15px rgba(0, 255, 255, 0.15);
        transition: transform 0.2s ease;
    }

    .article:hover {
        transform: translateY(-4px);
        box-shadow: 0 0 25px rgba(0, 255, 255, 0.3);
    }

    .article h2 {
        color: var(--secondary);
        margin-bottom: 0.5rem;
        text-shadow: 0 0 6px rgba(255, 110, 199, 0.5);
    }

    .article p {
        color: var(--muted);
        line-height: 1.7;
    }

    footer {
        text-align: center;
        color: var(--muted);
        padding: 1rem 0;
        margin-top: 3rem;
        font-size: 0.9rem;
        background-color: #0a0b1c;
        border-top: 1px solid #222244;
    }

    @media (max-width: 768px) {
        header h1 {
            font-size: 2.2rem;
        }

        .article {
            padding: 1.2rem 1.5rem;
        }
    }
</style>
</head>

<body>

    <header>
        <h1>WEB PORTAL ARTIKEL</h1>
        <p>Membaca, Menulis, dan Menyebarkan Pengetahuan</p>
    </header>

    <main>
        <div class="article">
            <h2>Apa Itu Web Portal Artikel?</h2>
            <p>Web Portal Artikel adalah platform online yang menyajikan berbagai tulisan informatif, edukatif, dan
                inspiratif dari berbagai topik seperti teknologi, kesehatan, gaya hidup, bisnis, dan lainnya. Tujuan
                utamanya adalah memberikan akses cepat terhadap informasi berkualitas.</p>
        </div>

        <div class="article">
            <h2>Fitur Unggulan Portal Ini</h2>
            <p>
                - Artikel terbaru selalu update<br>
                - Tampilan minimalis dan responsif<br>
                - Kategori yang terorganisir rapi<br>
                - Navigasi mudah dan cepat<br>
                - Sistem penulisan artikel ramah pengguna
            </p>
        </div>

        <div class="article">
            <h2>Manfaat Menggunakan Portal Artikel</h2>
            <p>Dengan membaca artikel di portal ini, pengunjung dapat memperluas wawasan, menemukan inspirasi, dan tetap
                mengikuti perkembangan informasi terkini. Cocok untuk pelajar, profesional, hingga penulis lepas yang
                ingin berbagi karya tulisannya.</p>
        </div>
    </main>

    <?= $this->include('template/footer'); ?>
