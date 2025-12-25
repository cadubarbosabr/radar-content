<?php
// =================================================================================
// 1. LÓGICA DE API (Responde ao JavaScript quando clica no post)
// =================================================================================
if (isset($_GET['get_post'])) {
    require_once 'Parsedown.php';
    header('Content-Type: application/json');

    $filename = basename($_GET['get_post']); // Segurança contra invasão de pasta
    $filepath = __DIR__ . '/posts/' . $filename;

    if (!file_exists($filepath)) {
        echo json_encode(['error' => 'Arquivo não encontrado']);
        exit;
    }

    $content = file_get_contents($filepath);
    
    // Separa Header do Corpo
    $pattern = "/^---\s*\r?\n(.*?)\r?\n---\s*\r?\n(.*)$/s";
    if (preg_match($pattern, $content, $matches)) {
        $rawMetadata = $matches[1];
        $rawBody = $matches[2];
        
        $meta = [];
        $lines = explode("\n", $rawMetadata);
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(':', $line, 2);
                $meta[trim($key)] = trim(str_replace(['"', "'"], '', trim($value)));
            }
        }

        $Parsedown = new Parsedown();
        echo json_encode([
            'success' => true,
            'title' => $meta['title'] ?? 'Sem Título',
            'category' => $meta['category'] ?? 'Geral',
            'date' => $meta['date'] ?? '',
            'author' => $meta['author'] ?? 'Admin',
            'image' => $meta['image'] ?? '',
            'content' => $Parsedown->text($rawBody)
        ]);
    } else {
        echo json_encode(['error' => 'Formato inválido (Falta Frontmatter)']);
    }
    exit; // Para a execução aqui se for uma requisição de post
}

// =================================================================================
// 2. LÓGICA DE FRONTEND (Carrega a lista inicial)
// =================================================================================
require_once 'Parsedown.php'; 

$site_config = [
    'title' => 'RADAR | Cadu Barbosa',
    'subtitle' => 'Curadoria estratégica de conteúdo, tecnologia e inovação.',
    'external_links' => [
        'Site Oficial' => 'https://www.cadubarbosa.com.br',
        'Blog' => 'https://www.cadubarbosa.com.br/blog'
    ]
];

// Apenas lê os metadados para a capa (Leve e Rápido)
$files = glob("posts/*.md");
$posts = [];

foreach ($files as $file) {
    $content = file_get_contents($file);
    // Regex apenas para o cabeçalho
    if (preg_match("/^---\s*\r?\n(.*?)\r?\n---/s", $content, $matches)) {
        $lines = explode("\n", $matches[1]);
        $meta = [];
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(':', $line, 2);
                $meta[trim($key)] = trim(str_replace(['"', "'"], '', trim($value)));
            }
        }
        $posts[] = [
            'file_id' => basename($file), // ID único para buscar depois
            'category' => $meta['category'] ?? 'Geral',
            'title' => $meta['title'] ?? 'Sem Título',
            'image' => $meta['image'] ?? '',
            'date' => $meta['date'] ?? '',
            'author' => $meta['author'] ?? 'Admin',
            'excerpt' => $meta['excerpt'] ?? ''
        ];
    }
}

// Ordenação
usort($posts, function($a, $b) {
    return strtotime(str_replace('/', '-', $b['date'])) - strtotime(str_replace('/', '-', $a['date']));
});

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
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], mono: ['JetBrains Mono', 'monospace'], display: ['Space Grotesk', 'sans-serif'] },
                    colors: { radar: { bg: '#0B0F19', card: '#151B2B', border: '#2A3441', accent: '#6366f1', glow: '#818cf8', text: '#e2e8f0', muted: '#94a3b8' } },
                    animation: { 'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite' }
                }
            }
        }
    </script>
    <style>
        .bg-grid-pattern { background-size: 40px 40px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px), linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px); mask-image: radial-gradient(circle at center, black 40%, transparent 100%); -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 100%); }
        ::-webkit-scrollbar { width: 6px; } ::-webkit-scrollbar-track { background: #0B0F19; } ::-webkit-scrollbar-thumb { background: #2A3441; border-radius: 3px; } ::-webkit-scrollbar-thumb:hover { background: #6366f1; }
        .glass-nav { background: rgba(11, 15, 25, 0.85); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .glass-card { background: rgba(21, 27, 43, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; position: relative; z-index: 10; }
        .glass-card:hover { transform: translateY(-4px); border-color: rgba(99, 102, 241, 0.4); box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 0.15); }
        .prose p { margin-bottom: 1.75em; line-height: 1.85; color: #cbd5e1; font-size: 1.125rem; font-weight: 300; }
        .prose h1, .prose h2, .prose h3 { color: #f8fafc; font-family: 'Space Grotesk', sans-serif; letter-spacing: -0.02em; margin-top: 2em; }
        .prose strong { color: #fff; font-weight: 600; }
        .prose blockquote { border-left-color: #6366f1; background: rgba(99,102,241,0.05); color: #a5b4fc; border-radius: 0 8px 8px 0; }
        .prose ul li::marker { color: #6366f1; }
        .prose code { color: #818cf8; background: rgba(99,102,241,0.1); padding: 2px 6px; border-radius: 4px; font-weight: 400; }
        .prose img { border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); }
        
        /* Loading Spinner */
        .loader { border: 3px solid rgba(255,255,255,0.1); border-left-color: #6366f1; border-radius: 50%; width: 30px; height: 30px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-radar-bg text-radar-text antialiased min-h-screen relative selection:bg-radar-accent selection:text-white overflow-x-hidden">

    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-grid-pattern opacity-60"></div>
        <div class="absolute top-[-10%] left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-radar-accent/10 blur-[120px] rounded-full mix-blend-screen"></div>
    </div>

    <header class="fixed top-0 w-full z-40 glass-nav">
        <div class="border-b border-white/5 bg-black/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-10 flex items-center justify-end gap-6 text-xs font-mono tracking-wider uppercase">
                <span class="text-radar-muted opacity-50 hidden sm:block">/// TERMINAL ACCESS</span>
                <?php foreach($site_config['external_links'] as $label => $link): ?>
                    <a href="<?php echo $link; ?>" target="_blank" class="text-radar-muted hover:text-radar-accent transition-all duration-300 flex items-center gap-1 group">
                        <?php echo $label; ?>
                        <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity transform -translate-x-2 group-hover:translate-x-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3 cursor-pointer" onclick="window.location.reload()">
                <div class="relative w-8 h-8 flex items-center justify-center">
                    <div class="absolute inset-0 bg-radar-accent/20 rounded-full animate-pulse-slow"></div>
                    <div class="w-3 h-3 bg-radar-accent rounded-full shadow-[0_0_15px_rgba(99,102,241,0.8)]"></div>
                    <div class="absolute inset-0 border border-radar-accent/30 rounded-full animate-[ping_3s_cubic-bezier(0,0,0.2,1)_infinite]"></div>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-display font-bold tracking-tight text-white leading-none">RADAR</span>
                    <span class="text-[10px] font-mono text-radar-accent uppercase tracking-[0.2em] leading-none mt-1">Cadu Barbosa</span>
                </div>
            </div>
            <nav class="flex flex-wrap justify-center gap-2 bg-white/5 p-1 rounded-full backdrop-blur-sm border border-white/5">
                <button onclick="filterPosts('all')" class="filter-btn px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wide transition-all duration-300 bg-radar-accent text-white shadow-lg shadow-indigo-500/20" data-filter="all">All Signals</button>
                <?php foreach ($categories as $cat): ?>
                <button onclick="filterPosts('<?php echo $cat; ?>')" class="filter-btn px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wide transition-all duration-300 text-radar-muted hover:text-white hover:bg-white/5 border border-transparent" data-filter="<?php echo $cat; ?>"><?php echo $cat; ?></button>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-48 pb-32 relative z-10">
        <div class="mb-20 text-center max-w-3xl mx-auto space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-mono uppercase tracking-widest">
                <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span></span>
                System Operational
            </div>
            <h1 class="text-4xl md:text-6xl font-display font-bold tracking-tight text-transparent bg-clip-text bg-gradient-to-b from-white via-white to-slate-400">Intelligence & Signals</h1>
            <p class="text-lg md:text-xl text-radar-muted font-light leading-relaxed max-w-2xl mx-auto"><?php echo $site_config['subtitle']; ?></p>
        </div>

        <div class="columns-1 md:columns-2 lg:columns-3 gap-8 space-y-8" id="posts-grid">
            <?php foreach ($posts as $post): ?>
            <article class="post-card break-inside-avoid glass-card rounded-2xl overflow-hidden group flex flex-col" 
                     data-category="<?php echo $post['category']; ?>"
                     onclick="loadPost('<?php echo $post['file_id']; ?>')">
                
                <div class="relative aspect-[16/10] overflow-hidden pointer-events-none">
                    <?php if($post['image']): ?>
                        <img src="<?php echo $post['image']; ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 group-hover:rotate-1">
                    <?php else: ?>
                        <div class="w-full h-full bg-slate-800 flex items-center justify-center text-slate-600 font-mono text-xs">NO IMAGE</div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-radar-card via-transparent to-transparent opacity-80"></div>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-black/60 backdrop-blur-md border border-white/10 text-white text-[10px] font-bold font-mono uppercase tracking-wider rounded-md shadow-lg"><?php echo $post['category']; ?></span>
                    </div>
                </div>

                <div class="p-8 flex-1 flex flex-col pointer-events-none">
                    <div class="flex items-center gap-3 text-xs text-indigo-400 mb-4 font-mono font-medium tracking-wide">
                        <span><?php echo $post['date']; ?></span>
                        <span class="w-1 h-1 bg-indigo-500 rounded-full opacity-50"></span>
                        <span class="text-slate-500"><?php echo $post['author']; ?></span>
                    </div>
                    <h2 class="text-2xl font-display font-bold text-white mb-4 leading-tight group-hover:text-radar-accent transition-colors"><?php echo $post['title']; ?></h2>
                    <p class="text-sm text-slate-400 leading-relaxed mb-6 font-light"><?php echo $post['excerpt']; ?></p>
                    <div class="mt-auto pt-6 border-t border-white/5 flex justify-between items-center">
                        <span class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2 group-hover:gap-3 transition-all">Ler Insight <svg class="w-4 h-4 text-radar-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($posts)): ?>
            <div class="text-center py-32 border border-dashed border-slate-800 rounded-3xl bg-slate-900/50 backdrop-blur-sm"><p class="text-radar-muted font-mono text-sm">Aguardando dados na pasta /posts...</p></div>
        <?php endif; ?>
    </main>

    <footer class="border-t border-white/5 bg-black/40 py-12 backdrop-blur-md relative z-10 text-center"><p class="text-slate-600 text-xs font-mono uppercase tracking-widest">&copy; <?php echo date('Y'); ?> Radar Cadu Barbosa.</p></footer>

    <div id="reading-modal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-[#05080f]/95 backdrop-blur-xl transition-opacity opacity-0 duration-500" id="modal-backdrop"></div>
        
        <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-0 md:p-6 text-center">
                <div class="relative w-full max-w-4xl transform transition-all opacity-0 scale-95 duration-500" id="modal-panel">
                    
                    <div id="modal-loader" class="absolute inset-0 flex items-center justify-center bg-radar-card z-50 rounded-2xl hidden">
                        <div class="flex flex-col items-center gap-4">
                            <div class="loader"></div>
                            <span class="text-xs font-mono text-radar-accent uppercase tracking-widest">Decodificando Sinal...</span>
                        </div>
                    </div>

                    <button onclick="closeModal()" class="fixed top-6 right-6 z-[60] p-3 rounded-full bg-black/40 text-slate-400 hover:text-white hover:bg-radar-accent hover:rotate-90 transition-all duration-300 border border-white/10 backdrop-blur-md cursor-pointer"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>

                    <div class="bg-[#0f1420] text-left md:rounded-2xl shadow-2xl overflow-hidden border border-white/5 relative min-h-[400px]">
                        <div class="modal-scroll max-h-[100vh] md:max-h-[90vh] overflow-y-auto custom-scroll">
                            
                            <div class="relative h-[40vh] md:h-[50vh] w-full" id="modal-header-area">
                                <img id="modal-img" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0f1420] via-[#0f1420]/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 p-8 md:p-16 w-full max-w-4xl mx-auto">
                                    <div class="flex items-center gap-3 mb-4">
                                        <span id="modal-category" class="px-3 py-1 rounded bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-xs font-bold font-mono uppercase tracking-widest"></span>
                                        <span class="text-slate-400 text-xs font-mono uppercase tracking-widest" id="modal-date"></span>
                                    </div>
                                    <h1 id="modal-title" class="text-3xl md:text-5xl lg:text-6xl font-display font-bold text-white leading-[1.1]"></h1>
                                </div>
                            </div>

                            <div class="px-6 py-12 md:px-16 md:py-16 bg-[#0f1420]">
                                <div class="max-w-2xl mx-auto">
                                    <div id="modal-body" class="prose prose-lg prose-invert max-w-none"></div>
                                    
                                    <div class="mt-20 pt-10 border-t border-white/5">
                                        <p class="text-xs font-mono text-slate-500 uppercase tracking-widest mb-6 text-center">Transmitir Sinal</p>
                                        <div class="flex justify-center gap-4">
                                            <a id="share-whatsapp" target="_blank" class="p-3 rounded-full bg-white/5 text-slate-300 hover:bg-[#25D366] hover:text-white transition-all">WhatsApp</a>
                                            <a id="share-linkedin" target="_blank" class="p-3 rounded-full bg-white/5 text-slate-300 hover:bg-[#0077b5] hover:text-white transition-all">LinkedIn</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const modal = document.getElementById('reading-modal');
        const modalBackdrop = document.getElementById('modal-backdrop');
        const modalPanel = document.getElementById('modal-panel');
        const loader = document.getElementById('modal-loader');
        const body = document.body;

        // Filter Logic
        function filterPosts(cat) {
            const btns = document.querySelectorAll('.filter-btn');
            btns.forEach(btn => {
                if(btn.dataset.filter === cat) {
                    btn.classList.add('bg-radar-accent', 'text-white', 'shadow-lg');
                    btn.classList.remove('text-radar-muted', 'hover:bg-white/5', 'border-transparent');
                } else {
                    btn.classList.remove('bg-radar-accent', 'text-white', 'shadow-lg');
                    btn.classList.add('text-radar-muted', 'hover:bg-white/5', 'border-transparent');
                }
            });
            document.querySelectorAll('.post-card').forEach(card => {
                if (cat === 'all' || card.dataset.category === cat) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // NEW: AJAX Load Function
        function loadPost(fileId) {
            // 1. Open Modal & Show Loader
            modal.classList.remove('hidden');
            body.style.overflow = 'hidden';
            loader.classList.remove('hidden');
            
            // Fade In Animation
            requestAnimationFrame(() => {
                modalBackdrop.classList.remove('opacity-0');
                modalPanel.classList.remove('opacity-0', 'scale-95');
                modalPanel.classList.add('opacity-100', 'scale-100');
            });

            // 2. Fetch Data from same file
            fetch(`index.php?get_post=${fileId}`)
                .then(response => response.json())
                .then(data => {
                    if(data.error) {
                        alert("Erro: " + data.error);
                        closeModal();
                        return;
                    }
                    
                    // 3. Populate Data
                    document.getElementById('modal-title').textContent = data.title;
                    document.getElementById('modal-category').textContent = data.category;
                    document.getElementById('modal-date').textContent = data.date;
                    document.getElementById('modal-body').innerHTML = data.content;
                    
                    const imgEl = document.getElementById('modal-img');
                    if(data.image) {
                        imgEl.src = data.image;
                        imgEl.parentElement.style.display = 'block';
                    } else {
                        imgEl.parentElement.style.display = 'none';
                    }

                    // Update Share Links
                    const url = window.location.href;
                    document.getElementById('share-whatsapp').href = `https://wa.me/?text=${encodeURIComponent(data.title)}%20${url}`;
                    document.getElementById('share-linkedin').href = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;

                    // 4. Hide Loader
                    setTimeout(() => {
                        loader.classList.add('hidden');
                    }, 300); // Pequeno delay artificial para suavidade
                })
                .catch(err => {
                    console.error(err);
                    alert("Erro de conexão ao buscar o insight.");
                    closeModal();
                });
        }

        function closeModal() {
            modalBackdrop.classList.add('opacity-0');
            modalPanel.classList.remove('opacity-100', 'scale-100');
            modalPanel.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                body.style.overflow = 'auto';
                loader.classList.add('hidden'); // Reset loader
            }, 500);
        }

        modalBackdrop.addEventListener('click', closeModal);
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
    </script>
</body>
</html>