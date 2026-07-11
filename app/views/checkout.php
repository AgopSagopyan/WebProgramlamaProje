<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeatVision - Akıllı Salon Tasarımcısı</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { 50: '#f0f7ff', 100: '#e0effe', 500: '#0284c7', 600: '#0369a1', 700: '#075985' },
                        slate: { 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 700: '#334155', 900: '#0f172a' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .canvas-grid {
            background-size: 20px 20px;
            background-image: linear-gradient(to right, #e2e8f0 1px, transparent 1px),
                              linear-gradient(to bottom, #e2e8f0 1px, transparent 1px);
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="h-screen flex flex-col overflow-hidden text-slate-900 selection:bg-brand-100 selection:text-brand-700">

    <!-- BİLDİRİM (TOAST) KONTEYNERİ -->
    <div id="toast-container" class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- ÜST BAR -->
    <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 shrink-0 z-20 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="bg-brand-500 text-white p-2 rounded-lg flex items-center justify-center shadow-md shadow-brand-500/20">
                <i class="fa-solid fa-bezier-curve text-lg"></i>
            </div>
            <div>
                <h1 class="text-md font-extrabold tracking-tight text-slate-900">SeatVision <span class="text-brand-500 font-medium text-xs bg-brand-50 px-2 py-0.5 rounded-full border border-brand-100 ml-1">Pro</span></h1>
                <p class="text-xs text-slate-500 font-medium">Akıllı Bağlama & Işın İzleme</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button id="btn-export-dxf" class="flex items-center gap-2 px-3 py-1.5 text-xs font-semibold text-white bg-slate-800 border border-slate-700 rounded-lg hover:bg-slate-900 transition-colors shadow-sm">
                <i class="fa-solid fa-file-export"></i> DWG/DXF İndir
            </button>
            <button class="flex items-center gap-2 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-50 border border-slate-200 rounded-lg hover:bg-slate-100 transition-colors">
                <i class="fa-solid fa-floppy-disk text-slate-400"></i> Taslağı Kaydet
            </button>
        </div>
    </header>

    <!-- ANA ÇALIŞMA ALANI -->
    <main class="flex flex-1 overflow-hidden w-full relative">
        
        <!-- SOL PANEL -->
        <section class="w-80 bg-white border-r border-slate-200 flex flex-col h-full shrink-0 shadow-sm overflow-y-auto z-10">
            
            <!-- Araç Kutusu -->
            <div class="p-5 border-b border-slate-100">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-toolbox text-slate-400"></i> Özellikler & Araçlar
                </h2>
                
                <!-- Masa Kapasitesi -->
                <div class="mb-3">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-brand-600 mb-1.5 flex items-center gap-1"><i class="fa-solid fa-users"></i> Kapasite (Boyut)</label>
                    <div class="flex bg-slate-100 p-1 rounded-lg">
                        <button id="cap-4" class="cap-btn flex-1 text-xs font-semibold py-1.5 rounded-md bg-white text-brand-700 shadow-sm transition-all border border-slate-200" data-val="4">4 Kişilik (Küçük)</button>
                        <button id="cap-6" class="cap-btn flex-1 text-xs font-semibold py-1.5 rounded-md text-slate-500 hover:text-slate-700 transition-all border border-transparent" data-val="6">6 Kişilik (Büyük)</button>
                    </div>
                </div>

                <!-- Masa Şekli -->
                <div class="mb-5">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-brand-600 mb-1.5 flex items-center gap-1"><i class="fa-solid fa-shapes"></i> Masa Şekli</label>
                    <div class="flex bg-slate-100 p-1 rounded-lg">
                        <button id="shape-round" class="shape-btn flex-1 text-xs font-semibold py-1.5 rounded-md bg-white text-brand-700 shadow-sm transition-all border border-slate-200" data-val="round">Yuvarlak</button>
                        <button id="shape-rect" class="shape-btn flex-1 text-xs font-semibold py-1.5 rounded-md text-slate-500 hover:text-slate-700 transition-all border border-transparent" data-val="rect">Düz (Dikdörtgen)</button>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 mb-3">
                    <button id="tool-table" class="tool-btn flex flex-col items-center justify-center gap-2 p-3 bg-brand-50 border border-brand-300 text-brand-700 rounded-xl transition-all font-bold text-xs shadow-inner">
                        <i class="fa-solid fa-circle text-lg"></i> Masa Ekle
                    </button>
                    <button id="tool-chair" class="tool-btn flex flex-col items-center justify-center gap-2 p-3 bg-white border border-slate-200 text-slate-500 rounded-xl hover:bg-slate-50 transition-all font-semibold text-xs shadow-sm">
                        <i class="fa-solid fa-chair text-lg"></i> Sandalye Ekle
                    </button>
                    <button id="tool-column" class="tool-btn col-span-2 flex flex-col items-center justify-center gap-2 p-3 bg-white border border-slate-200 text-slate-500 rounded-xl hover:bg-slate-50 transition-all font-semibold text-xs shadow-sm">
                        <i class="fa-solid fa-square text-lg"></i> Kolon Çiz
                    </button>
                </div>
                
                <p class="text-[10px] text-slate-400 mt-2 leading-relaxed"><i class="fa-solid fa-link text-brand-500"></i> <b>Akıllı Bağlama:</b> Sandalyeleri masaya yakın bırakın. Masayı sürüklediğinizde sandalyeler de onunla gelir.</p>
            </div>

            <!-- Optimizasyon Paneli -->
            <div class="p-5 border-b border-slate-100 bg-brand-50/20">
                <button id="btn-auto-arrange" class="w-full bg-white border border-brand-200 hover:bg-brand-50 text-brand-600 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm flex items-center justify-center gap-2 transition-all">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Örnek Düzen Oluştur
                </button>
                <button id="btn-clear" class="w-full mt-2 text-slate-500 hover:text-red-500 font-semibold text-xs py-2 px-4 transition-colors">
                    Sahneyi Temizle
                </button>
            </div>

            <!-- Gerçek Zamanlı Analiz -->
            <div class="p-5 flex-1 flex flex-col justify-end">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400">Görüş Analizi</h2>
                    <span id="vision-status" class="bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 rounded-full">KUSURSUZ</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                        <p class="text-[10px] font-semibold text-slate-400 uppercase">Masa / Sandalye</p>
                        <p class="text-xl font-extrabold text-slate-800 mt-0.5"><span id="stat-tables">0</span> <span class="text-sm text-slate-400 font-medium">/</span> <span id="stat-chairs">0</span></p>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                        <p class="text-[10px] font-semibold text-slate-400 uppercase">Kör Nokta</p>
                        <p id="stat-blocked" class="text-xl font-extrabold text-red-500 mt-0.5">0</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SAĞ TUVAL ALANI (CANVAS) -->
        <section class="flex-1 bg-slate-100 flex flex-col p-6 overflow-hidden relative select-none">
            
            <div class="absolute top-10 left-12 z-10 bg-white/90 border border-slate-200 rounded-xl px-4 py-2 flex flex-col gap-2 shadow-sm backdrop-blur-sm text-xs font-medium text-slate-600 pointer-events-none">
                <div class="flex gap-4">
                    <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm"></span> Görüş Açık (Sahneyi Görüyor)</div>
                    <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-sm"></span> Görüş Kapalı (Kolon Çarpması)</div>
                </div>
            </div>

            <div class="w-full h-full flex items-center justify-center overflow-auto">
                <div class="relative bg-white shadow-md border border-slate-200 rounded-2xl overflow-hidden shadow-slate-200/50">
                    <canvas id="designer-canvas" width="1000" height="700" class="canvas-grid block cursor-default"></canvas>
                </div>
            </div>
        </section>

    </main>

    <script>
        const canvas = document.getElementById('designer-canvas');
        const ctx = canvas.getContext('2d');
        
        // --- TEMEL VERİLER VE AYARLAR ---
        let tables = [];   // Masalar: {x, y, capacity, shape, w, h, r}
        let chairs = [];   // Sandalyeler: {x, y, angle}
        let columns = [];  // Kolonlar: {x, y}
        
        let currentTool = 'table';
        let currentCapacity = 4;
        let currentShape = 'round';
        
        // Sürükleme State'leri
        let isDragging = false;
        let draggedTableIndex = null;
        let draggedChairIndex = null;
        let draggedColumnIndex = null;
        let dragOffset = { x: 0, y: 0 };
        let draggedBoundChairs = []; // Masayla birlikte sürüklenen sandalyeler

        // Sabitler ve Masa Özellikleri
        const stage = { x: canvas.width / 2, y: 70, width: 320, height: 50 };
        const columnSize = 45;
        const chairSize = { w: 14, h: 14 }; 
        const ATTACH_ZONE = 35; // Sandalyenin masaya bağlanma tolerans mesafesi

        // Kapasite ve şekle göre boyutlar (Fark edilir büyüklük farkları)
        const TABLE_PROPS = {
            4: {
                round: { r: 24 },
                rect: { w: 50, h: 50 }
            },
            6: {
                round: { r: 38 }, // 6 kişilik yuvarlak masa daha büyük
                rect: { w: 90, h: 50 } // 6 kişilik düz masa daha geniş
            }
        };

        // UI Elementleri
        const statTables = document.getElementById('stat-tables');
        const statChairs = document.getElementById('stat-chairs');
        const statBlocked = document.getElementById('stat-blocked');
        const visionStatus = document.getElementById('vision-status');

        // Bildirim Sistemi (Toast)
        function showToast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            let colorClasses = type === 'error' ? 'bg-red-500 text-white' : 
                               type === 'success' ? 'bg-emerald-500 text-white' : 
                               'bg-brand-500 text-white';
                               
            let icon = type === 'error' ? '<i class="fa-solid fa-triangle-exclamation"></i>' : 
                       type === 'success' ? '<i class="fa-solid fa-check-circle"></i>' :
                       '<i class="fa-solid fa-circle-info"></i>';
            
            toast.className = `px-5 py-3 rounded-xl shadow-lg shadow-slate-900/10 text-sm font-semibold transition-all duration-300 transform -translate-y-4 opacity-0 flex items-center gap-3 ${colorClasses}`;
            toast.innerHTML = `${icon} ${message}`;
            container.appendChild(toast);

            requestAnimationFrame(() => toast.classList.remove('-translate-y-4', 'opacity-0'));

            setTimeout(() => {
                toast.classList.add('opacity-0', '-translate-y-4');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // --- UI KONTROLLERİ ---
        
        // Kapasite Seçici
        document.querySelectorAll('.cap-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                currentCapacity = parseInt(e.target.dataset.val);
                document.querySelectorAll('.cap-btn').forEach(b => {
                    b.classList.remove('bg-white', 'text-brand-700', 'shadow-sm', 'border-slate-200');
                    b.classList.add('text-slate-500', 'border-transparent');
                });
                e.target.classList.add('bg-white', 'text-brand-700', 'shadow-sm', 'border-slate-200');
                e.target.classList.remove('text-slate-500', 'border-transparent');
            });
        });

        // Şekil Seçici
        document.querySelectorAll('.shape-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                currentShape = e.target.dataset.val;
                document.querySelectorAll('.shape-btn').forEach(b => {
                    b.classList.remove('bg-white', 'text-brand-700', 'shadow-sm', 'border-slate-200');
                    b.classList.add('text-slate-500', 'border-transparent');
                });
                e.target.classList.add('bg-white', 'text-brand-700', 'shadow-sm', 'border-slate-200');
                e.target.classList.remove('text-slate-500', 'border-transparent');
            });
        });

        // Araç Seçimi
        const tools = ['table', 'chair', 'column'];
        tools.forEach(tool => {
            const el = document.getElementById(`tool-${tool}`);
            if(el) {
                el.addEventListener('click', () => {
                    currentTool = tool;
                    tools.forEach(t => {
                        const btn = document.getElementById(`tool-${t}`);
                        if(!btn) return;
                        if (t === tool) {
                            btn.className = "tool-btn flex flex-col items-center justify-center gap-2 p-3 bg-brand-50 border border-brand-300 text-brand-700 rounded-xl transition-all font-bold text-xs shadow-inner";
                            if(t === 'column') btn.classList.add('col-span-2');
                        } else {
                            btn.className = "tool-btn flex flex-col items-center justify-center gap-2 p-3 bg-white border border-slate-200 text-slate-500 rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all font-semibold text-xs shadow-sm";
                            if(t === 'column') btn.classList.add('col-span-2');
                        }
                    });
                    canvas.style.cursor = tool === 'column' ? 'crosshair' : 'default';
                });
            }
        });

        // --- AKILLI BAĞLAMA VE KAPASİTE MOTORU ---
        
        // Verilen (x,y) koordinatının bir masanın bağlanma alanı içinde olup olmadığını kontrol eder
        function isPointInTableZone(x, y, t) {
            if (t.shape === 'round') {
                return Math.hypot(t.x - x, t.y - y) <= t.r + ATTACH_ZONE;
            } else {
                return (x >= t.x - t.w/2 - ATTACH_ZONE && x <= t.x + t.w/2 + ATTACH_ZONE && 
                        y >= t.y - t.h/2 - ATTACH_ZONE && y <= t.y + t.h/2 + ATTACH_ZONE);
            }
        }

        // Masaya bağlı olan sandalyelerin indexlerini döndürür
        function getBoundChairs(tableIndex) {
            let t = tables[tableIndex];
            let bound = [];
            for (let i = 0; i < chairs.length; i++) {
                if (isPointInTableZone(chairs[i].x, chairs[i].y, t)) {
                    bound.push(i);
                }
            }
            return bound;
        }

        // Sandalye eklerken / bırakırken kapasite kurallarını denetler
        function validateAndBindChair(x, y, excludeChairIndex = -1) {
            let nearestTable = null;
            let nearestTableIndex = -1;
            let minDist = Infinity;
            
            // 1. En yakın masayı bul (Bağlanma alanı içindeyse)
            for(let i = 0; i < tables.length; i++) {
                let t = tables[i];
                if (isPointInTableZone(x, y, t)) {
                    let d = Math.hypot(t.x - x, t.y - y);
                    if (d < minDist) {
                        minDist = d;
                        nearestTable = t;
                        nearestTableIndex = i;
                    }
                }
            }

            // Eğer yakında masa yoksa boşluğa konuyordur, serbesttir.
            if(!nearestTable) return { valid: true, msg: null }; 

            // 2. Bu masaya bağlı diğer sandalyeleri say
            let count = 0;
            for(let i = 0; i < chairs.length; i++) {
                if (i === excludeChairIndex) continue; // Kendisini sayma
                if (isPointInTableZone(chairs[i].x, chairs[i].y, nearestTable)) count++;
            }

            // 3. Kapasite Kontrolü ve Mesaj Üretimi
            if (count >= nearestTable.capacity) {
                return { valid: false, msg: `Bu masa ${nearestTable.capacity} kişiliktir, kapasite dolu!`, type: 'error' };
            }

            let remaining = nearestTable.capacity - (count + 1); // +1 konulan sandalyeyi temsil eder
            let msg = remaining > 0 
                ? `Bağlandı! Buraya ${remaining} sandalye daha koyulabilir.`
                : `Masaya tam kapasite sandalye bağlandı.`;
            
            let type = remaining > 0 ? 'info' : 'success';

            return { valid: true, msg: msg, type: type };
        }

        // --- MATEMATİK & ÇARPIŞMA (RAYCASTING) ---
        function getIntersection(rayOrigin, rayDir, p1, p2) {
            const rpx = rayOrigin.x, rpy = rayOrigin.y, rdx = rayDir.x, rdy = rayDir.y;
            const spx = p1.x, spy = p1.y, sdx = p2.x - p1.x, sdy = p2.y - p1.y;
            const cross = rdx * sdy - rdy * sdx;
            if (Math.abs(cross) < 0.0001) return null;
            const t1 = ((spx - rpx) * sdy - (spy - rpy) * sdx) / cross;
            const t2 = ((spx - rpx) * rdy - (spy - rpy) * rdx) / cross;
            if (t1 >= 0 && t2 >= 0 && t2 <= 1) return { t: t1, x: rpx + rdx * t1, y: rpy + rdy * t1 };
            return null;
        }

        function getRectIntersection(rayOrigin, rayDir, rect) {
            const left = rect.x - rect.w/2, right = rect.x + rect.w/2;
            const top = rect.y - rect.h/2, bottom = rect.y + rect.h/2;
            const segments = [ [{x: left, y: top}, {x: right, y: top}], [{x: right, y: top}, {x: right, y: bottom}],
                               [{x: right, y: bottom}, {x: left, y: bottom}], [{x: left, y: bottom}, {x: left, y: top}] ];
            let minT = Infinity, hit = null;
            for (let seg of segments) {
                let inter = getIntersection(rayOrigin, rayDir, seg[0], seg[1]);
                if (inter && inter.t < minT) { minT = inter.t; hit = inter; }
            }
            return hit;
        }

        function roundRectPolyfill(ctx, x, y, w, h, r) {
            if (w < 2 * r) r = w / 2; if (h < 2 * r) r = h / 2;
            ctx.beginPath(); ctx.moveTo(x + r, y);
            ctx.arcTo(x + w, y, x + w, y + h, r); ctx.arcTo(x + w, y + h, x, y + h, r);
            ctx.arcTo(x, y + h, x, y, r); ctx.arcTo(x, y, x + w, y, r); ctx.closePath();
        }

        // --- ÇİZİM MOTORU ---
        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // 1. Sahne
            ctx.save();
            ctx.shadowBlur = 15; ctx.shadowColor = 'rgba(0,0,0,0.1)';
            ctx.fillStyle = '#ffffff'; ctx.strokeStyle = '#94a3b8'; ctx.lineWidth = 2;
            roundRectPolyfill(ctx, stage.x - stage.width/2, stage.y - stage.height/2, stage.width, stage.height, 12); 
            ctx.fill(); ctx.stroke();
            ctx.fillStyle = '#0f172a'; ctx.font = 'bold 14px Inter'; ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
            ctx.fillText("ANA SAHNE", stage.x, stage.y);
            ctx.restore();

            // 2. Kolonlar
            columns.forEach(col => {
                ctx.save();
                ctx.fillStyle = '#334155'; ctx.shadowBlur = 15; ctx.shadowColor = 'rgba(0,0,0,0.15)';
                ctx.fillRect(col.x - columnSize/2, col.y - columnSize/2, columnSize, columnSize);
                ctx.strokeStyle = '#475569'; ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(col.x - columnSize/2, col.y - columnSize/2); ctx.lineTo(col.x + columnSize/2, col.y + columnSize/2);
                ctx.moveTo(col.x + columnSize/2, col.y - columnSize/2); ctx.lineTo(col.x - columnSize/2, col.y + columnSize/2);
                ctx.stroke(); ctx.restore();
            });

            // 3. Masalar
            tables.forEach(table => {
                ctx.save();
                ctx.translate(table.x, table.y);
                ctx.fillStyle = '#ffffff';
                ctx.strokeStyle = '#0284c7';
                ctx.lineWidth = 3;
                ctx.shadowBlur = 8;
                ctx.shadowColor = 'rgba(2, 132, 199, 0.15)';
                
                // Şekle Göre Çizim
                if (table.shape === 'round') {
                    ctx.beginPath();
                    ctx.arc(0, 0, table.r, 0, Math.PI * 2);
                    ctx.fill(); ctx.stroke();
                } else {
                    roundRectPolyfill(ctx, -table.w/2, -table.h/2, table.w, table.h, 8);
                    ctx.fill(); ctx.stroke();
                }
                
                // Kapasite metni
                ctx.fillStyle = '#0284c7'; ctx.font = 'bold 14px Inter';
                ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
                ctx.fillText(table.capacity, 0, 1);
                
                // Gizli Bağlantı Alanı (Sadece geliştirici / gözlem için istenirse açılabilir)
                // ctx.beginPath(); ctx.strokeStyle = 'rgba(0,0,0,0.05)';
                // if(table.shape === 'round') ctx.arc(0, 0, table.r + ATTACH_ZONE, 0, Math.PI*2);
                // else roundRectPolyfill(ctx, -table.w/2 - ATTACH_ZONE, -table.h/2 - ATTACH_ZONE, table.w + ATTACH_ZONE*2, table.h + ATTACH_ZONE*2, 10);
                // ctx.stroke();

                ctx.restore();
            });

            // 4. Sandalyeler ve Işınlar
            let blockedCount = 0;
            
            chairs.forEach((chair, index) => {
                let dir = { x: Math.cos(chair.angle), y: Math.sin(chair.angle) };
                let colHitT = Infinity;
                for (let col of columns) {
                    let hit = getRectIntersection(chair, dir, {x: col.x, y: col.y, w: columnSize, h: columnSize});
                    if (hit && hit.t < colHitT) colHitT = hit.t;
                }
                let stageHit = getRectIntersection(chair, dir, {x: stage.x, y: stage.y, w: stage.width, h: stage.height});
                let stageHitT = stageHit ? stageHit.t : Infinity;

                let status = 'miss'; 
                let rayDistance = 800; 

                if (colHitT < stageHitT) {
                    status = 'blocked'; rayDistance = colHitT; blockedCount++;
                } else if (stageHitT < Infinity) {
                    status = 'clear'; rayDistance = stageHitT;
                }

                // Işın
                ctx.save();
                ctx.beginPath();
                ctx.moveTo(chair.x, chair.y);
                ctx.lineTo(chair.x + dir.x * rayDistance, chair.y + dir.y * rayDistance);
                if (status === 'clear') { ctx.strokeStyle = 'rgba(16, 185, 129, 0.4)'; ctx.setLineDash([5, 5]); } 
                else if (status === 'blocked') { ctx.strokeStyle = 'rgba(239, 68, 68, 0.6)'; ctx.setLineDash([4, 4]); } 
                else { ctx.strokeStyle = 'rgba(148, 163, 184, 0.2)'; }
                ctx.lineWidth = 2; ctx.stroke(); ctx.restore();

                // Sandalye
                ctx.save();
                ctx.translate(chair.x, chair.y);
                ctx.rotate(chair.angle); 
                if (status === 'clear') ctx.fillStyle = '#10b981'; 
                else if (status === 'blocked') ctx.fillStyle = '#ef4444'; 
                else ctx.fillStyle = '#cbd5e1'; 

                roundRectPolyfill(ctx, -chairSize.w/2, -chairSize.h/2, chairSize.w, chairSize.h, 3); ctx.fill();
                ctx.fillStyle = 'rgba(0,0,0,0.3)';
                roundRectPolyfill(ctx, -chairSize.w/2 - 2, -chairSize.h/2 + 1, 4, chairSize.h - 2, 2); ctx.fill();
                ctx.restore();
            });

            // Metrik Güncellemeleri
            statTables.innerText = tables.length; statChairs.innerText = chairs.length; statBlocked.innerText = blockedCount;
            if (chairs.length === 0) {
                visionStatus.innerText = "BEKLENİYOR";
                visionStatus.className = "bg-slate-100 text-slate-500 text-[9px] font-bold px-2 py-0.5 rounded-full";
            } else if (blockedCount > 0) {
                visionStatus.innerText = "KÖR NOKTA TESPİTİ";
                visionStatus.className = "bg-red-100 text-red-700 text-[9px] font-bold px-2 py-0.5 rounded-full";
            } else {
                visionStatus.innerText = "KUSURSUZ GÖRÜŞ";
                visionStatus.className = "bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 rounded-full";
            }
        }

        // --- FARE KONTROLLERİ ---
        
        window.addEventListener('mouseup', () => {
            if (draggedChairIndex !== null) {
                let c = chairs[draggedChairIndex];
                let val = validateAndBindChair(c.x, c.y, draggedChairIndex);
                if (!val.valid) {
                    showToast(val.msg, val.type);
                    c.x = c.origX; c.y = c.origY; // Geri sekme
                    c.angle = Math.atan2(stage.y - c.y, stage.x - c.x);
                } else if (val.msg && (c.x !== c.origX || c.y !== c.origY)) {
                    showToast(val.msg, val.type);
                }
            }
            isDragging = false; draggedTableIndex = null; draggedChairIndex = null; draggedColumnIndex = null; draggedBoundChairs = [];
            draw();
        });

        canvas.addEventListener('mousemove', (e) => {
            const rect = canvas.getBoundingClientRect();
            const mx = e.clientX - rect.left;
            const my = e.clientY - rect.top;
            
            if (isDragging) {
                if (draggedChairIndex !== null) {
                    chairs[draggedChairIndex].x = mx - dragOffset.x;
                    chairs[draggedChairIndex].y = my - dragOffset.y;
                    chairs[draggedChairIndex].angle = Math.atan2(stage.y - chairs[draggedChairIndex].y, stage.x - chairs[draggedChairIndex].x);
                } else if (draggedTableIndex !== null) {
                    let t = tables[draggedTableIndex];
                    t.x = mx - dragOffset.x;
                    t.y = my - dragOffset.y;
                    // Masaya bağlı sandalyeleri de beraberinde taşı!
                    draggedBoundChairs.forEach(bc => {
                        let c = chairs[bc.index];
                        c.x = t.x + bc.offX;
                        c.y = t.y + bc.offY;
                        c.angle = Math.atan2(stage.y - c.y, stage.x - c.x); // Giderken de sahneye baksınlar
                    });
                } else if (draggedColumnIndex !== null) {
                    columns[draggedColumnIndex].x = mx - dragOffset.x;
                    columns[draggedColumnIndex].y = my - dragOffset.y;
                }
            } else {
                let hitAny = false;
                for (let i = chairs.length - 1; i >= 0; i--) {
                    if (Math.hypot(chairs[i].x - mx, chairs[i].y - my) < chairSize.w + 10) { hitAny = true; break; }
                }
                if(!hitAny){
                    for (let i = tables.length - 1; i >= 0; i--) {
                        if(tables[i].shape === 'round') {
                            if (Math.hypot(tables[i].x - mx, tables[i].y - my) < tables[i].r + 5) { hitAny = true; break; }
                        } else {
                            if (mx >= tables[i].x - tables[i].w/2 && mx <= tables[i].x + tables[i].w/2 &&
                                my >= tables[i].y - tables[i].h/2 && my <= tables[i].y + tables[i].h/2) { hitAny = true; break; }
                        }
                    }
                }
                canvas.style.cursor = hitAny ? 'pointer' : (currentTool === 'column' ? 'crosshair' : 'default');
            }
            draw();
        });

        canvas.addEventListener('mousedown', (e) => {
            const rect = canvas.getBoundingClientRect();
            const mx = e.clientX - rect.left;
            const my = e.clientY - rect.top;
            let hit = false;

            // 1. Sandalye Seçimi
            for (let i = chairs.length - 1; i >= 0; i--) {
                if (Math.hypot(chairs[i].x - mx, chairs[i].y - my) < chairSize.w + 10) {
                    isDragging = true; draggedChairIndex = i;
                    chairs[i].origX = chairs[i].x; chairs[i].origY = chairs[i].y;
                    dragOffset.x = mx - chairs[i].x; dragOffset.y = my - chairs[i].y;
                    hit = true; break;
                }
            }

            // 2. Masa Seçimi (Bağlı Sandalyeleri hesapla)
            if (!hit) {
                for (let i = tables.length - 1; i >= 0; i--) {
                    let t = tables[i];
                    let hitTable = false;
                    if(t.shape === 'round') {
                        if(Math.hypot(t.x - mx, t.y - my) < t.r + 5) hitTable = true;
                    } else {
                        if(mx >= t.x - t.w/2 && mx <= t.x + t.w/2 && my >= t.y - t.h/2 && my <= t.y + t.h/2) hitTable = true;
                    }

                    if (hitTable) {
                        isDragging = true; draggedTableIndex = i;
                        dragOffset.x = mx - t.x; dragOffset.y = my - t.y;
                        
                        // Bağlı sandalyeleri bul ve ofsetlerini kaydet ki masayla sürükleyelim
                        draggedBoundChairs = [];
                        let boundIndices = getBoundChairs(i);
                        boundIndices.forEach(idx => {
                            draggedBoundChairs.push({
                                index: idx,
                                offX: chairs[idx].x - t.x,
                                offY: chairs[idx].y - t.y
                            });
                        });
                        
                        hit = true; break;
                    }
                }
            }

            // 3. Kolon Seçimi
            if (!hit) {
                for (let i = columns.length - 1; i >= 0; i--) {
                    let col = columns[i];
                    if (mx > col.x - columnSize/2 && mx < col.x + columnSize/2 && my > col.y - columnSize/2 && my < col.y + columnSize/2) {
                        isDragging = true; draggedColumnIndex = i;
                        dragOffset.x = mx - col.x; dragOffset.y = my - col.y;
                        hit = true; break;
                    }
                }
            }

            // 4. Boşluğa Tıklama -> Yeni Nesne Ekleme
            if (!hit && my > 120) {
                if (currentTool === 'table') {
                    let props = TABLE_PROPS[currentCapacity][currentShape];
                    tables.push({ 
                        x: mx, y: my, 
                        capacity: currentCapacity, 
                        shape: currentShape,
                        w: props.w || 0, h: props.h || 0, r: props.r || 0
                    });
                } else if (currentTool === 'chair') {
                    let val = validateAndBindChair(mx, my);
                    if (!val.valid) { showToast(val.msg, val.type); return; }
                    if (val.msg) showToast(val.msg, val.type);
                    
                    chairs.push({ x: mx, y: my, angle: Math.atan2(stage.y - my, stage.x - mx) });
                } else if (currentTool === 'column') {
                    columns.push({ x: mx, y: my });
                }
                draw();
            }
        });

        // --- BUTON İŞLEVLERİ ---
        document.getElementById('btn-auto-arrange').addEventListener('click', () => {
            tables = []; chairs = []; columns = [];
            
            // Yuvarlak Masa Örneği
            tables.push({x: stage.x - 180, y: 300, capacity: 6, shape: 'round', r: 38});
            // Dikdörtgen Masa Örneği
            tables.push({x: stage.x + 180, y: 300, capacity: 6, shape: 'rect', w: 90, h: 50});

            tables.forEach(t => {
                for(let i=0; i < t.capacity; i++) {
                    let angle = (i * Math.PI * 2) / t.capacity;
                    let dist = (t.shape === 'round' ? t.r : 30) + 20;
                    let cx = t.x + dist * Math.cos(angle);
                    let cy = t.y + dist * Math.sin(angle);
                    if(t.shape === 'rect') { cx = t.x + (i%3 - 1)*35; cy = t.y + (i<3?-1:1)*40; }
                    chairs.push({x: cx, y: cy, angle: Math.atan2(stage.y - cy, stage.x - cx)});
                }
            });
            draw();
        });

        document.getElementById('btn-clear').addEventListener('click', () => {
            tables = []; chairs = []; columns = []; draw();
        });

        document.getElementById('btn-export-dxf').addEventListener('click', () => {
            let dxf = `0\nSECTION\n2\nENTITIES\n`;
            function addLine(x1, y1, x2, y2, color) { dxf += `0\nLINE\n8\n0\n62\n${color}\n10\n${x1}\n20\n${-y1}\n11\n${x2}\n21\n${-y2}\n`; }
            function addCircle(x, y, r, color) { dxf += `0\nCIRCLE\n8\n0\n62\n${color}\n10\n${x}\n20\n${-y}\n40\n${r}\n`; }
            
            let sx1 = stage.x - stage.width/2, sy1 = stage.y - stage.height/2;
            let sx2 = stage.x + stage.width/2, sy2 = stage.y + stage.height/2;
            addLine(sx1, sy1, sx2, sy1, 2); addLine(sx2, sy1, sx2, sy2, 2); addLine(sx2, sy2, sx1, sy2, 2); addLine(sx1, sy2, sx1, sy1, 2);
            
            tables.forEach(t => {
                if(t.shape === 'round') addCircle(t.x, t.y, t.r, 4);
                else {
                    let tx1 = t.x - t.w/2, ty1 = t.y - t.h/2, tx2 = t.x + t.w/2, ty2 = t.y + t.h/2;
                    addLine(tx1, ty1, tx2, ty1, 4); addLine(tx2, ty1, tx2, ty2, 4); addLine(tx2, ty2, tx1, ty2, 4); addLine(tx1, ty2, tx1, ty1, 4);
                }
            });
            chairs.forEach(c => { addCircle(c.x, c.y, 7, 3); addLine(c.x, c.y, c.x + 10 * Math.cos(c.angle), c.y + 10 * Math.sin(c.angle), 3); });
            
            dxf += `0\nENDSEC\n0\nEOF\n`;
            const blob = new Blob([dxf], { type: 'application/dxf' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a'); a.href = url; a.download = 'seatvision_layout_final.dxf';
            a.click(); URL.revokeObjectURL(url);
        });

        // Başlat
        draw();
    </script>
</body>
</html>