import os

html_content = """<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeatVision - AI Destekli Salon Tasarımcısı</title>
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
        /* Özel Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="h-screen flex flex-col overflow-hidden text-slate-900 selection:bg-brand-100 selection:text-brand-700">

    <!-- ÜST BAR -->
    <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 shrink-0 z-20 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="bg-brand-500 text-white p-2 rounded-lg flex items-center justify-center shadow-md shadow-brand-500/20">
                <i class="fa-solid fa-bezier-curve text-lg"></i>
            </div>
            <div>
                <h1 class="text-md font-extrabold tracking-tight text-slate-900">SeatVision <span class="text-brand-500 font-medium text-xs bg-brand-50 px-2 py-0.5 rounded-full border border-brand-100 ml-1">AI Pro</span></h1>
                <p class="text-xs text-slate-500 font-medium">Javascript Motoru & Yapay Zeka Analizi</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
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
                    <i class="fa-solid fa-toolbox text-slate-400"></i> Çizim Araçları
                </h2>
                <div class="grid grid-cols-2 gap-2">
                    <button id="tool-table" class="flex flex-col items-center justify-center gap-2 p-3 bg-brand-50 border border-brand-200 text-brand-600 rounded-xl transition-all font-semibold text-xs">
                        <i class="fa-solid fa-circle text-lg"></i> Masa Ekle
                    </button>
                    <button id="tool-column" class="flex flex-col items-center justify-center gap-2 p-3 bg-slate-50 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition-all font-semibold text-xs">
                        <i class="fa-solid fa-square text-lg"></i> Kolon Çiz
                    </button>
                </div>
                <p class="text-[10px] text-slate-400 mt-3"><i class="fa-solid fa-info-circle"></i> Seçili araca göre boş alana tıklayarak ekleme yapabilirsiniz.</p>
            </div>

            <!-- Optimizasyon Paneli -->
            <div class="p-5 border-b border-slate-100 bg-brand-50/20">
                <div class="flex items-center gap-2 mb-2">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-brand-600">Akıllı Optimizasyon</h2>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Kolonları algılar, görüşü kapanan masaları eler ve sahneyi merkeze alır.</p>
                <button id="btn-auto-arrange" class="w-full bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs py-3 px-4 rounded-xl shadow-md shadow-brand-500/10 flex items-center justify-center gap-2 transition-all hover:scale-[1.02]">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Otomatik Yerleştir
                </button>
                <button id="btn-clear" class="w-full mt-2 text-slate-500 hover:text-slate-700 font-semibold text-xs py-2 px-4 transition-colors">
                    Sahneyi Temizle
                </button>
            </div>

            <!-- Gerçek Zamanlı Analiz -->
            <div class="p-5 flex-1 flex flex-col justify-end">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400">Durum Analizi</h2>
                    <span id="vision-status" class="bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 rounded-full">KUSURSUZ</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                        <p class="text-[10px] font-semibold text-slate-400 uppercase">Toplam Masa</p>
                        <p id="stat-tables" class="text-xl font-extrabold text-slate-800 mt-0.5">0</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                        <p class="text-[10px] font-semibold text-slate-400 uppercase">Kolon Sayısı</p>
                        <p id="stat-columns" class="text-xl font-extrabold text-slate-800 mt-0.5">0</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SAĞ TUVAL ALANI (CANVAS) -->
        <section class="flex-1 bg-slate-100 flex flex-col p-6 overflow-hidden relative select-none">
            
            <div class="absolute top-10 left-12 z-10 bg-white/90 border border-slate-200 rounded-xl px-4 py-2 flex items-center gap-4 shadow-sm backdrop-blur-sm text-xs font-medium text-slate-600">
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm"></span> Görüş Açık</div>
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-sm"></span> Görüş Kapalı (Kolon)</div>
                <div class="h-4 w-px bg-slate-200"></div>
                <div class="text-slate-400">Masaların üzerine gelerek (hover) analiz edebilirsiniz.</div>
            </div>

            <div class="w-full h-full flex items-center justify-center overflow-auto">
                <div class="relative bg-white shadow-md border border-slate-200 rounded-2xl overflow-hidden shadow-slate-200/50">
                    <canvas id="designer-canvas" width="900" height="650" class="canvas-grid block cursor-crosshair"></canvas>
                </div>
            </div>
        </section>

        <!-- SEATVISION AI CHAT YÜZEN PANEL -->
        <div id="ai-chat-panel" class="absolute bottom-6 right-6 w-80 bg-white rounded-2xl shadow-2xl border border-slate-200 flex flex-col transition-all duration-300 transform translate-y-[calc(100%-4rem)] z-50">
            <!-- Chat Header (Tıklanabilir) -->
            <div id="ai-chat-header" class="bg-brand-600 text-white p-3 rounded-t-2xl flex items-center justify-between cursor-pointer hover:bg-brand-700 transition-colors">
                <div class="flex items-center gap-2">
                    <div class="bg-white/20 p-1.5 rounded-lg"><i class="fa-solid fa-robot text-sm"></i></div>
                    <div>
                        <h3 class="text-xs font-bold">SeatVision Asistanı</h3>
                        <p class="text-[9px] text-brand-100">Mimari & Görüş Tavsiyesi</p>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-up text-xs transition-transform duration-300" id="ai-chat-icon"></i>
            </div>
            <!-- Chat Body -->
            <div class="flex-1 p-4 overflow-y-auto h-64 bg-slate-50 flex flex-col gap-3" id="chat-messages">
                <div class="flex gap-2">
                    <div class="bg-brand-100 text-brand-700 p-2.5 rounded-tr-xl rounded-b-xl text-xs shadow-sm max-w-[85%]">
                        Merhaba Emir! Alan tasarımına kolonları ekledikten sonra masaları dizebilirsin. Bir masanın görüşü kapanırsa kırmızı ile uyaracağım.
                    </div>
                </div>
            </div>
            <!-- Chat Input -->
            <div class="p-3 bg-white border-t border-slate-100 rounded-b-2xl flex gap-2">
                <input type="text" id="chat-input" placeholder="Yapay zekaya danış..." class="flex-1 text-xs border border-slate-200 rounded-lg px-3 py-2 outline-none focus:border-brand-500 bg-slate-50">
                <button id="chat-send" class="bg-brand-500 text-white w-9 h-9 rounded-lg flex items-center justify-center hover:bg-brand-600 transition-colors shadow-sm">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </div>
        </div>

    </main>

    <script>
        const canvas = document.getElementById('designer-canvas');
        const ctx = canvas.getContext('2d');
        
        let tables = [];
        let columns = [];
        
        // Araçlar: 'table' veya 'column'
        let currentTool = 'table';
        const toolTableBtn = document.getElementById('tool-table');
        const toolColumnBtn = document.getElementById('tool-column');
        
        let isDragging = false;
        let draggedTableIndex = null;
        let draggedColumnIndex = null;
        let dragOffset = { x: 0, y: 0 };
        
        let hoveredTableIndex = null;

        // Metrik Elementleri
        const statTables = document.getElementById('stat-tables');
        const statColumns = document.getElementById('stat-columns');
        const visionStatus = document.getElementById('vision-status');

        const stage = { x: canvas.width / 2, y: 70, width: 280, height: 45, focusX: canvas.width / 2, focusY: 70 };
        const tableRadius = 18;
        const columnSize = 40; // 40x40 kare kolon

        // --- ARAÇ SEÇİMİ ---
        toolTableBtn.addEventListener('click', () => setTool('table'));
        toolColumnBtn.addEventListener('click', () => setTool('column'));

        function setTool(tool) {
            currentTool = tool;
            if(tool === 'table') {
                toolTableBtn.className = "flex flex-col items-center justify-center gap-2 p-3 bg-brand-50 border border-brand-200 text-brand-600 rounded-xl transition-all font-semibold text-xs";
                toolColumnBtn.className = "flex flex-col items-center justify-center gap-2 p-3 bg-slate-50 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition-all font-semibold text-xs";
            } else {
                toolColumnBtn.className = "flex flex-col items-center justify-center gap-2 p-3 bg-slate-800 border border-slate-900 text-white rounded-xl transition-all font-semibold text-xs";
                toolTableBtn.className = "flex flex-col items-center justify-center gap-2 p-3 bg-slate-50 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition-all font-semibold text-xs";
            }
        }

        // --- MATEMATİK VE ÇARPIŞMA (RAYCASTING) ---
        // Çizgi ve Dikdörtgen çarpışma tespiti (Kolon arkasında mı?)
        function lineIntersectsRect(x1, y1, x2, y2, rx, ry, rw, rh) {
            // Kolonun sınırları
            const left = rx - rw/2;
            const right = rx + rw/2;
            const top = ry - rh/2;
            const bottom = ry + rh/2;

            // Masanın merkezi (x1, y1) kolonun içindeyse
            if (x1 > left && x1 < right && y1 > top && y1 < bottom) return true;

            // Çizgi kesişimi kontrolleri
            const intersects = (
                lineIntersectsLine(x1, y1, x2, y2, left, top, right, top) || // Üst
                lineIntersectsLine(x1, y1, x2, y2, left, bottom, right, bottom) || // Alt
                lineIntersectsLine(x1, y1, x2, y2, left, top, left, bottom) || // Sol
                lineIntersectsLine(x1, y1, x2, y2, right, top, right, bottom) // Sağ
            );
            return intersects;
        }

        function lineIntersectsLine(x1, y1, x2, y2, x3, y3, x4, y4) {
            const uA = ((x4-x3)*(y1-y3) - (y4-y3)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));
            const uB = ((x2-x1)*(y1-y3) - (y2-y1)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));
            return (uA >= 0 && uA <= 1 && uB >= 0 && uB <= 1);
        }

        // Masanın görüşü temiz mi?
        function isTableViewClear(table) {
            for (let col of columns) {
                if (lineIntersectsRect(table.x, table.y, stage.focusX, stage.focusY, col.x, col.y, columnSize, columnSize)) {
                    return false; // Bir kolon görüşü kesiyor
                }
            }
            return true;
        }

        // --- ÇİZİM MOTORU ---
        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // 1. Sahne
            ctx.save();
            ctx.shadowBlur = 10;
            ctx.shadowColor = 'rgba(0,0,0,0.05)';
            ctx.fillStyle = '#ffffff';
            ctx.strokeStyle = '#cbd5e1';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.roundRect(stage.x - stage.width/2, stage.y - stage.height/2, stage.width, stage.height, 8);
            ctx.fill(); ctx.stroke();
            
            ctx.fillStyle = '#0f172a';
            ctx.font = 'bold 12px Inter';
            ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
            ctx.fillText("SAHNE", stage.x, stage.y);
            
            ctx.fillStyle = '#ef4444';
            ctx.beginPath();
            ctx.arc(stage.focusX, stage.focusY, 5, 0, Math.PI*2);
            ctx.fill();
            ctx.restore();

            // 2. Kolonlar (Engeller)
            columns.forEach(col => {
                ctx.save();
                ctx.fillStyle = '#334155'; // Koyu Slate rengi
                ctx.shadowBlur = 15;
                ctx.shadowColor = 'rgba(0,0,0,0.15)';
                ctx.fillRect(col.x - columnSize/2, col.y - columnSize/2, columnSize, columnSize);
                
                // İç desen (Çapraz çizgiler)
                ctx.strokeStyle = '#475569';
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(col.x - columnSize/2, col.y - columnSize/2);
                ctx.lineTo(col.x + columnSize/2, col.y + columnSize/2);
                ctx.moveTo(col.x + columnSize/2, col.y - columnSize/2);
                ctx.lineTo(col.x - columnSize/2, col.y + columnSize/2);
                ctx.stroke();
                ctx.restore();
            });

            // 3. Masalar ve Etkileşimler
            let blockedCount = 0;
            
            tables.forEach((table, index) => {
                const isClear = isTableViewClear(table);
                if (!isClear) blockedCount++;
                const isHovered = (index === hoveredTableIndex);

                ctx.save();

                // Eğer üzerine gelindiyse (Hover) Işın Çizgisini göster
                if (isHovered) {
                    ctx.strokeStyle = isClear ? '#10b981' : '#ef4444'; // Yeşil veya Kırmızı Işın
                    ctx.lineWidth = 2;
                    ctx.setLineDash([4, 4]);
                    ctx.beginPath();
                    ctx.moveTo(table.x, table.y);
                    ctx.lineTo(stage.focusX, stage.focusY);
                    ctx.stroke();
                    ctx.setLineDash([]);
                }

                ctx.translate(table.x, table.y);
                ctx.rotate(table.angle);

                // Hover Renk Değişimi
                if (isHovered) {
                    ctx.fillStyle = isClear ? '#ecfdf5' : '#fef2f2'; // Hafif yeşil/kırmızı arka plan
                    ctx.strokeStyle = isClear ? '#10b981' : '#ef4444';
                    ctx.lineWidth = 3;
                    ctx.shadowBlur = 15;
                    ctx.shadowColor = isClear ? 'rgba(16, 185, 129, 0.4)' : 'rgba(239, 68, 68, 0.4)';
                } else {
                    ctx.fillStyle = '#ffffff';
                    ctx.strokeStyle = '#0284c7';
                    ctx.lineWidth = 2;
                    ctx.shadowBlur = 5;
                    ctx.shadowColor = 'rgba(0,0,0,0.05)';
                }
                
                ctx.beginPath();
                ctx.arc(0, 0, tableRadius, 0, Math.PI * 2);
                ctx.fill(); ctx.stroke();

                // Yön Oku
                ctx.fillStyle = isHovered ? (isClear ? '#10b981' : '#ef4444') : '#0284c7';
                ctx.beginPath();
                ctx.moveTo(0, -tableRadius - 2);
                ctx.lineTo(-4, -tableRadius + 4);
                ctx.lineTo(4, -tableRadius + 4);
                ctx.closePath();
                ctx.fill();

                ctx.restore();
            });

            // Metrikleri Güncelle
            statTables.innerText = tables.length;
            statColumns.innerText = columns.length;
            
            if (blockedCount > 0) {
                visionStatus.innerText = `${blockedCount} MASA ENGELLİ`;
                visionStatus.className = "bg-red-100 text-red-700 text-[9px] font-bold px-2 py-0.5 rounded-full";
            } else if (tables.length > 0) {
                visionStatus.innerText = "KUSURSUZ GÖRÜŞ";
                visionStatus.className = "bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 rounded-full";
            } else {
                visionStatus.innerText = "BEKLENİYOR";
                visionStatus.className = "bg-slate-100 text-slate-500 text-[9px] font-bold px-2 py-0.5 rounded-full";
            }
        }

        // --- FARE ETKİLEŞİMLERİ ---
        canvas.addEventListener('mousemove', (e) => {
            const rect = canvas.getBoundingClientRect();
            const mx = e.clientX - rect.left;
            const my = e.clientY - rect.top;

            hoveredTableIndex = null;
            canvas.style.cursor = currentTool === 'column' ? 'crosshair' : 'default';

            if (isDragging) {
                if (draggedTableIndex !== null) {
                    let nx = mx - dragOffset.x;
                    let ny = my - dragOffset.y;
                    tables[draggedTableIndex].x = nx;
                    tables[draggedTableIndex].y = ny;
                    tables[draggedTableIndex].angle = Math.atan2(stage.focusY - ny, stage.focusX - nx) + Math.PI/2;
                } else if (draggedColumnIndex !== null) {
                    columns[draggedColumnIndex].x = mx - dragOffset.x;
                    columns[draggedColumnIndex].y = my - dragOffset.y;
                }
            } else {
                // Hover tespiti (Sadece masalar için)
                for (let i = tables.length - 1; i >= 0; i--) {
                    if (Math.hypot(tables[i].x - mx, tables[i].y - my) < tableRadius + 5) {
                        hoveredTableIndex = i;
                        canvas.style.cursor = 'pointer';
                        break; // Sadece en üsttekini al
                    }
                }
            }
            draw();
        });

        canvas.addEventListener('mousedown', (e) => {
            const rect = canvas.getBoundingClientRect();
            const mx = e.clientX - rect.left;
            const my = e.clientY - rect.top;

            let hit = false;

            // Önce masaları kontrol et
            for (let i = tables.length - 1; i >= 0; i--) {
                if (Math.hypot(tables[i].x - mx, tables[i].y - my) < tableRadius + 5) {
                    isDragging = true;
                    draggedTableIndex = i;
                    dragOffset.x = mx - tables[i].x;
                    dragOffset.y = my - tables[i].y;
                    hit = true;
                    setTool('table'); // Tıklanan objeye göre aracı sıfırla
                    break;
                }
            }

            // Sonra kolonları kontrol et
            if (!hit) {
                for (let i = columns.length - 1; i >= 0; i--) {
                    let col = columns[i];
                    if (mx > col.x - columnSize/2 && mx < col.x + columnSize/2 && 
                        my > col.y - columnSize/2 && my < col.y + columnSize/2) {
                        isDragging = true;
                        draggedColumnIndex = i;
                        dragOffset.x = mx - col.x;
                        dragOffset.y = my - col.y;
                        hit = true;
                        setTool('column');
                        break;
                    }
                }
            }

            // Boşluğa tıklandıysa yeni ekle
            if (!hit && my > 120) {
                if (currentTool === 'table') {
                    tables.push({
                        x: mx, y: my,
                        angle: Math.atan2(stage.focusY - my, stage.focusX - mx) + Math.PI/2
                    });
                } else if (currentTool === 'column') {
                    columns.push({ x: mx, y: my });
                }
                draw();
            }
        });

        canvas.addEventListener('mouseup', () => {
            isDragging = false;
            draggedTableIndex = null;
            draggedColumnIndex = null;
            draw();
        });

        // --- AKILLI YERLEŞTİRME (Kolonlardan Kaçınma) ---
        document.getElementById('btn-auto-arrange').addEventListener('click', () => {
            tables = [];
            const rStart = 120, rEnd = 500, spacing = 65;
            
            for (let r = rStart; r <= rEnd; r += spacing) {
                let arcLen = r * (Math.PI * 0.7); // 126 derece yay
                let count = Math.floor(arcLen / 60);
                for (let i = 0; i < count; i++) {
                    let angle = Math.PI * 0.15 + (i * (Math.PI * 0.7) / (count - 1 || 1));
                    let tx = stage.focusX + r * Math.cos(angle);
                    let ty = stage.focusY + r * Math.sin(angle);
                    
                    if (tx > 50 && tx < canvas.width-50 && ty > 130 && ty < canvas.height-50) {
                        let t = { x: tx, y: ty, angle: Math.atan2(stage.focusY - ty, stage.focusX - tx) + Math.PI/2 };
                        // Eğer görüş kapalıysa ekleme! (Yapay Zeka Mantığı)
                        if (isTableViewClear(t)) {
                            tables.push(t);
                        }
                    }
                }
            }
            draw();
        });

        document.getElementById('btn-clear').addEventListener('click', () => {
            tables = []; columns = []; draw();
        });

        // --- AI CHAT PANEL YÖNETİMİ ---
        const chatPanel = document.getElementById('ai-chat-panel');
        const chatHeader = document.getElementById('ai-chat-header');
        const chatIcon = document.getElementById('ai-chat-icon');
        const chatInput = document.getElementById('chat-input');
        const chatSend = document.getElementById('chat-send');
        const chatMessages = document.getElementById('chat-messages');

        let chatOpen = false;

        chatHeader.addEventListener('click', () => {
            chatOpen = !chatOpen;
            if(chatOpen) {
                chatPanel.classList.remove('translate-y-[calc(100%-4rem)]');
                chatIcon.classList.replace('fa-chevron-up', 'fa-chevron-down');
                chatInput.focus();
            } else {
                chatPanel.classList.add('translate-y-[calc(100%-4rem)]');
                chatIcon.classList.replace('fa-chevron-down', 'fa-chevron-up');
            }
        });

        function appendMessage(text, isUser = false) {
            const div = document.createElement('div');
            div.className = `flex gap-2 ${isUser ? 'flex-row-reverse' : ''}`;
            div.innerHTML = `
                <div class="${isUser ? 'bg-slate-800 text-white rounded-tl-xl rounded-b-xl' : 'bg-brand-100 text-brand-700 rounded-tr-xl rounded-b-xl'} p-2.5 text-xs shadow-sm max-w-[85%]">
                    ${text}
                </div>
            `;
            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function handleChat() {
            const val = chatInput.value.trim();
            if(!val) return;
            
            appendMessage(val, true);
            chatInput.value = '';

            // Basit Yapay Zeka Cevapları
            setTimeout(() => {
                let reply = "Şu an sahnedeki düzeni inceledim. Masaların yerleşimi oldukça nizami görünüyor.";
                
                const blocked = tables.filter(t => !isTableViewClear(t)).length;
                if(val.toLowerCase().includes('kolon') || val.toLowerCase().includes('kör')) {
                    if(columns.length === 0) reply = "Henüz alana hiç kolon eklemedin. Sol menüden 'Kolon Çiz' aracını seçip alana kolonlar yerleştirebilirsin.";
                    else if(blocked > 0) reply = `Dikkat! Şu an ${blocked} masanın görüşü kolonlar tarafından kapanmış durumda. Fareyi masaların üzerine getirerek kırmızı ile yananları görebilir ve taşıyabilirsin.`;
                    else reply = "Harika! Kolonlar yerinde ama hiçbir masanın görüşünü kapatmıyor. Kusursuz bir tasarım.";
                } else if(val.toLowerCase().includes('otomatik') || val.toLowerCase().includes('düzen')) {
                    reply = "Sol taraftaki 'Otomatik Yerleştir' butonuna basarsan, mevcut kolonları algılayıp arkasında kalan kör noktalara masa koymadan tüm alanı doldururum.";
                }

                appendMessage(reply);
            }, 600);
        }

        chatSend.addEventListener('click', handleChat);
        chatInput.addEventListener('keypress', (e) => { if(e.key === 'Enter') handleChat(); });

        // Başlat
        draw();
    </script>
</body>
</html>
"""

output_path = "seatvision_designer_v2.html"
with open(output_path, "w", encoding="utf-8") as f:
    f.write(html_content)

print(f"SUCCESS: {output_path} generated.")