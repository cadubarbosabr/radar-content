<?php
// =================================================================================
// RADAR: VERSÃO "ZERO FAIL" (VISUAL IDENTITY: CADU BARBOSA)
// =================================================================================

// 1. Carrega Biblioteca (com fallback)
if (file_exists('Parsedown.php')) {
    require_once 'Parsedown.php';
    $Parsedown = new Parsedown();
} else {
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

// 2. Leitura dos Arquivos
$posts = [];
$files = glob("posts/*.md");

if ($files) {
    foreach ($files as $file) {
        $content = file_get_contents($file);
        
        // Limpeza de codificação
        if (!mb_check_encoding($content, 'UTF-8')) {
            $content = mb_convert_encoding($content, 'UTF-8', 'ISO-8859-1');
        }

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

            $id = md5(basename($file)); 

            $posts[] = [
                'id' => $id, 
                'category' => $meta['category'] ?? 'Geral',
                'title' => $meta['title'] ?? 'Sem Título',
                'date' => $meta['date'] ?? '',
                'author' => $meta['author'] ?? 'Radar',
                'image' => $meta['image'] ?? '',
                'excerpt' => $meta['excerpt'] ?? '',
                'html_content' => $Parsedown->text($rawBody)
            ];
        }
    }
    
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
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'], // Fonte principal agora é Roboto
                        display: ['Roboto', 'sans-serif'],
                    },
                    colors: {
                        radar: {
                            gold: '#D3A656', // RGB 211,166,86 Convertido
                            dark: '#0a0a0a',
                            card: '#121212',
                            text: '#f3f4f6',
                            muted: '#9ca3af'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Estilização Customizada */
        ::-webkit-scrollbar { width: 6px; background: #000; } 
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #D3A656; }

        /* Glassmorphism mais neutro/escuro */
        .glass-nav { 
            background: rgba(0, 0, 0, 0.85); 
            backdrop-filter: blur(12px); 
            border-bottom: 1px solid rgba(211, 166, 86, 0.1); /* Borda Dourada Sutil */
        }
        
        .glass-card { 
            background: rgba(20, 20, 20, 0.7); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.05); 
            transition: all 0.3s ease; 
        }
        
        .glass-card:hover { 
            transform: translateY(-4px); 
            border-color: #D3A656; /* Borda Dourada no Hover */
            box-shadow: 0 10px 30px -10px rgba(211, 166, 86, 0.15);
        }

        /* Tipografia do Conteúdo (Roboto) */
        .prose p { color: #d1d5db; font-weight: 300; line-height: 1.8; margin-bottom: 1.5em; font-family: 'Roboto', sans-serif; }
        .prose h1, .prose h2, .prose h3 { color: #fff; font-weight: 700; margin-top: 1.5em; }
        .prose strong { color: #D3A656; font-weight: 700; }
        .prose a { color: #D3A656; text-decoration: none; border-bottom: 1px solid rgba(211, 166, 86, 0.3); transition: border-color 0.2s; }
        .prose a:hover { border-bottom-color: #D3A656; }
        .prose blockquote { border-left: 3px solid #D3A656; color: #9ca3af; font-style: italic; padding-left: 1rem; }
    </style>
</head>
<body class="bg-radar-dark text-radar-text antialiased min-h-screen relative selection:bg-radar-gold selection:text-black">

    <div class="fixed inset-0 z-[-1]">
        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920&auto=format&fit=crop" class="w-full h-full object-cover opacity-30 grayscale-[50%]">
        <div class="absolute inset-0 bg-gradient-to-b from-black via-black/80 to-black"></div>
    </div>

    <header class="fixed top-0 w-full z-40 glass-nav">
        <div class="border-b border-white/5 bg-black/40">
            <div class="max-w-7xl mx-auto px-4 h-10 flex items-center justify-end gap-6 text-xs font-bold uppercase tracking-wider">
                <?php foreach($site_config['external_links'] as $label => $link): ?>
                    <a href="<?php echo $link; ?>" target="_blank" class="text-radar-muted hover:text-radar-gold transition-colors flex items-center gap-1 group font-roboto">
                        <?php echo $label; ?> <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3 cursor-pointer group" onclick="window.scrollTo(0,0)">
                <div class="w-10 h-10 border-2 border-radar-gold flex items-center justify-center transition-transform group-hover:rotate-45">
                    <div class="w-4 h-4 bg-radar-gold"></div>
                </div>
                <div>
                    <span class="text-xl font-bold leading-none block tracking-wide">RADAR</span>
                    <span class="text-[10px] text-radar-gold uppercase tracking-[0.2em] block mt-1 font-bold">Cadu Barbosa</span>
                </div>
            </div>
            
            <nav class="flex gap-2 p-1">
                <button onclick="filterPosts('all')" class="filter-btn px-5 py-2 text-xs font-bold uppercase bg-radar-gold text-black shadow-lg hover:brightness-110 transition-all tracking-wider" data-filter="all">Todos</button>
                <?php foreach ($categories as $cat): ?>
                <button onclick="filterPosts('<?php echo $cat; ?>')" class="filter-btn px-5 py-2 text-xs font-bold uppercase text-radar-muted border border-white/10 hover:border-radar-gold hover:text-radar-gold transition-all tracking-wider" data-filter="<?php echo $cat; ?>"><?php echo $cat; ?></button>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 pt-48 pb-32">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <div class="inline-flex items-center gap-2 px-3 py-1 border border-radar-gold/30 text-radar-gold text-[10px] font-bold uppercase tracking-widest mb-6">
                <span class="w-2 h-2 bg-radar-gold rounded-full animate-pulse"></span> Intelligence Hub
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 tracking-tight">Inteligência | Sinais | Ação</h1>
            <p class="text-lg text-radar-muted font-light max-w-2xl mx-auto"><?php echo $site_config['subtitle']; ?></p>
        </div>

        <div class="columns-1 md:columns-2 lg:columns-3 gap-8 space-y-8">
            <?php foreach ($posts as $post): ?>
            <article class="post-card break-inside-avoid glass-card cursor-pointer group flex flex-col relative z-10" 
                     data-category="<?php echo $post['category']; ?>"
                     onclick="openPost('<?php echo $post['id']; ?>')">
                
                <div class="relative aspect-[16/10] overflow-hidden bg-black">
                    <?php if($post['image']): ?>
                    <img src="<?php echo $post['image']; ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-xs text-slate-600">NO IMAGE</div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90"></div>
                    <span class="absolute top-4 left-4 px-3 py-1 bg-radar-gold text-black text-[10px] font-bold uppercase tracking-wider"><?php echo $post['category']; ?></span>
                </div>
                
                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex items-center gap-3 text-xs text-radar-muted mb-4 font-medium uppercase tracking-wider">
                        <span><?php echo $post['date']; ?></span><span class="text-radar-gold">•</span><span><?php echo $post['author']; ?></span>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-4 leading-tight group-hover:text-radar-gold transition-colors"><?php echo $post['title']; ?></h2>
                    <p class="text-sm text-gray-400 leading-relaxed mb-6 font-light line-clamp-3"><?php echo $post['excerpt']; ?></p>
                    <div class="mt-auto pt-6 border-t border-white/10 text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">Ler Insight <span class="text-radar-gold transition-transform group-hover:translate-x-1">→</span></div>
                </div>
            </article>

            <template id="template-<?php echo $post['id']; ?>">
                <div class="hidden-data">
                    <div class="data-title"><?php echo $post['title']; ?></div>
                    <div class="data-category"><?php echo $post['category']; ?></div>
                    <div class="data-date"><?php echo $post['date']; ?></div>
                    <div class="data-author"><?php echo $post['author']; ?></div>
                    <div class="data-image"><?php echo $post['image']; ?></div>
                    <div class="data-body"><?php echo $post['html_content']; ?></div>
                </div>
            </template>
            <?php endforeach; ?>
        </div>

        <?php if (empty($posts)): ?>
            <div class="text-center py-20 border border-dashed border-white/10"><p class="text-radar-muted">Nenhum post encontrado em /posts</p></div>
        <?php endif; ?>
    </main>

    <footer class="border-t border-white/10 bg-black/60 py-12 text-center text-gray-500 text-xs font-bold uppercase tracking-widest">&copy; <?php echo date('Y'); ?> Radar Cadu Barbosa.</footer>

    <div id="modal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/95 backdrop-blur-md transition-opacity opacity-0 duration-500" id="modal-backdrop"></div>
        <div class="absolute inset-0 overflow-y-auto">
            <div class="min-h-full flex items-center justify-center p-0 md:p-6">
                <div class="relative w-full max-w-4xl bg-[#0f0f0f] shadow-2xl border border-white/10 opacity-0 scale-95 transition-all duration-300 transform" id="modal-panel">
                    
                    <button onclick="closeModal()" class="fixed top-6 right-6 z-50 p-3 bg-black/50 text-white hover:text-black hover:bg-radar-gold border border-white/10 transition-colors cursor-pointer">✕</button>
                    
                    <div class="relative">
                        <div class="h-[40vh] relative w-full" id="area-img-container">
                            <img id="view-img" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0f0f0f] via-[#0f0f0f]/50 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-8 md:p-12 w-full">
                                <span id="view-category" class="px-2 py-1 bg-radar-gold text-black text-xs font-bold uppercase tracking-widest mb-3 inline-block"></span>
                                <h1 id="view-title" class="text-3xl md:text-5xl font-bold text-white leading-tight"></h1>
                                <div class="mt-4 text-gray-400 text-xs font-bold uppercase tracking-wider"><span id="view-date"></span> • <span id="view-author"></span></div>
                            </div>
                        </div>

                        <div class="px-6 py-10 md:px-16 md:py-16">
                            <div id="view-body" class="prose prose-lg prose-invert max-w-2xl mx-auto"></div>
                            
                            <div class="mt-16 pt-8 border-t border-white/10 text-center">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Compartilhar</p>
                                <div class="flex justify-center gap-2">
                                    <a id="btn-em" target="_blank" class="px-4 py-2 border border-white/10 rounded-none text-gray-300 hover:text-black hover:bg-radar-gold hover:border-radar-gold transition-all text-xs font-bold uppercase">E-Mail</a>
                                    <a id="btn-wa" target="_blank" class="px-4 py-2 border border-white/10 rounded-none text-gray-300 hover:text-black hover:bg-radar-gold hover:border-radar-gold transition-all text-xs font-bold uppercase">WhatsApp</a>
                                    <a id="btn-li" target="_blank" class="px-4 py-2 border border-white/10 rounded-none text-gray-300 hover:text-black hover:bg-radar-gold hover:border-radar-gold transition-all text-xs font-bold uppercase">LinkedIn</a>
                                    <a id="btn-fb" target="_blank" class="px-4 py-2 border border-white/10 rounded-none text-gray-300 hover:text-black hover:bg-radar-gold hover:border-radar-gold transition-all text-xs font-bold uppercase">Facebook</a>
                                    <a id="btn-tw" target="_blank" class="px-4 py-2 border border-white/10 rounded-none text-gray-300 hover:text-black hover:bg-radar-gold hover:border-radar-gold transition-all text-xs font-bold uppercase">X / Twitter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
        const modal = document.getElementById('modal');
        const backdrop = document.getElementById('modal-backdrop');
        const panel = document.getElementById('modal-panel');
        const body = document.body;

        // 1. ABRIR POST (Com Deep Linking)
        function openPost(id) {
            const template = document.getElementById('template-' + id);
            if (!template) return;

            // ATUALIZA URL DO NAVEGADOR (Sem recarregar)
            // Cria uma URL única: radar.com.br/?id=abcde
            const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?id=' + id;
            window.history.pushState({path: newUrl}, '', newUrl);

            // Extrai dados
            const content = template.content.querySelector('.hidden-data');
            const titleRaw = content.querySelector('.data-title').textContent;
            
            // Preenche Visual
            document.getElementById('view-title').textContent = titleRaw;
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

            // GERA LINKS DE SHARE (Usando a newUrl específica)
            const shareUrl = encodeURIComponent(newUrl);
            const shareTitle = encodeURIComponent(titleRaw);

            document.getElementById('btn-wa').href = `https://wa.me/?text=${shareTitle}%20${shareUrl}`;
            document.getElementById('btn-li').href = `https://www.linkedin.com/sharing/share-offsite/?url=${shareUrl}`;
            document.getElementById('btn-fb').href = `https://www.facebook.com/sharer/sharer.php?u=${shareUrl}`;
            document.getElementById('btn-tw').href = `https://twitter.com/intent/tweet?text=${shareTitle}&url=${shareUrl}`;
            document.getElementById('btn-em').href = `mailto:?subject=${shareTitle}&body=${shareTitle}%0A%0ALeia%20aqui:%20${shareUrl}`;

            // Abre Modal
            modal.classList.remove('hidden');
            body.style.overflow = 'hidden';
            
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'scale-95');
                panel.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        // 2. FECHAR POST (Limpa URL)
        function closeModal() {
            // Remove o ?id=... da URL voltando para a home limpa
            const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.pushState({path: cleanUrl}, '', cleanUrl);

            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'scale-100');
            panel.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                body.style.overflow = 'auto';
            }, 300);
        }

        // 3. AUTO-OPEN (Se alguém acessar pelo link direto)
        window.addEventListener('load', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const postId = urlParams.get('id');
            if (postId) {
                // Pequeno delay para garantir que o DOM renderizou
                setTimeout(() => openPost(postId), 100);
            }
        });

        // Utilitários
        function filterPosts(cat) {
            document.querySelectorAll('.post-card').forEach(el => {
                el.style.display = (cat === 'all' || el.dataset.category === cat) ? 'flex' : 'none';
            });
            document.querySelectorAll('.filter-btn').forEach(btn => {
                if(btn.dataset.filter === cat) {
                    btn.classList.add('bg-radar-gold', 'text-black');
                    btn.classList.remove('text-radar-muted', 'border');
                } else {
                    btn.classList.remove('bg-radar-gold', 'text-black');
                    btn.classList.add('text-radar-muted', 'border');
                }
            });
        }

        // Fechar com ESC ou Clique Fora
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
        backdrop.addEventListener('click', closeModal);
    </script>
</body>
</html>