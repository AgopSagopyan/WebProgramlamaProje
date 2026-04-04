<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Okey Oyunu</title>

<style>
body {
    background: #0b6623;
    font-family: Arial;
    color: white;
    text-align: center;
}

.middle {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 60px;
    margin-top: 60px;
}

.deck {
    width: 70px;
    height: 100px;
    background: #444;
    border-radius: 10px;
    cursor: grab;
}

.center-slot {
    width: 70px;
    height: 100px;
    background: #222;
    border-radius: 10px;
    display:flex;
    justify-content:center;
    align-items:center;
}

.rack {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 850px;
    background: #8b5a2b;
    padding: 10px;
    border-radius: 10px;
}

.row {
    display:flex;
    justify-content:center;
}

.tile {
    width: 45px;
    height: 65px;
    margin: 3px;
    border-radius: 5px;
    line-height: 65px;
    font-weight: bold;
    cursor: grab;
}

.red { background: #ff4d4d; }
.blue { background: #4da6ff; }
.yellow { background: #ffd11a; color:black; }
.black { background: #333; }

.okey {
    border: 3px solid gold;
}

.status {
    margin-top: 15px;
}

button {
    margin-top: 20px;
    padding: 8px 15px;
    font-size: 16px;
    cursor: pointer;
}
</style>
</head>
<body>

<h1>🀄 Okey Oyunu</h1>

<div id="status" class="status">Taş çek</div>
<button onclick="sortRack()">Akıllı Diz</button>

<div class="middle">
    <div id="deck" class="deck"
         draggable="true"
         ondragstart="startDraw()">
    </div>

    <div id="buffer" class="center-slot"
         draggable="true"
         ondragstart="dragBuffer()">
    </div>

    <div id="center" class="center-slot"
         draggable="true"
         ondragstart="takeCenter()"
         ondragover="event.preventDefault()"
         ondrop="throwTile()">
    </div>
</div>

<div id="rack"
     class="rack"
     ondragover="event.preventDefault()"
     ondrop="dropToRack(event)">
</div>

<script>
let deck=[];
let playerTiles=[];
let centerTile=null;
let bufferTile=null;
let draggedIndex=null;

let hasDrawn=false;
let hasThrown=false;

// 🎲 DESTE
function createDeck(){
    let colors=["red","blue","yellow","black"];
    colors.forEach(c=>{
        for(let i=1;i<=13;i++){
            deck.push({color:c,number:i});
            deck.push({color:c,number:i});
        }
    });
}

// 🔀
function shuffle(a){
    for(let i=a.length-1;i>0;i--){
        let j=Math.floor(Math.random()*(i+1));
        [a[i],a[j]]=[a[j],a[i]];
    }
}

// 🎮 BAŞLAT
function init(){
    createDeck();
    shuffle(deck);

    for(let i=0;i<21;i++){
        playerTiles.push(deck.pop());
    }

    render();
}

// 🎨 RENDER
function render(){
    renderRack();
    renderCenter();
    renderBuffer();
}

// ISTAKA
function renderRack(){
    let rack=document.getElementById("rack");
    rack.innerHTML="";

    let row1=document.createElement("div");
    let row2=document.createElement("div");

    row1.className="row";
    row2.className="row";

    playerTiles.forEach((tile,index)=>{

        let div=document.createElement("div");
        div.className="tile "+tile.color;
        div.innerText=tile.number;

        div.draggable=true;
        div.ondragstart=()=>draggedIndex=index;

        if(index<Math.ceil(playerTiles.length/2)){
            row1.appendChild(div);
        }else{
            row2.appendChild(div);
        }

    });

    rack.appendChild(row1);
    rack.appendChild(row2);
}

// ORTA
function renderCenter(){
    let c=document.getElementById("center");
    c.innerHTML="";
    if(centerTile){
        let d=document.createElement("div");
        d.className="tile "+centerTile.color;
        d.innerText=centerTile.number;
        c.appendChild(d);
    }
}

// BUFFER
function renderBuffer(){
    let b=document.getElementById("buffer");
    b.innerHTML="";
    if(bufferTile){
        let d=document.createElement("div");
        d.className="tile "+bufferTile.color;
        d.innerText=bufferTile.number;
        b.appendChild(d);
    }
}

// 🎯 DESTEDEN ÇEK
function startDraw(){
    if(hasDrawn){ setStatus("Zaten çektin!"); return;}
    bufferTile = deck.pop();
    hasDrawn=true;
    setStatus("Taşı ıstakaya sürükle");
    setTimeout(render,50);
}

// 🎯 BUFFER SÜRÜKLE
function dragBuffer(){ if(!bufferTile) return;}

// 🎯 ISTAKAYA BIRAK
function dropToRack(e){
    if(bufferTile){
        // yeni index hesapla
        let rect=e.target.getBoundingClientRect();
        let middleX=(rect.left+rect.right)/2;
        let insertIndex=(e.clientX < middleX)? 0 : playerTiles.length;

        playerTiles.splice(insertIndex,0,bufferTile);
        bufferTile=null;
        setStatus("Taş at");
        render();
    }
}

// 🎯 ORTADAN AL
function takeCenter(){
    if(hasDrawn){ setStatus("Zaten çektin!"); return;}
    if(!centerTile){ setStatus("Ortada taş yok"); return;}
    playerTiles.push(centerTile);
    centerTile=null;
    hasDrawn=true;
    setStatus("Taş at");
    setTimeout(render,50);
}

// ➖ TAŞ AT
function throwTile(){
    if(!hasDrawn){ setStatus("Önce taş çek!"); return;}
    if(hasThrown){ setStatus("Zaten attın!"); return;}
    if(draggedIndex===null) return;
    centerTile = playerTiles.splice(draggedIndex,1)[0];
    draggedIndex=null;
    hasThrown=true;
    setTimeout(()=>{
        hasDrawn=false;
        hasThrown=false;
        setStatus("Yeni tur - taş çek");
    },300);
    render();
}

// 📢 DURUM
function setStatus(msg){ document.getElementById("status").innerText=msg; }

// 🔀 AKILLI DİZME
function sortRack(){
    playerTiles.sort((a,b)=>{
        if(a.color===b.color) return a.number - b.number;
        return a.color.localeCompare(b.color);
    });
    render();
}

init();
</script>
</body>
</html>