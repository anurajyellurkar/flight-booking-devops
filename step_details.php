
<?php include 'partials/header.php';
$c=intval($_POST['count']); $fid=$_POST['flight_id']; $class=$_POST['class'];
?>
<h2>Booking — Step 2: Passenger Details</h2>
<form method="POST" action="step_seats.php" class="card">
<input type="hidden" name="flight_id" value="<?=$fid?>">
<input type="hidden" name="class" value="<?=$class?>">
<input type="hidden" name="count" value="<?=$c?>">
<?php for($i=1;$i<=$c;$i++): ?>
<div class="card" style="background:#0f1e3f">
<b>Passenger <?=$i?></b><br>
Name <input name="name[]" required>
Age <input type="number" name="age[]" style="width:70px" required>
Gender <select name="gender[]"><option>Male</option><option>Female</option></select><br><br>
Phone <input type="text" name="phone[]" placeholder="10-digit phone" required>
</div>
<?php endfor; ?>
<a class="btn" href="step_passengers.php?id=<?=$fid?>">Back</a>
<button class="btn">Continue</button>
</form>
<?php include 'partials/footer.php'; ?>
