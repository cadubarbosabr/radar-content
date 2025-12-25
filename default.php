<?php
// =================================================================================
// RADAR: VERSÃO "ZERO FAIL" (TEMPLATES OCULTOS)
// =================================================================================

// 1. Carrega Biblioteca (com fallback se falhar)
if (file_exists('Parsedown.php')) {
    require_once 'Parsedown.php';
    $Parsedown = new Parsedown();
} else {
    // Fallback simples se não tiver a lib, para não quebrar o site
    class Parsedown { function text($t) { return "<p>" . nl2br($t) . "</p>"; } }
    $Parsedown = new Parsedown();
}

$site_config = [
    'title' => 'RADAR | Cadu Barbosa',
    'subtitle' => 'Curadoria estratégica de conteúdo, tecnologia e inovação. Sem riscos, só oportunidades.',
    'external_links' => [
        'Site Oficial' => 'https://www.cadubarbosa.com.br',
        'Blog' => 'https://www.cadubarbosa.com.br/blog',
        'LinkedIN' => 'https://www.linkedin.com/in/cbarbosa9/'
    ]
];

// 2. Leitura dos Arquivos (Sem frescura de JSON)
$posts = [];
$files = glob("posts/*.md");

if ($files) {
    foreach ($files as $file) {
        $content = file_get_contents($file);
        
        // Limpeza de codificação (previne caracteres estranhos do Windows)
        if (!mb_check_encoding($content, 'UTF-8')) {
            $content = mb_convert_encoding($content, 'UTF-8', 'ISO-8859-1');
        }

        // Regex para separar Header e Body
        if (preg_match("/^---\s*\r?\n(.*?)\r?\n---\s*\r?\n(.*)$/s", $content, $matches)) {
            $rawMeta = $matches[1];
            $rawBody = $matches[2];
            
            $meta = [];
            $lines = explode("\n", $rawMeta);
            foreach ($lines as $line) {
                if (strpos($line, ':') !== false) {
                    list($k, $v) = explode(':', $line, 2);
                    $meta[trim($k)] = trim(str_replace(['"', "'"], '', trim($v)));
                }
            }

            // ID único baseado no nome do arquivo (sem extensão)
            $id = md5(basename($file)); 

            $posts[] = [
                'id' => $id, 
                'category' => $meta['category'] ?? 'Geral',
                'title' => $meta['title'] ?? 'Sem Título',
                'date' => $meta['date'] ?? '',
                'author' => $meta['author'] ?? 'Radar',
                'image' => $meta['image'] ?? '',
                'excerpt' => $meta['excerpt'] ?? '',
                'html_content' => $Parsedown->text($rawBody) // HTML PRONTO
            ];
        }
    }
    
    // Ordenar
    usort($posts, function($a, $b) {
        return strtotime(str_replace('/', '-', $b['date'])) - strtotime(str_replace('/', '-', $a['date']));
    });
}

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
                    colors: { radar: { bg: '#0B0F19', card: '#151B2B', border: '#2A3441', accent: '#6366f1', text: '#e2e8f0', muted: '#94a3b8' } },
                    animation: { 'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite' }
                }
            }
        }
    </script>
    <style>
        .bg-grid-pattern { background-image: linear-gradient(to right, rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 40px 40px; mask-image: radial-gradient(circle at center, black 40%, transparent 100%); -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 100%); }
        ::-webkit-scrollbar { width: 6px; background: #0B0F19; } ::-webkit-scrollbar-thumb { background: #2A3441; border-radius: 3px; }
        .glass-nav { background: rgba(11, 15, 25, 0.85); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255,255,255,0.05); }
        .glass-card { background: rgba(21, 27, 43, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.05); box-shadow: 0 4px 30px rgba(0,0,0,0.1); transition: all 0.4s ease; }
        .glass-card:hover { transform: translateY(-4px); border-color: rgba(99, 102, 241, 0.4); }
        .prose p { color: #cbd5e1; font-weight: 300; line-height: 1.8; margin-bottom: 1.5em; }
        .prose h1, .prose h2 { color: #fff; font-family: 'Space Grotesk'; margin-top: 1.5em; }
        .prose img { border-radius: 8px; }
        .prose a { color: #6366f1; text-decoration: underline; }
    </style>
</head>
<body class="bg-radar-bg text-radar-text antialiased min-h-screen relative selection:bg-radar-accent selection:text-white">

    <div class="fixed inset-0 z-[-1] pointer-events-none">
        <div class="absolute inset-0 bg-grid-pattern opacity-60"></div>
        <div class="absolute top-[-10%] left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-radar-accent/10 blur-[120px] rounded-full mix-blend-screen"></div>
    </div>

    <header class="fixed top-0 w-full z-40 glass-nav">
        <div class="border-b border-white/5 bg-black/20">
            <div class="max-w-7xl mx-auto px-4 h-10 flex items-center justify-end gap-6 text-xs font-mono uppercase">
                <span class="text-radar-muted opacity-50 hidden sm:block">/// TERMINAL ACCESS</span>
                <?php foreach($site_config['external_links'] as $label => $link): ?>
                    <a href="<?php echo $link; ?>" target="_blank" class="text-radar-muted hover:text-radar-accent transition-colors flex items-center gap-1 group">
                        <?php echo $label; ?> <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3 cursor-pointer" onclick="window.scrollTo(0,0)">
                <div class="w-8 h-8 rounded-full bg-radar-accent flex items-center justify-center shadow-[0_0_15px_rgba(99,102,241,0.8)]"><div class="w-2 h-2 bg-white rounded-full"></div></div>
                <div><span class="text-xl font-display font-bold leading-none block">RADAR</span><span class="text-[10px] font-mono text-radar-accent uppercase tracking-widest block mt-1">Cadu Barbosa</span></div>
            </div>
            <nav class="flex gap-2 bg-white/5 p-1 rounded-full backdrop-blur-sm border border-white/5">
                <button onclick="filterPosts('all')" class="filter-btn px-4 py-2 rounded-full text-xs font-bold uppercase bg-radar-accent text-white shadow-lg" data-filter="all">All</button>
                <?php foreach ($categories as $cat): ?>
                <button onclick="filterPosts('<?php echo $cat; ?>')" class="filter-btn px-4 py-2 rounded-full text-xs font-bold uppercase text-radar-muted hover:bg-white/5" data-filter="<?php echo $cat; ?>"><?php echo $cat; ?></button>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 pt-48 pb-32">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-mono uppercase tracking-widest mb-6">
                <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span></span> System Online
            </div>
            <h1 class="text-4xl md:text-6xl font-display font-bold text-transparent bg-clip-text bg-gradient-to-b from-white to-slate-400 mb-6">Inteligência | Sinais | Ação</h1>
            <p class="text-lg text-radar-muted font-light max-w-2xl mx-auto"><?php echo $site_config['subtitle']; ?></p>
        </div>

        <div class="columns-1 md:columns-2 lg:columns-3 gap-8 space-y-8">
            <?php foreach ($posts as $post): ?>
            <article class="post-card break-inside-avoid glass-card rounded-2xl overflow-hidden cursor-pointer group flex flex-col relative z-10" 
                     data-category="<?php echo $post['category']; ?>"
                     onclick="openPost('<?php echo $post['id']; ?>')"> <div class="relative aspect-[16/10] overflow-hidden">
                    <?php if($post['image']): ?>
                    <img src="<?php echo $post['image']; ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <?php else: ?>
                    <div class="w-full h-full bg-slate-800 flex items-center justify-center text-xs text-slate-600 font-mono">NO IMAGE</div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-radar-card to-transparent opacity-80"></div>
                    <span class="absolute top-4 left-4 px-3 py-1 bg-black/60 border border-white/10 text-white text-[10px] font-bold font-mono uppercase rounded shadow-lg"><?php echo $post['category']; ?></span>
                </div>
                
                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex items-center gap-3 text-xs text-indigo-400 mb-4 font-mono">
                        <span><?php echo $post['date']; ?></span><span class="w-1 h-1 bg-indigo-500 rounded-full opacity-50"></span><span><?php echo $post['author']; ?></span>
                    </div>
                    <h2 class="text-2xl font-display font-bold text-white mb-4 leading-tight group-hover:text-radar-accent transition-colors"><?php echo $post['title']; ?></h2>
                    <p class="text-sm text-slate-400 leading-relaxed mb-6 font-light line-clamp-3"><?php echo $post['excerpt']; ?></p>
                    <div class="mt-auto pt-6 border-t border-white/5 text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">Ler Insight <span class="text-radar-accent">→</span></div>
                </div>
            </article>

            <template id="template-<?php echo $post['id']; ?>">
                <div class="hidden-data">
                    <div class="data-title"><?php echo $post['title']; ?></div>
                    <div class="data-category"><?php echo $post['category']; ?></div>
                    <div class="data-date"><?php echo $post['date']; ?></div>
                    <div class="data-author"><?php echo $post['author']; ?></div>
                    <div class="data-image"><?php echo $post['image']; ?></div>
                    <div class="data-body"><?php echo $post['html_content']; ?></div> </div>
            </template>
            <?php endforeach; ?>
        </div>

        <?php if (empty($posts)): ?>
            <div class="text-center py-20 border border-dashed border-slate-800 rounded-2xl"><p class="text-radar-muted font-mono">Nenhum post encontrado em /posts</p></div>
        <?php endif; ?>
    </main>

    <footer class="border-t border-white/5 bg-black/40 py-12 text-center text-slate-600 text-xs font-mono uppercase tracking-widest">&copy; <?php echo date('Y'); ?> Radar Cadu Barbosa.</footer>

    <div id="modal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-[#05080f]/95 backdrop-blur-xl transition-opacity opacity-0 duration-500" id="modal-backdrop"></div>
        <div class="absolute inset-0 overflow-y-auto">
            <div class="min-h-full flex items-center justify-center p-0 md:p-6">
                <div class="relative w-full max-w-4xl bg-[#0f1420] md:rounded-2xl shadow-2xl border border-white/5 opacity-0 scale-95 transition-all duration-300 transform" id="modal-panel">
                    
                    <button onclick="closeModal()" class="fixed top-6 right-6 z-50 p-3 rounded-full bg-black/40 text-white hover:bg-radar-accent border border-white/10 transition-colors cursor-pointer">✕</button>
                    
                    <div class="relative">
                        <div class="h-[40vh] relative w-full" id="area-img-container">
                            <img id="view-img" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0f1420] via-[#0f1420]/60 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-8 md:p-12 w-full">
                                <span id="view-category" class="px-2 py-1 bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-xs font-bold font-mono uppercase tracking-widest mb-3 inline-block"></span>
                                <h1 id="view-title" class="text-3xl md:text-5xl font-display font-bold text-white leading-tight"></h1>
                                <div class="mt-4 text-slate-400 text-xs font-mono uppercase"><span id="view-date"></span> • <span id="view-author"></span></div>
                            </div>
                        </div>

                        <div class="px-6 py-10 md:px-16 md:py-16">
                            <div id="view-body" class="prose prose-lg prose-invert max-w-2xl mx-auto"></div>
                            
                            <div class="mt-16 pt-8 border-t border-white/5 text-center">
                                <p class="text-xs font-mono text-slate-500 uppercase tracking-widest mb-4">Share Signal</p>
                                <div class="flex justify-center gap-4">
                                    <a id="btn-wa" target="_blank" class="p-2 bg-white/5 rounded text-slate-300 hover:text-white hover:bg-[#25D366]">WhatsApp</a>
                                    <a id="btn-li" target="_blank" class="p-2 bg-white/5 rounded text-slate-300 hover:text-white hover:bg-[#0077b5]">LinkedIn</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Lógica Simplificada: Pegar HTML do template e jogar no Modal
        const modal = document.getElementById('modal');
        const backdrop = document.getElementById('modal-backdrop');
        const panel = document.getElementById('modal-panel');
        const body = document.body;

        function openPost(id) {
            // Busca o template escondido pelo ID
            const template = document.getElementById('template-' + id);
            if (!template) {
                console.error('Template not found for id:', id);
                return;
            }

            // Pega o conteúdo de dentro do template
            const content = template.content.querySelector('.hidden-data');
            
            // Preenche o Modal
            document.getElementById('view-title').textContent = content.querySelector('.data-title').textContent;
            document.getElementById('view-category').textContent = content.querySelector('.data-category').textContent;
            document.getElementById('view-date').textContent = content.querySelector('.data-date').textContent;
            document.getElementById('view-author').textContent = content.querySelector('.data-author').textContent;
            document.getElementById('view-body').innerHTML = content.querySelector('.data-body').innerHTML;

            // Imagem
            const imgUrl = content.querySelector('.data-image').textContent;
            const imgContainer = document.getElementById('area-img-container');
            const imgEl = document.getElementById('view-img');
            
            if (imgUrl && imgUrl.trim() !== '') {
                imgEl.src = imgUrl;
                imgContainer.style.display = 'block';
            } else {
                imgContainer.style.display = 'none';
            }

            // Links de Share
            const url = window.location.href;
            const title = content.querySelector('.data-title').textContent;
            document.getElementById('btn-wa').href = `https://wa.me/?text=${encodeURIComponent(title)} ${url}`;
            document.getElementById('btn-li').href = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;

            // Abre Modal
            modal.classList.remove('hidden');
            body.style.overflow = 'hidden';
            
            // Animação CSS simples
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'scale-95');
                panel.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        function closeModal() {
            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'scale-100');
            panel.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                body.style.overflow = 'auto';
            }, 300);
        }

        // Filtro
        function filterPosts(cat) {
            document.querySelectorAll('.post-card').forEach(el => {
                el.style.display = (cat === 'all' || el.dataset.category === cat) ? 'flex' : 'none';
            });
            document.querySelectorAll('.filter-btn').forEach(btn => {
                if(btn.dataset.filter === cat) {
                    btn.classList.add('bg-radar-accent', 'text-white', 'shadow-lg');
                    btn.classList.remove('text-radar-muted');
                } else {
                    btn.classList.remove('bg-radar-accent', 'text-white', 'shadow-lg');
                    btn.classList.add('text-radar-muted');
                }
            });
        }
    </script>
</body>
</html>