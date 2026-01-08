<?php
require "config.php";

if (!isset($_GET['flight_id'])) {
    die("Flight required");
}

$flight_id = intval($_GET['flight_id']);
?>
<!DOCTYPE html>
<html>
<head>
<title>Seat Map</title>

<style>
body{
  font-family: Arial;
  background:#0a1224;
  color:white;
}

.grid{
  display:grid;
  grid-template-columns:repeat(7,45px);
  gap:10px;
  justify-content:center;
  margin-top:25px;
}

.seat{
  padding:10px;
  border-radius:8px;
  text-align:center;
  cursor:pointer;
  font-weight:bold;
}

.free{background:#2ecc71;}   /* green */
.held{background:#f1c40f; color:#000;} /* yellow */
.booked{background:#e74c3c;} /* red */
.me{background:#3498db;}     /* blue */
.aisle{visibility:hidden;}
</style>
</head>

<body>

<h2 style="text-align:center">Select Seat</h2>

<div id="grid" class="grid"></div>

<script>
const flight_id = <?= $flight_id ?>;
let mySeat = null;

const seats=[];
const rows=20;
const cols=['A','B','C','aisle','D','E','F'];

for(let r=1;r<=rows;r++){
 for(let c of cols){
   if(c==='aisle'){ seats.push({id:'',aisle:true}); }
   else seats.push({id:`${c}${r}`});
 }
}

function render(data){
 let g=document.getElementById('grid');
 g.innerHTML='';
 seats.forEach(s=>{
   if(s.aisle){
     let d=document.createElement('div');
     d.className='aisle';
     g.appendChild(d);
     return;
   }

   let status = data[s.id] ?? 'FREE';
   let css='seat ';

   if(mySeat === s.id) css += 'me';
   else if(status === 'BOOKED') css+='booked';
   else if(status === 'HELD') css+='held';
   else css+='free';

   let d=document.createElement('div');
   d.className=css;
   d.innerText=s.id;
   d.onclick=()=>selectSeat(s.id,status);
   g.appendChild(d);
 });
}

function refresh(){
 fetch('api_cleanup.php');
 fetch('api_seats.php?flight_id='+flight_id)
   .then(r=>r.json())
   .then(render);
}

setInterval(refresh,1500);
refresh();

function selectSeat(seat,status){
 if(status!=='FREE' && mySeat!==seat){
   alert('Seat is not available');
   return;
 }
 if(mySeat && mySeat!==seat){
   fetch('api_release.php',{
     method:'POST',
     headers:{'Content-Type':'application/x-www-form-urlencoded'},
     body:`flight_id=${flight_id}&seat=${mySeat}`
   });
   mySeat=null;
 }

 if(status==='FREE'){
   fetch('api_hold.php',{
     method:'POST',
     headers:{'Content-Type':'application/x-www-form-urlencoded'},
     body:`flight_id=${flight_id}&seat=${seat}`
   })
   .then(r=>r.text())
   .then(t=>{
     if(t==='ok') mySeat=seat;
     else alert('Seat just taken');
   });
 }
}
</script>

</body>
</html>