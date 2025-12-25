<?php
// =================================================================================
// ENGINE MARKDOWN PARA PHP (RADAR ELITE VERSION - FIX 1.1)
// =================================================================================

require_once 'Parsedown.php'; 

$site_config = [
    'title' => 'RADAR | Cadu Barbosa',
    'subtitle' => 'Curadoria estratégica de conteúdo, tecnologia e inovação.',
    'url' => 'https://radar.cadubarbosa.com.br',
    'external_links' => [
        'Site Oficial' => 'https://www.cadubarbosa.com.br',
        'Blog' => 'https://www.cadubarbosa.com.br/blog'
    ]
];

// Lógica de Leitura de Posts
function getPosts() {
    $files = glob("posts/*.md");
    $posts = [];
    $Parsedown = new Parsedown();

    foreach ($files as $file) {
        $content = file_get_contents($file);
        $pattern = "/^---\s*\r?\n(.*?)\r?\n---\s*\r?\n(.*)$/s";
        
        if (preg_match($pattern, $content, $matches)) {
            $rawMetadata = $matches[1];
            $rawBody = $matches[2];
            $meta = [];
            $lines = explode("\n", $rawMetadata);
            foreach ($lines as $line) {
                if (strpos($line, ':') !== false) {
                    list($key, $value) = explode(':', $line, 2);
                    $meta[trim($key)] = trim($value);
                }
            }
            $posts[] = [
                'id' => basename($file),
                'category' => $meta['category'] ?? 'Geral',
                'title' => $meta['title'] ?? 'Sem Título',
                'image' => $meta['image'] ?? '',
                'date' => $meta['date'] ?? '',
                'author' => $meta['author'] ?? 'Admin',
                'excerpt' => $meta['excerpt'] ?? '',
                'content' => $Parsedown->text($rawBody)
            ];
        }
    }
    // Ordenação por Data (Mais recente primeiro)
    usort($posts, function($a, $b) {
        // Tenta converter datas portuguesas/inglesas para timestamp
        $dateA = strtotime(str_replace('/', '-', $a['date']));
        $dateB = strtotime(str_replace('/', '-', $b['date']));
        return $dateB - $dateA;
    });
    return $posts;
}

$posts = getPosts();
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
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                        display: ['Space Grotesk', 'sans-serif'],
                    },
                    colors: {
                        radar: {
                            bg: '#0B0F19',
                            card: '#151B2B',
                            border: '#2A3441',
                            accent: '#6366f1',
                            glow: '#818cf8',
                            text: '#e2e8f0',
                            muted: '#94a3b8'
                        }
                    },
                    animation: {
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <style>
        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px), linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            mask-image: radial-gradient(circle at center, black 40%, transparent 100%); 
            -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 100%);
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0B0F19; }
        ::-webkit-scrollbar-thumb { background: #2A3441; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #6366f1; }

        .glass-nav { background: rgba(11, 15, 25, 0.85); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .glass-card { background: rgba(21, 27, 43, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .glass-card:hover { transform: translateY(-4px); border-color: rgba(99, 102, 241, 0.4); box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 0.15); }

        .prose p { margin-bottom: 1.75em; line-height: 1.85; color: #cbd5e1; font-size: 1.125rem; font-weight: 300; }
        .prose h1, .prose h2, .prose h3 { color: #f8fafc; font-family: 'Space Grotesk', sans-serif; letter-spacing: -0.02em; margin-top: 2em; }
        .prose strong { color: #fff; font-weight: 600; }
        .prose blockquote { border-left-color: #6366f1; background: rgba(99,102,241,0.05); color: #a5b4fc; border-radius: 0 8px 8px 0; }
        .prose ul li::marker { color: #6366f1; }
        .prose code { color: #818cf8; background: rgba(99,102,241,0.1); padding: 2px 6px; border-radius: 4px; font-weight: 400; }
        .prose img { border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body class="bg-radar-bg text-radar-text antialiased min-h-screen relative selection:bg-radar-accent selection:text-white overflow-x-hidden">

    <div class="fixed inset-0 z-[-1] pointer-events-none">
        <div class="absolute inset-0 bg-grid-pattern opacity-60"></div>
        <div class="absolute top-[-10%] left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-radar-accent/10 blur-[120px] rounded-full mix-blend-screen"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-blue-500/5 blur-[100px] rounded-full mix-blend-screen"></div>
    </div>

    <header class="fixed top-0 w-full z-40 glass-nav transition-all duration-300">
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

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3 group cursor-pointer" onclick="window.scrollTo(0,0)">
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
            <?php foreach ($posts as $index => $post): ?>
            <article class="post-card break-inside-avoid glass-card rounded-2xl overflow-hidden cursor-pointer group relative flex flex-col" 
                     data-category="<?php echo $post['category']; ?>"
                     onclick="openModal(<?php echo $index; ?>)">
                
                <div class="relative aspect-[16/10] overflow-hidden">
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

                <div class="p-8 flex-1 flex flex-col">
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
            <div class="text-center py-32 border border-dashed border-slate-800 rounded-3xl bg-slate-900/50 backdrop-blur-sm">
                <p class="text-radar-muted font-mono text-sm">Aguardando dados na pasta /posts...</p>
            </div>
        <?php endif; ?>
    </main>

    <footer class="border-t border-white/5 bg-black/40 py-12 backdrop-blur-md relative z-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-600 text-xs font-mono uppercase tracking-widest">&copy; <?php echo date('Y'); ?> Radar Cadu Barbosa. <span class="text-indigo-900/50 mx-2">|</span> All Systems Nominal.</p>
        </div>
    </footer>

    <div id="reading-modal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-[#05080f]/95 backdrop-blur-xl transition-opacity opacity-0 duration-500" id="modal-backdrop"></div>
        <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-0 md:p-6 text-center">
                <div class="relative w-full max-w-4xl transform transition-all opacity-0 scale-95 duration-500" id="modal-panel">
                    <div class="fixed top-0 left-0 w-full md:w-[calc(100%-3rem)] md:left-6 md:top-6 md:rounded-t-2xl h-1 z-50 bg-slate-800/50 overflow-hidden pointer-events-none"><div id="read-progress" class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 w-0 shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div></div>
                    <button onclick="closeModal()" class="fixed top-6 right-6 z-50 p-3 rounded-full bg-black/20 text-slate-400 hover:text-white hover:bg-radar-accent hover:rotate-90 transition-all duration-300 border border-white/10 backdrop-blur-md group"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    <div class="bg-[#0f1420] text-left md:rounded-2xl shadow-2xl overflow-hidden border border-white/5 relative">
                        <div class="modal-scroll max-h-[100vh] md:max-h-[90vh] overflow-y-auto custom-scroll">
                            <div class="relative h-[40vh] md:h-[50vh] w-full group">
                                <img id="modal-img" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0f1420] via-[#0f1420]/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 p-8 md:p-16 w-full max-w-4xl mx-auto">
                                    <div class="flex items-center gap-3 mb-4 opacity-0 translate-y-4 animate-[fadeUp_0.8s_0.2s_forwards]">
                                        <span id="modal-category" class="px-3 py-1 rounded bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-xs font-bold font-mono uppercase tracking-widest"></span>
                                        <span class="text-slate-400 text-xs font-mono uppercase tracking-widest" id="modal-date"></span>
                                    </div>
                                    <h1 id="modal-title" class="text-3xl md:text-5xl lg:text-6xl font-display font-bold text-white leading-[1.1] opacity-0 translate-y-4 animate-[fadeUp_0.8s_0.3s_forwards]"></h1>
                                </div>
                            </div>
                            <div class="px-6 py-12 md:px-16 md:py-16 bg-[#0f1420]">
                                <div class="max-w-2xl mx-auto">
                                    <div class="flex items-center gap-4 mb-12 pb-8 border-b border-white/5 opacity-0 translate-y-4 animate-[fadeUp_0.8s_0.4s_forwards]">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">C</div>
                                        <div><p class="text-white font-bold text-sm">Cadu Barbosa</p><p class="text-slate-500 text-xs">Curador & Estrategista</p></div>
                                    </div>
                                    <div id="modal-body" class="prose prose-lg prose-invert max-w-none opacity-0 translate-y-4 animate-[fadeUp_0.8s_0.5s_forwards]"></div>
                                    <div class="mt-20 pt-10 border-t border-white/5 opacity-0 translate-y-4 animate-[fadeUp_0.8s_0.6s_forwards]">
                                        <p class="text-xs font-mono text-slate-500 uppercase tracking-widest mb-6 text-center">Transmitir Sinal</p>
                                        <div class="flex justify-center gap-4">
                                            <a id="share-whatsapp" target="_blank" class="p-3 rounded-full bg-white/5 text-slate-300 border border-white/5 hover:bg-[#25D366] hover:text-white hover:border-[#25D366] transition-all duration-300 hover:scale-110"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.008-.57-.008-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg></a>
                                            <a id="share-linkedin" target="_blank" class="p-3 rounded-full bg-white/5 text-slate-300 border border-white/5 hover:bg-[#0077b5] hover:text-white hover:border-[#0077b5] transition-all duration-300 hover:scale-110"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
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

    <style>@keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }</style>
    <script>
        // 1. DADOS BLINDADOS (Carregados via JS, não via HTML attribute)
        const postsData = <?php echo json_encode($posts); ?>;
        
        const modal = document.getElementById('reading-modal');
        const modalBackdrop = document.getElementById('modal-backdrop');
        const modalPanel = document.getElementById('modal-panel');
        const progressBar = document.getElementById('read-progress');
        const body = document.body;

        function filterPosts(cat) {
            const cards = document.querySelectorAll('.post-card');
            const btns = document.querySelectorAll('.filter-btn');
            
            btns.forEach(btn => {
                const isActive = btn.dataset.filter === cat;
                if(isActive) {
                    btn.classList.add('bg-radar-accent', 'text-white', 'shadow-lg');
                    btn.classList.remove('text-radar-muted', 'hover:bg-white/5', 'border-transparent');
                } else {
                    btn.classList.remove('bg-radar-accent', 'text-white', 'shadow-lg');
                    btn.classList.add('text-radar-muted', 'hover:bg-white/5', 'border-transparent');
                }
            });

            cards.forEach(card => {
                if (cat === 'all' || card.dataset.category === cat) {
                    card.style.display = 'flex';
                    setTimeout(() => card.style.opacity = '1', 50);
                } else {
                    card.style.display = 'none';
                    card.style.opacity = '0';
                }
            });
        }

        // 2. FUNÇÃO ATUALIZADA (Recebe apenas o índice)
        function openModal(index) {
            const post = postsData[index]; // Busca os dados seguros no array
            if(!post) return;

            // Populate
            document.getElementById('modal-title').textContent = post.title;
            document.getElementById('modal-category').textContent = post.category;
            document.getElementById('modal-author').textContent = post.author;
            document.getElementById('modal-date').textContent = post.date;
            
            const imgEl = document.getElementById('modal-img');
            if(post.image) {
                imgEl.src = post.image;
                imgEl.style.display = 'block';
            } else {
                imgEl.style.display = 'none';
            }
            
            document.getElementById('modal-body').innerHTML = post.content;

            // Share URLs
            const url = encodeURIComponent(window.location.href);
            document.getElementById('share-whatsapp').href = `https://wa.me/?text=${encodeURIComponent(post.title)}%20${url}`;
            document.getElementById('share-linkedin').href = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;

            // Open Animation
            modal.classList.remove('hidden');
            body.style.overflow = 'hidden'; 
            
            requestAnimationFrame(() => {
                modalBackdrop.classList.remove('opacity-0');
                modalPanel.classList.remove('opacity-0', 'scale-95');
                modalPanel.classList.add('opacity-100', 'scale-100');
            });
        }

        function closeModal() {
            modalBackdrop.classList.add('opacity-0');
            modalPanel.classList.remove('opacity-100', 'scale-100');
            modalPanel.classList.add('opacity-0', 'scale-95');
            setTimeout(() => { modal.classList.add('hidden'); body.style.overflow = 'auto'; }, 500);
        }

        modalBackdrop.addEventListener('click', closeModal);
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

        document.querySelector('.modal-scroll').addEventListener('scroll', function() {
            const scrollTop = this.scrollTop;
            const scrollHeight = this.scrollHeight - this.clientHeight;
            const percent = (scrollTop / scrollHeight) * 100;
            progressBar.style.width = percent + '%';
        });
    </script>
</body>
</html>
