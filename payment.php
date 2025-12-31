
<?php include 'partials/header.php';
$fid=$_POST['flight_id']; $class=$_POST['class']; $c=$_POST['count'];
$seats=$_POST['seat'] ?? [];
if(count($seats)!=$c){ echo "<div class=card>Please select $c seats.</div>"; include 'partials/footer.php'; exit; }
$_SESSION['seats']=$seats;
$f=$conn->query("SELECT * FROM flights WHERE id=$fid")->fetch_assoc();
$price=($class=='BUSINESS'?$f['price_business']:$f['price_economy']);
$total=$price*$c; $seatlist=implode(', ',$seats);
?>
<div class=wizard><div>Passengers</div><div>Details</div><div>Seats</div><div><b>Payment</b></div><div>Done</div></div>
<h2>Payment</h2>
<div class=card>
<form method=POST action='confirm.php'>
<input type=hidden name=flight_id value='<?=$fid?>'>
<input type=hidden name=class value='<?=$class?>'>
<input type=hidden name=total value='<?=$total?>'>

Payment Type<br>
<select id=ptype name=payment required>
 <option value='CARD'>Card</option>
 <option value='UPI'>UPI</option>
</select><br><br>

<div id=cardBox>
Card Holder Name<br><input name=card_name><br><br>
Card Number<br><input name=card_no><br><br>
Expiry Date<br><input name=exp><br><br>
CVV<br><input name=cvv><br><br>
</div>

<div id=upiBox style='display:none'>
UPI ID<br><input name=upi><br><br>
</div>

Amount: <b>₹<?=$total?></b><br>
Seats: <b><?=$seatlist?></b><br><br>

<a class='btn' href='step_seats.php'>Back</a>
<button class='btn'>Confirm Payment</button>
</form>
</div>

<script>
const pt=document.getElementById('ptype'),card=document.getElementById('cardBox'),upi=document.getElementById('upiBox');
pt.addEventListener('change',()=>{ if(pt.value==='CARD'){card.style.display='block';upi.style.display='none';}else{card.style.display='none';upi.style.display='block';}});
</script>
<?php include 'partials/footer.php'; ?>
