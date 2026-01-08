
<?php require '../config.php'; include 'header.php'; ?>
<h2>Seat Occupancy</h2>
<table class="table">
<tr><th>Flight</th><th>Booked</th><th>Free</th><th>Held</th></tr>
<?php
$r=$conn->query("
SELECT f.flight_no,
SUM(se.status='BOOKED') booked,
SUM(se.status='FREE') free_s,
SUM(se.status='HELD') held
FROM flights f
LEFT JOIN seats se ON se.flight_id=f.id
GROUP BY f.id");
while($x=$r->fetch_assoc()): ?>
<tr>
<td><?=$x['flight_no']?></td>
<td><?=$x['booked']?></td>
<td><?=$x['free_s']?></td>
<td><?=$x['held']?></td>
</tr>
<?php endwhile; ?>
</table>
<?php include 'footer.php'; ?>
