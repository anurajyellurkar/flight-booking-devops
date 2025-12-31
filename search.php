
<?php include 'partials/header.php';
$o=$_GET['origin']??'';$d=$_GET['destination']??'';$dt=$_GET['date']??'';
$s=$conn->prepare("SELECT * FROM flights WHERE origin LIKE ? AND destination LIKE ? AND DATE(depart_time)=?");
$oo="%$o%";$dd="%$d%";$s->bind_param("sss",$oo,$dd,$dt);$s->execute();$r=$s->get_result();
?>
<h2>Flights</h2>
<?php if($r->num_rows==0): ?>
<script>alert('No flights available for this search');</script>
<?php endif; ?><div class=card>
<table class=table><tr><th>No</th><th>Route</th><th>Time</th><th>Economy</th><th>Business</th><th></th></tr>
<?php while($f=$r->fetch_assoc()): ?>
<tr>
<td><?=$f['flight_no']?></td><td><?=$f['origin']?> → <?=$f['destination']?></td>
<td><?=$f['depart_time']?></td>
<td>₹<?=$f['price_economy']?></td>
<td>₹<?=$f['price_business']?></td>
<td><a href="step_passengers.php?id=<?=$f['id']?>">Book</a></td>
</tr><?php endwhile; ?></table></div>
<?php include 'partials/footer.php'; ?>
