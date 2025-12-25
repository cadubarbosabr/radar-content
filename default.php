<?php
// =================================================================================
// ENGINE MARKDOWN PARA PHP
// =================================================================================

require_once 'Parsedown.php'; // Certifique-se que este arquivo está na raiz

$site_config = [
    'title' => 'RADAR | Cadu Barbosa',
    'subtitle' => 'Curadoria estratégica de conteúdo, tecnologia e inovação.',
    'url' => 'https://radar.cadubarbosa.com.br'
];

// Função para ler o Frontmatter (Metadados) e o Conteúdo
function getPosts() {
    $files = glob("posts/*.md");
    $posts = [];
    $Parsedown = new Parsedown();

    foreach ($files as $file) {
        $content = file_get_contents($file);
        
        // Separa o Frontmatter do Corpo (--- no inicio e fim do header)
        $pattern = "/^---\s*\n(.*?)\n---\s*\n(.*)$/s";
        
        if (preg_match($pattern, $content, $matches)) {
            $rawMetadata = $matches[1];
            $rawBody = $matches[2];

            // Parseia os metadados (simples chave: valor)
            $meta = [];
            $lines = explode("\n", $rawMetadata);
            foreach ($lines as $line) {
                if (strpos($line, ':') !== false) {
                    list($key, $value) = explode(':', $line, 2);
                    $meta[trim($key)] = trim($value);
                }
            }

            // Converte Markdown para HTML
            $htmlContent = $Parsedown->text($rawBody);

            // Monta o array do post
            $posts[] = [
                'id' => basename($file), // O nome do arquivo vira ID
                'category' => $meta['category'] ?? 'Geral',
                'title' => $meta['title'] ?? 'Sem Título',
                'image' => $meta['image'] ?? '',
                'date' => $meta['date'] ?? '',
                'author' => $meta['author'] ?? 'Admin',
                'excerpt' => $meta['excerpt'] ?? '',
                'content' => $htmlContent
            ];
        }
    }

    // Ordena por data (assumindo formato textual ou timestamp, aqui simplificado)
    // Dica: Use nomes de arquivo como "2025-10-22-slug.md" para ordenação fácil
    usort($posts, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    return $posts;
}

$posts = getPosts();

// Extrair categorias
$categories = !empty($posts) ? array_unique(array_column($posts, 'category')) : [];
sort($categories);
?>
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_config['title']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], mono: ['JetBrains Mono', 'monospace'] }, colors: { radar: { dark: '#0f172a', card: '#1e293b', accent: '#6366f1', text: '#f1f5f9', muted: '#94a3b8' } } } } }
    </script>
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.05); }
        .glass-card { background: rgba(30, 41, 59, 0.5); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease; }
        .glass-card:hover { transform: translateY(-5px); border-color: rgba(99, 102, 241, 0.5); }
        /* Tive que ajustar o CSS do Prose para estilizar o HTML gerado pelo Markdown */
        .prose h1, .prose h2, .prose h3 { color: #fff; font-weight: 800; margin-top: 1.5em; margin-bottom: 0.5em; }
        .prose h1 { font-size: 2em; } .prose h2 { font-size: 1.5em; }
        .prose p { margin-bottom: 1.25rem; line-height: 1.75; color: #cbd5e1; }
        .prose ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; color: #cbd5e1; }
        .prose li { margin-bottom: 0.5rem; }
        .prose blockquote { border-left: 4px solid #6366f1; padding-left: 1rem; font-style: italic; color: #94a3b8; margin: 1.5rem 0; background: rgba(99, 102, 241, 0.1); padding: 1rem; border-radius: 0 8px 8px 0; }
        .prose a { color: #6366f1; text-decoration: underline; }
        .prose code { background: #0f172a; padding: 2px 6px; rounded: 4px; font-family: 'JetBrains Mono', monospace; font-size: 0.9em; color: #e2e8f0; }
        .prose pre { background: #0f172a; padding: 1rem; border-radius: 8px; overflow-x: auto; border: 1px solid #334155; }
        .prose img { border-radius: 8px; margin: 1.5rem 0; }
    </style>
</head>
<body class="bg-radar-dark text-radar-text antialiased min-h-screen relative selection:bg-radar-accent selection:text-white">
    <header class="fixed top-0 w-full z-40 glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-radar-accent rounded-full animate-pulse"></div>
                <a href="#" class="text-xl font-bold tracking-tight font-mono uppercase">Radar<span class="text-radar-muted">.CaduBarbosa</span></a>
            </div>
            <nav class="flex flex-wrap justify-center gap-2">
                <button onclick="filterPosts('all')" class="filter-btn px-4 py-1.5 rounded-full text-xs font-bold uppercase border border-transparent bg-radar-accent text-white" data-filter="all">Todos</button>
                <?php foreach ($categories as $cat): ?>
                <button onclick="filterPosts('<?php echo $cat; ?>')" class="filter-btn px-4 py-1.5 rounded-full text-xs font-bold uppercase border border-slate-700 text-radar-muted hover:border-radar-accent hover:text-white transition-all" data-filter="<?php echo $cat; ?>"><?php echo $cat; ?></button>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20">
        <div class="mb-12 text-center max-w-2xl mx-auto">
            <h1 class="text-3xl md:text-5xl font-extrabold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">Insights & Signals</h1>
            <p class="text-radar-muted text-lg"><?php echo $site_config['subtitle']; ?></p>
        </div>

        <div class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6" id="posts-grid">
            <?php foreach ($posts as $post): ?>
            <article class="post-card break-inside-avoid glass-card rounded-xl overflow-hidden cursor-pointer group relative" 
                     data-category="<?php echo $post['category']; ?>"
                     onclick='openModal(<?php echo json_encode($post, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)'>
                <div class="relative h-48 overflow-hidden">
                    <img src="<?php echo $post['image']; ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-radar-dark to-transparent opacity-60"></div>
                    <span class="absolute top-3 left-3 bg-black/50 backdrop-blur-sm border border-white/10 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-widest"><?php echo $post['category']; ?></span>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-radar-muted mb-3 font-mono">
                        <span><?php echo $post['date']; ?></span> • <span><?php echo $post['author']; ?></span>
                    </div>
                    <h2 class="text-xl font-bold mb-3 leading-tight group-hover:text-radar-accent transition-colors"><?php echo $post['title']; ?></h2>
                    <p class="text-sm text-slate-400 line-clamp-3"><?php echo $post['excerpt']; ?></p>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($posts)): ?>
            <div class="text-center py-20 text-radar-muted">Adicione arquivos .md na pasta /posts</div>
        <?php endif; ?>
    </main>

    <footer class="border-t border-slate-800 mt-auto bg-radar-dark py-8 text-center text-slate-500 text-sm">&copy; <?php echo date('Y'); ?> Radar Cadu Barbosa.</footer>

    <div id="reading-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-950/90 backdrop-blur-sm transition-opacity opacity-0" id="modal-backdrop"></div>
        <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-0 md:p-4 text-center">
                <div class="relative bg-radar-card text-left shadow-2xl transition-all sm:rounded-2xl w-full max-w-3xl opacity-0 scale-95 border border-slate-700" id="modal-panel">
                    <div class="fixed top-0 left-0 w-full h-1 z-20 bg-slate-800 sm:rounded-t-2xl overflow-hidden"><div id="read-progress" class="h-full bg-radar-accent w-0"></div></div>
                    <button onclick="closeModal()" class="absolute top-4 right-4 z-20 p-2 rounded-full bg-black/40 text-white hover:bg-radar-accent transition-colors backdrop-blur-md">✕</button>
                    <div class="modal-scroll max-h-[100vh] md:max-h-[85vh] overflow-y-auto bg-radar-dark">
                        <div class="relative h-64 md:h-80 w-full">
                            <img id="modal-img" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-radar-dark via-radar-dark/50 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-6 md:p-10 w-full">
                                <span id="modal-category" class="inline-block py-1 px-3 rounded bg-radar-accent/20 text-radar-accent border border-radar-accent/30 text-xs font-bold uppercase tracking-wider mb-3"></span>
                                <h2 id="modal-title" class="text-2xl md:text-4xl font-bold text-white leading-tight"></h2>
                                <div class="mt-4 flex text-sm text-slate-400 font-mono"><span id="modal-author"></span><span class="mx-2">•</span><span id="modal-date"></span></div>
                            </div>
                        </div>
                        <div class="p-6 md:p-10">
                            <div id="modal-body" class="prose max-w-none text-lg"></div>
                            <div class="mt-12 pt-8 border-t border-slate-800">
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Compartilhar</p>
                                <div class="flex gap-4">
                                    <a id="share-whatsapp" target="_blank" class="px-4 py-2 rounded bg-[#25D366]/10 text-[#25D366] border border-[#25D366]/20 hover:bg-[#25D366]/20">WhatsApp</a>
                                    <a id="share-linkedin" target="_blank" class="px-4 py-2 rounded bg-[#0077b5]/10 text-[#0077b5] border border-[#0077b5]/20 hover:bg-[#0077b5]/20">LinkedIn</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const modal = document.getElementById('reading-modal');
        const modalBackdrop = document.getElementById('modal-backdrop');
        const modalPanel = document.getElementById('modal-panel');
        const progressBar = document.getElementById('read-progress');

        function filterPosts(cat) {
            document.querySelectorAll('.post-card').forEach(card => {
                card.style.display = (cat === 'all' || card.dataset.category === cat) ? 'block' : 'none';
            });
            document.querySelectorAll('.filter-btn').forEach(btn => {
                const isActive = btn.dataset.filter === cat;
                btn.classList.toggle('bg-radar-accent', isActive); btn.classList.toggle('text-white', isActive); btn.classList.toggle('border-transparent', isActive);
                btn.classList.toggle('text-radar-muted', !isActive); btn.classList.toggle('border-slate-700', !isActive);
            });
        }
        function openModal(post) {
            document.getElementById('modal-title').textContent = post.title;
            document.getElementById('modal-category').textContent = post.category;
            document.getElementById('modal-author').textContent = post.author;
            document.getElementById('modal-date').textContent = post.date;
            document.getElementById('modal-img').src = post.image;
            document.getElementById('modal-body').innerHTML = post.content;
            const url = encodeURIComponent(window.location.href);
            document.getElementById('share-whatsapp').href = `https://wa.me/?text=${encodeURIComponent(post.title)}%20${url}`;
            document.getElementById('share-linkedin').href = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
            modal.classList.remove('hidden');
            setTimeout(() => { modalBackdrop.classList.remove('opacity-0'); modalPanel.classList.remove('opacity-0', 'scale-95'); modalPanel.classList.add('opacity-100', 'scale-100'); }, 10);
            document.body.style.overflow = 'hidden';
        }
        function closeModal() {
            modalBackdrop.classList.add('opacity-0'); modalPanel.classList.remove('opacity-100', 'scale-100'); modalPanel.classList.add('opacity-0', 'scale-95');
            setTimeout(() => { modal.classList.add('hidden'); document.body.style.overflow = 'auto'; }, 300);
        }
        modalBackdrop.addEventListener('click', closeModal);
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
        document.querySelector('.modal-scroll').addEventListener('scroll', function() {
            progressBar.style.width = ((this.scrollTop / (this.scrollHeight - this.clientHeight)) * 100) + '%';
        });
    </script>
</body>
</html>