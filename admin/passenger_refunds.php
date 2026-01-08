
<?php require '../config.php'; require '../lib/audit.php'; include 'header.php'; ?>
<h2>Passenger Refunds</h2>
<table class="table">
<tr><th>Ticket</th><th>Name</th><th>Status</th><th>Action</th></tr>
<?php
$r=$conn->query("SELECT p.id,p.ticket_no,p.name,p.refund_status FROM passengers p WHERE p.refund_status='PENDING'");
while($x=$r->fetch_assoc()):
?>
<tr>
<td><?=$x['ticket_no']?></td>
<td><?=$x['name']?></td>
<td><?=$x['refund_status']?></td>
<td><a href="passenger_refund_approve.php?id=<?=$x['id']?>">Approve</a></td>
</tr>
<?php endwhile; ?>
</table>
<?php include 'footer.php'; ?>
