
<?php include 'partials/header.php'; include 'helpers.php';
$_SESSION['tmp']=$_POST;
$fid=$_POST['flight_id']; $class=$_POST['class']; $c=$_POST['count'];
$taken=takenSeats($conn,$fid);
$flight=$conn->query("SELECT aircraft_type FROM flights WHERE id=$fid")->fetch_assoc();
$type=$flight['aircraft_type'];
?>
<div class=wizard><div>Passengers</div><div>Details</div><div><b>Seats</b></div><div>Payment</div><div>Done</div></div>
<h2>Seat Selection (<?=$class?>)</h2>
<form class=card method=POST action=payment.php>
<input type=hidden name=flight_id value="<?=$fid?>">
<input type=hidden name=class value="<?=$class?>">
<input type=hidden name=count value="<?=$c?>">

<div>
<?php if($class=='BUSINESS'): ?>
<h4>Business Seats</h4>
<?php for($s=1;$s<=6;$s++): $lab='S'.$s; $d=in_array($lab,$taken); ?>
<label class="seat <?=$d?'taken':'free'?>" data-seat="<?=$lab?>">
 <input type=checkbox style="display:none" name=seat[] value="<?=$lab?>" <?=$d?'disabled':''?>>
 <?=$lab?>
</label>
<?php if($s%3==0) echo " &nbsp; "; endfor; ?>

<?php else: ?>
<h4>Economy Seats</h4>
<?php for($s=7;$s<=($type=='B737'?36:30);$s++): $lab='S'.$s; $d=in_array($lab,$taken); ?>
<label class="seat <?=$d?'taken':'free'?>" data-seat="<?=$lab?>">
 <input type=checkbox style="display:none" name=seat[] value="<?=$lab?>" <?=$d?'disabled':''?>>
 <?=$lab?>
</label>
<?php if($s%6==0) echo "<br>"; endfor; ?>
<?php endif; ?>
</div><br>

<a class='btn' href='step_details.php'>Back</a>
<button class='btn'>Proceed to Payment</button>
</form>



<script>
const boxes=[...document.querySelectorAll('input[name="seat[]"]')];

boxes.forEach(b=>b.addEventListener('change',()=>{
 if(document.querySelectorAll('input[name="seat[]"]:checked').length > <?=$c?>){
   b.checked=false; alert("Select only <?=$c?> seats");
 }
}));

document.querySelectorAll('.seat').forEach(el=>{
 el.addEventListener('click',()=>{
   if(el.classList.contains('taken')){
     alert("This seat is already booked");
     return;
   }
   const cb=el.querySelector('input');
   if(cb && !cb.disabled){
     cb.checked=!cb.checked;
     el.classList.toggle('selected',cb.checked);
   }
 });
});
</script>



<?php include 'partials/footer.php'; ?>
