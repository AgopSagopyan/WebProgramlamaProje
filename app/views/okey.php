<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Okey Oyunu</title>

<style>
body {
    background:#0b6623;
    font-family:Arial;
    text-align:center;
    color:white;
}

.middle {
    display:flex;
    justify-content:center;
    gap:50px;
    margin-top:50px;
}

.deck,.buffer,.center {
    width:70px;
    height:100px;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.deck{background:#444;}
.buffer{background:#666;}
.center{background:#222;}

.rack{
    position:fixed;
    bottom:20px;
    left:50%;
    transform:translateX(-50%);
    width:850px;
    background:#8b5a2b;
    padding:10px;
    border-radius:10px;
}

.row{display:flex;justify-content:center;}

.tile{
    width:45px;
    height:65px;
    margin:3px;
    border-radius:5px;
    line-height:65px;
    font-weight:bold;
    cursor:grab;
}

.red{background:#ff4d4d;}
.blue{background:#4da6ff;}
.yellow{background:#ffd11a;color:black;}
.black{background:#333;}

.okey{border:3px solid gold;}

button{margin:10px;}
</style>

</head>
<body>

<h1>🀄 Okey</h1>

<button onclick="sortTiles()">Diz</button>
<button onclick="checkWin()">El Aç</button>

<div class="middle">
<div class="deck" draggable="true" ondragstart="drawTile()"></div>
<div id="buffer" class="buffer"></div>
<div id="center" class="center"
     draggable="true"
     ondragstart="takeCenter()"
     ondragover="event.preventDefault()"
     ondrop="throwTile()"></div>
</div>

<div id="rack" class="rack"
     ondragover="event.preventDefault()"
     ondrop="dropRack()"></div>

<script>

let deck=[],playerTiles=[];
let bufferTile=null,centerTile=null;
let draggedIndex=null;

let hasDrawn=false,hasThrown=false;

let okey=null;

// DESTE
function createDeck(){
    let colors=["red","blue","yellow","black"];
    colors.forEach(c=>{
        for(let i=1;i<=13;i++){
            deck.push({color:c,number:i});
            deck.push({color:c,number:i});
        }
    });
}

// KARIŞTIR
function shuffle(a){
    for(let i=a.length-1;i>0;i--){
        let j=Math.floor(Math.random()*(i+1));
        [a[i],a[j]]=[a[j],a[i]];
    }
}

// OKEY
function setOkey(){
    let r=deck[Math.floor(Math.random()*deck.length)];
    let next=r.number===13?1:r.number+1;
    okey={color:r.color,number:next};
}

// BAŞLAT
function init(){
    createDeck();
    shuffle(deck);
    setOkey();

    for(let i=0;i<21;i++){
        playerTiles.push(deck.pop());
    }

    render();
}

// RENDER
function render(){
    renderRack();
    renderBuffer();
    renderCenter();
}

// ISTAKA
function renderRack(){
    let rack=document.getElementById("rack");
    rack.innerHTML="";

    let row1=document.createElement("div");
    let row2=document.createElement("div");
    row1.className="row";
    row2.className="row";

    playerTiles.forEach((t,i)=>{

        let d=document.createElement("div");
        d.className="tile "+t.color;
        d.innerText=t.number;

        d.draggable=true;

        d.ondragstart=()=>draggedIndex=i;

        d.ondragover=e=>e.preventDefault();

        d.ondrop=()=>{
            let temp=playerTiles[i];
            playerTiles[i]=playerTiles[draggedIndex];
            playerTiles[draggedIndex]=temp;
            render();
        };

        if(i<Math.ceil(playerTiles.length/2)) row1.appendChild(d);
        else row2.appendChild(d);
    });

    rack.appendChild(row1);
    rack.appendChild(row2);
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

// ÇEK
function drawTile(){
    if(hasDrawn) return;

    bufferTile=deck.pop();
    hasDrawn=true;

    render();
}

// ISTAKAYA BIRAK
function dropRack(){
    if(bufferTile){
        playerTiles.push(bufferTile);
        bufferTile=null;
        render();
    }
}

// ORTADAN AL
function takeCenter(){
    if(hasDrawn || !centerTile) return;

    playerTiles.push(centerTile);
    centerTile=null;
    hasDrawn=true;

    render();
}

// AT
function throwTile(){
    if(!hasDrawn || hasThrown) return;

    centerTile=playerTiles.splice(draggedIndex,1)[0];
    draggedIndex=null;

    hasThrown=true;

    setTimeout(()=>{
        hasDrawn=false;
        hasThrown=false;
    },200);

    render();
}

// DİZ
function sortTiles(){
    playerTiles.sort((a,b)=>{
        if(a.color===b.color) return a.number-b.number;
        return a.color.localeCompare(b.color);
    });
    render();
}

// EL AÇ
function checkWin(){

    let tiles = [...playerTiles];

    // OKEY
    function isOkey(t){
        return t.color === okey.color && t.number === okey.number;
    }

    // SET
    function isSet(group){
        if(group.length < 3) return false;

        let num = group[0].number;
        let colors = new Set();

        for(let t of group){
            if(isOkey(t)) continue;

            if(t.number !== num) return false;
            colors.add(t.color);
        }

        return colors.size >= 3;
    }

    // SERİ
    function isRun(group){
        if(group.length < 3) return false;

        let non = group.filter(t=>!isOkey(t));
        if(non.length === 0) return true;

        let color = non[0].color;

        for(let t of non){
            if(t.color !== color) return false;
        }

        let nums = non.map(t=>t.number).sort((a,b)=>a-b);

        let gaps = 0;

        for(let i=1;i<nums.length;i++){
            let diff = nums[i]-nums[i-1];
            if(diff > 1) gaps += diff-1;
        }

        let joker = group.filter(isOkey).length;

        return gaps <= joker;
    }

    // BACKTRACK
    function solve(tiles){

        if(tiles.length === 0) return true;

        for(let i=0;i<tiles.length;i++){

            for(let j=i+1;j<tiles.length;j++){
                for(let k=j+1;k<tiles.length;k++){

                    let group=[tiles[i],tiles[j],tiles[k]];

                    if(isSet(group) || isRun(group)){

                        let remaining = tiles.filter((_,idx)=>idx!==i && idx!==j && idx!==k);

                        if(solve(remaining)) return true;
                    }
                }
            }

            break;
        }

        return false;
    }

    if(solve(tiles)){
        alert("🎉 GERÇEK OKEY! Kazandın!");
    } else {
        alert("❌ Açılmıyor (gerçek kontrol)");
    }
}

init();

</script>

</body>
</html>