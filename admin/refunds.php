
<?php require '../config.php'; require '../lib/audit.php'; include 'header.php'; ?>
<h2>Refund Requests</h2>
<table class='table'>
<tr><th>Ticket</th><th>Status</th><th>Action</th></tr>
<?php $r=$conn->query("SELECT id,ticket_no,refund_status FROM bookings WHERE refund_status='PENDING'");
while($x=$r->fetch_assoc()): ?>
<tr>
<td><?=$x['ticket_no']?></td>
<td><?=$x['refund_status']?></td>
<td><a href="refund_approve.php?id=<?=$x['id']?>">Approve</a></td>
</tr>
<?php endwhile; ?>
</table>
<?php include 'footer.php'; ?>
