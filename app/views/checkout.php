<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akıllı Salon Yerleşimi ve Kolon Analiz Sistemi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1e1e24;
            color: #ffffff;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .controls {
            background-color: #2b2b36;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            margin-bottom: 15px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        button {
            background-color: #4a6fa5;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        button:hover {
            background-color: #5b82be;
        }
        button.btn-danger {
            background-color: #d9534f;
        }
        button.btn-danger:hover {
            background-color: #e26b67;
        }
        button.btn-success {
            background-color: #5cb85c;
        }
        button.btn-success:hover {
            background-color: #6cc96c;
        }
        #canvas-container {
            position: relative;
            border: 2px solid #3f3f4e;
            border-radius: 8px;
            overflow: hidden;
            background-color: #141418;
            box-shadow: 0 8px 16px rgba(0,0,0,0.5);
        }
        canvas {
            display: block;
            cursor: crosshair;
        }
        .info-panel {
            margin-top: 10px;
            font-size: 14px;
            color: #a0a0b0;
        }
    </style>
</head>
<body>

    <div class="controls">
        <button id="add-column-btn">+ Sahneye Kolon Ekle</button>
        <button id="auto-layout-btn" class="btn-success">⚡ Kolonlara Göre Örnek Tasarım Yap</button>
        <button id="clear-seats-btn">🪑 Sadece Masaları Temizle (Kolonlar Kalsın)</button>
        <button id="clear-all-btn" class="btn-danger">🗑️ Her Şeyi Sıfırla</button>
    </div>

    <div id="canvas-container">
        <canvas id="salon-canvas" width="900" height="650"></canvas>
    </div>

    <div class="info-panel">
        * Kolon ekledikten sonra mouse ile sürükleyerek yerini değiştirebilirsin. "Örnek Tasarım Yap" butonuna bastığında kolonlar korunur ve kör noktalar kırmızı çizgiyle işaretlenir.
    </div>

    <script>
        const canvas = document.getElementById('salon-canvas');
        const ctx = canvas.getContext('2d');

        // Sahne (Stage) Tanımı
        const stage = {
            x: canvas.width / 2,
            y: 60,
            width: 400,
            height: 50
        };

        // Sahnedeki Tüm Elementler (Kolon, Masa, Sandalye)
        let elements = [];
        let isDragging = false;
        let draggedElement = null;
        let dragOffsetX = 0;
        let dragOffsetY = 0;

        // Başlangıç için örnek 2 adet kolon ekleyelim
        elements.push({ type: 'column', x: 300, y: 300, radius: 35 });
        elements.push({ type: 'column', x: 600, y: 350, radius: 40 });

        // Çizim Ana Döngüsü
        function drawScene() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Izgara (Grid) Çizimi
            drawGrid();

            // Sahne (Stage) Çizimi
            drawStage();

            // Bağlantı çizgileri / Işın izleme (Raycasting - Kör nokta analizi)
            drawRaycasting();

            // Elementleri Çiz
            elements.forEach(el => {
                if (el.type === 'column') drawColumn(el);
                else if (el.type === 'table') drawTable(el);
                else if (el.type === 'chair') drawChair(el);
            });
        }

        function drawGrid() {
            ctx.strokeStyle = '#1f1f27';
            ctx.lineWidth = 1;
            const gridSize = 40;
            for (let x = 0; x < canvas.width; x += gridSize) {
                ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, canvas.height); ctx.stroke();
            }
            for (let y = 0; y < canvas.height; y += gridSize) {
                ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(canvas.width, y); ctx.stroke();
            }
        }

        function drawStage() {
            ctx.fillStyle = '#3a3a4d';
            ctx.fillRect(stage.x - stage.width / 2, stage.y - stage.height / 2, stage.width, stage.height);
            ctx.strokeStyle = '#686882';
            ctx.lineWidth = 2;
            ctx.strokeRect(stage.x - stage.width / 2, stage.y - stage.height / 2, stage.width, stage.height);

            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 16px Segoe UI';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('S A H N E', stage.x, stage.y);
        }

        function drawColumn(col) {
            // Kolon Gölgelendirme ve Çizim
            ctx.beginPath();
            ctx.arc(col.x, col.y, col.radius, 0, Math.PI * 2);
            ctx.fillStyle = '#5a5a6e';
            ctx.fill();
            ctx.lineWidth = 4;
            ctx.strokeStyle = '#ff4757';
            ctx.stroke();

            // Kolon İç Metin
            ctx.fillStyle = '#ffffff';
            ctx.font = '11px Segoe UI';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('KOLON', col.x, col.y);
        }

        function drawTable(tbl) {
            ctx.beginPath();
            ctx.arc(tbl.x, tbl.y, tbl.radius, 0, Math.PI * 2);
            ctx.fillStyle = '#2ed573';
            ctx.fill();
            ctx.lineWidth = 2;
            ctx.strokeStyle = '#1e90ff';
            ctx.stroke();
        }

        function drawChair(chr) {
            ctx.beginPath();
            ctx.arc(chr.x, chr.y, chr.radius, 0, Math.PI * 2);
            ctx.fillStyle = chr.isBlindSpot ? '#ff4757' : '#ffa502';
            ctx.fill();
            ctx.lineWidth = 1.5;
            ctx.strokeStyle = '#ffffff';
            ctx.stroke();
        }

        // --- ÇAKIŞMA VE IŞIN İZLEME (RAYCASTING) ANALİZİ ---

        // Kolon ile fiziksel çakışma kontrolü
        function isCollidingWithColumns(x, y, radius, margin = 15) {
            const columns = elements.filter(el => el.type === 'column');
            for (let col of columns) {
                const dx = x - col.x;
                const dy = y - col.y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                if (distance < (radius + col.radius + margin)) {
                    return true;
                }
            }
            return false;
        }

        // Çizgi ile Daire Kesim Kontrolü (Raycasting Kör Nokta Algoritması)
        function checkLineCircleIntersection(x1, y1, x2, y2, cx, cy, cr) {
            const dx = x2 - x1;
            const dy = y2 - y1;
            const len = Math.sqrt(dx * dx + dy * dy);
            if (len === 0) return false;

            // Doğru üzerindeki izleme projeksiyonu
            const u = ((cx - x1) * dx + (cy - y1) * dy) / (len * len);
            
            // Eğer kesişim noktası doğru parçasının (sandalye-sahne arası) dışındaysa atla
            if (u < 0.05 || u > 0.95) return false;

            const nearestX = x1 + u * dx;
            const nearestY = y1 + u * dy;

            const distToCenter = Math.sqrt((cx - nearestX) ** 2 + (cy - nearestY) ** 2);
            return distToCenter <= (cr + 5); // 5px tolerans payı
        }

        // Sandalyenin görüş açısının kolon tarafından kapatılıp kapatılmadığını denetle
        function isBlindSpot(x, y) {
            const columns = elements.filter(el => el.type === 'column');
            for (let col of columns) {
                if (checkLineCircleIntersection(x, y, stage.x, stage.y, col.x, col.y, col.radius)) {
                    return true;
                }
            }
            return false;
        }

        // Görüş çizgilerini ve kör noktaları çiz
        function drawRaycasting() {
            const chairs = elements.filter(el => el.type === 'chair');
            chairs.forEach(chr => {
                chr.isBlindSpot = isBlindSpot(chr.x, chr.y);
                if (chr.isBlindSpot) {
                    ctx.beginPath();
                    ctx.setLineDash([4, 4]);
                    ctx.moveTo(chr.x, chr.y);
                    ctx.lineTo(stage.x, stage.y);
                    ctx.strokeStyle = 'rgba(255, 71, 87, 0.4)';
                    ctx.lineWidth = 1;
                    ctx.stroke();
                    ctx.setLineDash([]);
                }
            });
        }

        // --- AKILLI ÖRNEK TASARIM ALGORİTMASI ---

        function generateAutoLayout() {
            // 1. ADIM: MEVCUT KOLONLARI KORU!
            // Diziyi tamamen sıfırlamak yerine sadece kolonları filtreleyip saklıyoruz.
            const preservedColumns = elements.filter(el => el.type === 'column');
            elements = [...preservedColumns];

            const startX = 120;
            const startY = 160;
            const endX = canvas.width - 120;
            const endY = canvas.height - 80;
            const spacingX = 140;
            const spacingY = 130;
            const tableRadius = 25;
            const chairRadius = 10;
            const chairDistance = 42;

            // Izgara üzerinde döngüyle masa ve sandalye üret
            for (let y = startY; y <= endY; y += spacingY) {
                for (let x = startX; x <= endX; x += spacingX) {
                    
                    // 2. ADIM: KOLON ÇAKIŞMA KONTROLÜ
                    // Eğer masanın konumu bir kolonla çakışıyorsa burayı pas geç
                    if (isCollidingWithColumns(x, y, tableRadius, 30)) {
                        continue;
                    }

                    // Masayı ekle
                    elements.push({ type: 'table', x: x, y: y, radius: tableRadius });

                    // Masanın etrafına 4 adet sandalye (Açısal yerleşim)
                    const angles = [0, Math.PI / 2, Math.PI, (3 * Math.PI) / 2];
                    angles.forEach(angle => {
                        const chairX = x + Math.cos(angle) * chairDistance;
                        const chairY = y + Math.sin(angle) * chairDistance;

                        // Sandalye bir kolonla fiziksel olarak çakışmıyorsa ekle
                        if (!isCollidingWithColumns(chairX, chairY, chairRadius, 5)) {
                            elements.push({
                                type: 'chair',
                                x: chairX,
                                y: chairY,
                                radius: chairRadius,
                                isBlindSpot: false
                            });
                        }
                    });
                }
            }
            drawScene();
        }

        // --- ETKİLEŞİM VE BUTON OLAYLARI ---

        document.getElementById('auto-layout-btn').addEventListener('click', generateAutoLayout);

        document.getElementById('add-column-btn').addEventListener('click', () => {
            elements.push({
                type: 'column',
                x: canvas.width / 2 + (Math.random() * 100 - 50),
                y: canvas.height / 2 + (Math.random() * 100 - 50),
                radius: 35
            });
            drawScene();
        });

        document.getElementById('clear-seats-btn').addEventListener('click', () => {
            // Kolonlar hariç her şeyi temizle
            elements = elements.filter(el => el.type === 'column');
            drawScene();
        });

        document.getElementById('clear-all-btn').addEventListener('click', () => {
            elements = [];
            drawScene();
        });

        // Mouse Sürükle - Bırak (Drag & Drop) Olayları
        canvas.addEventListener('mousedown', (e) => {
            const rect = canvas.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const mouseY = e.clientY - rect.top;

            for (let i = elements.length - 1; i >= 0; i--) {
                const el = elements[i];
                const dist = Math.hypot(mouseX - el.x, mouseY - el.y);
                if (dist <= el.radius) {
                    isDragging = true;
                    draggedElement = el;
                    dragOffsetX = mouseX - el.x;
                    dragOffsetY = mouseY - el.y;
                    break;
                }
            }
        });

        canvas.addEventListener('mousemove', (e) => {
            if (!isDragging || !draggedElement) return;
            const rect = canvas.getBoundingClientRect();
            draggedElement.x = (e.clientX - rect.left) - dragOffsetX;
            draggedElement.y = (e.clientY - rect.top) - dragOffsetY;
            drawScene();
        });

        window.addEventListener('mouseup', () => {
            isDragging = false;
            draggedElement = null;
        });

        // İlk Çizim
        drawScene();
    </script>
</body>
</html>